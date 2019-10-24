<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 15.02.17.
     * Time: 13:11
     */

    namespace Zizoo\Bundle\CmsBundle\Service;


    use Kunstmaan\MediaBundle\Entity\Media;
    use Zizoo\Bundle\CmsBundle\Entity\DownloadEmail;
    use Zizoo\Bundle\CmsBundle\Entity\PageParts\DownloadWithEmailPagePart;
    use Zizoo\Bundle\CmsBundle\Model\DownloadEmailRepositoryInterface;
    use Zizoo\Bundle\CmsBundle\Model\PageParts\DownloadWithEmailPagePartRepositoryInterface;

    class DownloadEmailService
    {
        /**
         * @var DownloadEmailRepositoryInterface
         */
        private $repo;

        /**
         * @var DownloadWithEmailPagePartRepositoryInterface
         */
        private $ppRepo;

        public function __construct(DownloadEmailRepositoryInterface $repo, DownloadWithEmailPagePartRepositoryInterface $ppRepo)
        {
            $this->repo = $repo;
            $this->ppRepo = $ppRepo;
        }


        /**
         * @param int $id
         *
         * @return DownloadWithEmailPagePart|null
         */
        public function findDownloadWithEmailPagePart($id)
        {
            return $this->ppRepo->find($id);
        }


        /**
         * @param DownloadEmail $dEmail
         * @param Media $media
         */
        public function saveDownloadEmail(DownloadEmail $dEmail, Media $media)
        {
            $dEmail->setDownloadedMedia($media);
            $dEmail->setDownloadedAt(new \DateTime());
            $this->repo->save($dEmail);
        }
    }