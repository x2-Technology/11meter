<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 2019-10-30
 * Time: 09:47
 * Cookie Repository
 */
ob_start();
class CRepository extends ARepository implements IRepository
{
        const cLife = 31556926;

        protected function __construct() {
                parent::__construct();
        }

        public static function getInstance(){

                if (is_null(self::$instance))
                {
                        self::$instance = new static();
                }

                return self::$instance;


        }


        function add($k, $sk, $v = NULL)
        {
                $this->repoKey        = $k;


                if( is_null($v) )
                {
                        switch ( gettype($sk)){


                                case "string":

                                        $this->repoVal = $sk;

                                        break;

                                case "array":
                                case "object":


                                        $this->repoVal = $sk;

                                        break;

                        }
                }

                else {

                        $this->repoVal = $this->tempRepo[$k];

                        if( is_null($this->repoVal) )
                        {
                                $this->repoVal = $_COOKIE[$k];

                                $cookieIsJson = json_decode($this->repoVal, true);

                                if( json_last_error() === JSON_ERROR_NONE ){

                                        $this->repoVal = $cookieIsJson;

                                }
                        }


                        if( !is_null($this->repoVal) )
                        {
                                $this->repoVal[$sk] = $v;

                        }

                        else {
                                $this->repoVal = array($sk => $v);

                        }
                }

                $this->tempRepo[$k] = $this->repoVal;

                return $this;


        }

        public function commit()
        {
                if( count($this->tempRepo) ){

                        foreach ($this->tempRepo as $index => $item)
                        {
                                setcookie( $index, json_encode($item, JSON_PRETTY_PRINT) , time() + self::cLife, '/');
                        }
                }
        }




        function read($k, $sk = NULL)
        {

                $cookie = $this->tempRepo[$k];

                if( is_null($cookie) )
                {
                        $cookie = json_decode( $_COOKIE[$k], true);
                }

                if( !is_null($cookie) )
                {
                        if( is_null($sk) )
                        {
                                json_decode($cookie, JSON_PRETTY_PRINT);
                                if( json_last_error() === JSON_ERROR_NONE ){
                                        return $this->switchArray( $cookie, $this->getFetchMethod() === self::FETCH_TYPE_OBJECT  );
                                }

                                return $cookie;
                        }

                        else {

                                return $this->switchArray( $cookie[$sk], $this->getFetchMethod() === self::FETCH_TYPE_OBJECT );

                        }
                }

                return null;


        }


        function readAll()
        {
                $n = array();

                foreach ( $_COOKIE as $index => $item)
                {
                        $n[$index] = $this->read($index);
                }

                return $this->switchArray( $n, $this->getFetchMethod() === self::FETCH_TYPE_OBJECT  );

        }

        function kill($k, $sk = NULL)
        {

                $cookie = $this->tempRepo[$k];

                if( is_null($cookie) )
                {
                        $cookie = json_decode( $_COOKIE[$k], true);
                }


                if( !is_null($sk) )
                {
                        unset($cookie[$sk]);
                        $this->add( $k, $cookie )->add();
                        $this->commit();

                }

                else {
                        setcookie($k, null, -1, '/');
                        unset($_COOKIE[$k]);
                }
        }

        function killAll()
        {
                if( count($_COOKIE) )
                {
                        foreach ( $_COOKIE as $index => $item) {
                                setcookie($index, null, -1, '/');
                                unset($_COOKIE[$index]);
                        }
                }
        }

        function getInfo(){
                return "Cookie Repository";
        }


        public function __toString()
        {
                return "Cookie Repository Üretildi";
        }


        public function getId()
        {
                // TODO: Implement getId() method.
        }
}