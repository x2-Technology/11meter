<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 2019-10-30
 * Time: 09:47
 * Session Repository
 */

class SRepository extends ARepository implements IRepository
{
        protected function __construct()
        {
                // Call only one time
                if (session_status() !== PHP_SESSION_ACTIVE) {
                        session_start();
                }

                parent::__construct();

        }

        public static function getInstance()
        {

                if (is_null(self::$instance)) {
                        self::$instance = new static();
                }

                return self::$instance;
        }


        function getInfo()
        {

                return "Session Repository Session is active:" . session_status();
        }

        function commit()
        {
                if( count($this->tempRepo) ){

                        foreach ($this->tempRepo as $index => $item)
                        {
                                $_SESSION[$index] = $item;
                        }
                }
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

                                $repoIsJson = json_decode($this->repoVal, true);

                                if( json_last_error() === JSON_ERROR_NONE ){

                                        $this->repoVal = $repoIsJson;

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


        function read($k, $sk = NULL)
        {
                $repo = $this->tempRepo[$k];

                if( is_null($repo) )
                {
                        $repo = $_SESSION[$k];
                }

                if( !is_null($repo) )
                {
                        if( is_null($sk) )
                        {
                                json_decode($repo, JSON_PRETTY_PRINT);
                                if( json_last_error() === JSON_ERROR_NONE ){
                                        return $this->switchArray( $repo, $this->getFetchMethod() === self::FETCH_TYPE_OBJECT  );
                                }

                                return $repo;
                        }

                        else {

                                return $this->switchArray( $repo[$sk], $this->getFetchMethod() === self::FETCH_TYPE_OBJECT );

                        }
                }

                return null;

        }

        function readAll()
        {
                $n = array();

                foreach ( $_SESSION as $index => $item)
                {
                        $n[$index] = $this->read($index);
                }

                return $this->switchArray( $n, $this->getFetchMethod() === self::FETCH_TYPE_OBJECT  );
        }

        function kill($k, $sk = NULL)
        {

                $repo = $this->tempRepo[$k];

                if( is_null($repo) )
                {
                        $repo = $_SESSION[$k];
                }


                if( !is_null($sk) )
                {
                        unset($repo[$sk]);
                        $this->add( $k, $repo )->add();
                        $this->commit();

                }

                else {

                        unset($_SESSION[$k]);
                }

        }

        function killAll()
        {
                session_destroy();
                $_SESSION = NULL;
        }

        public function __toString()
        {
                return "Session Repository Üretildi";
        }

        public function __destruct()
        {
                // TODO: Implement __destruct() method.
        }

        public function getId()
        {
                return session_id();
        }
        
}
