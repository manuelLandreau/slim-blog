<?php

// Routes

// Back office routes
use Slim\Http\Request;
use Slim\Http\Response;

// Api routes
$app->get('/api/articles', function (Request $request, Response $response) {
    return $this->get('articleController')->fetch($request, $response);
});

$app->get('/api/articles/{slug}', function (Request $request, Response $response) {
    return $this->get('articleController')->fetchOne($request, $response, $request->getAttribute('slug'));
});

$app->get('/', \App\Controller\HomeController::class);
