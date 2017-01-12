<?php

namespace Zizoo\Bundle\CmsBundle\Entity\PageParts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Zizoo\Bundle\CmsBundle\Entity\FeaturedPartner;

/**
 * FeaturedPartnersPagePart
 *
 * @ORM\Table(name="zizoo_cms_bundle_featured_partners_page_parts")
 * @ORM\Entity
 */
class FeaturedPartnersPagePart extends \Zizoo\Bundle\CmsBundle\Entity\PageParts\AbstractPagePart
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @Assert\Valid
     *
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "You must specify at least one featured partner",
     * )
     *
     * @ORM\OneToMany(targetEntity="Zizoo\Bundle\CmsBundle\Entity\FeaturedPartner", mappedBy="featuredPartnersPagePart", cascade={"persist"})
     */
    protected $featuredPartners;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->featuredPartners = new ArrayCollection();
    }

    /**
     * Add featured partner
     *
     * @param FeaturedPartner $featuredPartner
     *
     * @return FeaturedPartnersPagePart
     */
    public function addFeaturedPartner(FeaturedPartner $featuredPartner)
    {
        $featuredPartner->setFeaturedPartnersPagePart($this);

        $this->featuredPartners->add($featuredPartner);

        return $this;
    }

    /**
     * Remove featured partner
     *
     * @param FeaturedPartner $featuredPartner
     *
     * @return FeaturedPartnersPagePart
     */
    public function removeFeaturedPartner(FeaturedPartner $featuredPartner)
    {
        $this->featuredPartners->removeElement($featuredPartner);

        return $this;
    }

    /**
     * Get featured partners
     *
     * @return ArrayCollection
     */
    public function getFeaturedPartners()
    {
        return $this->featuredPartners;
    }

    /**
     * Set featured partners
     *
     * @param array $featuredPartners
     *
     * @return FeaturedPartnersPagePart
     */
    public function setFeaturedPartners($featuredPartners)
    {
        $this->featuredPartners = $featuredPartners;

        return $this;
    }

    /**
     * When cloning this entity, we must also clone all entities in the ArrayCollection
     */
    public function deepClone()
    {
        $featuredPartners = $this->featuredPartners;
        $this->featuredPartners = new ArrayCollection();
        foreach ($featuredPartners as $featuredPartner) {
            $cloneMapRouteLocation = clone $featuredPartner;
            $this->addFeaturedPartner($cloneMapRouteLocation);
        }
    }

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'ZizooCmsBundle:PageParts:FeaturedPartnersPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return \Zizoo\Bundle\CmsBundle\Form\PageParts\FeaturedPartnersPagePartAdminType
     */
    public function getDefaultAdminType()
    {
        return new \Zizoo\Bundle\CmsBundle\Form\PageParts\FeaturedPartnersPagePartAdminType();
    }
}