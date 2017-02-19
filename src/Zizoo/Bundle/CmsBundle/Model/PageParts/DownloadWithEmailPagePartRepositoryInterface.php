<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 18.02.17.
     * Time: 13:34
     */

    namespace Zizoo\Bundle\CmsBundle\Model\PageParts;

    use Zizoo\Bundle\CmsBundle\Entity\PageParts\DownloadWithEmailPagePart;

    interface DownloadWithEmailPagePartRepositoryInterface
    {
        /**
         * @param int $id
         *
         * @return DownloadWithEmailPagePart|null
         */
        public function find($id);
    }