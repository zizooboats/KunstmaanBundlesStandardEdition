<?php

namespace Zizoo\Bundle\CmsBundle\Entity\PageParts;

use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\MediaBundle\Entity\Media;

/**
 * DownloadPagePart
 *
 * @ORM\Entity
 * @ORM\Table(name="zizoo_cms_bundle_download_page_parts")
 */
class DownloadPagePart extends AbstractPagePart
{
    /**
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id", nullable=false)
     */
    protected $media;

    /**
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="thumbnail_media_id", referencedColumnName="id", nullable=true)
     * 
     */
    protected $thumbnail;


    /**
     * Get media
     *
     * @return Media
     */
    public function getMedia()
    {
	    return $this->media;
    }

    /**
     * Set media
     *
     * @param Media $media
     *
     * @return DownloadPagePart
     */
    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * @param \Kunstmaan\MediaBundle\Entity\Media $thumbnail
     *
     * @return $this
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * @return \Kunstmaan\MediaBundle\Entity\Media
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }


    /**
     * @return string
     */
    public function getDefaultView()
    {
	return "ZizooCmsBundle:PageParts/DownloadPagePart:view.html.twig";
    }

    /**
     * @return DownloadPagePartAdminType
     */
    public function getDefaultAdminType()
    {
	return new \Zizoo\Bundle\CmsBundle\Form\PageParts\DownloadPagePartAdminType();
    }
}
