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
    public function __construct(ArticleResource $articleResource, ContainerInterface $container)
    {
        parent::__construct($container);
        $this->articleResource = $articleResource;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param Twig $view
     * @return Response|string
     */
    public function IndexAction(Request $request, Response $response, Twig $view)
    {
        $articles = $this->articleResource->get();
        return $view->render($response, 'home/index.twig', ['articles' => $articles]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param Twig $view
     * @return Response|string
     */
    public function showAction(Request $request, Response $response, Twig $view)
    {
        $id = $request->getAttributes()['routeInfo'][2]['id']; // To improve
        $article = $this->articleResource->get($id);

        // Csrf protection
        $csrf = $this->getCsrf($request);
        return $view->render($response, 'article/show.twig', ['article' => $article, 'csrf' => $csrf]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param Twig $view
     * @return Response|string
     */
    public function createOrUpdateAction(Request $request, Response $response, Twig $view)
    {
        // Id param
        $id = $request->getAttributes()['routeInfo'][2]['id']; // Todo:  improve

        // get the Csrf tokens
        $csrf = $this->getCsrf($request);

        if (empty($id)) {
            if ($request->getMethod() == 'POST') {
                $article = $this->articleResource->create($request);
                $this->success('Article "' . $article->getTitle() . '" successfully created.');
                return $response->withRedirect(
                    $this->getContainer()->get('router')->pathFor('article.show', ['id' => $article->getId()]),
                    301
                );
            }
            return $view->render($response, 'article/new.twig', ['csrf' => $csrf]);
        } else {
            if ($request->getMethod() == 'POST') {
                $article = $this->articleResource->update($request, $id);
                $this->success('Article "' . $article->getTitle() . '" successfully updated.');
                return $response->withRedirect(
                    $this->getContainer()->get('router')->pathFor('article.show', ['id' => $article->getId()]),
                    301
                );
            }
            $article = $this->articleResource->get($id);
            return $view->render($response, 'article/edit.twig', ['article' => $article, 'csrf' => $csrf]);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response|string
     */
    public function deleteAction(Request $request, Response $response)
    {
        $id = $request->getAttributes()['routeInfo'][2]['id']; // To improve
        $this->articleResource->delete($id);
        $this->success('Article "' . $id . '" successfully removed.');
        return $response->withRedirect($this->getContainer()->get('router')->pathFor('home'), 301);
    }
}
