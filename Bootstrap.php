<?php

/**
 * Created by PhpStorm.
 * User: tSoftX
 * Date: 04/02/2017
 * Time: 02:33
 */
class Bootstrap
{
        var $url, $cnt, $ns, $mtd, $pars, $public;

        function __construct()
        {



                $this->url = explode("/", $_GET["url"]);

                $convertedOriginalPHPGetPars = $this->convertOriginalPHPGetPars($_GET);
                if (!is_null($convertedOriginalPHPGetPars)) {
                        $this->url[3] = $convertedOriginalPHPGetPars;
                }

                $this->cnt = $this->url[0];
                $this->ns = $this->url[1];
                $this->mtd = $this->url[2];
                $this->pars = $this->url[3];



                $pars = array();
                if (count($this->pars)) {
                        $this->pars = trim($this->pars);
                        $this->pars = explode("|", $this->pars);
                        $_ = array();
                        foreach ($this->pars as $par) {

                                $par = explode(":", $par);

                                $r = json_decode($par[1]);
                                if (!json_last_error()) {
                                        $_[$par[0]] = $r;
                                } else {
                                        $_[$par[0]] = $par[1];
                                }
                        }
                        $pars = $_;
                }

                $this->pars = (object)array_merge($pars, $_POST);


                include "Libs/Autoloader.php";
                new Autoloader();



                ini_set("display_errors", Config::SHOW_DISPLAY_ERRORS);
                error_reporting(Config::SHOW_PHP_ERRORS_WITH);

        }




        /**
         * @return string
         */
        function output()
        {

                // required controller
                $file = "Controllers" . DIRECTORY_SEPARATOR . $this->cnt . ".php";



                if (file_exists($file)) {


                        try {

                                // include base class with his model
                                include $file;
                                include "Models" . DIRECTORY_SEPARATOR . $this->cnt . "_Model.php";

                                // include public class with his model
                                if ($this->cnt !== "_Public") {
                                        require_once "Controllers" . DIRECTORY_SEPARATOR . "_Public.php";
                                        require_once "Models" . DIRECTORY_SEPARATOR . "_Public_Model.php";
                                }


                                if ($this->ns !== "!") {
                                        $this->cnt = $this->ns . "\\" . $this->cnt;
                                }




                        } catch (Exception $exc) {

                                die("Error");

                        }


                        if (!class_exists($this->cnt)) {
                                return $this->errModule($this->cnt, null);
                        } else {
                                try {

                                        // echo $this->cnt;

                                        $controller = new $this->cnt($this->pars, false);
                                        // $controller->cnt = $this->cnt;

                                        if (!method_exists($controller, $this->mtd)) {
                                                return $this->errModule($this->cnt,$this->mtd );
                                        }

                                        // set service class

                                } catch (Exception $exc) {
                                        echo $exc->getMessage();
                                }
                        }

                } else {

                        return $this->errModule($file, null);

                }


                // return json_encode($controller->{$this->mtd}());

                if ( $this->pars->output === "json") {

                        return json_encode(array("data" => array($controller->{$this->mtd}())));

                } else {
                        $f = $controller->{$this->mtd}();
                        return $f;
                }
        }


        function errModule($cnt, $mtd)
        {


                include "Controllers" . DIRECTORY_SEPARATOR . "Error.php";
                include "Models" . DIRECTORY_SEPARATOR . "Error_Model.php";

                $this->cnt = "Error";
                $this->mtd = "p404";


                #echo $_SERVER["HTTP_REQUEST"];

                $this->pars->forController = $cnt;
                $this->pars->forMethod = $mtd;


                $controller = new $this->cnt($this->pars, false);


                if ($this->pars->output === "json") {

                        return json_encode($controller->{$this->mtd}());

                } else {
                        $f = $controller->{$this->mtd}();
                        return $f;
                }


        }


        /**
         * @param $GET
         * @return mixed|null|string
         *
         * Format Default PHP GEt params to System Params
         */
        private function convertOriginalPHPGetPars($GET)
        {

                unset($GET["url"]);
                if (count($GET)) {
                        $pars = json_encode($GET, JSON_UNESCAPED_UNICODE);
                        $pars = preg_replace("/\"|\\\\|{|}/i", null, $pars);
                        $pars = preg_replace("/,/i", "|", $pars);
                        return $pars;
                }
                return NULL;
        }

}