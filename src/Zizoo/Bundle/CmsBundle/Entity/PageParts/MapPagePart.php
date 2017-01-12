<?php

namespace Zizoo\Bundle\CmsBundle\Entity\PageParts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Zizoo\Bundle\CmsBundle\Entity\MapRouteLocation;

/**
 * MapPagePart
 *
 * @ORM\Table(name="zizoo_cms_bundle_map_page_parts")
 * @ORM\Entity
 */
class MapPagePart extends AbstractPagePart
{

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @Assert\Valid
     *
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "You must specify at least one map route location",
     * )
     *
     * @ORM\OneToMany(targetEntity="Zizoo\Bundle\CmsBundle\Entity\MapRouteLocation", mappedBy="mapPagePart", cascade={"persist"})
     *
     */
    protected $mapRouteLocations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mapRouteLocations = new ArrayCollection();
    }

    /**
     * Add map route location
     *
     * @param MapRouteLocation $mapRouteLocation
     *
     * @return MapPagePart
     */
    public function addMapRouteLocation(MapRouteLocation $mapRouteLocation)
    {
        $mapRouteLocation->setMapPagePart($this);

        $this->mapRouteLocations->add($mapRouteLocation);

        return $this;
    }

    /**
     * Remove map route location
     *
     * @param MapRouteLocation $mapRouteLocation
     *
     * @return MapPagePart
     */
    public function removeMapRouteLocation(MapRouteLocation $mapRouteLocation)
    {
        $this->mapRouteLocations->removeElement($mapRouteLocation);
        return $this;
    }

    /**
     * Get map route locations
     *
     * @return ArrayCollection
     */
    public function getMapRouteLocations()
    {
        return $this->mapRouteLocations;
    }

    /**
     * Set map route locations
     *
     * @return MapPagePart
     */
    public function setMapRouteLocations($mapRouteLocations)
    {
        $this->mapRouteLocations = $mapRouteLocations;

        return $this;
    }

    /**
     * When cloning this entity, we must also clone all entities in the ArrayCollection
     */
    public function deepClone()
    {
        $mapRouteLocations = $this->mapRouteLocations;
        $this->mapRouteLocations = new ArrayCollection();
        foreach ($mapRouteLocations as $mapRouteLocation) {
            $cloneMapRouteLocation = clone $mapRouteLocation;
            $this->addMapRouteLocation($cloneMapRouteLocation);
        }
    }


    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'ZizooCmsBundle:PageParts:MapPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return \Zizoo\Bundle\CmsBundle\Form\PageParts\MapPagePartAdminType
     */
    public function getDefaultAdminType()
    {
        return new \Zizoo\Bundle\CmsBundle\Form\PageParts\MapPagePartAdminType();
    }
}