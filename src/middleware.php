<?php
use \Slim\Middleware\JwtAuthentication;
use \Slim\Middleware\JwtAuthentication\RequestPathRule;
use \Slim\Middleware\HttpBasicAuthentication;
use \Slim\Middleware\HttpBasicAuthentication\PdoAuthenticator;
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

/*
$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    "users" => [
        "root" => "t00r",
        "somebody" => "passw0rd"
    ]
]));
*/

/*
$app->add(new \Slim\Middleware\JwtAuthentication([
    "logger" => $container['logger'],
    "secret" => "supersecretkeyyoushouldnotcommittogithub"
]));
*/

/*
$app->add(new HttpBasicAuthentication([
    "path" => "/token",
    "users" => [
        "test" => "test"
    ],
//    "environment" => "REDIRECT_HTTP_AUTHORIZATION"
]));*/

//$hash =
/*
if ( $settings['settings']['db']['type'] == "sqlite" ){
  $pdo = new \PDO($settings['settings']['db']['type'].":".$settings['settings']['db']['path']);
}else {
  $pdo = $app->db();
}

$db = ;
*/

$container = $app->getContainer();
$pdo = $container['db'];

$app->add(new \Slim\Middleware\HttpBasicAuthentication([  "realm" => "Protected",
                                                          "secure" => false,
                                                          "path" => '/token',
                                                          "error" => function ($request, $response, $arguments) {
                                                                    $data = [];
                                                                    $data["status"] = "error";
                                                                    $data["message"] = $arguments["message"];
                                                                    return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));
                                                                  },
                                                          "authenticator" => new WikkaAuthenticator([ "pdo" => $pdo,
                                                                                                    "table" => $settings['settings']['db']['prefix']."users",
                                                                                                    "user" => "name",
                                                                                                    "hash" => "password" ])
                                                         ])
);
// "users" => [ "user" => "pass",
//             "user1" => "123" ]

$app->add(new \Slim\Middleware\JwtAuthentication([
    "secret" => "supersecretkeyyoushouldnotcommittogithub",
    "secure" => false,
    "rules" => [
        new RequestPathRule([
            "path" => "/",
            "passthrough" => ["/token", "/ping"]
        ])
    ]
]));
