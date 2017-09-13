<?php

namespace App\Controller;

use App\Resource\ArticleResource;
use \Slim\Http\Request;
use \Slim\Http\Response;

/**
 * Class ArticleController
 * @package App\Controller
 */
final class ArticleController
{
    private $articleResource;

    /**
     * ArticleController constructor.
     * @param ArticleResource $articleResource
     */
    public function __construct(ArticleResource $articleResource)
    {
        $this->articleResource = $articleResource;
    }

    public function fetch(Request $request, Response $response)
    {
        $articles = $this->articleResource->get();
        return $response->withJSON($articles);
    }

    public function fetchOne(Request $request, Response $response, $args)
    {
        $article = $this->articleResource->get($args);
        if ($article) {
            return $response->withJSON($article);
        }
        return $response->withStatus(404, 'No article found with that slug.');
    }
}
