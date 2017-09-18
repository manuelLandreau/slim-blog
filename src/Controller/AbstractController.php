<?php

namespace App\Controller;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;

/**
 * Class AbstractController
 * @package App\Controller
 */
abstract class AbstractController
{
    protected $container;

    /**
     * AbstractController constructor.
     * @param ContainerInterface $container
     */
    function __construct(ContainerInterface $container)
    {
        $this->containter = $container;
    }

    /**
     * @param Request $request
     * @return array
     */
    function getCsrf(Request $request)
    {
        $nameKey = $this->containter->get('csrf')->getTokenNameKey();
        $valueKey = $this->containter->get('csrf')->getTokenValueKey();
        $name = $request->getAttribute($nameKey);
        $value = $request->getAttribute($valueKey);
        return compact('nameKey', 'valueKey', 'name', 'value');
    }
}
