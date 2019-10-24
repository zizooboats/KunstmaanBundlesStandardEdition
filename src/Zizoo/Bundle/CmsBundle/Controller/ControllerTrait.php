<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 18.02.17.
     * Time: 12:04
     */

    namespace Zizoo\Bundle\CmsBundle\Controller;


    use Symfony\Component\HttpFoundation\Request;

    trait ControllerTrait
    {
        private function isAdmin()
        {
            /** @var Request $masterRequest */
            $masterRequest = $this->get('request_stack')->getMasterRequest();
            if(strpos($masterRequest->getUri(), 'admin') !== false) {
                return true;
            }

            return false;
        }
    }