<?php

namespace App\Resource;

use App\Entity\Article;
use Doctrine\ORM\EntityManager;

/**
 * Class Resource
 *
 * @package App
 */
class ArticleResource extends AbstractResource
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
    }

    /**
     * @param string|null $slug
     *
     * @return array
     */
    public function get($slug = null)
    {
        if ($slug === null) {
            $articles = $this->entityManager->getRepository('App\Entity\Article')->findAll();
            $articles = array_map(
                function (Article $article) {
                    return $article->getArrayCopy();
                },
                $articles
            );

            return $articles;
        } else {
            $article = $this->entityManager->getRepository('App\Entity\Article')->findOneBy(
                array('id' => $slug)
            );
            if ($article) {
                return $article->getArrayCopy();
            }
        }
        return [];
    }
}
