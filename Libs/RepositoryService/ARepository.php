<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 2019-10-30
 * Time: 13:54
 */

abstract class ARepository
{

        const CURRENT_REDIRECT  = "CURRENT_REDIRECT";
        const CURRENT_USER      = "CURRENT_USER";
        const CURRENT_CLUB      = "CURRENT_CLUB";
        const CURRENT_DEVICE    = "CURRENT_DEVICE";
        const CURRENT_MESSAGE   = "CURRENT_MESSAGE";
        const CURRENT_MEETING   = "CURRENT_MEETING";
        const CURRENT_TEMPORARILY_ADDED_CLUB_FOR_ROLE = "CURRENT_TEMPORARILY_ADDED_CLUB_FOR_ROLE";
        const CURRENT_DFB_CLUB_TEAMS = "CURRENT_DFB_CLUB_TEAMS";
        const CURRENT_FILTER_FOR_CARD_TEAMS = "CURRENT_FILTER_FOR_CARD_TEAMS";
        const CURRENT_APPENDED_CARD_TEAMS = "CURRENT_APPENDED_CARD_TEAMS";
        const CURRENT_ENVIRONMENT_DATA = "CURRENT_ENVIRONMENT_DATA";
        const CURRENT_AD_DISCUSSION_DATA = "CURRENT_AD_DISCUSSION_DATA";
        const CURRENT_SELECTED_AD_FROM_SEARCH = "CURRENT_SELECTED_AD_FROM_SEARCH";
        const CURRENT_LAST_MYSQL_ERROR = "CURRENT_LAST_MYSQL_ERROR";


        /**
         * This is a temporarily storing user roles
         * Either New Adding Or calling from host
         * Storing all Roles data into this repository
         * Finally sending all user roles data from this REPOSITORY
         */
        const USER_ROLES        = "USER_ROLES";


        const FETCH_TYPE_ARRAY = 0;
        const FETCH_TYPE_OBJECT = 1;

        private $fetchMethod = self::FETCH_TYPE_OBJECT;

        protected static $instance = null;
        protected $tempRepo     = null;
        protected $repoKey      = "";
        protected $repoVal      = null;

        protected $version      = 1.2;

        protected function __construct()
        {


        }

        function switchArray($arrayData, $toObject = true)
        {

                $n = array();
                foreach ($arrayData as $index => $item) {


                        if (gettype($item) == ($toObject ? "array" : "object")) {

                                if ($this->isAssoc($item)) {
                                        $n[$index] = $this->switchArray($item, $toObject);
                                } else {

                                        $n[$index] = $item;
                                }
                        } else {
                                $n[$index] = $item;
                        }
                }

                if ($toObject) {
                        return (object)$n;
                }

                return (array)$n;


        }

        function isAssoc($arrayData)
        {

                if (!count($arrayData)) {
                        return false;
                }

                return array_keys($arrayData) !== range(0, count($arrayData) - 1);

        }


        final function setFetchMethod($fetchType = self::FETCH_TYPE_ARRAY)
        {
                $this->fetchMethod = $fetchType;
        }

        final function getFetchMethod()
        {
                return $this->fetchMethod;
        }

        public function getVersion(){
                return $this->version;
        }


}