<?php

namespace Zizoo\Bundle\CmsBundle\Entity\PageParts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Zizoo\Bundle\CmsBundle\Entity\Testimonial;

/**
 * TestimonialsPagePart
 *
 * @ORM\Table(name="zizoo_cms_bundle_testimonials_page_parts")
 * @ORM\Entity
 */
class TestimonialsPagePart extends \Zizoo\Bundle\CmsBundle\Entity\PageParts\AbstractPagePart
{
    /**
     * @var Collection
     *
     * @Assert\Valid
     *
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "You must specify at least one testimonial",
     * )
     *
     * @ORM\OneToMany(targetEntity="Zizoo\Bundle\CmsBundle\Entity\Testimonial", mappedBy="testimonialsPagePart", cascade={"persist", "remove"}, orphanRemoval=true)
     *
     */
    protected $testimonials;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->testimonials = new ArrayCollection();
    }


    /**
     * Add testimonial
     *
     * @param Testimonial $testimonial
     *
     * @return TestimonialsPagePart
     */
    public function addTestimonial(Testimonial $testimonial)
    {
        $testimonial->setTestimonialsPagePart($this);

        $this->testimonials->add($testimonial);

        return $this;
    }

    /**
     * Remove testimonial
     *
     * @param Testimonial $testimonial
     *
     * @return TestimonialsPagePart
     */
    public function removeTestimonial(Testimonial $testimonial)
    {
        $this->testimonials->removeElement($testimonial);

        return $this;
    }

    /**
     * Get testimonials
     *
     * @return ArrayCollection
     */
    public function getTestimonials()
    {
        return $this->testimonials;
    }

    /**
     * Set testimonial
     *
     * @param ArrayCollection $testimonials
     *
     * @return TestimonialsPagePart
     */
    public function setTestimonials($testimonials)
    {
        $this->testimonials = $testimonials;

        return $this;
    }

    /**
     * When cloning this entity, we must also clone all entities in the ArrayCollection
     */
    public function deepClone()
    {
        $testimonials = $this->testimonials;
        $this->testimonials = new ArrayCollection();
        foreach ($testimonials as $testimonial) {
            $cloneTestimonial = clone $testimonial;
            $this->addTestimonial($cloneTestimonial);
        }
    }


    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'ZizooCmsBundle:PageParts:TestimonialsPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return \Zizoo\Bundle\CmsBundle\Form\PageParts\TestimonialsPagePartAdminType
     */
    public function getDefaultAdminType()
    {
        return new \Zizoo\Bundle\CmsBundle\Form\PageParts\TestimonialsPagePartAdminType();
    }
}