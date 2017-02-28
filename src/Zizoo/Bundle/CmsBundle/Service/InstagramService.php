<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 19.02.17.
     * Time: 17:30
     */

    namespace Zizoo\Bundle\CmsBundle\Service;


    use Doctrine\DBAL\Driver\PDOException;
    use Doctrine\ORM\NoResultException;
    use Zizoo\Bundle\CmsBundle\Entity\InstagramMedia;
    use Zizoo\Bundle\CmsBundle\Entity\PageParts\InstagramPagePart;
    use Zizoo\Bundle\CmsBundle\Model\InstagramMediaRepositoryInterface;
    use Zizoo\Bundle\CmsBundle\Model\PageParts\InstagramPagePartRepositoryInterface;

    class InstagramService
    {
        /** @var  InstagramMediaRepositoryInterface */
        private $instagramMediaRepo;

        /**
         * @var InstagramPagePartRepositoryInterface
         */
        private $instagramPPRepo;


        /**
         * @var InstagramApiAdapterInterface
         */
        private $instagramApiAdapter;


        public function __construct(InstagramMediaRepositoryInterface $instagramMediaRepo, InstagramPagePartRepositoryInterface $instagramPPRepo, InstagramApiAdapterInterface $instagramApiAdapter)
        {
            $this->instagramMediaRepo = $instagramMediaRepo;
            $this->instagramPPRepo = $instagramPPRepo;
            $this->instagramApiAdapter = $instagramApiAdapter;
        }


        /**
         * @param int $id
         *
         * @return InstagramPagePart|null
         */
        public function findInstagramPagePart($id)
        {
            return $this->instagramPPRepo->find($id);
        }


        public function getRecentMedia($pageNumber = null, $mediaCount = null)
        {
            return $this->instagramMediaRepo->getRecentMedia($pageNumber, $mediaCount);
        }

        public function getInstagramMediaCount()
        {
            return $this->instagramMediaRepo->getMediaCount();
        }


        public function syncInstagram()
        {
            $lastInstagramId = null;
            while(true) {
                $data = $this->instagramApiAdapter->getRecentMedia(null, $lastInstagramId);
                $mediasData = $data->data;
                if(count($mediasData) > 0) {
                    foreach ($mediasData as $mediaData) {
                        $media = $this->createMediasFromInstagramData($mediaData);
                        try{
                            $this->instagramMediaRepo->save($media);
                        }
                        catch (\Exception $e) {
                            if(!is_null($e->getPrevious())
                                && get_class($e->getPrevious()) === PDOException::class
                                && strpos($e->getPrevious()->getMessage(), 'SQLSTATE[23000]: Integrity constraint violation') !== false) {
                                break;
                            }

                            throw $e;
                        }
                    }

                    if(!isset($data->pagination->next_max_id)) {
                        break;
                    }

                    $lastInstagramMedia = end($mediasData);
                    $lastInstagramId = $lastInstagramMedia->id;
                }
                else {
                    break;
                }
            }
        }


        /**
         * @param array $mediaData
         *
         * @return InstagramMedia
         */
        private function createMediasFromInstagramData($mediaData)
        {
            $media = new InstagramMedia();
            return $media->setInstagramId($mediaData->id)
                ->setCreatedAtFromTimestamp($mediaData->created_time)
                ->setLink($mediaData->link)
                ->setThumbnailUrl($mediaData->images->thumbnail->url)
                ->setSmallImageUrl($mediaData->images->low_resolution->url)
                ->setStandardImageUrl($mediaData->images->standard_resolution->url);
        }
    }