<?php

namespace Zizoo\Bundle\CmsBundle\Entity\PageParts;

use Doctrine\ORM\Mapping as ORM;

/**
 * GalleryPagePart
 *
 * @ORM\Table(name="zizoo_cms_bundle_gallery_page_parts")
 * @ORM\Entity
 */
class GalleryPagePart extends \Zizoo\Bundle\CmsBundle\Entity\PageParts\AbstractPagePart
{
    /**
     * @var string
     *
     * @ORM\Column(name="gallery_alt_text", type="text", nullable=true)
     */
    private $galleryAltText;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinTable(name="zizoo_cms_bundle_gallery_page_part_media",
     *   joinColumns={
     *     @ORM\JoinColumn(name="gallery_page_part_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     *   }
     * )
     */
    private $gallery;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->gallery = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set galleryAltText
     *
     * @param string $galleryAltText
     *
     * @return GalleryPagePart
     */
    public function setGalleryAltText($galleryAltText)
    {
        $this->galleryAltText = $galleryAltText;

        return $this;
    }

    /**
     * Get galleryAltText
     *
     * @return string
     */
    public function getGalleryAltText()
    {
        return $this->galleryAltText;
    }

    /**
     * Add media to gallery
     *
     * @param \Kunstmaan\MediaBundle\Entity\Media $gallery
     *
     * @return GalleryPagePart
     */
    public function addMedia(\Kunstmaan\MediaBundle\Entity\Media $gallery)
    {
        $this->gallery[] = $gallery;

        return $this;
    }

    /**
     * Remove media from gallery
     *
     * @param \Kunstmaan\MediaBundle\Entity\Media $gallery
     *
     * @return GalleryPagePart
     */
    public function removeMedia(\Kunstmaan\MediaBundle\Entity\Media $gallery)
    {
        $this->gallery->removeElement($gallery);

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGallery()
    {
        return $this->gallery;
    }


    /**
     * Set gallery
     *
     *
     * @param \Doctrine\Common\Collections\Collection
     *
     * @return GalleryPagePart
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'ZizooCmsBundle:PageParts:GalleryPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return \Zizoo\Bundle\CmsBundle\Form\PageParts\GalleryPagePartAdminType
     */
    public function getDefaultAdminType()
    {
        return new \Zizoo\Bundle\CmsBundle\Form\PageParts\GalleryPagePartAdminType();
    }
}