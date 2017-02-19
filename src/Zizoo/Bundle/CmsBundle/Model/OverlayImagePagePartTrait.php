<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 17.01.17.
     * Time: 19:14
     */

    namespace Zizoo\Bundle\CmsBundle\Model;

    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Validator\Constraints as Assert;

    trait OverlayImagePagePartTrait
    {
        /**
         * @var string
         *
         * @Assert\Type(
         *     type="string",
         *     message="The value {{ value }} is not a valid {{ type }} for overlay image text"
         * )
         *
         * @ORM\Column(type="string", length=255, name="overlay_text", nullable=true)
         */
        protected $overlayImageText;

        /**
         * @return string
         */
        public function getOverlayImageText()
        {
            return $this->overlayImageText;
        }

        /**
         * @param string $overlayImageText
         *
         * @return ImagePagePart
         */
        public function setOverlayImageText($overlayImageText)
        {
            $this->overlayImageText = $overlayImageText;

            return $this;
        }
    }