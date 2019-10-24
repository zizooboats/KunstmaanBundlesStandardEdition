<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 19.02.17.
     * Time: 16:25
     */

    namespace Zizoo\Bundle\CmsBundle\Controller;


    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;

    class InstagramController extends Controller
    {
        public function getRecentMediaAction(Request $request, $mediaCount = null)
        {
            if(is_null($mediaCount)) {
                $mediaCount = $request->get('mediaCount');
            }

            $pageNumber = $request->get('pageNumber');

            $instagramService = $this->get('zizoo_cms_bundle.service.instagram_service');
            $medias = $instagramService->getRecentMedia($pageNumber, $mediaCount);

            $response = $this->render(
                '@ZizooCms/PageParts/InstagramPagePart/media_items.html.twig',
                array(
                    'medias' => $medias
                )
            );

            if($request->isXmlHttpRequest()) {
                $html = $response->getContent();

                if(is_null($mediaCount)) {
                    $mediaCount = $this->getParameter('instagram.api.get_recent_media_count');
                }

                $dbMediaCount = $instagramService->getInstagramMediaCount();

                $showLoadMore = true;
                if($dbMediaCount <= ($mediaCount * ($pageNumber+1))) {
                    $showLoadMore = false;
                }

                $data = array(
                    'html' => $html,
                    'showLoadMore' => $showLoadMore
                );
                return new JsonResponse($data);
            }

            return $response;
        }
    }