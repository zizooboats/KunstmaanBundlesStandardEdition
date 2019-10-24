<?php

namespace Zizoo\Bundle\CmsBundle\Entity\PageParts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Zizoo\Bundle\CmsBundle\Entity\IconBulletPoint;
use Zizoo\Bundle\CmsBundle\Form\PageParts\IconBulletPointPagePartAdminType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * IconBulletPointPagePart
 *
 * @ORM\Table(name="zizoo_cms_bundle_icon_bullet_point_page_parts")
 * @ORM\Entity
 */
class IconBulletPointPagePart extends AbstractPagePart
{
    const VERTICAL_ALIGNMENT = "v";
    const HORIZONTAL_ALIGNMENT = "h";

    /**
     * @var Collection
     *
     * @Assert\Valid
     *
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "You must specify at least one icon bullet point",
     * )
     *
     * @ORM\OneToMany(targetEntity="Zizoo\Bundle\CmsBundle\Entity\IconBulletPoint", mappedBy="iconBulletPointPagePart", cascade={"persist"})
     */
    protected $iconBulletPoints;


    /**
     * @var string
     *
     * @Assert\Valid
     *
     * @Assert\Length(
     *      min = 1,
     *      max = 1,
     *      minMessage = "Alignment is string exact {{ limit }} character long",
     *      maxMessage = "Alignment is string exact {{ limit }} characters long"
     * )
     *
     * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }} for alignment."
     * )
     *
     * @ORM\Column(name="alignment", type="string", length=1, options={"fixed" = true, "default"="h"})
     */
    protected $alignment = IconBulletPointPagePart::HORIZONTAL_ALIGNMENT;


    public function __construct()
    {
        $this->iconBulletPoints = new ArrayCollection();
    }


    /** Add icon bullet point
     *
     * @param IconBulletPoint $iconBulletPoint
     *
     * @return IconBulletPointPagePart
     */
    public function addIconBulletPoint(IconBulletPoint $iconBulletPoint)
    {
        $iconBulletPoint->setIconBulletPointPagePart($this);

        $this->iconBulletPoints->add($iconBulletPoint);

        return $this;
    }

    /**
     * Remove icon bullet point
     *
     * @param IconBulletPoint $iconBulletPoint
     *
     * @return IconBulletPointPagePart
     */
    public function removeIconBulletPoint(IconBulletPoint $iconBulletPoint)
    {
        $this->iconBulletPoints->removeElement($iconBulletPoint);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getIconBulletPoints()
    {
        return $this->iconBulletPoints;
    }

    /**
     * @param Collection $iconBulletPoints
     *
     * @return IconBulletPointPagePart
     */
    public function setIconBulletPoints($iconBulletPoints)
    {
        $this->iconBulletPoints = $iconBulletPoints;

        return $this;
    }

    /**
     * When cloning this entity, we must also clone all entities in the ArrayCollection
     */
    public function deepClone()
    {
        $iconBulletPoints = $this->iconBulletPoints;
        $this->iconBulletPoints = new ArrayCollection();
        foreach ($iconBulletPoints as $iconBulletPoint) {
            $cloneIconBulletPoint = clone $iconBulletPoint;
            $this->addIconBulletPoint($cloneIconBulletPoint);
        }
    }


    /**
     * Set alignment
     *
     * @param string $alignment
     *
     * @return IconBulletPointPagePart
     */
    public function setAlignment($alignment)
    {
        $this->alignment = $alignment;

        return $this;
    }

    /**
     * Get alignment
     *
     * @return string
     */
    public function getAlignment()
    {
        return $this->alignment;
    }


    /**
     * Get the twig view.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'ZizooCmsBundle:PageParts:IconBulletPointPagePart/view.html.twig';
    }

    /**
     * Get the admin form type.
     *
     * @return IconBulletPointPagePartAdminType
     */
    public function getDefaultAdminType()
    {
        return new IconBulletPointPagePartAdminType();
    }
}