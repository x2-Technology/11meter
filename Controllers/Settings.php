<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 22.10.18
 * Time: 09:35
 */
namespace _start;
use Controller;
use FETCH_STRUCTURE;
use ACTIVITY;
use Config;
use ALERT_ACTION_STYLE;
use REPOSITORY;
use APP_ICON;
use ViewController;
use RightBarButton;
use ConfirmationAlert;
use VIEW_CONTROLLER;
class Settings extends Controller
{

        private $uid = NULL;

        /**
         * Settings constructor.
         * @param $pars
         * @param $public_load
         * @throws \ReflectionException
         */
        public function __construct($pars)
        {
                parent::__construct($pars);
                $this->uid = REPOSITORY::read(REPOSITORY::CURRENT_USER)["uid"];
        }



        public function index()
        {
                // TODO: Implement index() method.

                $cellData = array(
                        $this->cellDataGeneral(),
                        $this->cellDataPassword(),
                        $this->cellDataNotification(),
                        $this->cellDataCodeAdd(),
                        $this->cellDataRoleManagement(),
                        $this->cellDataTest()
                );
                

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "cell_data"=>$cellData
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }


        /**
         * @return array
         * While need the Password class after password added if Profile is missing data null
         */
        public function cellDataGeneral( $customActivity = NULL ){

                // TODO: Implement index() method.



                /*$_ = array();
                $_["display_name"]              = "General";
                $_["link"]                      = Config::BASE_URL . DIRECTORY_SEPARATOR. "Settings". DIRECTORY_SEPARATOR . "_general" . DIRECTORY_SEPARATOR . "index/?uid=" . $this->uid;
                $_["right_bar_button"]          = array(
                        "title"=>"Speichern",
                        "icon"=>"floppy-disk",
                        "confirm"=>array(
                                "title"=>"Speichern",
                                "message"=>"Moechten Sie speichern?",
                                "actions"=>array(
                                        array("title"=>"Cancel", "action"=>"", "style"=>ALERT_ACTION_STYLE::UIAlertActionStyleDestructive),
                                        array("title"=>"Save", "icon"=>\APP_ICON::ICON_SAVE, "action"=>"javascript:new Layout().save('_general')", "style"=>ALERT_ACTION_STYLE::UIAlertActionStyleDefault),
                                )
                        )
                        // "action"=>"javascript:new Settings().save('settings')"
                );
                $_["left_bar_button"] =  NULL;
                $_[ACTIVITY::ACTIVITY]          = ACTIVITY::go(ACTIVITY::ACTIVITY_2);
                $_[\VIEW_CONTROLLER::X2UINavigationBackButtonKey] = \VIEW_CONTROLLER::X2UINavigationBarBackgroundHide;*/

                // highlight_string(var_export($_, true));
                
                // return $_;



                
                $confirmationAlert = new ConfirmationAlert("Speichern", "Möchten Sie speichern?");
                $confirmationAlert->setAction("Cancel", ALERT_ACTION_STYLE::UIAlertActionStyleDestructive, NULL );
                $confirmationAlert->setAction("Save", ALERT_ACTION_STYLE::UIAlertActionStyleDefault, "javascript:new Layout().save('_general')" );

                $rightBarButton = new RightBarButton("Speichern", "floppy-disk", NULL, $confirmationAlert->prepare() );

                $vcParams = array();
                $vcParams["uid"] = $this->uid;

                /**
                 * If this View Rune External Script in
                 * Different WebView
                 */
                $vcParams[ViewController::EXTERNAL_URL_KEY] = "http://www.fussball.de/verein/tus-hoppstaedten-1908-ev-suedwest/-/id/00ES8GNBC8000021VV0AG08LVUPGND5I";
                $vcParams[ViewController::RUNNABLE_SCRIPT_KEY] = "1345221.js";

                $viewController = new ViewController(
                        "General",
                        "Base einstellungen",
                        "Settings",
                        "_general",
                        "index",
                        $vcParams,
                        (!is_null($customActivity) ? $customActivity : ACTIVITY::ACTIVITY_2),
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                /**
                 * Posted in Params
                 */
                // $viewController->setExternalUrl("http://www.fussball.de/verein/tus-hoppstaedten-1908-ev-suedwest/-/id/00ES8GNBC8000021VV0AG08LVUPGND5I");
                // $viewController->setRunnableScript("1345221.js" );


                return $viewController->prepare();

                // highlight_string(var_export($viewController->prepare(), true));


        }

        private function cellDataPassword(){

                $_ = array();
                $_["display_name"]              = "Passwort";
                $_["link"]                      = Config::BASE_URL . DIRECTORY_SEPARATOR. "Settings". DIRECTORY_SEPARATOR . "_password" . DIRECTORY_SEPARATOR . "index/?uid=" . $this->uid;
                // $_["right_bar_button"]          = array("title"=>"Save", "icon"=>APP_ICON::ICON_SAVE, "code"=>"javascript:document.getElementById('form').submit();");
                /*$_["right_bar_button"]          = array(
                        "title"=>"Save",
                        "icon"=>APP_ICON::ICON_SAVE,
                        "code"=>"javascript:document.getElementById('form').submit();");*/
                $_["right_bar_button"] = array("title"=>"Save", "icon"=>APP_ICON::ICON_SAVE, "action"=>"javascript:new Layout().save('_password');");
                $_[ACTIVITY::ACTIVITY]          = ACTIVITY::go(ACTIVITY::ACTIVITY_2);

                return $_;

        }

        private function cellDataNotification(){

                $_ = array();
                $_["display_name"]     = "Notification";
                $_["link"]             = Config::BASE_URL . DIRECTORY_SEPARATOR. "Settings". DIRECTORY_SEPARATOR . "_notification" . DIRECTORY_SEPARATOR . "index/?uid=" . $this->uid;
                $_["right_bar_button"] = array("title"=>"Save", "icon"=>APP_ICON::ICON_SAVE, "action"=>"javascript:new Layout().save('_notification');");
                $_[ACTIVITY::ACTIVITY] = ACTIVITY::go(ACTIVITY::ACTIVITY_2);
                return $_;
        }

        private function cellDataCodeAdd(){

                // $_ = array();
                // $_["display_name"]     = "Code einfügen";
                // $_["link"]             = Config::BASE_URL . DIRECTORY_SEPARATOR. "Settings". DIRECTORY_SEPARATOR . "code" . DIRECTORY_SEPARATOR . "index/?uid=" . $this->uid;
                // $_["right_bar_button"] = array("title"=>"Save", "icon"=>APP_ICON::ICON_SAVE, "action"=>"javascript:new Layout().save('_notification');");
                // $_[ACTIVITY::ACTIVITY] = ACTIVITY::go(ACTIVITY::ACTIVITY_2);

                $vcParams = array(
                        "uid"=>$this->pars->uid
                );

                $viewController = new ViewController(
                        "Code eingeben",
                        "Individuell code",
                        "Settings",
                        "_code",
                        "index",
                        $vcParams,
                        ACTIVITY::ACTIVITY_2,
                        true,
                        null
                        );



                return $viewController->prepare();
        }

        private function cellDataRoleManagement(){

                // View Roles
                $rightBarButton = new RightBarButton("Einfügen", \APP_ICON::ICON_ADD, "javascript:Layout().addRoleWithAlertConfirmation()",NULL);
                // TeamRol Data
                $vc = new ViewController(
                        "Benutzer Rolle",
                        NULL,
                        "Role",
                        "manage",
                        "fetchUserUsedRolesWithTable",
                        array(),
                        ACTIVITY::ACTIVITY_3,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $vc->prepare();
        }



        private function cellDataTest(){

                $_ = array();
                $_["display_name"]     = "Table View Control";
                $_["link"]             = Config::BASE_URL . DIRECTORY_SEPARATOR. "Test". DIRECTORY_SEPARATOR . "tableView" . DIRECTORY_SEPARATOR . "index/";
                $_["right_bar_button"] = array("title"=>"Save", "icon"=>APP_ICON::ICON_MATCH_DAY, "action"=>"javascript:new Layout().save('_notification');");
                $_[ACTIVITY::ACTIVITY] = ACTIVITY::go(ACTIVITY::ACTIVITY_2);
                return $_;
        }




        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}


namespace _password;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use REPOSITORY;
use RedirectViewController;
class Settings extends Controller
{

        public function __construct($pars)
        {
                try {
                        parent::__construct($pars);
                } catch (ReflectionException $e) {
                }
        }



        public function index()
        {


                // TODO: Implement index() method.

                // highlight_string(var_export(REPOSITORY::read(REPOSITORY::CURRENT_USER), true));
                
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "show_actually_password" =>  !is_null(REPOSITORY::read(REPOSITORY::CURRENT_USER)["password"])

                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }

        function save(){

                $password_actually = $this->pars->password_actually;
                $password = $this->pars->password;
                $password_again = $this->pars->password_again;

                $password_choose = preg_replace("/\s/", '', $password_actually);
                $password = preg_replace("/\s/", '', $password);
                $password_again = preg_replace("/\s/", '', $password_again);

                $me = REPOSITORY::read(REPOSITORY::CURRENT_USER);
                
                

                // FetchMe
                $this->pars->customStatement = "id=". $me["uid"];
                $this->model->pars = $this->pars;
                $meActually = $this->model->fetchMe();


                // Match Options
                $passwordActually = $meActually["password"];


                if( $passwordActually !== $password_choose && !is_null(REPOSITORY::read(REPOSITORY::CURRENT_USER)["password"]) ){

                        return array(
                                "messageWithAlert"=>true,
                                "title"=>"Fehler",
                                "message"=>"Deine aktuelle Passwort stimmt nicht!"

                        );
                }

                if( $password !== $password_again  ){

                        return array(
                                "messageWithAlert"=>true,
                                "title"=>"Fehler",
                                "message"=>"Passwort stimmt nicht ubehin! P:{$password} PA:{$password_again}  "

                        );
                }

                $this->pars->uid = $me["uid"];
                $this->pars->passwort = $password; // Space Removed
                $this->model->pars = $this->pars;
                $data = $this->model->{__FUNCTION__}();

                if( $data->resulta ){

                        if( $data->process ){

                                // Overwrite User

                                // Fresh Data from Server
                                try {
                                        // FetchMe
                                        $me["password"] = $password;
                                        REPOSITORY::write(REPOSITORY::CURRENT_USER, $me);



                                } catch (ReflectionException $e) {
                                        highlight_string(var_export($e->getMessage(), true));
                                }


                                // Redirect to View
                                /*$action = "javascript:dismissViewController('{}');";
                                if( is_null($me["profile_edited"]) ){

                                        try {
                                                // $sett = new Start_Setting($this->pars, false);
                                                // $action = "javascript:redirectViewController(" . json_encode($sett->cellDataGeneral(ACTIVITY::ACTIVITY_3)) . ")";

                                                $confirmationAlert = new ConfirmationAlert("Speichern", "Möchten Sie speichern?");
                                                $confirmationAlert->setAction("Cancel", ALERT_ACTION_STYLE::UIAlertActionStyleDestructive, NULL );
                                                $confirmationAlert->setAction("Save", ALERT_ACTION_STYLE::UIAlertActionStyleDefault, "javascript:new Layout().save('_general')" );

                                                $rightBarButton = new RightBarButton("Speichern", "floppy-disk", NULL, $confirmationAlert->prepare() );

                                                $vcParams = array();
                                                $vcParams["uid"] = $me["uid"];

                                                $viewController = new ViewController("Profile", "Settings","_general", "index", $vcParams,ACTIVITY::ACTIVITY_3,NULL, $rightBarButton->prepare());
                                                // echo json_encode($viewController->prepare());

                                                $action = "javascript:redirectViewController(" . json_encode($viewController->prepare()) . ")";;

                                        } catch (ReflectionException $e) {
                                        }


                                }



                                return array(
                                        "messageWithAlert"=>true,
                                        "title" => "Erfolgreich",
                                        "message" => "Passwort aktualisiert erfolgreich!",
                                        "action" => $action

                                );*/


                                $RVC = new RedirectViewController();

                                $RVC->autoRoutingWithUserDataAfterConfirm( REPOSITORY::read(REPOSITORY::CURRENT_USER), $isRedirect, $redirectTo );

                                return array(
                                    "messageWithAlert" => true,
                                    "title" => "Erfolgreich",
                                    "message" => "Passwort aktualisiert erfolgreich!",
                                    "action" => $isRedirect ? $redirectTo : "javascript:dismissViewController('{}');"

                                );
                        }

                        return array(
                                "messageWithAlert"=>true,
                                "title"=>"Achtung",
                                "message"=>"Bitte geben Sie andere Passwort!" . $data->errInfo

                        );

                }

                return array(
                        "messageWithAlert"=>true,
                        "title"=>"Fehler",
                        "message"=>"Unbekannter fehler!"

                );




        }



        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}


namespace _general;
use _list\Contact;
use Controller;
use FETCH_STRUCTURE;
use manage\Role;
use ReflectionException;
use REPOSITORY;
use RedirectViewController;
use ViewController;
use ACTIVITY;
use VIEW_CONTROLLER;
use RightBarButton;

class Settings extends Controller
{

        public function __construct($pars)
        {
                try {
                        parent::__construct($pars);
                } catch (ReflectionException $e) {
                }
        }



        public function index()
        {
                
                // highlight_string(var_export( REPOSITORY::read(REPOSITORY::CURRENT_USER), true));


                $repUSER = REPOSITORY::read(REPOSITORY::CURRENT_USER);

                include "Controllers/Contact.php";
                include "Models/Contact_Model.php";

                // Fresh Data from Server
                try {
                        // highlight_string(var_export($repUSER, true));
                        $this->pars->uid = $repUSER["uid"];
                        $contact = new Contact( $this->pars );
                        $user = $contact->fetchAll();
                        
                        // highlight_string(var_export($user, true));
                        
                        if( count($user) ){
                                $user = array_shift($user);
                        } else {
                                $user = array();
                        }


                } catch (ReflectionException $e) {

                }



                // TeamRol Data
                $newRoleViewController = new ViewController(
                        "Neue Rolle",
                        NULL,
                        "Role",
                        "manage",
                        "index",
                        array(), // Selected (If )
                        ACTIVITY::ACTIVITY_3,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        NULL
                );

                // View Roles
                $rightBarButton = new RightBarButton("Einfügen", \APP_ICON::ICON_ADD, "javascript:Layout().addRoleWithAlertConfirmation()",NULL);
                // TeamRol Data
                $userRolesViewController = new ViewController(
                        "Benutzer Rolle",
                        NULL,
                        "Role",
                        "manage",
                        "fetchUserUsedRolesWithTable",
                        array(),
                        ACTIVITY::ACTIVITY_3,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );


                #highlight_string(var_export($newRoleViewController->prepare(), true));;
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);
                $this->view->data = array(
                        "user"=>$user,
                        "newRoleViewData"=>$newRoleViewController->prepare(),
                        "userRolesViewData"=>$userRolesViewController->prepare(),
                        "fetchUserUsedRolesWithIcon"=>$this->fetchUserUsedRolesWithIcon()

                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }


        private function fetchUserUsedRolesWithIcon(){

                include "Controllers/Role.php";
                include "Models/Role_Model.php";

                try {

                        $role = new Role($this->pars);
                        return $role->{__FUNCTION__}();

                } catch (ReflectionException $e) {
                        return NULL;
                }



        }



        function save(){

                #highlight_string(var_export($this->pars, true));

                $userData = REPOSITORY::read(REPOSITORY::CURRENT_USER);

                $RVC = new RedirectViewController();


                include "Controllers/Contact.php";
                include "Models/Contact_Model.php";

                try {

                        // Add inclusive uid on params
                        $this->pars->profile_edited = true;
                        $this->pars->uid = $userData["uid"];
                        $contact = new Contact($this->pars);
                        $user = $contact->save();


                } catch (ReflectionException $e) {

                }


                $RVC->autoRoutingWithUserDataAfterConfirm( REPOSITORY::read(REPOSITORY::CURRENT_USER), $isRedirect, $redirectTo );

                if( $isRedirect ){
                        return array(
                                "messageWithAlert" => true,
                                "title" => "Erfolgreich",
                                "message" => $user->message,
                                "action" => $redirectTo

                        );
                }


                return (object) array("resulta"=>$user->resulta, "process"=>$user->process, "pars"=>$this->pars, "message"=>$user->message, "color"=>$user->color);

        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}


namespace _notification;
use Controller;
use ReflectionException;
use FETCH_STRUCTURE;
use REPOSITORY;
use _list\Contact;
use ACTIVITY;
use Config;
class Settings extends Controller{

        /**
         * Settings constructor.
         * @param $pars
         * @throws ReflectionException
         */
        function __construct($pars)
        {
                parent::__construct($pars);
        }




        public function index()
        {

                include "Controllers/Contact.php";
                include "Models/Contact_Model.php";
                $repUSER = REPOSITORY::read(REPOSITORY::CURRENT_USER );
                $this->pars->uid = $repUSER["uid"];

                $contact = new Contact($this->pars, false);
                #highlight_string(var_export($contact->fetchAll(), true));
                
                $this->pars->u_settings = array_shift($contact->fetchAll())["settings"];
                $this->model->pars = $this->pars;
                $user_settings_wd = $this->model->settingsFetch()["data"];
                
                        
                #highlight_string(var_export($user_settings_wd, true));
                
               
                $settings_with_data = array();
                if(count($user_settings_wd)){

                        foreach ($user_settings_wd as $k => $v) {

                                if( $v["role_with_plan"] ){
                                        $v["display_name"]              = $v["name"];
                                        $v["link"]                      = Config::BASE_URL . DIRECTORY_SEPARATOR .
                                            "Settings" .
                                            DIRECTORY_SEPARATOR .
                                            "_notification" .
                                            DIRECTORY_SEPARATOR .
                                            "plan_picker/?picker=" . $v["key"];

                                        $v[ACTIVITY::ACTIVITY]          = ACTIVITY::go(ACTIVITY::ACTIVITY_3);
                                        $v["unwind_get_data_store"]     = "javascript:new Layout().getUnwindDataStore();";
                                }

                                $settings_with_data[] = $v;
                        }
                }
                
                /*
                $user_settings = array_shift($contact->fetchAll())["settings"];

                $pp_meeting_data = array();
                $pp_meeting_data["display_name"]              = "Plan picker for Meeting";
                $pp_meeting_data["link"]                      = Config::BASE_URL . DIRECTORY_SEPARATOR. "Settings". DIRECTORY_SEPARATOR . "_notification" . DIRECTORY_SEPARATOR . "plan_picker?picker=meeting";
                $pp_meeting_data[ACTIVITY::ACTIVITY]          = ACTIVITY::go(ACTIVITY::ACTIVITY_3);
                $pp_meeting_data["unwind_get_data_store"]     = "javascript:new Layout().getUnwindDataStore();";

                $pp_birthday_data = array();
                $pp_birthday_data["display_name"]              = "Plan picker for Birthday";
                $pp_birthday_data["link"]                      = Config::BASE_URL . DIRECTORY_SEPARATOR. "Settings". DIRECTORY_SEPARATOR . "_notification" . DIRECTORY_SEPARATOR . "plan_picker?picker=birthday";
                $pp_birthday_data[ACTIVITY::ACTIVITY]          = ACTIVITY::go(ACTIVITY::ACTIVITY_3);
                $pp_birthday_data["unwind_get_data_store"]     = "javascript:new Layout().getUnwindDataStore();";
                */
                // TODO: Implement index() method.
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);
                $this->view->data = array(
                    "settings_with_data" => $settings_with_data
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }

        public function plan_picker()
        {
                
                #highlight_string(var_export($this->pars, true));
                
                // TODO: Implement index() method.
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                    "pars"=>$this->pars
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }


        function save(){

                $repUSER = REPOSITORY::read(REPOSITORY::CURRENT_USER );

                include "Controllers/Contact.php";
                include "Models/Contact_Model.php";

                try {

                        // highlight_string(var_export($this->pars, true));
                        unset($this->pars->output);
                        unset($this->pars->with_session);

                        $settings_ = array();
                        foreach ($this->pars as $index => $par) {
                               $settings_[$index] = $par;
                        }

                        // Empty all objects in array
                        // Post only the uid and settings param
                        $this->pars = (object) array();

                        $this->pars->settings = json_encode($settings_);

                        // Add inclusive uid on params
                        $this->pars->uid = $repUSER["uid"];
                        $contact = new Contact($this->pars, false );
                        $user = $contact->save();


                } catch (ReflectionException $e) {

                }

                return (object) array("resulta"=>$user->resulta, "process"=>$user->process, "pars"=>$this->pars, "message"=>$user->message, "color"=>$user->color);

        }


        function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }
}


namespace _how_us_found;
use Controller;
use ReflectionException;
use FETCH_STRUCTURE;
use REPOSITORY;
use _list\Contact;
use ACTIVITY;
use ViewController;
use RightBarButton;
use RedirectViewController;
class Settings extends Controller{

        /**
         * Settings constructor.
         * @param $pars
         * @throws ReflectionException
         */
        function __construct($pars)
        {
                parent::__construct($pars);
        }




        public function index()
        {

                $this->model->pars = $this->pars;
                $huf_data = $this->model->fetchHuf();

                // TODO: Implement index() method.
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "huf_data" => $huf_data
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }

        public function plan_picker()
        {

                #highlight_string(var_export($this->pars, true));

                // TODO: Implement index() method.
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "pars"=>$this->pars
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }


        function save(){

                $repUSER = REPOSITORY::read(REPOSITORY::CURRENT_USER );

                $RVC = new RedirectViewController();


                include "Controllers/Contact.php";
                include "Models/Contact_Model.php";

                // highlight_string(var_export($this->pars->feedback_huf, true));
                
                try {
                        // Prepare for Save
                        // unset($this->pars->output);
                        // unset($this->pars->with_session);

                        $this->pars = (object) array(
                                "uid"=>$repUSER["uid"],
                                "huf"=>json_encode($this->pars->feedback_huf)
                        );

                        // highlight_string(var_export($this->pars, true));
                        $contact = new Contact($this->pars);
                        $user = $contact->save();



                } catch (ReflectionException $e) {

                }


                $RVC->autoRoutingWithUserDataAfterConfirm( REPOSITORY::read(REPOSITORY::CURRENT_USER), $isRedirect, $redirectTo );

                if( $isRedirect ){
                        return array(
                                "messageWithAlert" => true,
                                "title" => "Danke für feedback",
                                "message" => $user->message,
                                "action" => $redirectTo

                        );
                }




        }


        function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }
}

namespace _code;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use REPOSITORY;
class Settings extends Controller
{

        public function __construct($pars)
        {
                try {
                        parent::__construct($pars);
                } catch (ReflectionException $e) {
                }
        }



        public function index()
        {
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);
                $this->view->data = array(
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }

        function check(){


                $resulta = false;
                if( is_null($this->pars->code) ){
                        $title = "Checked Code";
                        $message = "Error with code";
                } else {
                        if(empty(trim($this->pars->code))){
                                $title = "Fehler";
                                $message = "Bitte geben Sie eine gültige code!";
                        }
                        else {

                                $this->pars->code = preg_replace("/-/i", "", $this->pars->code);

                                $this->pars->uid = REPOSITORY::read(REPOSITORY::CURRENT_USER)["uid"];
                                $this->model->pars = $this->pars;
                                $data = $this->model->{__FUNCTION__}();
                                #print_r($data);

                                if( !is_null($data["_code"]) ){

                                        if( !$data["status"] )
                                        {
                                                $resulta = false;
                                                $title   = "Achtung";
                                                $message = $data["status_message"];
                                        }
                                        else {


                                                if( !$data["code_expired"] )
                                                {
                                                        /*$title = $data["pretty_code_group_name"];
                                                        $resulta = true;
                                                        $message = $data["pretty_code_group_description"] .
                                                                "\n" . $data["pretty_club_name"] . " ( " . $data["pretty_team_name"] . " )" ;*/

                                                        if( !$data["code_using"] ){

                                                                if( !$data["code_using_by_me"]){

                                                                        $title = $data["pretty_code_group_name"];
                                                                        $resulta = true;
                                                                        $message = $data["pretty_code_group_description"] .
                                                                                "\n" . $data["pretty_club_name"] .
                                                                                " ( " . $data["pretty_team_name"] . " " . $data["pretty_team_group_name"] . " )" ;

                                                                } else {
                                                                        $title = "Achtung";
                                                                        $resulta = false;
                                                                        $message = "Sie haben diesen Code bereits hinzugefügt";
                                                                }
                                                        }

                                                        else {

                                                                $title = "Alert";
                                                                $resulta = false;
                                                                $message = "Dieser Code wurde bereits von einem anderen Benutzer registriert!";

                                                        }


                                                }
                                                else {
                                                        $title = "Tut mir leid";
                                                        $resulta = false;
                                                        $message = "Ihre Code Seit:" . $data["pretty_until_at"] ." ist abgelaufen";
                                                }


                                        }

                                } else {
                                        $title = "Achtung";
                                        $message = "Ihre code unültig!" . $this->pars->code;
                                }

                        }
                }


                return array(
                        "resulta"=>$resulta,
                        "title"=>$title,
                        "message"=>$message,
                        "unwindFrom"=>$this->pars->unwindFrom, // Can be null (Success only when from Role and unwind to Role)
                        "prettyCode"=>$this->pars->code
                );


        }

        function bindCodeToUser(){

                $this->pars->uid = REPOSITORY::read(REPOSITORY::CURRENT_USER)["uid"];
                $this->model->pars = $this->pars;
                $data = $this->model->{__FUNCTION__}();

                return $data;

        }


        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}

