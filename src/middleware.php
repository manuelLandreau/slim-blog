<?php

use \Slim\Http\Request;
use \Slim\Http\Response;

// Application middleware

// Basic http auth
//$app->add(new \Slim\Middleware\HttpBasicAuthentication([
//            "path" => "/",
//            "passthrough" => ["/api", "/css"],
//            "realm" => "Protected",
////        "secure" => false,
////        "relaxed" => ["localhost:8000"],
//            "users" => [
//                "admin" => "admin",
//            ],
//            "callback" => function (Request $request, Response $response) {
//                return $response->withRedirect('/articles', 301);
//            }]
//    ));

// A middleware for enabling CORS
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
})
    ->add(function (Request $request, Response $response, $next) {
    $res = $next($request, $response);
    return $res
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});
