<?php

namespace App\Controller;

use App\Resource\ArticleResource;
use \Slim\Http\Request;
use \Slim\Http\Response;

/**
 * Class ApiController
 * @package App\Controller
 */
final class ApiController
{
    private $articleResource;

    /**
     * ApiController constructor.
     * @param ArticleResource $articleResource
     */
    public function __construct(ArticleResource $articleResource)
    {
        $this->articleResource = $articleResource;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function fetch(Request $request, Response $response): Response
    {
        $articles = $this->articleResource->get();
        return $response->withJSON($articles);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function fetchOne(Request $request, Response $response, $args): Response
    {
        $article = $this->articleResource->get($args);
        if ($article) {
            return $response->withJSON($article);
        }
        return $response->withStatus(404, 'No article found with that slug.');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function fetchOneBySlug(Request $request, Response $response): Response
    {
        $slug = $request->getAttributes()['routeInfo'][2]['slug']; // To improve
        $article = $this->articleResource->getBySlug($slug);
        if ($article) {
            return $response->withJSON($article);
        }
        return $response->withStatus(404, 'No article found with that slug.');
    }
}
