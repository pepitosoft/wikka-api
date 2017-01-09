<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
// Routes
require __DIR__ . '/../src/classes/Mapper.php';
require __DIR__ . '/../src/classes/PagesMaster.php';
require __DIR__ . '/../src/classes/UsersMaster.php';

/*
spl_autoload_register(function ($classname) {
    require __DIR__ . "/../src/classes/" . $classname . ".php";
});*/

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/pages/', function (Request $request, Response $response) {
    $this->logger->addInfo("Page table description");
    $mapper = new PagesMapper($this->db, $this->settings);
    $mapper = $mapper->getPagesDef();
    //print( json_encode($mapper) );
    //$response = $this->view->render($response, "tickets.phtml", ["tickets" => $tickets, "router" => $this->router]);
    return json_encode($mapper);
});

$app->get('/pages/{all}', function (Request $request, Response $response) {
    $this->logger->addInfo("Ticket list");
    $mapper = new PageMapper($this->db);
    $mapper = $mapper->getPagesAll();
    print_r( json_encode($mapper) );
    //$response = $this->view->render($response, "tickets.phtml", ["tickets" => $tickets, "router" => $this->router]);
    return $response;
});
