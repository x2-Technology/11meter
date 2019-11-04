<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 17.10.18
 * Time: 09:15
 */
namespace monthview;
use _list\Meeting as Meetings;
use Controller;
use FETCH_STRUCTURE;
use DateTime;
use Config;
use ReflectionException;
use ACTIVITY;
class Calendar extends Controller
{

        /**
         * Calendar constructor.
         * @param $pars
         * @param $public_load
         * @throws ReflectionException
         */
        public function __construct($pars, $public_load)
        {
                parent::__construct($pars, $public_load);
        }

        public function index()
        {

                // TODO: Implement index() method.
                // OTHER
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);
                $this->view->data = array(
                        "db"            => "",
                        "month_events"  => $this->fetchMonth()
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);
        }

        function getDayEvents()
        {


                $o = '<ul data-role="listview" data-theme="d" data-divider-theme="d" data-autodividers="false" class="day-events ui-listview ui-group-theme-d">';
                $o .= $this->getDayEventsContent()["resulta"];
                $o .= '</ul>';

                return $o;


        }

        function fetchMonth()
        {

                // Current Month
                if( is_null($this->pars->month ) ){
                        $this->pars->month = date_create(date("Y-m-d"))->format("m");
                }

                // Current Year
                if( is_null($this->pars->year) ){
                        $this->pars->year = date_create(date("Y-m-d"))->format("Y");

                }

                $this->model->pars = $this->pars;
                $meetings = $this->model->{__FUNCTION__}();


                // Organize
                $new_meeting_array = array();
                if (count($meetings)){
                        foreach ($meetings as $index => $meeting) {

                                $date = $meeting["datum"];
                                $d = new DateTime($date);
                                $m = $d->format("m");
                                $dd = $d->format("d");

                                // Already included from Database with custom Col Data
                                // $viewData = [];
                                // $viewData["display_name"]                   = $meeting["display_name"];
                                // $viewData["title_color"]                    = $meeting["title_color"];
                                // $viewData["meeting_pretty_date"]            = $meeting["meeting_pretty_date"];
                                // $viewData["icon"]                           = "ic_home";
                                // $viewData["last_check"]                     = "";
                                // $viewData["meeting_id"]                     = $meeting["id"];
                                $meeting["link"] = Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "_details" . DIRECTORY_SEPARATOR . "index/?id=" . $meeting["id"];
                                $meeting["unwind_get_data_store"]       = "javascript:new Layout().getUnwindDataStore();";
                                // $meeting["unwind_action"]                  = "javascript:javascript:unwindAction(); new Calendar().updateAvailability();";
                                $meeting[ACTIVITY::ACTIVITY]            = ACTIVITY::go(ACTIVITY::ACTIVITY_2);


                                $new_meeting_array[$m][$dd][$index] = $meeting;


                        }

                }



                return array(
                        "events"        => $new_meeting_array,
                        "count"         => count($meetings),
                        "month_names"   => $this->months()["data"],
                        "years"         => $this->years()["data"]
                );


        }

        function months(){

                $m_short        = array("Jan.","Feb.", "Mär.", "Apr.", "Mai.", "Jun.", "Jul.", "Aug.", "Sep.", "Okt.", "Nov.", "Dez.");
                $m_long         = array("Januar","Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");


                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "m_short" => $m_short,
                        "m_long"  => $m_long
                );

                return array(

                        "view" => $this->view->fileContent($this->getReflectedClass()->getShortName(), __FUNCTION__ . ".php" ),
                        "data" => array(
                                "m_short" => $m_short,
                                "m_long"  => $m_long
                        )
                );

        }

        function years(){

                $yearsData = array( "2014", "2015", "2016", "2017", "2018", "2019", "2021", "2022", "2023", "2024", "2025", "2026" );


                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "y_data"=>$yearsData
                );

                return array(
                        "view"=>$this->view->fileContent($this->getReflectedClass()->getShortName(), __FUNCTION__ . ".php" ),
                        "data"=>$yearsData
                );

        }

}


namespace weekview;
use Controller;
class Calendar extends Controller{

        /**
         * Calendar constructor.
         * @param $pars
         * @throws \ReflectionException
         */
        public function __construct($pars)
        {
                parent::__construct($pars);
        }



        public function index()
        {
                // TODO: Implement index() method.

        }


        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }
}



namespace dayview;
use Controller;
class Calendar extends Controller{


        /**
         * Calendar constructor.
         * @param $pars
         * @throws \ReflectionException
         */
        public function __construct($pars)
        {
                parent::__construct($pars);
        }


        public function index()
        {
                // TODO: Implement index() method.
        }


        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }
}