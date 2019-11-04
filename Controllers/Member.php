<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 27.09.18
 * Time: 09:44
 */
namespace owner;
use ReflectionException;
use Controller;
use REPOSITORY;
use FETCH_STRUCTURE;
use ACTIVITY;
use SHARED_APPLICATION;
use Config;
use Texts;
use TEXT_LANGUAGE;
use TEXT_FILES;
use TEXT_GROUPS;
use FILE_EXTENSIONS;
use Helper;

class Member extends Controller
{
        /**
         * User constructor.
         * @param $pars
         * @param $public_load
         * @throws ReflectionException
         */
        function __construct($pars)
        {
                parent::__construct($pars);
        }


        public function index()
        {

                // TODO: Implement index() method.

                // Default month is current month
                $this->pars->month = date("m");

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "performance"   => $this->performance(),
                        "user"          => REPOSITORY::read(REPOSITORY::CURRENT_USER)
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }


        function performance(){
                
                // $this->pars->month = 10;

                $this->pars->date = date("Y-m-d");
                $this->model->pars = $this->pars;
                $dataMonth      = $this->model->fetchMonthPerformance();
                $dataWeek       = $this->model->fetchWeekPerformance();

                $totalMonthTraining     = count($dataMonth);
                $totalWeekTraining      = count($dataWeek);
                $totalMonthAttendTraining       = 0;
                $totalWeekAttendTraining        = 0;
                $totalMonthBonus        = 0;
                $totalWeekBonus         = 0;

                $data = array(
                        "monthly"       =>array("data"=>$dataMonth, "total"=>count($dataMonth),"attend"=>0),
                        "weekly"        =>array("data"=>$dataWeek, "total"=>count($dataWeek),"attend"=>0),
                );

                $presence_training_in_time_accepted_types = [
                        MEETING_FEEDBACK_TYPE_IN_TIME,
                        MEETING_FEEDBACK_TYPE_NOT_IN_TIME,
                        MEETING_FEEDBACK_TYPE_DFB,
                        MEETING_FEEDBACK_TYPE_ENGAGED,
                        MEMBER_PRESENCE_TYPE_IN_TIME,
                        MEMBER_PRESENCE_TYPE_NO_IN_TIME
                ];

                foreach ($data as $key => $value) {

                        if( count($value["data"]) ){
                                
                                foreach ($value["data"] as $index => $item) {

                                        // Result for only Yes
                                        if (!is_null($item["my_availability"]) && $item["my_availability"])
                                        {
                                                $data[$key]["attend"]++;
                                        }

                                        else {
                                                if(
                                                        in_array( $item["meeting_reason_feedback"], $presence_training_in_time_accepted_types )
                                                        ||
                                                        in_array( $item["meeting_reason"], $presence_training_in_time_accepted_types )
                                                ){
                                                        $data[$key]["attend"]++;
                                                }
                                        }
                                }
                        }

                        // Not more need
                        unset($data[$key]["data"]);

                }

                return $data;


        }


        /**
         * Wait while App not in Public
         */
        function fireWall(){





                // Official Page Data
                $gen_data = array();
                // Navigation Title
                $gen_data["display_name"]              = Config::APP_NAME . " Official Page";
                // Activity Full Url
                $gen_data["link"]                      = "http://www.adler-gruppe.com";
                // With Right Bar Button on Navigation
                $gen_data[ACTIVITY::ACTIVITY]          = ACTIVITY::go(ACTIVITY::ACTIVITY_SHARED);

                $gen_data[SHARED_APPLICATION::X2SharedApplicationKey] = SHARED_APPLICATION::X2SharedApplicationAdsKey;


                $text = new Texts();



                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "user"=>REPOSITORY::read(REPOSITORY::CURRENT_USER),
                        "official_page_data"=>$gen_data,
                        "text" =>
                                $text->readFileContent(
                                        TEXT_LANGUAGE::LANGUAGE_GERMAN,
                                        TEXT_GROUPS::GROUP_INFORMATION,
                                        TEXT_FILES::FILE_WAIT_FOR_PUBLIC,
                                        FILE_EXTENSIONS::FILE_EXTENSION_TXT,
                                        array(
                                                "name"=> REPOSITORY::read(REPOSITORY::CURRENT_USER)["final_name"],
                                                "link"=>'<a class="text-primary text-underline font-bold" data-data="' . Helper::JSONCleaned($gen_data) . '"> ' . Config::APP_NAME . ' Official Webpage!</a>'
                                        )
                                )
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__ );





        }



        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}

namespace role;
use ReflectionException;
use Controller;
use FETCH_STRUCTURE;

class Member extends Controller
{
        /**
         * User constructor.
         * @param $pars
         * @param $public_load
         * @throws ReflectionException
         */
        function __construct($pars)
        {
                parent::__construct($pars);
        }


        public function index()
        {

                // TODO: Implement index() method.
        }

        /**
         * @return array
         * @deprecated
         * @use role/manage/delete
         */
        function delete(){


                // TODO Delete Member Required Role
                $this->model->pars = $this->pars;
                $data = $this->model->{__FUNCTION__}();


                return array(
                        "resulta" => $data->resulta && $data->process,
                        "messageTitle"=>"Fehler",
                        "messageBody"=>"Fehler aufgetreten",
                        "user_removed_role_id" => $this->pars->id
                );



        }

        function add(){

                // TODO Move Add and Same Functions from Role/manage to self


        }



        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}

namespace friends;
use ReflectionException;
use Controller;
use FETCH_STRUCTURE;

class Member extends Controller
{
        /**
         * User constructor.
         * @param $pars
         * @param $public_load
         * @throws ReflectionException
         */
        function __construct($pars)
        {
                parent::__construct($pars);
        }


        public function index()
        {

                // TODO: Implement index() method.

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array();

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }





        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}



