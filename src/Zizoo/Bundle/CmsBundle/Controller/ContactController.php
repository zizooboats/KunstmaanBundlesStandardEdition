<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 19.12.16.
     * Time: 11:18
     */

    namespace Zizoo\Bundle\CmsBundle\Controller;


    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\RedirectResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Zizoo\Bundle\CmsBundle\Form\PageParts\ContactPagePartType;
    use Zizoo\Bundle\CmsBundle\Service\ContactService;

    class ContactController extends Controller
    {

        /**
         * @param string $emailTo
         * @param string $subject
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function getContactFromAction($emailTo, $subject)
        {
            $form = $this->createForm(
                new ContactPagePartType($emailTo, $subject),
                null,
                array(
                    'action' => $this->generateUrl('zizoocmsbundle_contact_post_form'),
                    'mapped' => false
                )
            );

            return $this->render('ZizooCmsBundle:PageParts/ContactPagePart:form.html.twig',
                array(
                    'form' => $form->createView()
                )
            );
        }

        /**
         * @param Request $request
         *
         * @return JsonResponse|RedirectResponse
         */
        public function postContactFromAction(Request $request)
        {
            if(!$request->isXmlHttpRequest()) {
                return $this->redirect($this->generateUrl('zizoo_cms_default_index'));
            }
            $data = $request->request->all();
            $data = $data['contactpageparttype'];

            /** @var ContactService $contactService */
            $contactService = $this->get('zizoo_cms_bundle.service.contact');
            $contactService->sendEmail($data);

            return new JsonResponse(
                array(
                    'data' => $this->get('translator')->trans('zizoo_cms_bundle.contactpagepart.confirmation_message')
                )
            );
        }
    }