<?php

/**
 * Created by PhpStorm.
 * User: tSoftX
 * Date: 04/02/2017
 * Time: 02:45
 */
abstract class Controller extends Controller_Extends
{

        var $cnt;
        var $mtd;
        var $ns;
        var $pars;
        var $view;
        var $model;
        var $template;
        var $default;
        var $storage;
        var $label;
        var $labelArr;
        var $lng_src;
        var $public;
        var $service;
        var $helper;

        /**
         * Controller constructor.
         * @param $pars
         * @param bool $public_load
         * @throws ReflectionException
         */
        function __construct($pars, $public_load = true)
        {
                // Declare Storage
                $this->storage = new Storage();
                $this->helper = new Helper();
                $this->default = "Default Content";

                if (!$this->helper->accessWithLogin($this)) {
                        header("Location: /Error/!/session_expired");
                }


                $this->pars = (object)$pars;




                #echo "Controller:" . $this->cnt;

                if ($this->cnt != "_Public" && $public_load ) {
                        // PUBLIC CLASSES
                        $this->public = new _Public($this->pars);
                }


                try {

                        // Parent model
                        // new Model();

                        // Child Model
                        $model = get_class($this) . "_Model";
                        $this->model = new $model();

                        if (file_exists("Models" . DIRECTORY_SEPARATOR . get_class($this) . "_Model")) {
                        }

                } catch (Exception $e) {

                        echo "Class need Model Class";
                }


                if (get_class($this) !== "_Public" && class_exists("_Public")) {
                        $this->model->public = new _Public($this->pars);
                }

                // highlight_string(var_export($this->pars, true));

                $this->setDevice();

                // View
                $this->view = new View();
                $this->view->storage = $this->storage;
                $this->view->pars = $this->pars;
                $this->helper->storage = $this->storage;

                $this->view->helper = $this->helper;


                $this->setReflectedClass($this);


        }

        abstract public function index();



        private function setDevice(){

                // highlight_string(var_export($_SESSION[REPOSITORY::CURRENT_DEVICE], true));
                // highlight_string(var_export($this->pars, true));
                // echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                // if (($this->pars->device === DEVICE_TYPE::ANDROID || $this->pars->device === DEVICE_TYPE::IOS)) {
                if (!is_null($this->pars->device)) {
                        $allowedDevice = array(DEVICE_TYPE::ANDROID, DEVICE_TYPE::IOS);
                        if( in_array($this->pars->device, $allowedDevice) ){
                                // $_SESSION[REPOSITORY::CURRENT_DEVICE] = $this->pars->device;
                                REPOSITORY::write(REPOSITORY::CURRENT_DEVICE, $this->pars->device);
                        }
                }

        }

        public function weatherNow($city )
        {

                try {
                        $public = new _Public($this->pars);
                        $weather = $public->{__FUNCTION__}( $city );
                        return $weather;
                } catch (Exception $e) {

                }

                return null;
        }

        public function weatherIn5DayWithDateAndTime( $city, $datetime )
        {

                try {
                        $public = new _Public($this->pars);
                        $weather = $public->{__FUNCTION__}( $city, $datetime );
                        return $weather;
                } catch (Exception $e) {

                }

                return null;
        }


        public function contentHeader($data = array())
        {

                try {
                        $public = new _Public($this->pars);
                        $header = $public->contentHeader($data);
                        return $header;
                } catch (Exception $e) {
                }

                return null;
        }

        /**
         * @param $_class
         * @return mixed
         * @throws ReflectionException
         */
        protected function setReflectedClass($_class)
        {
                $this->reflectionClass = new ReflectionClass($_class);
        }

        protected function getReflectedClass()
        {
                return $this->reflectionClass;
        }

        private $reflectionClass;


        function __destruct()
        {

        }


        /**
         * @deprecated
         * @example No Using with this Project Here
         * Set Language for this session
         */
        function setLanguageForSession($lang = Config::DEFAULT_LANGUAGE)
        {

                $lng = $this->lang($lang);

                $this->helper->lng_src = $lang;
                $this->view->label = (object)$lng;
                $this->view->labelArr = $lng;

                $this->view->lng_src = $this->storage->read("language");
                $this->label = (object)$lng;
                $this->labelArr = $lng;

                $this->model->label = $this->label;

        }


        /**
         * @param string $lang
         * @return null
         * @deprecated
         * @example No Using with this Project Here
         */
        function lang($lang = Config::DEFAULT_LANGUAGE)
        {
                $this->lng_src = $lang;

                // $active_language    = $_SESSION["language"];
                $active_language = $this->storage->read("language");
                // highlight_string(var_export($active_language, true));

                if (isset($this->lng_src)) {

                        if (isset($active_language)) {

                                // Already language selected
                                if ($this->lng_src !== $active_language) {
                                        // set new language
                                        return $this->changeLanguage($this->lng_src);

                                } else {

                                        // already language
                                        $this->lng_src = $active_language;
                                        return $this->storage->read("language_data");
                                }


                        } else {
                                return $this->changeLanguage($this->lng_src);
                        }


                } else {


                        // check active language
                        if (isset($active_language)) {
                                // if( is_null($_SESSION["language_data"]) )
                                if (!count($this->storage->read("language_data"))) {
                                        // return $this->changeLanguage( $_SESSION["language"] );
                                        return $this->changeLanguage($this->storage->read("language"));
                                }


                                #echo "Language A" . $this->storage->read("language");
                                $this->lng_src = $active_language;
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

                $path = "../sources/translate/{$file}";
                #highlight_string(var_export($path, true));
                $l = array();
                if (file_exists($path)) {
                        $l = file_get_contents($path);
                        $l = json_decode($l, true);
                        # highlight_string(var_export($l, true));

                } else {
                        // Default language file
                        // die("No Language File found!");
                        $path = "../sources/translate/en.json";
                        $l = file_get_contents($path);
                        $l = json_decode($l, true);
                }


                // Set Session the language
                // $_SESSION["language"] = $lng;
                // $_SESSION["language_data"] = $l;

                $this->storage->write("language", $lng);
                $this->storage->write("language_data", $l);

                #highlight_string(var_export($l, true));


                // return $_SESSION["language_data"];
                return $this->storage->read("language_data");


        }

        function toggle_help($key)
        {

                // Butun toggle help'S Database yada json file üzrinden kontrol olacak


        }


}