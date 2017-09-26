<?php

use \Slim\Http\Request;
use \Slim\Http\Response;

// Basic http auth
$app->add(new \Slim\Middleware\HttpBasicAuthentication([
            'path' => '/',
            'passthrough' => ['/api', '/public', '/css/*.css'],
            'realm' => 'Protected',
            'secure' => false,
            'relaxed' => ['localhost:8000', '58cd6c5487.url-de-test.ws'],
            'users' => [
                getenv('HTTP_USER') => getenv('HTTP_PASSWORD'), // TODO: create a methode for for password encryption
            ],
            'callback' => function (Request $request, Response $response) {
                return $response->withRedirect('/articles', 301);
            }]));

// Cors middleware
$app->add(new \Tuupola\Middleware\Cors([
    'origin' => ['*'],
    'methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
    'headers.allow' => [],
    'headers.expose' => [],
    'credentials' => false,
    'cache' => 0,
]));
