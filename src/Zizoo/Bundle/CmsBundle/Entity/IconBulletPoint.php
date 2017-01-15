<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 12.01.17.
     * Time: 14:47
     */

    namespace Zizoo\Bundle\CmsBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Kunstmaan\AdminBundle\Entity\AbstractEntity;
    use Kunstmaan\MediaBundle\Entity\Media;
    use Symfony\Component\Validator\Constraints as Assert;
    use Zizoo\Bundle\CmsBundle\Entity\PageParts\IconBulletPointPagePart;

    /**
     * FeaturedPartner
     *
     * @ORM\Table(name="zizoo_cmsbundle_icon_bullet_point")
     * @ORM\Entity()
     */
    class IconBulletPoint extends AbstractEntity
    {
        /**
         * @var Media
         *
         * @Assert\Valid
         *
         * @Assert\NotBlank(
         *      message = "Icon must be set"
         * )
         *
         * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
         * @ORM\JoinColumns({
         *   @ORM\JoinColumn(name="icon_id", referencedColumnName="id", nullable=false)
         * })
         */
        protected $icon;

        /**
         * @var string
         *
         * @Assert\Type(
         *     type="string",
         *     message="The value {{ value }} is not a valid {{ type }} for circle color."
         * )
         *
         * @Assert\NotBlank(
         *      message = "Circle color must be set",
         * )
         *
         * @ORM\Column(name="circle_color", type="string", length=255)
         */
        protected $circleColor;

        /**
         * @var string
         *
         * @Assert\Type(
         *     type="string",
         *     message="The value {{ value }} is not a valid {{ type }} for title."
         * )
         *
         * @Assert\NotBlank(
         *      message = "Title must be set",
         * )
         *
         * @ORM\Column(name="title", type="string", length=255)
         */
        protected $title;

        /**
         * @var string
         *
         * @Assert\Type(
         *     type="string",
         *     message="The value {{ value }} is not a valid {{ type }} for content."
         * )
         *
         * @ORM\Column(name="content", type="text", nullable=true)
         */
        protected $content;


        /**
         * @var IconBulletPointPagePart
         *
         * @Assert\NotBlank(
         *      message = "Icon bullet point page part must be set",
         * )
         *
         * @ORM\ManyToOne(targetEntity="Zizoo\Bundle\CmsBundle\Entity\PageParts\IconBulletPointPagePart", inversedBy="iconBulletPoints")
         * @ORM\JoinColumn(name="icon_bullet_point_pp_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
         **/
        protected $iconBulletPointPagePart;


        /**
         * Set icon
         *
         * @param Media $icon
         *
         * @return IconBulletPoint
         */
        public function setIcon(Media $icon)
        {
            $this->icon = $icon;

            return $this;
        }

        /**
         * Get icon
         *
         * @return Media
         */
        public function getIcon()
        {
            return $this->icon;
        }


        /**
         * Set circleColor
         *
         * @param string $circleColor
         *
         * @return IconBulletPoint
         */
        public function setCircleColor($circleColor)
        {
            $this->circleColor = $circleColor;

            return $this;
        }

        /**
         * Get circleColor
         *
         * @return string
         */
        public function getCircleColor()
        {
            return $this->circleColor;
        }

        /**
         * Set title
         *
         * @param string $title
         *
         * @return IconBulletPoint
         */
        public function setTitle($title)
        {
            $this->title = $title;

            return $this;
        }

        /**
         * Get title
         *
         * @return string
         */
        public function getTitle()
        {
            return $this->title;
        }

        /**
         * Set content
         *
         * @param string $content
         *
         * @return IconBulletPoint
         */
        public function setContent($content)
        {
            $this->content = $content;

            return $this;
        }

        /**
         * Get content
         *
         * @return string
         */
        public function getContent()
        {
            return $this->content;
        }


        /**
         * @return IconBulletPointPagePart
         */
        public function getIconBulletPointPagePart()
        {
            return $this->iconBulletPointPagePart;
        }

        /**
         * @param IconBulletPointPagePart $iconBulletPointPagePart
         *
         * @return IconBulletPoint
         */
        public function setIconBulletPointPagePart(IconBulletPointPagePart $iconBulletPointPagePart)
        {
            $this->iconBulletPointPagePart = $iconBulletPointPagePart;

            return $this;
        }
    }