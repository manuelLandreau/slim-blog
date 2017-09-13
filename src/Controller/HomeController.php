<?php

namespace App\Controller;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class HomeController
 * @package App\Controllers
 */
class HomeController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param Twig $view
     * @return Response
     */
    public function __invoke(Request $request, Response $response, Twig $view)
    {
        return $view->render($response, 'home.twig');
    }
}
