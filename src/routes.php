<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
// Routes

// Pages

$app->get('/pages/[{rows}]', function (Request $request, Response $response, $args) {
  $this->logger->addInfo("Page table description");
  $mapper = new PagesMapper($this->db, $this->settings);
  if( isset( $args['rows'] ) )
    $mapper = $mapper->getPagesAll($args['rows']);
  else
    $mapper = $mapper->getPages();
  return json_encode($mapper);
});

$app->get('/pages/id/{id}', function (Request $request, Response $response, $args) {
  $this->logger->addInfo("Page table description");
  $mapper = new PagesMapper($this->db, $this->settings);
  $mapper = $mapper->getPageById($args['id']);
  return json_encode($mapper);
});

$app->get('/[{name}]', function (Request $request, Response $response, $args) {

  switch ($args['name']) {
    case "acls":
      $this->logger->addInfo($args['name']." table description");
      $mapper = new AclsMapper($this->db, $this->settings);
      $mapper = $mapper->getDef();
      return json_encode($mapper);
      break;

    case "comments":
      $this->logger->addInfo($args['name']." table description");
      $mapper = new CommentsMapper($this->db, $this->settings);
      $mapper = $mapper->getDef();
      return json_encode($mapper);
      break;

    case "links":
      $this->logger->addInfo($args['name']." table description");
      $mapper = new LinksMapper($this->db, $this->settings);
      $mapper = $mapper->getDef();
      return json_encode($mapper);
      break;

    case "pages":
      $this->logger->addInfo($args['name']." table description");
      $mapper = new PagesMapper($this->db, $this->settings);
      $mapper = $mapper->getDef();
      return json_encode($mapper);
      break;

    case "referrerblacklist":
      $this->logger->addInfo($args['name']." table description");
      $mapper = new ReferrerBlacklistMapper($this->db, $this->settings);
      $mapper = $mapper->getDef();
      return json_encode($mapper);
      break;

    case "referrers":
      $this->logger->addInfo($args['name']." table description");
      $mapper = new ReferrersMapper($this->db, $this->settings);
      $mapper = $mapper->getDef();
      return json_encode($mapper);
      break;

    case "sessions":
      $this->logger->addInfo($args['name']." table description");
      $mapper = new SessionsMapper($this->db, $this->settings);
      $mapper = $mapper->getDef();
      return json_encode($mapper);
      break;

    case "users":
      $this->logger->addInfo($args['name']." table description");
      $mapper = new UsersMapper($this->db, $this->settings);
      $mapper = $mapper->getDef();
      return json_encode($mapper);
      break;

    default:
      // Sample log message
      $this->logger->info("Slim-Skeleton '/' route");
      // Render index view
      return $this->renderer->render($response, 'index.phtml', $args);
      break;
  }
});
