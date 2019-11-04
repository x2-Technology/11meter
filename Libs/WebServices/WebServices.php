<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 2019-04-21
 * Time: 00:58
 */

class WebServices
{
        private $serviceName;
        function __construct( $serviceName ) {
                $this->serviceName = $serviceName;
        }

        function getServiceExternalAttack(){
                return file_get_contents("Libs/WebServices/ExternalJSAttackServices/" . $this->serviceName);
        }

        function getServiceExternalAdaptation(){
                return file_get_contents("Libs/WebServices/ExternalJSAdaptationServices/" . $this->serviceName );
        }
}



