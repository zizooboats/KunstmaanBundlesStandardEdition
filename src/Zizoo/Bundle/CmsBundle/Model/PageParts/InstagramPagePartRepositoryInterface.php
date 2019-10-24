<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 19.02.17.
     * Time: 17:31
     */

    namespace Zizoo\Bundle\CmsBundle\Model\PageParts;
    
    use Zizoo\Bundle\CmsBundle\Entity\PageParts\InstagramPagePart;

    interface InstagramPagePartRepositoryInterface
    {
        /**
         * @param int $id
         *
         * @return InstagramPagePart
         */
        public function find($id);
    }