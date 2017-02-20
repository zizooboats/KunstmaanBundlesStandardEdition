<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 19.02.17.
     * Time: 17:30
     */

    namespace Zizoo\Bundle\CmsBundle\Service;


    use Zizoo\Bundle\CmsBundle\Entity\PageParts\InstagramPagePart;
    use Zizoo\Bundle\CmsBundle\Model\InstagramPagePartRepositoryInterface;

    class InstagramService
    {
        /**
         * @var InstagramPagePartRepositoryInterface
         */
        private $repo;


        private $instagramApiAdapter;


        public function __construct(InstagramPagePartRepositoryInterface $repo, InstagramApiAdapterInterface $instagramApiAdapter)
        {
            $this->repo = $repo;
            $this->instagramApiAdapter = $instagramApiAdapter;
        }


        /**
         * @param int $id
         *
         * @return InstagramPagePart|null
         */
        public function findInstagramPagePart($id)
        {
            return $this->repo->find($id);
        }


        public function getRecentMedia($mediaCount = null, $lastMediaId = null)
        {
            $data = $this->instagramApiAdapter->getRecentMedia($mediaCount, $lastMediaId);
            return $data->data;
        }
    }