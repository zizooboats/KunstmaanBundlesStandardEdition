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

            $lastMediaId = $request->get('lastMediaId');

            $instagramService = $this->get('zizoo_cms_bundle.service.instagram_service');
            $medias = $instagramService->getRecentMedia($mediaCount, $lastMediaId);

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

                $showLoadMore = true;
                if($mediaCount > count($medias)) {
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