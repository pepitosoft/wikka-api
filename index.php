<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

require 'vendor/autoload.php';

$app = new \Slim\App();

/*
function getDB()
{
    $dbhost = "";
    $dbuser = "";
    $dbpass = "";
    $dbname = "";

      //$dsn = $obj->GetConfigValue('dbms_type') . ':' .  $obj->GetConfigValue('dbms_database');
      $dsn = "sqlite".":"."/var/www/html/wikka/wikka";

//    $mysql_conn_string = "mysql:host=$dbhost;dbname=$dbname";
//    $dbConnection = new PDO($mysql_conn_string, $dbuser, $dbpass);
//    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    try {
      $dbConnection = new PDO($dsn);
    } catch(PDOException $e) {
      die('<em class="error">'.print("PDO connection error!").'</em>');
    }


    $dbConnection = new PDO($dsn);

    return $dbConnection;
}*/

//$db = getDB();

//$sql  = "select * from ".$this->GetConfigValue('table_prefix')."pages WHERE latest = ". "'Y'";
$sql  = "select * from "."wikka"."pages WHERE latest = ". "'Y'";

$app->get("/", function () {
    echo '<div id="content"> Welcome to Slim based API</div>';
});

$app->get("/pages/", function () {
    $dblink = new PDO("sqlite".":"."/var/www/html/wikka/wikka");
    $query  = "select * from "."wikka_"."pages WHERE latest = ". "'Y'";

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
