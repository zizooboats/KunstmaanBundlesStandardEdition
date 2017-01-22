<?php

namespace Zizoo\Bundle\CmsBundle\Entity\PageParts;

use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\MediaBundle\Entity\Media;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="zizoo_cms_bundle_video_page_parts")
 */
class VideoPagePart extends AbstractPagePart
{
    /**
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="video_media_id", referencedColumnName="id")
     * @Assert\NotNull()
     */
    protected $video;


    /**
     * @var string
     *
     * * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }} for video width."
     * )
     *
     * @ORM\Column(type="integer", name="video_width", options={"default"=50})
     */
    protected $videoWidth;

    /**
     * @var string
     *
     * * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }} for video height."
     * )
     *
     * @ORM\Column(type="integer", name="video_height", options={"default"=50})
     */
    protected $videoHeight;


    /**
     * @var string
     *
     * @ORM\Column(type="string", name="caption", nullable=true)
     */
    protected $caption;


    /**
     * @param Media $video
     */
    public function setVideo($video)
    {
        $this->video = $video;
    }

    /**
     * @return Media
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @return string
     */
    public function getVideoWidth()
    {
        return $this->videoWidth;
    }

    /**
     * @param string $videoWidth
     */
    public function setVideoWidth($videoWidth)
    {
        $this->videoWidth = $videoWidth;
    }

    /**
     * @return string
     */
    public function getVideoHeight()
    {
        return $this->videoHeight;
    }

    /**
     * @param string $videoHeight
     */
    public function setVideoHeight($videoHeight)
    {
        $this->videoHeight = $videoHeight;
    }


    /**
     * @param string $caption
     */
    public function setCaption($caption)
    {
	$this->caption = $caption;
    }

    /**
     * @return string
     */
    public function getCaption()
    {
	    return $this->caption;
    }


    /**
     * @return string
     */
    public function getDefaultView()
    {
	    return "ZizooCmsBundle:PageParts/VideoPagePart:view.html.twig";
    }

    /**
     * @return VideoPagePartAdminType
     */
    public function getDefaultAdminType()
    {
	    return new \Zizoo\Bundle\CmsBundle\Form\PageParts\VideoPagePartAdminType();
    }
}
