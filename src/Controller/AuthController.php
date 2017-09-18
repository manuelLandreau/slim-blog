<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

/**
 * Class AuthController
 * @package App\Controller
 */
class AuthController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param Twig $view
     * @return Response|string
     */
    public function __invoke(Request $request, Response $response, Twig $view)
    {
        return $view->render($response, 'login/login.twig');
    }
}
