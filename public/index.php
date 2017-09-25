<?php

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

session_start();

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

$settings = include __DIR__ . '/../src/dependencies.php';

$app = new \App\App;

$container = $app->getContainer();

require __DIR__ . '/../src/middleware.php';

require __DIR__ . '/../src/routes.php';

$app->run();