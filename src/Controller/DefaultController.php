<?php

namespace App\Controller;

use App\Resource\ArticleResource;
use Doctrine\ORM\ORMInvalidArgumentException;
use Psr\Container\ContainerInterface;
use \Slim\Http\Request;
use \Slim\Http\Response;
use Slim\Views\Twig;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class ArticleController
 * @package App\Controller
 */
final class DefaultController extends AbstractController
{

    /**
     * ArticleController constructor.
     * @param ContainerInterface $container
     * @param Twig $view
     * @internal param ArticleResource $articleResource
     */
    public function __construct(ContainerInterface $container, Twig $view)
    {
        parent::__construct($container, $view);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response|string
     */
    public function IndexAction(Request $request, Response $response)
    {
        return $this->view->render($response, 'app/index.twig');
    }
}