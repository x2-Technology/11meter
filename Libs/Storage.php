<?php

/**
 * Created by PhpStorm.
 * User: adler_supervisor
 * Date: 01.08.17
 * Time: 16:44
 */
class Storage
{
    function __construct() {

    }


    function read( $main_key ){


        /*if( !session_status() || session_status() == 1 ){
            session_start();
        }*/

        if( count($_SESSION[strtoupper($main_key)] ))
        {
            return $_SESSION[strtoupper($main_key)];
        } else {
            // echo count($_SESSION[strtoupper($main_key)]);
            return NULL;
        }


    }

    function write( $main_key, $value, $sub_value = NULL ){


        /*if( !session_status() || session_status() == 1 ){
            session_start();
        }*/

        if( !is_null($sub_value) )
        {

            if( is_object($_SESSION[strtoupper($main_key)])){
                // Convert object to array for edit
                $_SESSION[strtoupper($main_key)] = (array) $_SESSION[strtoupper($main_key)];
            }


            $sub_key = $value;

            if( array_key_exists( strtoupper($main_key), $_SESSION) ){

                @$_SESSION[strtoupper($main_key)][$sub_key] = $sub_value;

            } else {

                @$_SESSION[strtoupper($main_key)] = array ($sub_key=>$sub_value);

            }

            // convert the array to object again
            $_SESSION[strtoupper($main_key)] = (object) $_SESSION[strtoupper($main_key)];



        } else
        {
            $_SESSION[strtoupper($main_key)] = $value;
        }

    }



    function kill( $main_key, $sub_key = NULL ){

        try{

            $_SESSION = (array) $_SESSION;
            if( !is_null($sub_key) )
            {
                if( @array_key_exists( $sub_key, $_SESSION[strtoupper($main_key)] ) ):

                    $_SESSION[strtoupper($main_key)] = (array) $_SESSION[strtoupper($main_key)];
                    unset($_SESSION[strtoupper($main_key)][$sub_key]);
                    $_SESSION[strtoupper($main_key)] = (object) $_SESSION[strtoupper($main_key)];
                endif;
            } else
            {
                unset($_SESSION[strtoupper($main_key)]);
            }

        } catch (Exception $e){

            die($e->getMessage());

        }


    }


    function killAll( callable $callback = NULL ){


          session_destroy();
          $_SESSION = [];
          
        // $this->kill( "logged" );
        // $this->kill( "user" );

        if( !is_null($callback) )
            call_user_func($callback);


    }

    function readAll(){

        return $_SESSION;

    }




}