<?php

namespace Zizoo\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InstagramMedia
 *
 * @ORM\Table(name="zizoo_cmsbundle_instagram_media")
 * @ORM\Entity(repositoryClass="Zizoo\Bundle\CmsBundle\Entity\InstagramMediaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class InstagramMedia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="instagram_id", type="string", length=255, unique=true)
     */
    private $instagramId;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, unique=true)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail_url", type="string", length=1000)
     */
    private $thumbnailUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="small_image_url", type="string", length=1000)
     */
    private $smallImageUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="standard_image_url", type="string", length=1000)
     */
    private $standardImageUrl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inserted_at", type="datetime")
     */
    private $insertedAt;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set instagramId
     *
     * @param string $instagramId
     *
     * @return InstagramMedia
     */
    public function setInstagramId($instagramId)
    {
        $this->instagramId = $instagramId;

        return $this;
    }

    /**
     * Get instagramId
     *
     * @return string
     */
    public function getInstagramId()
    {
        return $this->instagramId;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return InstagramMedia
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set thumbnailUrl
     *
     * @param string $thumbnailUrl
     *
     * @return InstagramMedia
     */
    public function setThumbnailUrl($thumbnailUrl)
    {
        $this->thumbnailUrl = $thumbnailUrl;

        return $this;
    }

    /**
     * Get thumbnailUrl
     *
     * @return string
     */
    public function getThumbnailUrl()
    {
        return $this->thumbnailUrl;
    }

    /**
     * Set smallImageUrl
     *
     * @param string $smallImageUrl
     *
     * @return InstagramMedia
     */
    public function setSmallImageUrl($smallImageUrl)
    {
        $this->smallImageUrl = $smallImageUrl;

        return $this;
    }

    /**
     * Get smallImageUrl
     *
     * @return string
     */
    public function getSmallImageUrl()
    {
        return $this->smallImageUrl;
    }

    /**
     * Set standardImageUrl
     *
     * @param string $standardImageUrl
     *
     * @return InstagramMedia
     */
    public function setStandardImageUrl($standardImageUrl)
    {
        $this->standardImageUrl = $standardImageUrl;

        return $this;
    }

    /**
     * Get standardImageUrl
     *
     * @return string
     */
    public function getStandardImageUrl()
    {
        return $this->standardImageUrl;
    }

    /**
     * Set createdAt
     *
     * @param int $createdAtTimestamp
     *
     * @return InstagramMedia
     */
    public function setCreatedAtFromTimestamp($createdAtTimestamp)
    {
        $this->createdAt = new \DateTime('@' . $createdAtTimestamp);

        return $this;
    }


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return InstagramMedia
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set insertedAt
     *
     * @param \DateTime $insertedAt
     *
     * @return InstagramMedia
     */
    public function setInsertedAt($insertedAt)
    {
        $this->insertedAt = $insertedAt;

        return $this;
    }

    /**
     * Get insertedAt
     *
     * @return \DateTime
     */
    public function getInsertedAt()
    {
        return $this->insertedAt;
    }


    /**
     * @ORM\PrePersist
     */
    public function setInsertedAtOnPersist()
    {
        $this->insertedAt = new \DateTime();
    }
}

