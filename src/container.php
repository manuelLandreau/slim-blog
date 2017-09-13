<?php

use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Interop\Container\ContainerInterface;

// PHP-DI dependencies definitions

return [
    // Twig
    Twig::class => function (ContainerInterface $c) {
        $twig = new Twig(__DIR__.'/../resources/views', [
            'cache' => false
        ]);

        $twig->addExtension(new TwigExtension(
            $c->get('router'),
            $c->get('request')->getUri()
        ));

        return $twig;
    },

    // Monolog
    'monolog.config' => [
        'name' => 'slim-app',
        'path' => __DIR__ . '/../logs/app.log',
        'level' => \Monolog\Logger::DEBUG,
    ],
    'logger' => function (\Psr\Container\ContainerInterface $c) {
        $logger = new Monolog\Logger($c->get('monolog.config')['name']);
        $logger->pushProcessor(new Monolog\Processor\UidProcessor());
        $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $c->get('monolog.config')['level']));
        return $logger;
    },

    // Doctrine
    'doctrine.config' => [
        'meta' => [
            'entity_path' => [
                __DIR__ . '/Entity'
            ],
            'auto_generate_proxies' => true,
            'proxy_dir' => __DIR__ . '/../cache/proxies',
            'cache' => null,
        ],
        'connection' => [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'foo',
            'user' => 'root',
            'password' => '',
        ]
    ],
    \Doctrine\ORM\EntityManager::class => function (\Psr\Container\ContainerInterface $c) {
        $settings = $c->get('doctrine.config');
        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            $settings['meta']['entity_path'],
            $settings['meta']['auto_generate_proxies'],
            $settings['meta']['proxy_dir'],
            $settings['meta']['cache'],
            false
        );
        return \Doctrine\ORM\EntityManager::create($settings['connection'], $config);
    },

    // ArticleController
    'articleController' => function (\Psr\Container\ContainerInterface $c) {
        $articleResource = new \App\Resource\ArticleResource($c->get(\Doctrine\ORM\EntityManager::class));
        return new App\Controller\ArticleController($articleResource);
    },

];
