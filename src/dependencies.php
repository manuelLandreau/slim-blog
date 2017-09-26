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

        $twig->getEnvironment()->addGlobal('flash', $c->get('flash')->flash());
        $twig->getEnvironment()->addGlobal('prefix', getenv('NODE_ENV') == 'prod' ? '/public' : '');

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
        $logger->pushHandler(
            new Monolog\Handler\StreamHandler(
                $c->get('monolog.config')['path'],
                $c->get('monolog.config')['level']
            )
        );
        return $logger;
    },

    // Doctrine
    'doctrine.config' => function (\Psr\Container\ContainerInterface $c) {
        return [
            'meta' => [
                'entity_path' => [
                    __DIR__ . '/Entity'
                ],
                'auto_generate_proxies' => true,
                'proxy_dir' => __DIR__ . '/../cache/proxies',
                'cache' => null,
            ],
            'connection' => [
                'driver' => getenv('DRIVER'),
                'host' => getenv('HOST'),
                'dbname' => getenv('DATABASE'),
                'user' => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD'),
            ]
        ];
    },
    \Doctrine\ORM\EntityManager::class => function (\Psr\Container\ContainerInterface $c) {
        $settings = $c->get('doctrine.config');
        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            $settings['meta']['entity_path'],
            $settings['meta']['auto_generate_proxies'],
            $settings['meta']['proxy_dir'],
            $settings['meta']['cache'],
            true
        );
        return \Doctrine\ORM\EntityManager::create($settings['connection'], $config);
    },

    // Csrf protection
    'csrf' => function () {
        return new \Slim\Csrf\Guard;
    },

    // Flash messages
    'flash' => function () {
        return new Pagerange\Flash\Flash();
    }
];
