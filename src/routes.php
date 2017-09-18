<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Api routes
$app->get('/api/articles', function (Request $request, Response $response) {
    return $this->get('articleController')->fetch($request, $response);
});

$app->get('/api/articles/{slug:[a-zA-Z0-9_-]+}', function (Request $request, Response $response) {
    return $this->get('articleController')->fetchOne($request, $response, $request->getAttribute('slug'));
});

// BO routes
//$app->get('/', function (Request $request, Response $response) use ($app) {
//    return $response->withRedirect($container->->get('router')->pathFor('home'));
//});

$app->get('/', ['\App\Controller\ArticleController', 'indexAction'])
    ->setName('home');

$app->get('/articles/show/{id:[0-9]+}', ['\App\Controller\ArticleController', 'showAction'])
    ->setName('article');

// ->via('GET', 'POST')
$app->get('/articles/new', ['\App\Controller\ArticleController', 'createOrUpdateAction'])
    ->add($container->get('csrf'))
    ->setName('article.new');

$app->post('/articles/new', ['\App\Controller\ArticleController', 'createOrUpdateAction'])
    ->setName('article.create');

$app->get('/articles/edit/{id:[0-9]+}', ['\App\Controller\ArticleController', 'createOrUpdateAction'])
    ->add($container->get('csrf'))
    ->setName('article.edit');

$app->post('/articles/edit/{id:[0-9]+}', ['\App\Controller\ArticleController', 'createOrUpdateAction'])
    ->setName('article.update');

$app->post('/articles/delete/{id:[0-9]+}', ['\App\Controller\ArticleController', 'deleteAction'])
    ->setName('article.delete');
