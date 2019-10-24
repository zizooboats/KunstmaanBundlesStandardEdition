<?php

namespace Zizoo\Bundle\CmsBundle\Entity\PageParts;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Zizoo\Bundle\CmsBundle\Model\OverlayImagePagePartTrait;

/**
 * ContentSectionPagePart
 *
 * @ORM\Table(name="zizoo_cms_bundle_content_section_page_parts")
 * @ORM\Entity
 */
class ContentSectionPagePart extends AbstractPagePart
{
    use OverlayImagePagePartTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="header", type="string", length=255, nullable=true)
     */
    private $header;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     * @Assert\Length(max = 1600)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="quote", type="string", length=255, nullable=true)
     */
    private $quote;

    /**
     * @var string
     *
     * @ORM\Column(name="image_alt_text", type="text", nullable=true)
     */
    private $imageAltText;

    /**
     * @var \Kunstmaan\MediaBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     * })
     */
    private $image;

    /**
     * @ORM\Column(name="image_right", type="boolean", nullable=true)
     */
    private $imageRight;

    /**
     * Set header
     *
     * @param string $header
     *
     * @return ContentSectionPagePart
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return ContentSectionPagePart
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set $quote
     *
     * @param string $quote
     *
     * @return ContentSectionPagePart
     */
    public function setQuote($quote)
    {
        $this->quote = $quote;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * Set imageAltText
     *
     * @param string $imageAltText
     *
     * @return ContentSectionPagePart
     */
    public function setImageAltText($imageAltText)
    {
        $this->imageAltText = $imageAltText;

        return $this;
    }

    /**
     * Get imageAltText
     *
     * @return string
     */
    public function getImageAltText()
    {
        return $this->imageAltText;
    }

    /**
     * Set image
     *
     * @param \Kunstmaan\MediaBundle\Entity\Media $image
     *
     * @return ContentSectionPagePart
     */
    public function setImage(\Kunstmaan\MediaBundle\Entity\Media $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Kunstmaan\MediaBundle\Entity\Media
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set Image Right
     *
     * @param boolean $imageRight
     *
     * @return ContentSectionPagePart
     */
    public function setImageRight($imageRight)
    {
        $this->imageRight = $imageRight;

        return $this;
    }

    /**
     * Get Image Right
     *
     * @return boolean
     */
    public function getImageRight()
    {
        return $this->imageRight;
    }

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'ZizooCmsBundle:PageParts:ContentSectionPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return \Zizoo\Bundle\CmsBundle\Form\PageParts\ContentSectionPagePartAdminType
     */
    public function getDefaultAdminType()
    {
        return new \Zizoo\Bundle\CmsBundle\Form\PageParts\ContentSectionPagePartAdminType();
    }
}