<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 27.09.18
 * Time: 09:44
 */

namespace _list;
use Controller;
use FETCH_TYPE;
use FETCH_STRUCTURE;
use ReflectionException;
use ACTIVITY;
use Config;
use REPOSITORY;
use ALERT_ACTION_STYLE;
use APP_ICON;

class Message extends Controller
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

                $this->pars->rows = $this->getRows();
                
                // TODO: Implement index() method.
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = $this->pars;
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }

        private function getRows(){

                // Set User ID from REPOSITORY
                if( is_null($this->pars->uid) ){
                        $this->pars->uid = REPOSITORY::read(REPOSITORY::CURRENT_USER)["uid"];
                }

                // Get Mails
                $rowDataAll = $this->fetchAll()->data;
                

                #highlight_string(var_export($this->fetchAll(), true));

                $rows = array();

                // Get next 5 Days Weather Report

                if( count($rowDataAll) ) {
                        foreach ($rowDataAll as $rowData) {

                                if (intval($rowData["is_delete"]) != 1) {
                                        $data = array();
                                        // Prepare the Data
                                        $data["display_name"] = $rowData["display_name"];
                                        $data["message_pretty_date"] = $rowData["message_pretty_date"];
                                        $data["message"] = $rowData["message"];
                                        $data["link"] = Config::BASE_URL . DIRECTORY_SEPARATOR . "Message" . DIRECTORY_SEPARATOR . "_content" . DIRECTORY_SEPARATOR . "index/?id=" . $rowData["id"];
                                        $data["icon"] = "ic_home";
                                        $data["last_check"] = "";
                                        $data[ACTIVITY::ACTIVITY] = ACTIVITY::go(ACTIVITY::ACTIVITY_3);
                                        $data["unwind_get_data_store"]  = "javascript:new Layout().getUnwindDataStore();";
                                        // $data["unwind_action"]          = "javascript:new Layout().setMessageAsRead({$rowData["display_name"]});";
                                        /*$data["right_bar_button"] = array(
                                                // Button Title
                                                "title" => "Loeschen",
                                                "icon" => "bin5",
                                                // Action With Confirm
                                                "confirm" => array(
                                                        // Alert View Title
                                                        "title" => "Löschen",
                                                        "icon" => APP_ICON::ICON_RECYCLE_BIN, // Show Button Icon ( If Icon is not Empty than Icon else Show title)
                                                        "message" => "Möchten Sie löschen?",
                                                        // Alert View Actions
                                                        "actions" => array(
                                                                // Alert View Actions
                                                                array(
                                                                        // Priority Icon, if empty is than String
                                                                        "icon" => "floppy-disc",
                                                                        // Alert View Action[] title
                                                                        "title" => "Cancel",
                                                                        // Alert View Action[] action dismiss alert controller if empty action
                                                                        "action" => "",
                                                                        // Alert View Action[] action style support for ios, will combine with android
                                                                        "style" => ALERT_ACTION_STYLE::UIAlertActionStyleDestructive,

                                                                ),

                                                                array(
                                                                        // Alert View Action[] title
                                                                        "title" => "Ok",
                                                                        // Alert View Action[] action dismiss alert controller if empty action or call javascript code
                                                                        "action" => "javascript:new Layout().delete('_content')",
                                                                        // Alert View Action[] action style support for ios, will combine with android
                                                                        "style" => ALERT_ACTION_STYLE::UIAlertActionStyleDefault
                                                                ),
                                                        )
                                                )
                                                // Or
                                                // Nothing with empty action or call javascript code
                                                # "action"=>"javascript:new Settings().save('settings')"
                                        );*/


                                        $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);
                                        $this->view->data = array(
                                                "post" => $data,
                                                "db" => $rowData,
                                        );


                                        $row = $this->view->fileContent($this->getReflectedClass()->getShortName() . DIRECTORY_SEPARATOR . $this->getReflectedClass()->getNamespaceName(), "row.php");

                                        array_push($rows, $row);
                                }

                        }
                }

                return $rows;



        }

        private function fetchAll(){
                $this->pars->club_id = REPOSITORY::read(REPOSITORY::CURRENT_USER)["club_id"];
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();
        }


        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}

namespace _content;
use Controller;
use FETCH_TYPE;
use FETCH_STRUCTURE;
use ReflectionException;
use ACTIVITY;
use Config;
use REPOSITORY;

class Message extends Controller
{

        public function __construct($pars, $public_load)
        {
                parent::__construct($pars, $public_load);
        }

        public function index()
        {

                // Set User ID from REPOSITORY
                if( is_null($this->pars->uid) ){
                        $this->pars->uid = REPOSITORY::read(REPOSITORY::CURRENT_USER)["uid"];
                }

                $data = $this->fetch();
                $message = array_shift($data->data);
                REPOSITORY::write(REPOSITORY::CURRENT_MESSAGE, $message);
                
                $this->setAsRead( $message );


                // TODO: Implement index() method.
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(

                        "message"=>$message,
                        "error"=>$data->errInfo

                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }

        function getCurrentMessage(){
                return REPOSITORY::read(REPOSITORY::CURRENT_MESSAGE);
        }

        private function fetch(){

                
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();


        }

        private function setAsRead( $originalMessage ){

                $this->pars->uid = REPOSITORY::read(REPOSITORY::CURRENT_USER )["uid"];
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}( $originalMessage );


        }

        function delete(){


                $this->pars->uid = REPOSITORY::read(REPOSITORY::CURRENT_USER)["uid"];
                $this->pars->new = REPOSITORY::read(REPOSITORY::CURRENT_MESSAGE);

                $this->model->pars = $this->pars;
                $data = $this->model->{__FUNCTION__}();

                return array(
                        "resulta"=>$data["resulta"],
                        "process"=>$data["process"],
                        "message"=>$data["resulta"] ? "Message deleted successfully" : $data["errInfo"],
                        "color" =>      $data["resulta"] ? "success" : "danger",
                        // "sql" =>      $data["sql"],
                        "new_id"        =>      REPOSITORY::read(REPOSITORY::CURRENT_MESSAGE)["id"]
                );

        }


        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}