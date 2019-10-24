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
    use Zizoo\Bundle\CmsBundle\Entity\PageParts\FeaturedPartnersPagePart;

    /**
     * FeaturedPartner
     *
     * @ORM\Table(name="zizoo_cmsbundle_featured_partner")
     * @ORM\Entity()
     */
    class FeaturedPartner extends AbstractEntity
    {
        /**
         * @var Media
         *
         * @Assert\NotBlank(
         *      message = "Logo must be set",
         * )
         * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
         * @ORM\JoinColumn(name="logo_id", referencedColumnName="id", unique=false, nullable=false, onDelete="CASCADE")
         */
        protected $logo;


        /**
         * @var FeaturedPartnersPagePart
         * 
         * @Assert\NotBlank(
         *      message = "Featured partners page part must be set",
         * )
         *
         * @ORM\ManyToOne(targetEntity="Zizoo\Bundle\CmsBundle\Entity\PageParts\FeaturedPartnersPagePart", inversedBy="featuredPartners")
         * @ORM\JoinColumn(name="featured_partners_pp_id", referencedColumnName="id", onDelete="CASCADE")
         **/
        protected $featuredPartnersPagePart;

        
        /**
         * @return Media
         */
        public function getLogo()
        {
            return $this->logo;
        }

        /**
         * @param Media $logo
         *
         * @return FeaturedPartner
         */
        public function setLogo(Media $logo)
        {
            $this->logo = $logo;

            return $this;
        }

        /**
         * @return FeaturedPartnersPagePart
         */
        public function getFeaturedPartnersPagePart()
        {
            return $this->featuredPartnersPagePart;
        }

        /**
         * @param FeaturedPartnersPagePart $featuredPartnersPagePart
         *
         * @return FeaturedPartner
         */
        public function setFeaturedPartnersPagePart(FeaturedPartnersPagePart $featuredPartnersPagePart)
        {
            $this->featuredPartnersPagePart = $featuredPartnersPagePart;

            return $this;
        }
    }