<?php

namespace App\Controller;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Views\Twig;

/**
 * Class AbstractController
 * @package App\Controller
 */
abstract class AbstractController
{
    protected $container;

    protected $view;

    /**
     * AbstractController constructor.
     * @param ContainerInterface $container
     */
    function __construct(ContainerInterface $container, Twig $view)
    {
        $this->container = $container;
        $this->view = $view;
    }

    /**
     * Generate csrf tikens through the request
     * @param Request $request
     * @return array
     */
    function getCsrf(Request $request): array
    {
        $nameKey = $this->getContainer()->get('csrf')->getTokenNameKey();
        $valueKey = $this->getContainer()->get('csrf')->getTokenValueKey();
        $name = $request->getAttribute($nameKey);
        $value = $request->getAttribute($valueKey);
        return compact('nameKey', 'valueKey', 'name', 'value');
    }

    /**
     * Allow the app to pass flash messages without reload or redirect
     * @param string $key
     * @param mixed $value
     * @return array
     */
    function setFlashMessage(string $key, $value): array
    {
        $_SESSION['slim.flash'][$key] = $value;
        return $_SESSION['slim.flash'];
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @param string $msg
     */
    protected function success(string $msg)
    {
        $this->getContainer()
            ->get('flash')
            ->message($msg, ['alert', 'alert-success']);
    }

    /**
     * @param string $msg
     */
    protected function warning(string $msg)
    {
        $this->getContainer()
            ->get('flash')
            ->message($msg, ['alert', 'alert-warning']);
    }

    /**
     * @param string $msg
     */
    protected function info(string $msg)
    {
        $this->getContainer()
            ->get('flash')
            ->message($msg, ['alert', 'alert-info']);
    }

    /**
     * @param string $msg
     */
    protected function error(string $msg)
    {
        $this->getContainer()
            ->get('flash')
            ->message($msg, ['alert', 'alert-danger']);
    }
}
