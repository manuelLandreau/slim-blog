<?php

namespace App\Resource;

use App\Entity\Article;
use Doctrine\ORM\EntityManager;
use Slim\Http\Request;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class Resource CGUD
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
     * @param Request $request
     * @return Article
     */
    public function create(Request $request): Article
    {
        $article = new Article();
        $article->setTitle($request->getParam('title'));
        $article->setDescription($request->getParam('description'));
        $article->setCreatedAt(new \DateTime());
        $article->setUpdatedAt(new \DateTime());
        $article->setContent($request->getParam('content'));
        $article->setSlug($request->getParam('slug'));
        $this->entityManager->persist($article);
        $this->entityManager->flush();
        return $article;
    }

    /**
     * @param string|null $id
     * @return array
     */
    public function get(string $id = null): array
    {
        if ($id === null) {
            $articles = $this->entityManager->getRepository('App\Entity\Article')->findAll();
            $articles = array_map(
                function (Article $article) {
                    return $article->getArrayCopy();
                },
                $articles
            );
            return $articles;
        } else {
            $article = $this->entityManager->getRepository('App\Entity\Article')->find($id);
            if ($article) {
                return $article->getArrayCopy();
            }
        }
    }

    /**
     * @param string|null $slug
     * @return array
     */
    public function getBySlug(string $slug): array
    {
        $article = $this->entityManager->getRepository('App\Entity\Article')->findOneBy(
            array('slug' => $slug)
        );
        if ($article) {
            return $article->getArrayCopy();
        }
    }

    /**
     * @param Request $request
     * @param string $id
     * @return Article
     */
    public function update(Request $request, string $id): Article
    {
        $article = $this->entityManager->getRepository('App\Entity\Article')->find($id);
        $article->setTitle($request->getParam('title'));
        $article->setDescription($request->getParam('description'));
        $article->setUpdatedAt(new \DateTime());
        $article->setContent($request->getParam('content'));
        $article->setSlug($request->getParam('slug'));
        $this->entityManager->merge($article);
        $this->entityManager->flush();
        return $article;
    }

    /**
     * @param string $id
     */
    public function delete(string $id)
    {
        $article = $this->entityManager->getRepository('App\Entity\Article')->find($id);
        if ($article) {
            $this->entityManager->remove($article);
            $this->entityManager->flush();
        }
    }
}
