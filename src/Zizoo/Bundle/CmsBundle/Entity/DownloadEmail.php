<?php

namespace Zizoo\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\MediaBundle\Entity\Media;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DownloadEmail
 *
 * @ORM\Table(name="zizoo_cms_bundle_download_email")
 * @ORM\Entity(repositoryClass="Zizoo\Bundle\CmsBundle\Entity\DownloadEmailRepository")
 */
class DownloadEmail
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true,
     *     strict = true,
     *     checkHost = true
     * )
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    protected $email;


    /**
     * @var \DateTime
     * @Assert\DateTime(message="The value: {{value}} is not valid! Downloaded at is datetime type")
     * @ORM\Column(name="downloaded_at", type="datetime", nullable=false)
     */
    protected $downloadedAt;


    /**
     * @var Media
     *
     * @Assert\Type("object")
     *
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="downloaded_media_id", referencedColumnName="id", nullable=false)
     */
    protected $downloadedMedia;


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
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return DownloadEmail
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }


    /**
     * @return \DateTime
     */
    public function getDownloadedAt()
    {
        return $this->downloadedAt;
    }

    /**
     * @param \DateTime $downloadedAt
     *
     * @return DownloadEmail
     */
    public function setDownloadedAt($downloadedAt)
    {
        $this->downloadedAt = $downloadedAt;

        return $this;
    }


    /**
     * @return Media
     */
    public function getDownloadedMedia()
    {
        return $this->downloadedMedia;
    }

    /**
     * @param Media $downloadedMedia
     *
     * @return DownloadEmail
     */
    public function setDownloadedMedia($downloadedMedia)
    {
        $this->downloadedMedia = $downloadedMedia;

        return $this;
    }
}

