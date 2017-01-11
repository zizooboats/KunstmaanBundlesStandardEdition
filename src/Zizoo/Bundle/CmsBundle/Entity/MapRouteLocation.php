<?php

namespace Zizoo\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\AdminBundle\Entity\AbstractEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MapRouteLocation
 *
 * @ORM\Table(name="zizoo_cmsbundle_map_route_location")
 * @ORM\Entity()
 */
class MapRouteLocation extends AbstractEntity
{
    /**
     * @var integer
     *
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }} for map route location day number."
     * )
     *
     *  @Assert\Range(
     *      min = 1,
     *      minMessage = "Map route location day number is integer and must be greater then {{ limit }}",
     * )
     *
     * @ORM\Column(name="day_number", type="integer")
     */
    protected $dayNumber;


    /**
     * Set dayNumber
     *
     * @param integer $dayNumber
     *
     * @return MapRouteLocation
     */
    public function setDayNumber($dayNumber)
    {
        $this->dayNumber = $dayNumber;

        return $this;
    }

    /**
     * Get dayNumber
     *
     * @return integer
     */
    public function getDayNumber()
    {
        return $this->dayNumber;
    }


    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id", unique=false, nullable=false)
     */
    protected $region;


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
}

