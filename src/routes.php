<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
// Routes
require __DIR__ . '/../src/classes/Mapper.php';
require __DIR__ . '/../src/classes/AclsMaster.php';
require __DIR__ . '/../src/classes/CommentsMaster.php';
require __DIR__ . '/../src/classes/LinksMaster.php';
require __DIR__ . '/../src/classes/PagesMaster.php';
require __DIR__ . '/../src/classes/ReferrerBlacklistMaster.php';
require __DIR__ . '/../src/classes/ReferrersMaster.php';
require __DIR__ . '/../src/classes/SessionsMaster.php';
require __DIR__ . '/../src/classes/UsersMaster.php';

/*
spl_autoload_register(function ($classname) {
    require __DIR__ . "/../src/classes/" . $classname . ".php";
});*/

// Acls

$app->get('/acls', function (Request $request, Response $response) {
    $this->logger->addInfo("Acls table description");
    $mapper = new AclsMapper($this->db, $this->settings);
    $mapper = $mapper->getDef();
    return json_encode($mapper);
});

$app->get('/comments', function (Request $request, Response $response) {
    $this->logger->addInfo("Comments table description");
    $mapper = new CommentsMapper($this->db, $this->settings);
    $mapper = $mapper->getDef();
    return json_encode($mapper);
});

$app->get('/links', function (Request $request, Response $response) {
    $this->logger->addInfo("Links table description");
    $mapper = new LinksMapper($this->db, $this->settings);
    $mapper = $mapper->getDef();
    return json_encode($mapper);
});

// Pages

$app->get('/pages', function (Request $request, Response $response) {
    $this->logger->addInfo("Page table description");
    $mapper = new PagesMapper($this->db, $this->settings);
    $mapper = $mapper->getDef();
    return json_encode($mapper);
});

$app->get('/pages/', function (Request $request, Response $response) {
    $this->logger->addInfo("Page table description");
    $mapper = new PagesMapper($this->db, $this->settings);
    $mapper = $mapper->getPages();
    return json_encode($mapper);
});

$app->get('/referrerblacklist', function (Request $request, Response $response) {
    $this->logger->addInfo("Black list table description");
    $mapper = new ReferrerBlacklistMapper($this->db, $this->settings);
    $mapper = $mapper->getDef();
    return json_encode($mapper);
});

$app->get('/referrers', function (Request $request, Response $response) {
    $this->logger->addInfo("Black list table description");
    $mapper = new ReferrersMapper($this->db, $this->settings);
    $mapper = $mapper->getDef();
    return json_encode($mapper);
});

$app->get('/sessions', function (Request $request, Response $response) {
    $this->logger->addInfo("Black list table description");
    $mapper = new SessionsMapper($this->db, $this->settings);
    $mapper = $mapper->getDef();
    return json_encode($mapper);
});

$app->get('/users', function (Request $request, Response $response) {
    $this->logger->addInfo("Black list table description");
    $mapper = new UsersMapper($this->db, $this->settings);
    $mapper = $mapper->getDef();
    return json_encode($mapper);
});

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/pages/{all}', function (Request $request, Response $response) {
    $this->logger->addInfo("Ticket list");
    $mapper = new PageMapper($this->db);
    $mapper = $mapper->getPagesAll();
    print_r( json_encode($mapper) );
    //$response = $this->view->render($response, "tickets.phtml", ["tickets" => $tickets, "router" => $this->router]);
    return $response;
});
