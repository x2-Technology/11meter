<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 27.09.18
 * Time: 12:02
 */


/**
 *
 *
        BASE DATA FOR LINKING
        $data["display_name"]                   = $rowData["display_name"];
        $data["title_color"]                    = $rowData["title_color"];
        $data["meeting_pretty_date"]            = $rowData["meeting_pretty_date"];
        $data["link"]                           = Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "_details" . DIRECTORY_SEPARATOR . "index/?id=" . $rowData["id"];
        $data["icon"]                           = "ic_home";
        $data["last_check"]                     = "";
        $data["meeting_id"]                     = $rowData["id"];
 *
 */
namespace _list;
use Controller;
use FETCH_STRUCTURE;
use Config;
use ANLASS;
use ACTIVITY;
use APP_ICON;
use DateTime;
class Meeting extends Controller
{

        /**
         * Meeting constructor.
         * @param $pars
         * @param $public_load
         * @throws \ReflectionException
         */
        public function __construct($pars)
        {
                parent::__construct($pars);


        }

        public function index()
        {

                $meetingRows    = array();
                $listingLabel   = "";
                switch ($this->pars->direction){
                        case NULL:
                        case "next":
                                $meetingRows = $this->fetchNext();
                                $listingLabel   = "Nächste Termine gelistet";
                                break;
                        case "prev":
                                $meetingRows = $this->fetchPrev();
                                $listingLabel   = "Vorherige Termine gelistet";
                                break;
                }
                $listingLabel = !count( $meetingRows ) ? "Sorry Keine Termin vefügbar" : $listingLabel;

                #highlight_string(var_export($meetingRows, true));
                $this->pars->listing_label = $listingLabel;
                $this->pars->rows = $this->getRowsWithData( $meetingRows );

                
                // TODO: Implement index() method.
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = $this->pars;
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);
        }


        private function getRowsWithData($meetingRows){



                $rows = array();

                if( count($meetingRows)) {
                        foreach ($meetingRows as $rowData) {


                                $data = array();
                                // Prepare the Data
                                $data["display_name"] = $rowData["display_name"];
                                $data["title_color"] = $rowData["title_color"];
                                $data["meeting_pretty_date"] = $rowData["meeting_pretty_date"];
                                $data["link"] = Config::BASE_URL . DIRECTORY_SEPARATOR . "Meeting" . DIRECTORY_SEPARATOR . "_details" . DIRECTORY_SEPARATOR . "index/?id=" . $rowData["id"];
                                $data["icon"] = "ic_home";
                                $data["last_check"] = "";
                                $data["unwind_get_data_store"] = "javascript:new Layout().getUnwindDataStore();";
                                // $data["unwind_action"]                  = "javascript:new Meeting().updateAvailability();";
                                $data[ACTIVITY::ACTIVITY] = ACTIVITY::go(ACTIVITY::ACTIVITY_2);
                                // $data["meeting_id"]                     = $rowData["id"];


                                $data["right_bar_button"] = array(
                                        // Button Title
                                        "title" => "Whatsapp",
                                        "icon" => APP_ICON::ICON_WHATSAPP,
                                        // Action Without Confirm
                                        "action" => "javascript:Layout().shareWithWhatsApp();"
                                );


                                switch ($rowData["anlass"]) {

                                        case ANLASS::LIGASPIEL:
                                        case ANLASS::POKALSPIEL:
                                        case ANLASS::TURNIER:
                                        case ANLASS::TESTSPIEL:
                                                $data["isMatch"] = true;
                                                break;

                                        default:
                                                $data["isMatch"] = false;
                                                break;
                                }


                                $startAbsTime = $rowData["datum"] . " " . $rowData["beginn"];

                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);
                                $this->view->data = array(
                                        "post" => $data,
                                        "db" => $rowData,
                                        "weather" => $this->weatherIn5DayWithDateAndTime('Frankenthal', $startAbsTime)
                                );

                                $row = $this->view->fileContent($this->getReflectedClass()->getShortName() . DIRECTORY_SEPARATOR . $this->getReflectedClass()->getNamespaceName(), "cell.php");
                                


                                array_push($rows, $row);

                        }
                }


                return $rows;



        }

        public function fetchAll(){

                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();
        }

        public function fetchNext(){
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();
        }

        public function fetchPrev(){
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();
        }


        public function weatherIn5DayWithDateAndTime( $cityName, $datetime ){

                parent::weatherIn5DayWithDateAndTime($cityName, $datetime);

        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }


}

namespace _details;
use Controller;
use FETCH_STRUCTURE;
use Config;
use ACTIVITY;
use ALERT_ACTION_STYLE;
use ReflectionException;
use REPOSITORY;
use APP_ICON;
use SHARED_APPLICATION;

class Meeting extends Controller
{
        /**
         * Meeting constructor.
         * @param $pars
         * @param $public_load
         * @throws \ReflectionException
         */


        const DETAIL_MY_POSSIBILITY = 0;
        const DETAIL_TEAM_PRESENCE = 1;
        const DETAIL_MEETING_FEEDBACK = 2;


        /**
         * Meeting constructor.
         * @param $pars
         * @throws ReflectionException
         */
        public function __construct($pars)
        {
                parent::__construct($pars);
        }

        public function index()
        {

                // HEADER DATA


                $rowData = $this->getMeetingData();
                #highlight_string(var_export($rowData, true));
                REPOSITORY::write(REPOSITORY::CURRENT_MEETING, $rowData);



                // TODO: Implement index() method.
                // OTHER
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);
                $this->view->data = array(
                        "header"                => $this->contentHeader( $rowData ),
                        "db"                    => $rowData,
                        "detail_items"          => array(
                            self::DETAIL_MY_POSSIBILITY => $this->prepareAvailabilityPostDataWithData( $rowData ),
                            self::DETAIL_TEAM_PRESENCE => $this->preparePresencePostDataWithData( $rowData ),
                            self::DETAIL_MEETING_FEEDBACK => $this->prepareFeedbackPostDataWithData( $rowData )
                        )
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);
        }


        public function shareWithWhatsapp(){

                $meeting = REPOSITORY::read(REPOSITORY::CURRENT_MEETING);
                return array(
                        SHARED_APPLICATION::X2SharedApplicationKey => SHARED_APPLICATION::X2SharedApplicationWhatsAppKey,
                        "link"=>$meeting["display_name"] . " " . $meeting["meeting_pretty_date"] . " " . $meeting["meeting_start"]
                );


        }

        public function contentHeader($data = array())
        {
                return parent::contentHeader($data); // TODO: Change the autogenerated stub
        }

        public function getMeetingData(){

                $this->pars->uid = REPOSITORY::read(REPOSITORY::CURRENT_USER)["uid"];
                $this->model->pars = $this->pars;
                return $this->model->fetch();
                
        }


        private function prepareAvailabilityPostDataWithData( $data = array() ){

                $_ = array();
                $_["display_name"]              = "Meine Verfügbarkeit";
                $_["meeting_pretty_date"]       = "";
                $_["link"]                      = Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "_availability" . DIRECTORY_SEPARATOR . "index/?meeting_id=" . $this->pars->id;
                $_["last_check"]                = "";
                $_["meeting_id"]                = $data["id"];
                $_["unwind_get_data_store"]     = "javascript:new Layout().getUnwindDataStore();";
                // $_["unwind_action"]             = "javascript:javascript:unwindAction(); new Meeting().updateAvailability();";
                $_["right_bar_button"]          = array(
                        // Button Title
                        "title"=>"Speichern",
                        "icon"=>APP_ICON::ICON_SAVE,
                        // Action With Confirm
                        "confirm"=>array(
                                // Alert View Title
                                "title"=>"Speichern",
                                "message"=>"Möchten Sie speichern?",
                                // Alert View Actions
                                "actions"=>array(
                                        // Alert View Actions
                                        array(
                                                // Alert View Action[] title
                                                "title"=>"Cancel",
                                                // Alert View Action[] action dismiss alert controller if empty action
                                                "action"=>"",
                                                // Alert View Action[] action style support for ios, will combine with android
                                                "style"=>ALERT_ACTION_STYLE::UIAlertActionStyleDestructive
                                        ),

                                        array(
                                                // Alert View Action[] title
                                                "title"=>"Save",
                                                // Alert View Action[] action dismiss alert controller if empty action or call javascript code
                                                "action"=>"javascript:new Layout().save('_availability');",
                                                // Alert View Action[] action style support for ios, will combine with android
                                                "style"=>ALERT_ACTION_STYLE::UIAlertActionStyleDefault
                                        ),
                                )
                        )


                );
                $_[ACTIVITY::ACTIVITY]          = ACTIVITY::go(ACTIVITY::ACTIVITY_3);

                return $_;

        }

        private function preparePresencePostDataWithData( $data = array() ){

                $_ = array();
                $_["display_name"]                   = "Anwesenheit";//  $rowData["display_name"];
                $_["meeting_pretty_date"]            = ""; // $rowData["meeting_pretty_date"];
                $_["link"]                           = Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "_presence" . DIRECTORY_SEPARATOR . "index/?meeting_id=" . $this->pars->id;
                $_["last_check"]                     = "";
                $_["meeting_id"]                     = $data["id"];
                $_[ACTIVITY::ACTIVITY]               = ACTIVITY::go(ACTIVITY::ACTIVITY_3);

                return $_;
        }

        private function prepareFeedbackPostDataWithData( $data = array() ){

                $_ = array();
                $_["display_name"]              = "Termin Feedback";
                $_["meeting_pretty_date"]       = "";
                $_["link"]                      = Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "_feedback" . DIRECTORY_SEPARATOR . "index/?meeting_id=" . $this->pars->id;
                $_["last_check"]                = "";
                $_["meeting_id"]                = $data["id"];
                // $_["unwind_get_data_store"]     = "javascript:new Layout().getUnwindDataStore();";
                // $_["unwind_action"]             = "javascript:javascript:unwindAction(); new Meeting().updateAvailability();";
                $_["right_bar_button"]          = array(
                        // Button Title
                        "title"=>"Speichern",
                        "icon"=>APP_ICON::ICON_SAVE,
                        // Action With Confirm
                        "confirm"=>array(
                                // Alert View Title
                                "title"=>"Speichern",
                                "message"=>"Möchten Sie speichern?",
                                // Alert View Actions
                                "actions"=>array(
                                        // Alert View Actions
                                        array(
                                                // Alert View Action[] title
                                                "title"=>"Cancel",
                                                // Alert View Action[] action dismiss alert controller if empty action
                                                "action"=>"",
                                                // Alert View Action[] action style support for ios, will combine with android
                                                "style"=>ALERT_ACTION_STYLE::UIAlertActionStyleDestructive
                                        ),

                                        array(
                                                // Alert View Action[] title
                                                "title"=>"Save",
                                                // Alert View Action[] action dismiss alert controller if empty action or call javascript code
                                                "action"=>"javascript:new Layout().feedbackMeetingSave();",
                                                // Alert View Action[] action style support for ios, will combine with android
                                                "style"=>ALERT_ACTION_STYLE::UIAlertActionStyleDefault
                                        ),
                                )
                        )


                );
                $_[ACTIVITY::ACTIVITY]          = ACTIVITY::go(ACTIVITY::ACTIVITY_3);

                return $_;

        }


        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }




}


namespace _presence;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use ANWESENHEIT;
use TEAMROLLE;
use _details\Meeting as MeetingDetail;
use ACTIVITY;
use Config;
class Meeting extends Controller{


        /**
         * Meeting constructor.
         * @param $pars
         * @param $public_load
         * @throws ReflectionException
         */
        public function __construct($pars, $public_load )
        {
                parent::__construct($pars, $public_load);

        }

        
        public function index()
        {

                // highlight_string(var_export($this->pars, true));
                $this->model->pars = $this->pars;
                $rows = $this->getRowsForMeeting();

                $meetingData = null;
                try {
                        $this->pars->id = $this->pars->meeting_id;
                        unset($this->pars->meeting_id);
                        $meetingDetail = new MeetingDetail($this->pars, false );
                        $meetingData = $meetingDetail->getMeetingData();
                        unset($this->pars->id);
                } catch (ReflectionException $e) {
                }
                
                

                #highlight_string(var_export($rows, true));
                // TODO: Implement index() method.
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "rows"=> $rows,
                        "header"=> $this->contentHeader( $meetingData )
                );


                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);



        }
        
        function contentHeader($data = array())
        {
                return parent::contentHeader($data); // TODO: Change the autogenerated stub
        }


        private function getRowsForMeeting(){


                $rowDataAll = $this->model->fetchAll();
                #highlight_string(var_export($rowDataAll, true));

                // Spread out to 3 Groups
                $trainers        = array();
                $players         = array( ANWESENHEIT::YES => array(), ANWESENHEIT::NO => array(), ANWESENHEIT::MAYBE => array() );

                foreach ( $rowDataAll  as $index => $item) {


                        if( $item["is_player"] ){

                                // OR SHORTENED CODE

                                /*
                                $presence_data = array();
                                $presence_data["display_name"]                   = "Anwesenheit";//  $rowData["display_name"];
                                $presence_data["meeting_pretty_date"]            = ""; // $rowData["meeting_pretty_date"];
                                $presence_data["link"]                           = Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "_presence" . DIRECTORY_SEPARATOR . "index/?meeting_id=" . $this->pars->id;
                                $presence_data["last_check"]                     = "";
                                $presence_data["meeting_id"]                     = $item["id"];
                                $presence_data[ACTIVITY::ACTIVITY]               = ACTIVITY::go(ACTIVITY::ACTIVITY_4);
                                */
                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);
                                $this->view->data = array(
                                        "db"                    => $item,
                                        // "presence_data"         => $presence_data
                                );

                                $row = $this->view->fileContent($this->getReflectedClass()->getShortName() . DIRECTORY_SEPARATOR . $this->getReflectedClass()->getNamespaceName(), "row.php");


                                // echo $item["anwesenheit"];
                                if( !is_null($item["anwesenheit"]) ){
                                        array_push( $players[ $item["anwesenheit"] ], array("row"=>$row, "data"=>$item ) );
                                }


                        } else if( $item["is_trainer"] ){

                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);
                                $this->view->data = array(
                                        "db"            => $item
                                );

                                $row = $this->view->fileContent($this->getReflectedClass()->getShortName() . DIRECTORY_SEPARATOR . $this->getReflectedClass()->getNamespaceName(), "row.php");

                                array_push($trainers, array("row"=>$row, "data"=>$item ));
                        }

                }
                
                #highlight_string(var_export($trainers, true));

                $rows = array(  TEAMROLLE::SPIELER => $players, TEAMROLLE::TRAINER => $trainers );

                return $rows;



        }


}


namespace _availability;
use Controller;
use FETCH_STRUCTURE;
use FETCH_TYPE;
use Config;
use _details\Meeting as MeetingDetail;
use ReflectionException;
use REPOSITORY;
use ANWESENHEIT;
use _details\Meeting as Meeting_Details;

class Meeting extends Controller{

        /**
         * Meeting constructor.
         * @param $pars
         * @param bool $public_load
         * @throws \ReflectionException
         */
        function __construct($pars)
        {
                parent::__construct($pars);
        }

        public function index()
        {
                // TODO: Implement index() method.

                $meetingData = REPOSITORY::read(REPOSITORY::CURRENT_MEETING);


                $this->pars->availability = $meetingData["my_availability"];

                // highlight_string(var_export(REPOSITORY::read(REPOSITORY::CURRENT_USER), true));
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "user" => REPOSITORY::read(REPOSITORY::CURRENT_USER),
                        // "reasons"=>$this->needReasons($this->public->getReasons()),
                        "meeting" => $meetingData,
                        "pars" => $this->pars,
                        "header" => $this->contentHeader($meetingData),
                        "subview"=>$this->dispatchSubview()
                        
                );



                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }

        
        public function dispatchSubview(){

                $meetingData    = REPOSITORY::read(REPOSITORY::CURRENT_MEETING);
                $reasons        = $this->public->getReasons();
                
                // $meetingData["my_availability"] = ANWESENHEIT::MAYBE;
                $new_reason = [];


                $av = "";

                switch ( $this->pars->availability ){

                        case ANWESENHEIT::NO:
                                $av = "No";
                                // unset($reasons[16]);
                                // unset($reasons[17]);
                                foreach ($reasons as $index => $reason) {
                                        if( $reason["listable_absence"] ){
                                                $new_reason[$index] = $reason;
                                        }
                                }
                                $reasons = $new_reason;
                                break;
                        case ANWESENHEIT::YES:
                                $av = "Yes";
                                // $new_reason = array();
                                // $new_reason["16"] = $reasons["16"];
                                // $new_reason["17"] = $reasons["17"];
                                // $reasons = $new_reason;
                                foreach ($reasons as $index => $reason) {
                                        if( $reason["listable_presence"] ){
                                                $new_reason[$index] = $reason;
                                        }
                                }
                                $reasons = $new_reason;

                                break;
                        case ANWESENHEIT::MAYBE:
                                $av = "Maybe";
                                $reasons = array();
                                break;
                }

                #highlight_string(var_export($reasons, true));
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "reasons" => $reasons,
                        "meeting" => $meetingData,

                );


                return $this->view->fileContent($this->getReflectedClass()->getShortName() . DIRECTORY_SEPARATOR . $this->getReflectedClass()->getNamespaceName(), "A{$av}Subview.php");
                
        }


        function save(){


                if( empty($this->pars->selected_availability) ){


                        return array(
                                "resulta"=>false,
                                "process"=>false,
                                "message"=>"Please select your availability!",
                                "color"=>"warning"


                        );

                } else {

                        $this->pars->uid = REPOSITORY::read(REPOSITORY::CURRENT_USER)["uid"];

                        $this->model->pars = $this->pars;
                        $data = $this->model->{__FUNCTION__}();

                        $title = "Vefügbarkeit";
                        if( $data->resulta ){

                                if( $data->process ) {
                                        $message = "Ihre vefügbarkeit gespeichert erfolgreich!";
                                        $color="success";
                                        
                                        // Overwrite Meeting Data for Availability
                                        try {
                                                // highlight_string(var_export($this->pars, true));
                                                // Use Method id instead of meeting id;
                                                $this->pars->id=$this->pars->meeting_id;
                                                $m = new Meeting_Details($this->pars);
                                                REPOSITORY::write(REPOSITORY::CURRENT_MEETING, $m->getMeetingData() );
                                                
                                        } catch (ReflectionException $e) {
                                        }


                                } else {
                                        $message = "Alles klar!";
                                        $color="warning";
                                }

                        } else {
                                $message = $data->errInfo;
                                $color="danger";
                        }


                        return array(
                                "resulta" => $data->resulta,
                                "process" => $data->process,
                                "message" => $message,
                                "title" => $title,
                                "availability" => $this->pars->selected_availability,
                                "meeting_id" => $this->pars->meeting_id,
                                "updated_meetings" => $data->extras,
                                "color" => $color
                        );



                }




        }

        public function contentHeader($data = array())
        {
                return parent::contentHeader($data); // TODO: Change the autogenerated stub
        }


}


namespace _feedback;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use ANWESENHEIT;
use TEAMROLLE;
use _details\Meeting as MeetingDetail;
use REPOSITORY;

class Meeting extends Controller{


        /**
         * Meeting constructor.
         * @param $pars
         * @param $public_load
         * @throws ReflectionException
         */
        public function __construct($pars )
        {
                parent::__construct($pars);

        }


        public function index()
        {



                #highlight_string(var_export(REPOSITORY::read(REPOSITORY::CURRENT_MEETING), true));
                $this->model->pars = $this->pars;
                $rows = $this->getRowsForMeeting();


                $meetingData = null;
                try {
                        $this->pars->id = $this->pars->meeting_id;
                        unset($this->pars->meeting_id);
                        $meetingDetail = new MeetingDetail($this->pars );
                        $meetingData = $meetingDetail->getMeetingData();
                        unset($this->pars->id);
                } catch (ReflectionException $e) {
                }

                // TODO: Implement index() method.
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "rows"   => $rows,
                        "header" => $this->contentHeader( $meetingData )
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }

        function contentHeader($data = array())
        {
                return parent::contentHeader($data); // TODO: Change the autogenerated stub
        }


        private function getRowsForMeeting(){


                // Only Presence YES
                $feedbackReasons = $this->public->getReasons('listable_feedback');

                $this->model->pars = $this->pars;
                $rowDataAll = $this->model->fetchAll();
                #highlight_string(var_export($rowDataAll, true));


                #highlight_string(var_export($feedbackReasons, true));

                // Spread out to 3 Groups
                $trainers        = array();
                $players         = array( ANWESENHEIT::YES => array(), ANWESENHEIT::NO => array(), ANWESENHEIT::MAYBE => array() );

                if( count($rowDataAll) ) {
                        foreach ($rowDataAll as $index => $item) {


                                if ($item["is_player"]) {

                                        #highlight_string(var_export($feedbackReasons, true));
                                        $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);
                                        $this->view->data = array(
                                                "db" => $item,
                                                "feedbackReasons"=>$feedbackReasons
                                        );

                                        $row = $this->view->fileContent($this->getReflectedClass()->getShortName() . DIRECTORY_SEPARATOR . $this->getReflectedClass()->getNamespaceName(), "cell.php");

                                        if (!is_null($item["anwesenheit"])) {
                                                array_push($players[$item["anwesenheit"]], array("row" => $row, "data" => $item));
                                        }
                                }

                        }
                }

                $rows = array(  TEAMROLLE::SPIELER => $players/*, TEAMROLLE::TRAINER => $trainers*/ );

                return $rows;



        }


        function save(){

                $cm = REPOSITORY::read(REPOSITORY::CURRENT_MEETING);
                #highlight_string(var_export($cm, true));

                $this->pars->meeting_id = $cm["id"];

                $this->model->pars = $this->pars;
                $data = $this->model->{__FUNCTION__}();

                $title = "Feedback";
                if( $data->resulta ){

                        $message = "Termin feedback gespeichert erfolgreich";
                        $color="success";
                        /*if( $data->process ) {
                                $message = "Successfull";
                                $color="success";
                        } else {
                                $message = "No any data updated";
                                $color="warning";
                        }*/

                } else {
                        $message = $data->errInfo;
                        $color="danger";
                }

                return array(
                        "resulta" => $data->resulta,
                        "process" => $data->process,
                        "title" => $title,
                        "message" => $message,
                        "availability" => $this->pars->selected_availability,
                        "meeting_id" => $this->pars->meeting_id,
                        "color" => $color,
                        "sql" => $data->sql
                );
        }


}

