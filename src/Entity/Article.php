<?php

namespace App\Entity;

use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="articles")
 */
class Article
{
    /**
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=255)
     */
    protected $asin;

    /**
     * @Column(type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * @Column(type="text", nullable=true)
     */
    protected $details;

    /**
     * @Column(type="string", length=255)
     */
    protected $price;

    /**
     * @Column(type="string", length=255)
     */
    protected $amazonUrl;

    /**
     * @Column(type="text", length=255, nullable=true)
     */
    protected $smallImageUrl;

    /**
     * @Column(type="text", length=255, nullable=true)
     */
    protected $mediumImageUrl;

    /**
     * @Column(type="text", length=255, nullable=true)
     */
    protected $largeImageUrl;

    /**
     * @Column(type="text", length=255, nullable=true)
     */
    protected $imageSet;

    /**
     * @Column(type="date", name="created_at", nullable=true)
     */
    protected $createdAt;

    /**
     * @Column(type="date", name="updated_at", nullable=true)
     */
    protected $updatedAt;

    /**
     * Url name
     * @Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $slug;


    /**
     * Get article id
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getAsin(): string
    {
        return $this->asin;
    }

    /**
     * @param string $asin
     */
    public function setAsin(string $asin)
    {
        $this->asin = $asin;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getAmazonUrl()
    {
        return $this->amazonUrl;
    }

    /**
     * @param mixed $amazonUrl
     */
    public function setAmazonUrl($amazonUrl)
    {
        $this->amazonUrl = $amazonUrl;
    }

    /**
     * @return mixed
     */
    public function getSmallImageUrl()
    {
        return $this->smallImageUrl;
    }

    /**
     * @param mixed $smallImageUrl
     */
    public function setSmallImageUrl($smallImageUrl)
    {
        $this->smallImageUrl = $smallImageUrl;
    }

    /**
     * @return mixed
     */
    public function getMediumImageUrl()
    {
        return $this->mediumImageUrl;
    }

    /**
     * @param mixed $mediumImageUrl
     */
    public function setMediumImageUrl($mediumImageUrl)
    {
        $this->mediumImageUrl = $mediumImageUrl;
    }

    /**
     * @return mixed
     */
    public function getLargeImageUrl()
    {
        return $this->largeImageUrl;
    }

    /**
     * @param mixed $largeImageUrl
     */
    public function setLargeImageUrl($largeImageUrl)
    {
        $this->largeImageUrl = $largeImageUrl;
    }

    /**
     * @return mixed
     */
    public function getImageSet()
    {
        return $this->imageSet;
    }

    /**
     * @param mixed $imageSet
     */
    public function setImageSet($imageSet)
    {
        $this->imageSet = $imageSet;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get array copy of object
     *
     * @return array
     */
    public function getArrayCopy(): array
    {
        return get_object_vars($this);
    }
}
