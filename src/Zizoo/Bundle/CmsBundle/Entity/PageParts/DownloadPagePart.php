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
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     */
    protected $media;

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
