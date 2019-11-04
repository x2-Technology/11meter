<?php

/**
 * Created by PhpStorm.
 * User: tSoftX
 * Date: 04/02/2017
 * Time: 02:45
 */
abstract class Model extends Model_Extends
{
        public $db;
        public $pars;
        public $helper;
        public $storage;
        public $label;
        public $public;

        public $LIMIT           = 1000;
        public $ORDER_BY        = array("id", Database::ORDER_ASC);

        private static $entity = null;


        // This class create as Abstract and must implement from other class

        function __construct()
        {

                #echo get_class($this) . "<br />";

                $this->helper = new Helper();
                $this->storage = new Storage();

        }

        public function connect()
        {
                $this->db = new Database();
                self::$entity = $this->db;
        }

        static function Entity(){
                return self::$entity;
        }


        function __destruct()
        {
                // TODO: Implement __destruct() method.
        }


}