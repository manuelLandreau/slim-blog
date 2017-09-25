<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Api routes
$app->get('/api/articles', ['\App\Controller\ApiController', 'fetch']);
$app->get('/api/articles/{slug:[a-zA-Z0-9_-]+}', ['\App\Controller\ApiController', 'fetchOneBySlug']);


// BO routes
$app->get('/', ['\App\Controller\ArticleController', 'indexAction'])
    ->setName('home');

$app->get('/articles/show/{id:[0-9]+}', ['\App\Controller\ArticleController', 'showAction'])
    ->setName('article.show');

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

$app->delete('/articles/delete/{id:[0-9]+}', ['\App\Controller\ArticleController', 'deleteAction'])
    ->setName('article.delete');
