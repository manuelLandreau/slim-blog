<?php

use \Slim\Http\Request;
use \Slim\Http\Response;

// Basic http auth
$app->add(new \Slim\Middleware\HttpBasicAuthentication([
            "path" => "/",
            "passthrough" => ['/api', '/public', '/css/*.css'],
            "realm" => "Protected",
//        "secure" => false,
//        "relaxed" => ["localhost:8000"],
            "users" => [
                "admin" => "admin",
            ],
            "callback" => function (Request $request, Response $response) {
                return $response->withRedirect('/articles', 301);
            }]
    ));

// Cors middleware
$app->add(new \Tuupola\Middleware\Cors([
    'origin' => ['*'],
    'methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
    'headers.allow' => [],
    'headers.expose' => [],
    'credentials' => false,
    'cache' => 0,
]));
