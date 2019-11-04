<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 27.09.18
 * Time: 09:44
 */

namespace in;

use Controller;
use ReflectionException;
use FETCH_STRUCTURE;
use REPOSITORY;
use Config;
use Helper;
use ACTIVITY;
use LOX24;
use DateTime;
use VIEW_CONTROLLER;

class Sign extends Controller
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

        function index()
        {


                // REPOSITORY::killAll(true);

                $signUp = array();
                $signUp["display_name"] = "";
                $signUp["link"] = Config::BASE_URL . DIRECTORY_SEPARATOR . "Sign" . DIRECTORY_SEPARATOR . "up" . DIRECTORY_SEPARATOR . "index";
                // $signUp["unwind_get_data_store"] = "javascript:new Layout().getUnwindDataStore();";
                // $signUp["unwind_action"] = "javascript:new Layout().fetchUser();";
                $signUp[ACTIVITY::ACTIVITY] = ACTIVITY::go(ACTIVITY::ACTIVITY_1);
                $signUp[VIEW_CONTROLLER::X2UINavigationBarBackgroundKey] = VIEW_CONTROLLER::X2UINavigationBarBackgroundHide;


                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                $this->view->data = array(
                    "signup"=>$signUp
                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);
        }

        function logout()
        {

                $this->storage->killAll(function () {

                        header("Location: " . Config::BASE_URL);

                });


        }

        /**
         * @return array
         * @Deprecated
         */
        function checkNumber()
        {
                $confirmation_code = Helper::passwordGenerator(NULL, 5)->base;
                $mobil_number = Helper::prettyTelNumberFormat($this->pars->mobil_number);


                $this->pars->confirmation_code = $confirmation_code;
                $this->pars->mobil_number = $mobil_number;
                $this->model->pars = $this->pars;
                $data = $this->model->{__FUNCTION__}();

                // highlight_string(var_export($data, true));
                

                if( count($data) ){


                        $viewData = array();
                        $viewData["display_name"] = "Bestätigen";
                        $viewData["link"] = Config::BASE_URL . DIRECTORY_SEPARATOR . "Sign" . DIRECTORY_SEPARATOR . "confirmation" . DIRECTORY_SEPARATOR . "index?mobil_number=" . $mobil_number;
                        $viewData["unwind_get_data_store"] = "javascript:new Layout().getUnwindDataStore();";
                        $viewData["unwind_action"] = "javascript:new Layout().fetchUser();";
                        $viewData[ACTIVITY::ACTIVITY] = ACTIVITY::go(ACTIVITY::ACTIVITY_1);

                        // highlight_string(var_export($data, true));
                        $sendCodeMitInterval = Helper::sentCodeMitInterval($data["mobil_confirmation_next_try"] );
                        #highlight_string(var_export($sendCodeMitInterval, true));
                        if( $sendCodeMitInterval["sent"] ){


                                // Next Activate Code Request time
                                $sentDate       = $data["mobil_confirmation_next_try"];
                                $nextTryDate    = date_create($sentDate);
                                date_add($nextTryDate, date_interval_create_from_date_string(Config::SMS_SEND_AGAIN_IN_INTERVAL ));
                                $this->pars->mobil_confirmation_next_try = $nextTryDate->format("Y-m-d H:i:s");

                                $this->model->pars = $this->pars;
                                $data = $this->model->setNumberActivationCode();

                                // echo $data->errInfo;
                                if ($data->resulta && $data->process) {

                                        $title = "Successfully";
                                        $message = "Bereit für activation";

                                        LOX24::$SERVICE_STATUS = LOX24::SERVICE_CLOSED;
                                        LOX24::sendSMS("Ihre aktivierungskode lautet:" . $confirmation_code, $mobil_number);


                                        return array(
                                            "confirmation_code" => $confirmation_code,
                                            "mobil_number" => $mobil_number,
                                            "process" => $data->process,
                                            "resulta" => $data->resulta,
                                            "data"=>$viewData

                                        );

                                }



                        }

                        $title = "Expired Time";
                        $message = "Bitte versuchen Sie in {$sendCodeMitInterval["in_min"]} nochmal!";

                        return array(
                            "process" => false,
                            "resulta" => false,
                            "title" => $title,
                            "message" => $message,
                                "withpin"=>true,
                            "data"=>$viewData


                        );
                }


                $title = "Fehler";
                $message = "Nummer nicht gefunden!";

                return array(
                    "process" => false,
                    "resulta" => false,
                    "title" => $title,
                    "message" => $message

                );
                

        }

        function fetch()
        {

                // Rewrite the mobile number without 0 and pretty format
                $this->pars->mobil_number = Helper::prettyTelNumberFormat($this->pars->mobil_number);

                $this->model->pars = $this->pars;
                $user = $this->model->{__FUNCTION__}();

                #highlight_string(var_export($user, true));
                $return = array();

                if (count($user)) {
                        REPOSITORY::write(REPOSITORY::CURRENT_USER, $user);

                        /// Overwrite
                        $return["user"] = $user;
                        // $return[ACTIVITY::ACTIVITY] = ACTIVITY::ACTIVITY_LOGGED;

                } else {
                        $return["user"] = array();
                        $return["title"] = "Achtung";
                        $return["message"] = "Benutzer nicht gefunden!";
                }



                return $return;
        }

        function currentUSER()
        {
                return REPOSITORY::read(REPOSITORY::CURRENT_USER);
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }


        // Will be remove
        function test(){
                $this->public->addTestLeagueClubs();
        }



}


namespace up;

use Controller;
use ReflectionException;
use FETCH_STRUCTURE;
use REPOSITORY;
use LOX24;
use Config;
use ACTIVITY;
use Helper;
use VIEW_CONTROLLER;

class Sign extends Controller
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

        function index()
        {
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                $this->pars->statement = "maybelistedforappregister=1";
                $maybelistedforappregister = $this->public->getTeamrolle();
                // highlight_string(var_export($maybelistedforappregister, true));

                $terms = [];
                $terms["display_name"] = "AGB";
                $terms["link"] = Config::BASE_URL . DIRECTORY_SEPARATOR . "Gtc" . DIRECTORY_SEPARATOR . "gtc" . DIRECTORY_SEPARATOR . "index";
                $terms["unwind_get_data_store"] = "javascript:new Layout().getUnwindDataStore();";
                // $terms["unwind_action"] = "javascript:new Layout().test();";
                $terms[ACTIVITY::ACTIVITY] = ACTIVITY::go(ACTIVITY::ACTIVITY_2);
                // $terms[VIEW_CONTROLLER::X2UINavigationBarBackgroundKey] = VIEW_CONTROLLER::X2UINavigationBarBackgroundHide;



                $this->view->data = array(
                        "maybelistedforappregister"=>$maybelistedforappregister,
                        "termsData"=>$terms
                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);
        }


        function termsAndConditions(){







        }


        function save()
        {
                #highlight_string(var_export($this->pars, true));
                $confirmation_code      = Helper::passwordGenerator(NULL, 5  )->base;
                $mobil_number           = Helper::prettyTelNumberFormat($this->pars->mobil_number);

                $this->pars->mobil_number = $mobil_number;
                $this->pars->confirmation_code = $confirmation_code;

                // Next Activate Code Request time
                $sentDate       = date("Y-m-d H:i:s");
                $nextTryDate    = date_create($sentDate);
                date_add($nextTryDate, date_interval_create_from_date_string(Config::SMS_SEND_AGAIN_IN_INTERVAL ));
                $this->pars->mobil_confirmation_next_try = $nextTryDate->format("Y-m-d H:i:s");

                $this->model->pars = $this->pars;
                $data = $this->model->{__FUNCTION__}();

                $process = true;
                // highlight_string(var_export($data, true));

                if ($data->resulta && $data->process) {

                        // Send SMS
                        // highlight_string(var_export(LOX24::sendSMS("selam", "004915228763036"), true));
                        LOX24::setServiceStatus(LOX24::SERVICE_OPEN) ;
                        LOX24::sendSMS("Ihre aktivierungskode lautet:" . $confirmation_code, $mobil_number);

                } else {

                        #echo $data->traceMonitoring();

                        $process = false;
                        $title = "Fehler";
                        $message = "";
                        if ($data->errCode == "1062") {
                                $message = "Handynummer ist bereits registriert!";
                        }


                }

                $viewData = array();
                // Prepare the Data
                $viewData["display_name"] = "";
                $viewData["link"] = Config::BASE_URL . DIRECTORY_SEPARATOR . "Sign" . DIRECTORY_SEPARATOR . "confirmation" . DIRECTORY_SEPARATOR . "index?mobil_number=" . $mobil_number . "&title=Confirmation";
                // $data["icon"] = "ic_home";
                // $data["last_check"] = "";
                $viewData["unwind_get_data_store"] = "javascript:new Layout().getUnwindDataStore();";
                $viewData["unwind_action"] = "javascript:new Layout().updateAvailability();";
                $viewData[ACTIVITY::ACTIVITY] = ACTIVITY::go(ACTIVITY::ACTIVITY_2);
                $viewData[VIEW_CONTROLLER::X2UINavigationBarBackgroundKey] = VIEW_CONTROLLER::X2UINavigationBarBackgroundHide;

                // $data["meeting_id"]                     = $rowData["id"];

                return array(

                    "process" => $process,
                    "title" => $title,
                    "message" => $message,
                    "data" => $viewData,
                    // "number" => $data->extras
                );
        }





        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}


namespace confirmation;

use Controller;
use FETCH_STRUCTURE;
use in\Sign as SignIn;
use REPOSITORY;

class Sign extends Controller{


        public function index()
        {
                // TODO: Implement index() method.
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);


                $this->view->data = array(
                    "mobil_number" => $this->pars->mobil_number
                );

                if( !is_null($this->pars->title) ){
                        $this->view->data["title"] = $this->pars->title;
                }

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);
        }



        function check()
        {
                // highlight_string(var_export($this->pars, true));
                $this->model->pars = $this->pars;
                $data = $this->model->{__FUNCTION__}();

                if( count($data->extras) ){

                        try {

                                $this->pars->customStatement = "mobil_number=" . $this->pars->mobil_number;
                                $classSignIn = new SignIn($this->pars);
                                $data = $classSignIn->fetch();

                                // highlight_string(var_export(REPOSITORY::read(REPOSITORY::CURRENT_REDIRECT), true));
                                $redirectData = REPOSITORY::read(REPOSITORY::CURRENT_REDIRECT);
                                if( !is_null($redirectData) ){
                                        $data["redirect"] = $redirectData;
                                        REPOSITORY::kill(REPOSITORY::CURRENT_REDIRECT);
                                }

                                // highlight_string(var_export($data, true));
                                return $data;


                        } catch (\ReflectionException $e) {
                        }


                }



                $title = "Fehler";
                $message = "Falsche Anzahl von Ziffern. Versuchen Sie es noch einmal!";

                return array(
                    "process" => false,
                    "title" => $title,
                    "message" => $message
                );
        }

        // Temporarily Deprecated
        function save()
        {

                #highlight_string(var_export($this->pars, true));

                $this->model->pars = $this->pars;
                $data = $this->model->{__FUNCTION__}();


                if( $data->resulta && $data->process ){

                        // Fetch user data from Sign In Class correctly;



                        // echo $this->pars->mobil_number;
                        try {

                                $this->pars->customStatement = "mobil_number=" . $this->pars->mobil_number;
                                $classSignIn = new SignIn($this->pars);
                                $data = $classSignIn->fetch();

                                $redirectData = REPOSITORY::read(REPOSITORY::CURRENT_REDIRECT);
                                if( !is_null($redirectData) ){
                                        $data["redirect"] = $redirectData;
                                        REPOSITORY::kill(REPOSITORY::CURRENT_REDIRECT);
                                }

                                return $data;


                        } catch (\ReflectionException $e) {
                        }


                }


                $title = "Fehler";
                $message = "Ungültiger Aktivierungscode!(Normalde kod dogru ama Kod NULL lenmedigi icin herhange bir update isleme olmadigindan process false donuyor, cözümü SELECT ile data varligini kontrol edeblilirm ama bu diger cihazlardan da herhangi bir device kontrolu olmaksizin girise sebep olacektir)";

                return array(
                        "process" => false,
                        "title" => $title,
                        "message" => $message
                );
        }




}

namespace newPassword;

use Controller;
use FETCH_STRUCTURE;
use in\Sign as SignIn;
use Helper;
use LOX24;
use Config;
use ACTIVITY;
use REPOSITORY;
use VIEW_CONTROLLER;
use ViewController;

class Sign extends Controller{


        public function index()
        {
                // TODO: Implement index() method.
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);

                $this->view->data = array(
                        "mobil_number"=>$this->pars->mobil_number
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);
        }


        function request()
        {
                $mobil_number           = Helper::prettyTelNumberFormat($this->pars->mobil_number);
                $confirmation_code      = Helper::passwordGenerator(NULL, 5)->base;

                $this->pars->mobil_number = $mobil_number;
                $this->model->pars = $this->pars;

                $data = $this->model->{__FUNCTION__}();

                // highlight_string(var_export($data, true));

                if( count($data) ){

                        // Replace Mobile number with registered correct number
                        $this->pars->mobil_number = $data["mobil_number"];


                        /*
                        $viewData = array();
                        $viewData["display_name"] = "";
                        $viewData["link"] = Config::BASE_URL .
                                DIRECTORY_SEPARATOR .
                                "Sign" .
                                DIRECTORY_SEPARATOR .
                                "confirmation" .
                                DIRECTORY_SEPARATOR .
                                "index?mobil_number=" .
                                $this->pars->mobil_number;
                        // $viewData["unwind_get_data_store"] = "javascript:new Layout().getUnwindDataStore();";
                        // $viewData["unwind_action"] = "javascript:new Layout().fetchUser();";
                        $viewData[ACTIVITY::ACTIVITY] = ACTIVITY::go(ACTIVITY::ACTIVITY_1);
                        $viewData[VIEW_CONTROLLER::X2UINavigationBarBackgroundKey] = VIEW_CONTROLLER::X2UINavigationBarBackgroundHide;
                        */



                        // Temporarily Stored Data
                        REPOSITORY::write(REPOSITORY::CURRENT_REDIRECT, array(
                                "display_name" => "",
                                "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Sign" . DIRECTORY_SEPARATOR . "newPassword" . DIRECTORY_SEPARATOR . "index?mobil_number=" . $this->pars->mobil_number,
                                // $viewData["unwind_get_data_store"] = "javascript:new Layout().getUnwindDataStore();",
                                // $viewData["unwind_action"] = "javascript:new Layout().fetchUser();",
                                ACTIVITY::ACTIVITY => ACTIVITY::go(ACTIVITY::ACTIVITY_2),
                                VIEW_CONTROLLER::X2UINavigationBarBackgroundKey => VIEW_CONTROLLER::X2UINavigationBarBackgroundHide

                        ));





                        // $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().selectSeasonAndDismissWithData()", NULL );

                        $vcParams = array();
                        $vcParams["mobil_number"] = $this->pars->mobil_number;

                        $viewController = new ViewController(
                                "",
                                "",
                                "Sign",
                                "confirmation",
                                "index",
                                $vcParams,
                                // ACTIVITY::ACTIVITY_6,
                                ACTIVITY::ACTIVITY_1,
                                VIEW_CONTROLLER::X2UINavigationBarBackgroundShow,
                                null
                        );

                        $viewData =  $viewController->prepare();

















                        $sendCodeMitInterval = Helper::sentCodeMitInterval($data["mobil_confirmation_next_try"] );
                        // highlight_string(var_export($sendCodeMitInterval, true));

                        if( $sendCodeMitInterval["sent"] ){



                                LOX24::$SERVICE_STATUS = LOX24::SERVICE_OPEN;
                                $smsResulta = LOX24::sendSMS("Deine " . Config::APP_NAME . " Bestätigungscode ist:" . $confirmation_code, $this->pars->mobil_number);



                                // echo $smsResulta->code[0];
                                // if( $smsResulta->code[0] == 100 ){
                                if( true ){


                                        // Next Activate Code Request time
                                        $sentDate       = $data["mobil_confirmation_next_try"];

                                        // If now greater than last sent date, than set sentDate to now
                                        if( strtotime($sentDate) < strtotime(date("Y-m-d H:i:s")) ){
                                                $sentDate = date("Y-m-d H:i:s");
                                        }
                                        $nextTryDate    = date_create($sentDate);
                                        date_add($nextTryDate, date_interval_create_from_date_string(Config::SMS_SEND_AGAIN_IN_INTERVAL ));

                                        $this->pars->mobil_confirmation_next_try        = $nextTryDate->format("Y-m-d H:i:s");
                                        $this->pars->confirmation_code                  = $confirmation_code;

                                        $this->model->pars                              = $this->pars;
                                        $data                                           = $this->model->setNumberActivationCode();

                                        // highlight_string(var_export($data, true));

                                        $message = $smsResulta->codetext[0] . " an ". "\n" . $smsResulta->info[0]->Ziel[0];
                                        $message = "Ein sechsstelliger Bestätigungscode wurde gerade per SMS an " . $smsResulta->info[0]->Ziel[0] . " gesendet";


                                        // echo $message;
                                        return array(
                                            "confirmation_code" => $confirmation_code,
                                            "mobil_number" => $this->pars->mobil_number,
                                            "process" => $data->process,
                                            "title"=>"Erfolgreich",
                                            "message"=>$message,
                                            // "resulta" => $data->resulta,
                                                "action_title"=>"Weiter",
                                            "data"=>$viewData 
                                        );

                                } else {


                                        return array(
                                            "confirmation_code" => $confirmation_code,
                                            "mobil_number" => $this->pars->mobil_number,
                                            "process" => false,
                                            "title"=>"Fehler",
                                            "message"=>$smsResulta->codetext[0],
                                            "data"=>$viewData
                                        );




                                }

                        }



                        // Already sent code no used
                        // Show user information and have a possibility for code enter
                        if( !is_null($data["mobil_confirmation"]) ){

                                $message = "Verwenden Sie den bitte zuletzt gesendeten Bestätigungscode!";


                                // echo $message;
                                return array(
                                        "mobil_number" => $this->pars->mobil_number,
                                        "process" => true,
                                        "title"=>"Ihre Bestätigungscode noch aktiv!",
                                        "message"=>$message,
                                        // "resulta" => $data->resulta,
                                        "action_title"=>"Weiter",
                                        "data"=>$viewData
                                );



                        }

                        $title = "Info";
                        $message = "Bitte versuchen Sie es später erneut.\n in {$sendCodeMitInterval["in_min"]}";

                        return array(
                                "process" => false,
                                "resulta" => false,
                                "title" => $title,
                                "message" => $message,
                                "withCode"=>true,
                                "data"=>$viewData
                        );
                }


                $title = "Fehler";
                // $message = "Ungültiger Aktivierungscode!(Normalde kod dogru ama Kod NULL lenmedigi icin herhange bir update isleme olmadigindan process false donuyor, cözümü SELECT ile data varligini kontrol edeblilirm ama bu diger cihazlardan da herhangi bir device kontrolu olmaksizin girise sebep olacektir)";
                $message = "Nummer nicht registriert!";
                if( !isset($mobil_number) || empty($mobil_number) ){
                        $message = "Bitte geben Sie Ihre Handynummer!";
                }

                return array(
                        "process" => false,
                        "title" => $title,
                        "message" => $message
                );
        }

        function save()
        {
                $this->model->pars = $this->pars;
                $data = $this->model->{__FUNCTION__}();


                if( $data->resulta ){

                        if( $data->process ) {

                                return array(

                                        "process" => $data->resulta && $data->process,
                                        "title" => "Erfolgreich",
                                        "message" => "Ihr Passwort wurde erfolgreich geändert.\nApp würde neustarten"
                                );
                        }

                        else {

                                return array(
                                        "process" => false,
                                        "title" => "Opppsss",
                                        "message" => "Bitte geben Sie andere Passwort!"
                                );


                        }


                }


                $title = "Fehler";
                $message = "Unbekannte fehler, bitte versuchen sie später!";

                return array(
                        "process" => false,
                        "title" => $title,
                        "message" => $message
                );
        }



}


