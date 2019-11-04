<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 30.09.18
 * Time: 18:24
 */
namespace _general;
use ReflectionException;
use Controller;
use REPOSITORY;
use Config;
use NOTIFICATION;
use ACTIVITY;

class Notifications extends Controller
{
        /**
         * Notifications constructor.
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

        function fetchAll_(){

                $sec = 5;
                $secDiff = $sec + 10;
                $format = "Y-m-d H:i:s";
                $date = date($format);
                $time1 = date($format, strtotime("+{$sec} seconds", strtotime($date)));
                $time2 = date($format, strtotime("+{$secDiff} seconds", strtotime($date)));

                $arr = array(
                        "display_name"=>"Ligaspiel",
                        "link"=>"http://app.dfanet.de/Meeting/_details/index/?id=922",
                        "icon"=>"ic_wrench",
                        "unwind_get_data_store"=>"javascript:new Layout().getUnwindDataStore();",
                        "activity"=> ACTIVITY::ACTIVITY_1,
                        "isMatch"=>""
                );


                $_      = array();
                $__     = array();
                array_push($_, array(
                        NOTIFICATION::X2DataForNotificationTicketKey            => uniqid(),
                        NOTIFICATION::X2DataForNotificationTimeZoneKey          => "Europe/Berlin",
                        NOTIFICATION::X2DataForNotificationTimeKey              => $time1,
                        NOTIFICATION::X2DataForNotificationTitleKey             => "Title 1",
                        NOTIFICATION::X2DataForNotificationMessageKey           => "Message 1",

                        // Determine which ob return data index or object
                        NOTIFICATION::X2DataForNotificationRedirectData         => NOTIFICATION::X2DataForNotificationRedirectDataObject,
                        // Please Use Only Empty String if not any Data
                        NOTIFICATION::X2DataForNotificationRedirectDataObject   => $arr, // No Add the type NULL instead of empty
                        NOTIFICATION::X2DataForNotificationRedirectDataIndex    => "2",


                ));

                array_push($_, array(
                        NOTIFICATION::X2DataForNotificationTicketKey            => uniqid(),
                        NOTIFICATION::X2DataForNotificationTimeZoneKey          => "Europe/Berlin",
                        NOTIFICATION::X2DataForNotificationTimeKey              => $time2,
                        NOTIFICATION::X2DataForNotificationTitleKey             => "Title 2",
                        NOTIFICATION::X2DataForNotificationMessageKey           => "Message 2",
                        // Determine which ob return data index or object
                        NOTIFICATION::X2DataForNotificationRedirectData         => NOTIFICATION::X2DataForNotificationRedirectDataIndex,
                        // Please Use Only Empty String if not any Data
                        NOTIFICATION::X2DataForNotificationRedirectDataIndex    => "3",
                        NOTIFICATION::X2DataForNotificationRedirectDataObject   => ""
                ));

                #highlight_string(var_export($_, true));
                return $_;

        }

        function fetchAll(){

                $this->pars->uid = REPOSITORY::read(REPOSITORY::CURRENT_USER)["uid"];
                $this->pars->base_url = Config::BASE_URL;
                $this->pars->limit = 1;
                $this->model->pars = $this->pars;
                $notifications_group = $this->model->{__FUNCTION__}();

                /*
                $sec = 5;
                $secDiff = $sec + 10;
                $format = "Y-m-d H:i:s";
                $date = date($format);
                $time1 = date($format, strtotime("+{$sec} seconds", strtotime($date)));
                $time2 = date($format, strtotime("+{$secDiff} seconds", strtotime($date)));
                */

                $_ = array();$i=0;$limit = 30;// $this->pars->limit; // over 64 IOS LIMIT
                if(count($notifications_group)){

                        foreach ($notifications_group as $notifications) {

                                $i = 0;
                                if( count($notifications) ){
                                        foreach ($notifications as $index => $notification) {

                                                // $sec = $i + 10;
                                                // $time = date($format, strtotime("+{$sec} seconds", strtotime($date)));

                                                if( $notification && ( $i < $limit ) ){


                                                        array_push($_, array(

                                                            // Needless Data Only for Check
                                                            // "SHOW"                                                      => $notification["allow"],
                                                            NOTIFICATION::X2DataForNotificationMessageKey               => $notification["present_day_string"],
                                                                // Determine which ob return data index or object
                                                                // Please Use Only Empty String if not any Data
                                                            NOTIFICATION::X2DataForNotificationRedirectData             => $notification[ NOTIFICATION::X2DataForNotificationRedirectData ],
                                                            NOTIFICATION::X2DataForNotificationRedirectDataObject       => json_decode($notification[ NOTIFICATION::X2DataForNotificationRedirectDataObject], true) ,
                                                            NOTIFICATION::X2DataForNotificationRedirectDataIndex        => $notification[ NOTIFICATION::X2DataForNotificationRedirectDataIndex ],

                                                                NOTIFICATION::X2DataForNotificationTicketKey                => uniqid(),
                                                            NOTIFICATION::X2DataForNotificationTimeKey                  => $notification["notification_time"],
                                                            NOTIFICATION::X2DataForNotificationTimeZoneKey              => "Europe/Berlin",

                                                                // For Android
                                                            NOTIFICATION::X2DataForNotificationTitleKey                 => $notification[NOTIFICATION::X2DataForNotificationTitleKey ],
                                                        ));


                                                        /*
                                                        array_push($_, array(
                                                            NOTIFICATION::X2DataForNotificationTicketKey            => uniqid(),
                                                            NOTIFICATION::X2DataForNotificationTimeZoneKey          => "Europe/Berlin",
                                                            NOTIFICATION::X2DataForNotificationTimeKey              => $time2,
                                                            NOTIFICATION::X2DataForNotificationTitleKey             => "Title 2",
                                                            NOTIFICATION::X2DataForNotificationMessageKey           => "Message 2",
                                                                // Determine which ob return data index or object
                                                            NOTIFICATION::X2DataForNotificationRedirectData         => NOTIFICATION::X2DataForNotificationRedirectDataIndex,
                                                                // Please Use Only Empty String if not any Data
                                                            NOTIFICATION::X2DataForNotificationRedirectDataIndex    => "3"
                                                        ));
                                                        */

                                                        /*
                                                        "N_MESSAGE" = "Verpasst nicht Training Tomorrow um 17:30";
                                                        "N_REDIRECT_DATA" = "N_REDIRECT_WITH_OBJECT";
                                                        "N_REDIRECT_WITH_OBJECT" = "{\"display_name\":\"Training\",\"link\":\"http://app.dfanet.de/Meeting/_details/index/?id=898\",\"icon\":\"ic_wrench\",\"unwind_get_data_store\":\"javascript:new Layout().getUnwindDataStore();\",\"activity\":9,\"isMatch\":\"false\"}";
                                                        "N_REDIRECT_WITH_TAB_INDEX" = 2;
                                                        "N_TICKET" = 5bfcfef44473c;
                                                        "N_TIME" = "2018-11-28 00:03:00";
                                                        "N_TIMEZONE" = "Europe/Berlin";
                                                        "N_TITLE" = Training;
                                                        */

                                                        if( $i > $limit ){
                                                                break;
                                                        }
                                                        $i++;
                                                }
                                        }
                                }
                        }
                }

                $data = $_;

                $final_notifications = $data;

                #highlight_string(var_export($final_notifications, true));


                return  $final_notifications;

        }

        function test(){


                // ["Europe\/Berlin","2018-11-09 11:25","Verpasst nicht Training am 19.11.2018 um 17:15"]

                return array(
                        array("Europe/Berlin","2018-11-19 13:58:00","Dogumgunu unutma"),
                        array("Europe/Berlin","2018-11-19 13:58:15","Verpasst nicht Training am 19.11.2018 um 17:15"),
                );





        }

        public function get(){

                return array("message"=>2);
        }

        function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }
}