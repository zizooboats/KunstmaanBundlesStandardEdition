<?php

namespace Zizoo\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\AdminBundle\Entity\AbstractEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Zizoo\Bundle\CmsBundle\Entity\PageParts\MapPagePart;

/**
 * MapRouteLocation
 *
 * @ORM\Table(name="zizoo_cmsbundle_map_route_location")
 * @ORM\Entity()
 */
class MapRouteLocation extends AbstractEntity
{
    /**
     * @var Region
     *
     * @Assert\NotBlank(
     *      message = "Region must be set",
     * )
     *
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id", unique=false, nullable=false, onDelete="CASCADE")
     */
    protected $region;

    /**
     * @var MapPagePart
     *
     * @Assert\NotBlank(
     *      message = "Map page part must be set",
     * )
     *
     * @ORM\ManyToOne(targetEntity="Zizoo\Bundle\CmsBundle\Entity\PageParts\MapPagePart", inversedBy="mapRouteLocations")
     * @ORM\JoinColumn(name="map_pp_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     **/
    protected $mapPagePart;


    /**
     * Get region
     *
     * @return Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param Region $region
     *
     * @return MapRouteLocation
     */
    public function setRegion(Region $region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return MapPagePart
     */
    public function getMapPagePart()
    {
        return $this->mapPagePart;
    }

    /**
     * @param MapPagePart $mapPagePart
     *
     * @return MapRouteLocation
     */
    public function setMapPagePart(MapPagePart $mapPagePart)
    {
        $this->mapPagePart = $mapPagePart;

        return $this;
    }
}

