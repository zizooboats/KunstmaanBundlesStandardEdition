<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 27.02.17.
     * Time: 13:21
     */

    namespace Zizoo\Bundle\CmsBundle\Model;


    use Zizoo\Bundle\CmsBundle\Entity\InstagramMedia;

    interface InstagramMediaRepositoryInterface
    {
        public function save(InstagramMedia $media);

        public function saveBatch(array $medias);

        public function getRecentMedia($pageNumber = null, $itemCount = null);

        public function getMediaCount();
    }