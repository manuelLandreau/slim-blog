<?php

namespace App\Resource;

use App\Controller\ArticleController;
use App\Entity\Article;
use App\Service\AWSService;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class Resource CGUD
 *
 * @package App
 */
class ArticleResource extends AbstractResource
{
    protected $container;

    public function __construct(EntityManager $entityManager, ContainerInterface $container)
    {
        parent::__construct($entityManager, $container);
    }

    /**
     * @param Request $request
     * @return Article
     */
    public function create(Request $request): Article
    {
        $article = new Article();
        $AWSArticle = AWSService::getProductInfo($request->getParam('asin'));

        $article->setAsin($request->getParam('asin'));
        $article->setAmazonUrl($request->getParam('amazon_url'));
        $article->setTitle($AWSArticle['title']);
        $article->setDescription($AWSArticle['description']);
        $article->setContent($AWSArticle['content']);
        $article->setDetails($AWSArticle['details']);
        $article->setPrice($AWSArticle['price']);
        $article->setSmallImageUrl($AWSArticle['small_image']);
        $article->setMediumImageUrl($AWSArticle['medium_image']);
        $article->setLargeImageUrl($AWSArticle['large_image']);
        $article->setImageSet($AWSArticle['image_set']);
        $article->setCreatedAt(new \DateTime());
        $article->setUpdatedAt(new \DateTime());
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
        $AWSArticle = AWSService::getProductInfo($request->getParam('asin'));

        $article->setAsin($request->getParam('asin'));
        $article->setAmazonUrl($request->getParam('amazon_url'));
        $article->setTitle($AWSArticle['title']);
        $article->setDescription($AWSArticle['description']);
        $article->setContent($AWSArticle['content']);
        $article->setDetails($AWSArticle['details']);
        $article->setPrice($AWSArticle['price']);
        $article->setSmallImageUrl($AWSArticle['small_image']);
        $article->setMediumImageUrl($AWSArticle['medium_image']);
        $article->setLargeImageUrl($AWSArticle['large_image']);
        $article->setImageSet($AWSArticle['image_set']);
        $article->setUpdatedAt(new \DateTime());
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
