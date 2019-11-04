<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 08.02.19
 * Time: 16:07
 */

class Config_Manager
{
        const CONFIG_FOR_APP            = "Config/app.config.json";
        const CONFIG_FOR_DATABASE       = "";

        static function get( $CONFIG_FOR, $key ){
                $_ = json_decode(file_get_contents($CONFIG_FOR),true);
                return $_[$key];
        }

        static function getAll( $CONFIG_FOR ){



        }

        static function  set( $CONFIG_FOR, $key, $value ){



        }

}