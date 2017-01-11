<?php

namespace Zizoo\Bundle\CmsBundle\Entity\PageParts;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrustpilotPagePart
 *
 * @ORM\Table(name="zizoo_cms_bundle_trustpilot_page_parts")
 * @ORM\Entity
 */
class TrustpilotPagePart extends \Zizoo\Bundle\CmsBundle\Entity\PageParts\AbstractPagePart
{


    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'ZizooCmsBundle:PageParts:TrustpilotPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return \Zizoo\Bundle\CmsBundle\Form\PageParts\TrustpilotPagePartAdminType
     */
    public function getDefaultAdminType()
    {
        return new \Zizoo\Bundle\CmsBundle\Form\PageParts\TrustpilotPagePartAdminType();
    }
}