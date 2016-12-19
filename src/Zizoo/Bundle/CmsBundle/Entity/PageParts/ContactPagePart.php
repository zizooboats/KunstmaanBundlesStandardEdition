<?php

namespace Zizoo\Bundle\CmsBundle\Entity\PageParts;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactPagePart
 *
 * @ORM\Table(name="zizoo_cms_bundle_contact_page_parts")
 * @ORM\Entity
 */
class ContactPagePart extends \Zizoo\Bundle\CmsBundle\Entity\PageParts\AbstractPagePart
{
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255, nullable=true)
     */
    private $subject;


    /**
     * Set email
     *
     * @param string $email
     *
     * @return ContactPagePart
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return ContactPagePart
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'ZizooCmsBundle:PageParts:ContactPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return \Zizoo\Bundle\CmsBundle\Form\PageParts\ContactPagePartAdminType
     */
    public function getDefaultAdminType()
    {
        return new \Zizoo\Bundle\CmsBundle\Form\PageParts\ContactPagePartAdminType();
    }
}