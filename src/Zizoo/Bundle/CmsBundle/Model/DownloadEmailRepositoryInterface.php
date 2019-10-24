<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 15.02.17.
     * Time: 15:49
     */

    namespace Zizoo\Bundle\CmsBundle\Model;

    use Zizoo\Bundle\CmsBundle\Entity\DownloadEmail;

    interface DownloadEmailRepositoryInterface
    {
        /**
         * @param DownloadEmail $entity
         */
        public function save(DownloadEmail $entity);
    }