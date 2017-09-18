<?php

namespace App;

use DI\ContainerBuilder;
use DI\Bridge\Slim\App as DIBridge;

/**
 * Class App
 * @package App
 */
class App extends DIBridge
{
    /**
     * @param ContainerBuilder $builder
     */
    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->addDefinitions([
            'settings.displayErrorDetails' => true,
            'settings.determineRouteBeforeAppMiddleware' => true,
        ]);

        $builder->addDefinitions(__DIR__ . '/dependencies.php');
    }
}
