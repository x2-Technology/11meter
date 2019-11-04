<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 08.02.19
 * Time: 14:12
 */

class RedirectViewController
{
        private $userData               = null;
        const UID_KEY                   = "uid";
        const REDIRECT_KEY_PROFILE      = "profile_edited";
        const REDIRECT_KEY_PASSWORD     = "password";
        const REDIRECT_KEY_HOW_US_FOUND = "huf";

        function __construct() {

        }

        function autoRoutingWithUserData( $userData, &$isRedirect, &$redirectTo){


                $this->userData = $userData;

                if(is_null($this->userData[self::REDIRECT_KEY_PASSWORD]))
                {
                        $isRedirect = true;
                        $redirectTo = $this->ViewPassword($this->userData[self::UID_KEY]);
                        return ;
                }

                if(is_null($this->userData[self::REDIRECT_KEY_PROFILE])){

                        $isRedirect = true;
                        $redirectTo = $this->ViewProfile($this->userData[self::UID_KEY]);
                        return ;
                }

                if(is_null($this->userData[self::REDIRECT_KEY_HOW_US_FOUND])){

                        $isRedirect = true;
                        $redirectTo = $this->ViewHowUsFound($this->userData[self::UID_KEY]);
                        return ;

                }


                if( !Config_Manager::get(CONFIG_MANAGER::CONFIG_FOR_APP, "deploy" ) ){

                        $isRedirect = true;
                        $redirectTo = $this->ViewUserWaitWhileAppNotPublic($this->userData[self::UID_KEY]);
                        return ;

                }




                $isRedirect = false;

        }


        function autoRoutingWithUserDataAfterConfirm( $userData, &$isRedirect, &$redirectTo )
        {
                $this->autoRoutingWithUserData($userData, $ir, $rt );

                $isRedirect = $ir;
                $redirectTo = "javascript:redirectViewController(" . json_encode($rt) . ")";

                /*$_ = $this->autoRoutingWithUserData($this->userData);
                $isRedirect = !is_null($_);
                $redirectTo = "javascript:redirectViewController(" . json_encode($this->autoRoutingWithUserData()) . ")";*/
                return null;
        }



        function ViewPassword($userID){


                /*$_ = array();
                $_["display_name"]              = "Passwort";
                $_["link"]                      = Config::BASE_URL . DIRECTORY_SEPARATOR. "Settings". DIRECTORY_SEPARATOR . "_password" . DIRECTORY_SEPARATOR . "index/?uid=" . $me["uid"];
                $_["right_bar_button"]          = array("title"=>"Save", "icon"=>APP_ICON::ICON_SAVE, "action"=>"javascript:new Layout().save('_password');");
                $_[ACTIVITY::ACTIVITY]          = ACTIVITY::go(ACTIVITY::ACTIVITY_2);
                $_[VIEW_CONTROLLER::X2UINavigationBackButtonKey] = VIEW_CONTROLLER::X2UINavigationBackButtonHide;
                return $_;*/


                /*$confirmationAlert = new ConfirmationAlert("Passwort", "Möchten Sie speichern?");
                $confirmationAlert->setAction("Cancel", ALERT_ACTION_STYLE::UIAlertActionStyleDestructive, NULL );
                $confirmationAlert->setAction("Save", ALERT_ACTION_STYLE::UIAlertActionStyleDefault, "javascript:new Layout().save('_general')" );*/

                $rightBarButton = new RightBarButton("Speichern", APP_ICON::ICON_SAVE, "javascript:new Layout().save('_password');", NULL );

                $vcParams = array();
                $vcParams["uid"] = $userID;

                $viewController = new ViewController("Passwort", "Manage deine Password","Settings","_password", "index", $vcParams,ACTIVITY::ACTIVITY_1,NULL, $rightBarButton->prepare());

                return $viewController->prepare();


        }


        function ViewProfile($userID){


                $confirmationAlert = new ConfirmationAlert("Speichern", "Möchten Sie speichern?");
                $confirmationAlert->setAction("Cancel", ALERT_ACTION_STYLE::UIAlertActionStyleDestructive, NULL );
                $confirmationAlert->setAction("Save", ALERT_ACTION_STYLE::UIAlertActionStyleDefault, "javascript:new Layout().save('_general')" );

                $rightBarButton = new RightBarButton("Speichern", "floppy-disk", NULL, $confirmationAlert->prepare() );

                $vcParams = array();
                $vcParams["uid"] = $userID;

                $viewController = new ViewController("General", "Base einstellungen", "Settings","_general", "index", $vcParams,ACTIVITY::ACTIVITY_2,NULL, $rightBarButton->prepare());

                return $viewController->prepare();


        }

        function ViewHowUsFound($userID){

                // $confirmationAlert = new ConfirmationAlert("Speichern", "Möchten Sie speichern?");
                // $confirmationAlert->setAction("Cancel", ALERT_ACTION_STYLE::UIAlertActionStyleDestructive, NULL );
                // $confirmationAlert->setAction("Save", ALERT_ACTION_STYLE::UIAlertActionStyleDefault, "javascript:new Layout().save('_general')" );

                // Create a Right Button Object
                $rightBarButton = new RightBarButton("Speichern", "floppy-disk", "javascript:new Layout().save('_how_us_found')", NULL );

                // Custom Parameter
                $vcParams = array();
                $vcParams["uid"] = $userID;

                // Create View Controller
                $viewController = new ViewController("Empfehlung", "Wie haben Sie uns gefunden", "Settings","_how_us_found", "index", $vcParams,ACTIVITY::ACTIVITY_3,NULL, $rightBarButton->prepare());


                return $viewController->prepare();

        }


        function ViewUserWaitWhileAppNotPublic($userID){


                $vcParams = array();
                $vcParams["uid"] = $userID;

                $viewController = new ViewController("Alles Ok!", NULL, "Member","owner", "fireWall", $vcParams,ACTIVITY::ACTIVITY_4,NULL, NULL);

                return $viewController->prepare();


        }





        public function __destruct()
        {
                // TODO: Implement __destruct() method.
        }
}