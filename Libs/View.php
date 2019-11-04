<?php

/**
 * Created by PhpStorm.
 * User: tSoftX
 * Date: 04/02/2017
 * Time: 02:45
 */
class View
{
        var $content;
        var $msg = "";
        var $params = array();
        var $data = array();
        var $page_title;
        var $page_meta_property = "";
        var $class = "";
        var $method = "";
        var $label;
        var $labelArr;
        var $lng_src = Config::DEFAULT_LANGUAGE;
        var $pars = array();

        var $header;
        var $footer;
        var $sidebarmenu;

        var $helper;

        var $storage;

        private $postDataStructure = FETCH_STRUCTURE::FETCH_ARRAY;

        /**
         * @return int
         */
        private function getPostDataStructure()
        {
                return $this->postDataStructure;
        }

        /**
         * @param int $postDataStructure
         */
        public function setPostDataStructure($postDataStructure)
        {
                $this->postDataStructure = $postDataStructure;
        }
        // const FETCH_OBJECT = "object";
        // const FETCH_ARRAY = "array";

        function __construct()
        {

        }


        function render($cnt, $mtd)
        {


                // Company Registration Not Completed?, Redirect to Register Page
                /*if (
                    $this->storage->read("logged") &&
                    $this->storage->read("user")->cstatus2 != COMPANY_STATUS::ACTIVE &&
                    $cnt !== "Register" &&
                    $this->storage->read("user")->urole != Defaults::USER_ROLE_SUPERVISOR
                ) {
                      header("Location: /Register/dispatcher/index");
                      exit(0);
                }*/


                // If company registration completed and request to register page redirect to main page

                // Company Registration Not Completed?, Redirect to Register Page



                $this->page_title = Config::APP_NAME;
                $this->header = $this->header();
                $this->footer = $this->footer();
                $this->class = $cnt;
                $this->method = $mtd;
                $this->content = $this->content($cnt, $mtd);

                // $this->data->user   = $this->storage->read("user"); // $_SESSION["user"];

                include "Libs/Template/" . Config::TEMPLATE . "/index.php";


        }

        function fileContent($class, $file)
        {

                ob_start();
                $this->data = $this->postParamsAs($this->getPostDataStructure());
                $file = "Views/{$class}/{$file}";
                if (file_exists($file)) {
                        include($file);
                        return ob_get_clean();
                }
                return "$file not found!";
      }

        function content($cnt, $mtd)
        {

                ob_start();
                $this->data = $this->postParamsAs($this->getPostDataStructure());

                #echo "Views/{$cnt}/{$mtd}.php";
                include("Views/{$cnt}/{$mtd}.php");
                return ob_get_clean();
        }

        function header()
        {
                ob_start();
                include("Libs/Template/" . Config::TEMPLATE . "/" . __FUNCTION__ . ".php");
                return ob_get_clean();
        }

        function footer()
        {
                ob_start();
                include("Libs/Template/" . Config::TEMPLATE . "/" . __FUNCTION__ . ".php");
                return ob_get_clean();
        }

        function sidebarmenu()
        {
                ob_start();
                include("Libs/Template/" . Config::TEMPLATE . "/" . __FUNCTION__ . ".php");
                return ob_get_clean();
        }

        function lang()
        {

                $selected_language = $_POST["language"];
                // $active_language    = $_SESSION["language"];
                $active_language = $this->storage->read("language");


                if (isset($selected_language)) {

                        if (isset($active_language)) {

                                // Already language selected
                                if ($selected_language !== $active_language) {
                                        #highlight_string(var_export($_POST, true));
                                        // set new language
                                        return $this->changeLanguage($selected_language);

                                } else {

                                        // already language
                                        // return $_SESSION["language_data"];
                                        return $this->storage->read("language_data");
                                }


                        } else {
                                return $this->changeLanguage($selected_language);
                        }


                } else {


                        // check active language
                        if (isset($active_language)) {
                                // if( is_null($_SESSION["language_data"]) )
                                if (!count($this->storage->read("language_data"))) {
                                        // return $this->changeLanguage( $_SESSION["language"] );
                                        return $this->changeLanguage($this->storage->read("language"));
                                }


                                // return $_SESSION["language_data"];
                                return $this->storage->read("language_data");

                        } else {

                                // set active language as default
                                return $this->changeLanguage();

                        }

                }

        }


        private function changeLanguage($lng = Config::DEFAULT_LANGUAGE)
        {


                $file = $lng . ".json";

                $path = "Libs/languages/{$file}";
                $l = array();
                if (file_exists($path)) {
                        $l = file_get_contents($path);
                        $l = json_decode($l, true);
                        #highlight_string(var_export($l, true));

                } else {
                        // Default language file
                        // die("No Language File found!");
                        $path = "Libs/languages/en.json";
                        $l = file_get_contents($path);
                        $l = json_decode($l, true);
                }


                // Set Session the language
                // $_SESSION["language"] = $lng;
                // $_SESSION["language_data"] = $l;

                $this->storage->write("language", $lng);
                $this->storage->write("language_data", $l);


                // return $_SESSION["language_data"];
                return $this->storage->read("language_data");


        }


        private function postParamsAs($type = FETCH_STRUCTURE::FETCH_ARRAY)
        {

                if ($type === FETCH_STRUCTURE::FETCH_ARRAY) {
                        return $this->data;
                } else if ($type === FETCH_STRUCTURE::FETCH_OBJECT) {
                        return (object)$this->data;
                }

        }


}