<?php

namespace Zizoo\Bundle\CmsBundle\Entity\PageParts;

use Doctrine\ORM\Mapping as ORM;
use Zizoo\Bundle\CmsBundle\Entity\MapRoute;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MapPagePart
 *
 * @ORM\Table(name="zizoo_cms_bundle_map_page_parts")
 * @ORM\Entity
 */
class MapPagePart extends AbstractPagePart
{

    /**
     * @var MapRoute
     *
     * @Assert\Valid
     *
     * @ORM\ManyToOne(targetEntity="Zizoo\Bundle\CmsBundle\Entity\MapRoute", cascade={"remove", "persist"})
     * @ORM\JoinColumn(name="map_route_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $mapRoute;

    /**
     * @return MapRoute
     */
    public function getMapRoute()
    {
        return $this->mapRoute;
    }

    /**
     * @param MapRoute $mapRoute
     *
     * @return MapPagePart
     */
    public function setMapRoute(MapRoute $mapRoute)
    {
        $this->mapRoute = $mapRoute;

        return $this;
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


    public function getEditTemplate()
    {
        return 'ZizooCmsBundle:PageParts:MapPagePart/mappagepart_admin_edit.html.twig';
    }
}