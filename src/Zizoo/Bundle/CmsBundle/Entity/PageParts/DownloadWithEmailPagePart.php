<?php

namespace Zizoo\Bundle\CmsBundle\Entity\PageParts;

use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\MediaBundle\Entity\Media;
use Zizoo\Bundle\CmsBundle\Model\OverlayImagePagePartTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DownloadWithEmailPagePart
 *
 * @ORM\Table(name="zizoo_cms_bundle_download_with_email_page_parts")
 * @ORM\Entity(repositoryClass="Zizoo\Bundle\CmsBundle\Entity\PageParts\DownloadWithEmailPagePartRepository")
 */
class DownloadWithEmailPagePart extends \Zizoo\Bundle\CmsBundle\Entity\PageParts\AbstractPagePart
{
    use OverlayImagePagePartTrait;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 1,
     *      max = 255,
     *      minMessage = "Title must be at least {{ limit }} characters long",
     *      maxMessage = "Title cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }} for title"
     * )
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @var string
     *
     * * @Assert\Length(
     *      min = 1,
     *      max = 100,
     *      minMessage = "Game name must be at least {{ limit }} characters long",
     *      maxMessage = "Game name cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }} for title"
     * )
     *
     * @ORM\Column(name="button_text", type="string", length=100, nullable=true)
     */
    protected $buttonText;


    /**
     * @var Media
     *
     * @Assert\Type("object")
     *
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $media;

    /**
     * @var Media
     *
     * @Assert\Type("object")
     *
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     *
     */
    protected $image;


    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 1,
     *      max = 255,
     *      minMessage = "Success message must be at least {{ limit }} characters long",
     *      maxMessage = "Success message cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }} for success message"
     * )
     *
     * @ORM\Column(name="success_msg", type="string", length=255, nullable=true)
     */
    protected $successMessage;


    /**
     * Set title
     *
     * @param string $title
     *
     * @return DownloadWithEmailPagePart
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Set buttonText
     *
     * @param string $buttonText
     *
     * @return DownloadWithEmailPagePart
     */
    public function setButtonText($buttonText)
    {
        $this->buttonText = $buttonText;

        return $this;
    }

    /**
     * Get buttonText
     *
     * @return string
     */
    public function getButtonText()
    {
        return $this->buttonText;
    }

    /**
     * @return Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param Media $media
     *
     * @return DownloadWithEmailPagePart
     */
    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * @return Media
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Media $image
     *
     * @return DownloadWithEmailPagePart
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getSuccessMessage()
    {
        return $this->successMessage;
    }

    /**
     * @param string $successMessage
     *
     * @return DownloadWithEmailPagePart
     */
    public function setSuccessMessage($successMessage)
    {
        $this->successMessage = $successMessage;

        return $this;
    }

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'ZizooCmsBundle:PageParts:DownloadWithEmailPagePart/view.html.twig';
    }


    /**
     * Get the admin form type.
     *
     * @return \Zizoo\Bundle\CmsBundle\Form\PageParts\DownloadWithEmailPagePartAdminType
     */
    public function getDefaultAdminType()
    {
        return new \Zizoo\Bundle\CmsBundle\Form\PageParts\DownloadWithEmailPagePartAdminType();
    }
}