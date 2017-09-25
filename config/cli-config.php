<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once __DIR__ . '/../index.php';

return ConsoleRunner::createHelperSet($app->getContainer()->get(\Doctrine\ORM\EntityManager::class));
