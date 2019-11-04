<?php

/**
 * Created by PhpStorm.
 * User: tSoftX
 * Date: 05/02/2017
 * Time: 00:30
 */
class Error extends Controller
{
        /**
         * Message constructor.
         * @param $pars
         * @param $public_load
         * @throws ReflectionException
         */
        function __construct($pars, $public_load)
        {
                parent::__construct($pars, $public_load);
        }


        public function index()
        {
                // TODO: Implement index() method.
        }

        function p302()
        {


                $m = "Sie haben keine erlaubnisse!";

                // Parameter for View
                $this->view->data = array(
                    "header" => "Access Denied for User",
                    "message" => $m,
                );


                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                // View
                $this->view->render("Error", "index");

        }

        function p404($cnt = null)
        {


                if ($this->pars->output === "json") {

                        return array("data" => array(array("error" => true, "title" => "Error 404", "message" => "View not found for Controller!" . $this->pars->forController . " " . $this->pars->forMethod  )));

                }

                $m = "404 Seite nicht gefunden_!";// . highlight_string(var_export($_SERVER, true));;

                // Parameter for View
                $this->view->data = array(
                        "header" => "Fehler 404",
                        "message" => $m,
                );


                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                // View
                $this->view->render("Error", "index");

        }

        function session_expired()
        {

                $file = "Libs/Texts/Messages/{$this->lng_src}/session_expired.txt";          // <- File With Language
                if (!file_exists($file)) {
                        $file = "Libs/Texts/Messages/en/session_expired.txt";     // <- Default file
                }
                $text = "";
                $file = fopen($file, 'r');
                while (!feof($file)) {
                        $text .= fgets($file) . "<br />";
                }
                fclose($file);

                // Parameter for View
                $this->view->data = array(
                    "header" => "Fehler 404",
                    "message" => $text,
                );


                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                // View
                $this->view->render("Error", __FUNCTION__);


        }



        function jsHttpRequestViewControllerData(){

                $leagueViewController = new ViewController(
                        "Fehler",
                        "Request Fehler",
                        "Error",
                        "!",
                        "viewJsHttpRequest",
                        array(),
                        ACTIVITY::ACTIVITY_ERROR,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        NULL
                );

                return $leagueViewController->prepare();



        }

        function viewJsHttpRequest(){

                // Parameter for View
                $this->view->data = array(
                        "data"=>REPOSITORY::reads(REPOSITORY::CURRENT_LAST_MYSQL_ERROR),
                        "sql_view_controller_data"=>$this->sqlViewControllerData()
                );


                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                // View
                $this->view->render("Error", "js_http_request");


        }

        private function sqlViewControllerData(){

                $leagueViewController = new ViewController(
                        "Error SQL Script",
                        "Error SQL",
                        "Error",
                        "!",
                        "sqlView",
                        array(),
                        ACTIVITY::ACTIVITY_HELPER_1,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        NULL
                );

                return $leagueViewController->prepare();



        }

        function sqlView(){


                // Parameter for View
                $this->view->data = array(
                        "sql"=>REPOSITORY::reads(REPOSITORY::CURRENT_LAST_MYSQL_ERROR)["query"]
                );


                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                // View
                $this->view->render("Error", "sql_view");


        }


}