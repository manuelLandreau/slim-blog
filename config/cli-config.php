<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once __DIR__ . '/../public/index.php';

$settings = include __DIR__ . '/../src/container.php';
$settings = $settings['doctrine.settings'];

// replace with mechanism to retrieve EntityManager in your app
$entityManager = \Doctrine\ORM\EntityManager::create($settings['connection'], $config);

return ConsoleRunner::createHelperSet($entityManager);
