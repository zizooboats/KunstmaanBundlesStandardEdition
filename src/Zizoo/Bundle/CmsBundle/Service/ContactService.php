<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 19.12.16.
     * Time: 20:36
     */

    namespace Zizoo\Bundle\CmsBundle\Service;


    use Symfony\Component\DependencyInjection\ContainerInterface;
    use Symfony\Component\Intl\Intl;

    class ContactService
    {
        /* @var ContainerInterface */
        protected $container;

        public function __construct(ContainerInterface $container){
            $this->container = $container;
        }

        public function sendEmail($data)
        {
            $mail = $this->getEmail($data);
            $mailer = $this->container->get('mailer');
            $mailer->send($mail);
        }


        private function getEmail($data)
        {
            $country = Intl::getRegionBundle()->getCountryName($data['country']);
            $message = \Swift_Message::newInstance()
                ->setSubject($data['subject'])
                ->setFrom($data['email_from'])
                ->setTo($data['email_to'])
                ->setBody(
                    $this->container->get('twig')->render(
                        '@ZizooCms/PageParts/ContactPagePart/email.html.twig',
                        array(
                            'name' => $data['name'],
                            'phone_number' => isset($data['phone_number']) ? $data['phone_number'] : null,
                            'country' => $country,
                            'country_code' => $data['country'],
                            'phone_code' => PhoneCodeService::getPhoneCode($data['country']),
                            'message' => $data['message']
                        )
                    ),
                    'text/html'
                 );

            return $message;
        }
    }