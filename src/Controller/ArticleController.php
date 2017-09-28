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
final class ArticleController extends AbstractController
{
    private $articleResource;

    /**
     * ArticleController constructor.
     * @param ArticleResource $articleResource
     * @param ContainerInterface $container
     */
    public function __construct(ArticleResource $articleResource, ContainerInterface $container, Twig $view)
    {
        parent::__construct($container, $view);
        $this->articleResource = $articleResource;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response|string
     */
    public function IndexAction(Request $request, Response $response)
    {
        $articles = $this->articleResource->get();
        return $this->view->render($response, 'home/index.twig', ['articles' => $articles]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response|string
     */
    public function showAction(Request $request, Response $response)
    {
        $id = $request->getAttributes()['routeInfo'][2] ? $request->getAttributes()['routeInfo'][2]['id'] : null;
        $article = $this->articleResource->get($id);

        // Csrf protection
        $csrf = $this->getCsrf($request);
        return $this->view->render($response, 'article/show.twig', ['article' => $article, 'csrf' => $csrf]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response|string
     */
    public function createOrUpdateAction(Request $request, Response $response)
    {
        // Id param
        $id = $request->getAttributes()['routeInfo'][2] ? $request->getAttributes()['routeInfo'][2]['id'] : null;

        // get the Csrf tokens
        $csrf = $this->getCsrf($request);

        if (empty($id)) {

            if ($request->getMethod() == 'POST') {
                $article = $this->articleResource->create($request);
                $id = $article->getTitle();
                $this->success("Article $id successfully created.");
                return $response->withRedirect(
                    $this->getContainer()->get('router')->pathFor('article.show', ['id' => $article->getId()]),
                    301
                );
            }
            return $this->view->render($response, 'article/new.twig', ['csrf' => $csrf]);
        } else {
            if ($request->getMethod() == 'POST') {
                $article = $this->articleResource->update($request, $id);
                $this->success("Article $id successfully updated.");
                return $response->withRedirect(
                    $this->getContainer()->get('router')->pathFor('article.show', ['id' => $article->getId()]),
                    301
                );
            }
            $article = $this->articleResource->get($id);
            return $this->view->render($response, 'article/edit.twig', ['article' => $article, 'csrf' => $csrf]);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response|string
     */
    public function deleteAction(Request $request, Response $response)
    {
        $id = $request->getAttributes()['routeInfo'][2] ? $request->getAttributes()['routeInfo'][2]['id'] : null;
        $this->articleResource->delete($id);
        $this->success("Article $id successfully removed.");
        return $response->withRedirect($this->getContainer()->get('router')->pathFor('home'), 301);
    }
}
