<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 27.12.18
 * Time: 19:37
 */

abstract class LOX24
{
        private static $LOX24_CLIENT_NR= "21256";
        private static $LOX24_PASSWORD = "adler299";
        private static $LOX24_SERVICE  = "12109";

        private static $BASE_URL       = "https://www.lox24.eu/API/httpsms.php?";
        // konto=1&password=3a7501ed91bc2edf44c2821c09a161b1&service=12109&text=Testtext&from=11 Meter&to=004915228763036&httphead=0&return=xml

        const SERVICE_CLOSED    = 0;
        const SERVICE_OPEN      = 1;
        public static $SERVICE_STATUS           = self::SERVICE_OPEN;

        static function getMD5Password(){

                return md5( self::$LOX24_PASSWORD );
        }

        static function setServiceStatus( $status ){

                self::$SERVICE_STATUS = $status;
        }

        static function sendSMS( $text, $number ){

                if( self::$SERVICE_STATUS === self::SERVICE_OPEN ){

                        $url  = self::$BASE_URL ;
                        $url .= "konto=" . self::$LOX24_CLIENT_NR;
                        $url .= "&password=" . self::getMD5Password();
                        $url .= "&service=" . self::$LOX24_SERVICE;
                        $url .= "&text=" . $text;
                        $url .= "&from=" . Config::APP_NAME;
                        $url .= "&to=" . $number;
                        $url .= "&httphead=" . 0;
                        $url .= "&return=xml";

                        return simplexml_load_file($url);
                }

                return null;


        }

}