<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 2019-10-30
 * Time: 09:40
 */

interface IRepository
{
        public static function getInstance();
        public function add( $k, $sk, $v = NULL );
        public function commit();
        public function read($k, $sk = NULL);
        public function readAll();
        public function kill($k, $sk = NULL);
        public function killAll();
        public function getInfo();
        public function getId();
}