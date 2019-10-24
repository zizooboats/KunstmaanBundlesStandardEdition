<?php
    /**
     * Created by PhpStorm.
     * User: mcafuta
     * Date: 19.01.17.
     * Time: 21:44
     */

    namespace Zizoo\Bundle\CmsBundle\Service;

    use Symfony\Component\Intl\Exception\MissingResourceException;
    use Symfony\Component\Yaml\Yaml;

    class PhoneCodeService
    {
        /**
         * @var array
         */
        private static $phoneCodeValues;


        /**
         * Returns the absolute path to the data directory.
         *
         * @return string The absolute path to the data directory
         */
        private static function getDataDirectory()
        {
            return __DIR__.'/../Resources/data/country/phone_codes.yml';
        }

        /**
         * @return array
         */
        private static function getPhoneCodeValues()
        {
            if (null === self::$phoneCodeValues) {
                self::$phoneCodeValues = Yaml::parse(self::getDataDirectory());
            }

            return self::$phoneCodeValues;
        }

        /**
         * @param string $countryCode
         *
         * @return string
         */
        public static function getPhoneCode($countryCode)
        {
            $phoneCodeValues = self::getPhoneCodeValues();


            if(isset($phoneCodeValues['PhoneCodes']) && isset($phoneCodeValues['PhoneCodes'][$countryCode])) {
                return  "(+" . $phoneCodeValues['PhoneCodes'][$countryCode] . ")";
            }

            return "";
        }
    }