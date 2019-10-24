<?php

namespace Zizoo\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Zizoo\Bundle\CmsBundle\Entity\PageParts\TestimonialsPagePart;

/**
 * Testimonial
 *
 * @ORM\Table(name="zizoo_cmsbundle_testimonial")
 * @ORM\Entity(repositoryClass="Zizoo\Bundle\CmsBundle\Entity\TestimonialRepository")
 */
class Testimonial
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
     * @Assert\NotBlank(
     *     message="Content must not be empty"
     * )
     *
     * * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }} for content"
     * )
     *
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    protected $content;


    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 1,
     *      max = 255,
     *      minMessage = "Image alt text must be at least {{ limit }} characters long",
     *      maxMessage = "Image alt text cannot be longer than {{ limit }} characters"
     * )
     *
     * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }} for image alt text"
     * )
     *
     * @ORM\Column(name="image_alt_text", type="string", length=255, nullable=true)
     */
    protected $imageAltText;

    /**
     * @var \Kunstmaan\MediaBundle\Entity\Media
     *
     * * @Assert\Type(
     *     type="object",
     *     message="The value {{ value }} is not a valid {{ type }} for image"
     * )
     *
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     * })
     */
    protected $image;


    /**
     * @var TestimonialsPagePart
     *
     * @Assert\NotBlank(
     *      message = "Testimonial page part must be set",
     * )
     *
     * @ORM\ManyToOne(targetEntity="Zizoo\Bundle\CmsBundle\Entity\PageParts\TestimonialsPagePart", inversedBy="testimonials")
     * @ORM\JoinColumn(name="testimonial_pp_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     **/
    protected $testimonialsPagePart;


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
     * Set content
     *
     * @param string $content
     *
     * @return Testimonial
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
     * Set imageAltText
     *
     * @param string $imageAltText
     *
     * @return Testimonial
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
     * @return Testimonial
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
     * @return TestimonialsPagePart
     */
    public function getTestimonialsPagePart()
    {
        return $this->testimonialsPagePart;
    }

    /**
     * @param TestimonialsPagePart $testimonialsPagePart
     *
     * @return Testimonial
     */
    public function setTestimonialsPagePart($testimonialsPagePart)
    {
        $this->testimonialsPagePart = $testimonialsPagePart;

        return $this;
    }
}

