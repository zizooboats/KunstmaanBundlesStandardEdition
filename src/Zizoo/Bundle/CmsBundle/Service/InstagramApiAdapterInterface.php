<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 19.02.17.
     * Time: 17:33
     */

    namespace Zizoo\Bundle\CmsBundle\Service;


    interface InstagramApiAdapterInterface
    {
        /**
         * @param null|int $mediaCount
         * @param null|int $lastMediaId
         *
         * @return array
         */
        public function getRecentMedia($mediaCount = null, $lastMediaId = null);

    }