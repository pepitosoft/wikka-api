<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

spl_autoload_register(function ($classname) {
    require ("../classes/" . $classname . ".php");
});

require 'vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['type']   = "sqlite";
$config['db']['path']   = "/var/www/html/wikka/wikka";
$config['db']['host']   = "localhost";
$config['db']['user']   = "user";
$config['db']['pass']   = "password";
$config['db']['dbname'] = "exampleapp";


$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();

$container['view'] = new \Slim\Views\PhpRenderer("../templates/");

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];

    if ($db['type'] == "sqlite"){
      $pdo = new PDO("sqlite:".$db['path']);
    }else{
      $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
          $db['user'], $db['pass']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    return $pdo;
};

function getDB()
{
    $dbtype = "sqlite";

    $dbpath = "/var/www/html/wikka/wikka";

    $dbhost = "";
    $dbuser = "";
    $dbpass = "";
    $dbname = "";

    try {

      if ($dbtype == "sqlite"){
        $dsn = "sqlite".":".$dbpath;
        $dbConnection = new PDO($dsn);
      }else{
        $dsn = "mysql:host=$dbhost;dbname=$dbname";
        $dbConnection = new PDO($mysql_conn_string, $dbuser, $dbpass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }

    } catch(PDOException $e) {
      die('<em class="error">'.print("PDO connection error!").'</em>');
    }

    return $dbConnection;
}

//$db = getDB();

//$sql  = "select * from ".$this->GetConfigValue('table_prefix')."pages WHERE latest = ". "'Y'";
$sql  = "select * from "."wikka"."pages WHERE latest = ". "'Y'";

$app->get("/", function () {
    echo '<div id="content"> Welcome to Slim based API</div>';
});

$app->get('/pages', function (Request $request, Response $response) {
    $this->logger->addInfo("Ticket list");
    $mapper = new TicketMapper($this->db);
    $tickets = $mapper->getTickets();
    $response = $this->view->render($response, "tickets.phtml", ["tickets" => $tickets, "router" => $this->router]);
    return $response;
});

$app->get("/pages/", function () {
    $dblink = new PDO("sqlite".":"."/var/www/html/wikka/wikka");
    //$dblink = getDB();
    //$query  = "select * from "."wikka_"."pages WHERE latest = ". "'Y' AND tag='guzzle'";
    $query  = "select * from "."wikka_"."pages WHERE latest = ". "'Y' LIMIT 5";

    //SELECT * FROM ".$wakka->config['table_prefix']."pages WHERE tag=:tag ORDER BY time DESC LIMIT 2", array(':tag' => $tag)
    //$query = "";

    $result = $dblink->prepare($query);
    $result->execute();

    $pages = $result->fetch(PDO::FETCH_OBJ);

    $pages->body = base64_encode($pages->body);

    //$pages['body'] = base64_encode($pages['body']);

    //print_r( base64_encode($pages_result['body']) );

    print_r( json_encode($pages) );
});

$app->run();

?>
