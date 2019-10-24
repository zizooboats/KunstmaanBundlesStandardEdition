<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 13.02.17.
     * Time: 15:32
     */

    namespace Zizoo\Bundle\CmsBundle\Controller;


    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Zizoo\Bundle\CmsBundle\Entity\DownloadEmail;
    use Zizoo\Bundle\CmsBundle\Entity\PageParts\DownloadWithEmailPagePart;
    use Zizoo\Bundle\CmsBundle\Form\PageParts\DownloadWithEmailPagePartType;

    class DownloadWithEmailController extends Controller
    {
        use ControllerTrait;

        /**
         * @param Request $request
         * @param DownloadWithEmailPagePart|int|null $pagePart
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function downloadAction(Request $request, $pagePart)
        {
            $dEmailService = null;

            if(is_numeric($pagePart)) {
                $dEmailService = $this->get('zizoo_cms_bundle.service.download_email');
                $pagePart = $dEmailService->findDownloadWithEmailPagePart($pagePart);
            }

            $downloadEmail = new DownloadEmail();

            $form = $this->createForm(
                new DownloadWithEmailPagePartType($pagePart->getButtonText()),
                $downloadEmail,
                array(
                    'action' => $this->generateUrl(
                        'zizoocmsbundle_download_with_email',
                        array('pagePart' => $pagePart->getId())
                    ),
                )
            );
            $form->handleRequest($request);

            if($request->isXmlHttpRequest()) {
                $response = new JsonResponse();
                if ($form->isSubmitted() && $form->isValid()) {
                    if(is_null($dEmailService)) {
                        $dEmailService = $this->get('zizoo_cms_bundle.service.download_email');
                    }
                    $dEmailService->saveDownloadEmail($downloadEmail, $pagePart->getMedia());
                    $response->setData(
                        array(
                            'url' => $request->getSchemeAndHttpHost() . $request->getBasePath() . $pagePart->getMedia()->getUrl(),
                            'filename' => $pagePart->getMedia()->getName()
                        )
                    );
                    
                    return $response;
                } elseif ($form->isSubmitted()) {
                    $errors = array();
                    foreach ($form->getErrors(true) as $error) {
                        $errors[] = $error->getMessage();
                    }

                    $response->setData($errors);
                }

                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                return $response;
            }

            return $this->render(
                '@ZizooCms/PageParts/DownloadWithEmailPagePart/form.html.twig',
                array(
                    'form' => $form->createView(),
                    'isAdmin' => $this->isAdmin()
                )
            );
        }
    }