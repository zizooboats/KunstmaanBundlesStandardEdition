<?php

namespace Zizoo\Bundle\CmsBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\AdminBundle\Entity\AbstractEntity;

/**
 * MapRoute
 *
 * @ORM\Table(name="zizoo_cmsbundle_map_route")
 * @ORM\Entity()
 */
class MapRoute extends AbstractEntity
{
    ///**
    // *
    // * @Assert\Type(
    // *     type="string",
    // *     message="The value {{ value }} is not a valid {{ type }} for map route name."
    // * )
    // *
    // * @Assert\NotBlank(
    // *     message="Map route name must not be blank."
    // * )
    // *
    // * @ORM\Column(type="string", nullable=false)
    // */
    //protected $name;

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
     * @ORM\ManyToMany(targetEntity="Zizoo\Bundle\CmsBundle\Entity\MapRouteLocation", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinTable(name="zizoo_cmsbundle_map_route_map_route_location",
     *   joinColumns={
     *     @ORM\JoinColumn(name="map_route_id", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="map_route_location_id", unique=true, referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
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
     * @return MapRoute
     */
    public function addMapRouteLocation(MapRouteLocation $mapRouteLocation)
    {
        $this->mapRouteLocations->add($mapRouteLocation);

        return $this;
    }

    /**
     * Remove map route location
     *
     * @param MapRouteLocation $mapRouteLocation
     *
     * @return MapRoute
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
}

