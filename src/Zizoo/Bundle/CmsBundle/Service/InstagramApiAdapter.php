<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 19.02.17.
     * Time: 16:27
     */

    namespace Zizoo\Bundle\CmsBundle\Service;


    use Symfony\Component\HttpFoundation\Request;

    class InstagramApiAdapter implements InstagramApiAdapterInterface
    {
        /**
         * The API base URL
         */
        const API_URL = 'https://api.instagram.com/v1/';
        const ACCESS_TOKEN_OWNER_RECENT_MEDIA = 'users/self/media/recent';

        /**
         * @var string
         */
        private $accessToken;

        /**
         * @var int
         */
        private $mediaCount;

        /**
         * InstagramApiAdapter constructor.
         *
         * @param string $accessToken
         * @param int    $resultCount
         */
        public function __construct($accessToken, $resultCount)
        {
            $this->accessToken = $accessToken;
            $this->mediaCount = $resultCount;
        }


        public function getRecentMedia($mediaCount = null, $lastMediaId = null)
        {
            $params = array();
            if(!is_null($mediaCount)) {
                $params['count'] = $mediaCount;
            }
            else{
                $params['count'] = $this->mediaCount;
            }

            if(!is_null($lastMediaId)) {
                $params['max_id'] = $lastMediaId;
            }

            return $this->makeApiCall(self::ACCESS_TOKEN_OWNER_RECENT_MEDIA, $params);
        }



        private function makeApiCall($function, $params, $method = Request::METHOD_GET)
        {
            if (isset($this->accessToken)) {
                $authMethod = '?access_token=' . $this->accessToken;
            } else {
                throw new \Exception("Access token not set!");
            }


            if (isset($params) && is_array($params)) {
                $paramString = '&' . http_build_query($params);
            } else {
                $paramString = null;
            }

            $apiUrl = self::API_URL . $function . $authMethod . (($method === Request::METHOD_GET) ? $paramString : null);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            if ($method === Request::METHOD_POST) {
                curl_setopt($ch, CURLOPT_POST, count($params));
                curl_setopt($ch, CURLOPT_POSTFIELDS, ltrim($paramString, '&'));
            }

            $jsonData = curl_exec($ch);

            if (false === $jsonData) {
                throw new \Exception("cURL error: " . curl_error($ch));
            }
            curl_close($ch);

            return json_decode($jsonData);
        }
    }