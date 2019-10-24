<?php

namespace Zizoo\Bundle\CmsBundle\Entity\PageParts;

use Doctrine\ORM\Mapping as ORM;

/**
 * InstagramPagePart
 *
 * @ORM\Table(name="zizoo_cms_bundle_instagram_page_parts")
 * @ORM\Entity(repositoryClass="Zizoo\Bundle\CmsBundle\Entity\PageParts\InstagramPagePartRepository")
 */
class InstagramPagePart extends \Zizoo\Bundle\CmsBundle\Entity\PageParts\AbstractPagePart
{
    /**
     * @var integer
     *
     * @ORM\Column(name="items_per_page", type="integer", nullable=false, options={"default" : 8})
     */
    private $itemsPerPage = 8;


    /**
     * Set itemsPerPage
     *
     * @param integer $itemsPerPage
     *
     * @return InstagramPagePart
     */
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;

        return $this;
    }

    /**
     * Get itemsPerPage
     *
     * @return integer
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'ZizooCmsBundle:PageParts:InstagramPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return \Zizoo\Bundle\CmsBundle\Form\PageParts\InstagramPagePartAdminType
     */
    public function getDefaultAdminType()
    {
        return new \Zizoo\Bundle\CmsBundle\Form\PageParts\InstagramPagePartAdminType();
    }
}