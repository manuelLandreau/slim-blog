<?php

session_start();

require __DIR__.'/../vendor/autoload.php';

$paths = array(__DIR__ . '/../src/Entity');
$isDevMode = true;

$settings = include __DIR__ . '/../src/container.php';

// the connection configuration
$dbParams = $settings['doctrine.config']['connection'];

$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = \Doctrine\ORM\EntityManager::create($dbParams, $config);

$app = new \App\App;

require __DIR__ . '/../src/routes.php';

$app->run();