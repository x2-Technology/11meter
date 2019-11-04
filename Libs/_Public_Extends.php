<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 31.01.19
 * Time: 11:02
 */

abstract class _Public_Extends extends Controller
{

        abstract function sessionUser();

        abstract function runnableScript();

        function getMenu()
        {
               if (method_exists($this, 'get' . ucfirst($this->appInfo()->menu) . 'Menu')) {
                        return $this->{'get' . ucfirst($this->appInfo()->menu) . 'Menu'}();
                }

                return array(
                        "response" => "false",
                        "reason" => "Error",
                        "message" => "Check ouf of the menu type!"
                );

        }

        /**
         * @return array
         * Dynamic Call from getMenu as app.config.json (key=menu)
         */
        private function getStaticMenu()
        {
                $_["slide_menu"] = $this->getStaticSlideMenu();
                $_["bottom_menu"] = $this->getStaticBottomMenu();

                return $_;
                // return array( "slide_menu" => $this->getStaticSlideMenu() );
                // return array( "slide_menu" => $this->getStaticSlideMenu(), "bottom_menu" => $this->getStaticBottomMenu() );
        }

        private function getStaticBottomMenu(){

                if ($this->pars->data_fetch == DATA_FETCH::ASSOC) {

                        $params = array();
                        $output = array();

                        array_push($output, array("display_name" => "Home", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Home" . DIRECTORY_SEPARATOR . "_start" . DIRECTORY_SEPARATOR . "index", "icon" => "ic_home", "last_check" => ""));
                        array_push($output,
                                array(
                                        "display_name" => "Termin",
                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Meeting" . DIRECTORY_SEPARATOR . "_list" . DIRECTORY_SEPARATOR . "index",
                                        "icon" => APP_ICON::ICON_LIST,
                                        "last_check" => "",
                                        "right_bar_button" => array(
                                                // Button Title
                                                "title"=>"Toggle List",
                                                "icon"=>APP_ICON::ICON_HISTORY,
                                                "action"=> "javascript:new Layout().toggleList();"
                                                // Action With Confirm
                                                /*"confirm"=>array(
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
                                                )*/


                                        )
                                )
                        );
                        array_push($output, array(
                                "display_name" => "",
                                        "link" => "",
                                        "icon" => "home3",
                                        "last_check" => "",
                                        "center"=>array(

                                                array(
                                                        "display_name" => "Testspiele",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Ad" . DIRECTORY_SEPARATOR . "ads" . DIRECTORY_SEPARATOR . "index/?" . INQUIRY_TYPE::INQUIRY_TYPE_KEY . "=" . INQUIRY_TYPE::INQUIRY_PUBLIC,
                                                        "icon" => "home",
                                                        "last_check" => "",
                                                        "enabled"=>true
                                                ),
                                                array(
                                                        "display_name" => "Turniere",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Ad" . DIRECTORY_SEPARATOR . "ads" . DIRECTORY_SEPARATOR . "index/?" . INQUIRY_TYPE::INQUIRY_TYPE_KEY . "=" . INQUIRY_TYPE::INQUIRY_PUBLIC,
                                                        "icon" => "stopwatch",
                                                        "last_check" => "",
                                                        "enabled"=>true
                                                ),
                                                array(
                                                        "display_name" => "Scouting",
                                                        "link" => "https://www.ebay.de",
                                                        "icon" => "",
                                                        "last_check" => "",
                                                        "enabled"=>false
                                                ),
                                                array(
                                                        "display_name" => "Statistik",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index",
                                                        "icon" => "home",
                                                        "last_check" => ""
                                                ),
                                                array(
                                                        "display_name" => "Mirror",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index",
                                                        "icon" => "home",
                                                        "last_check" => "",
                                                        "enabled"=>false
                                                ),

                                                array(
                                                        "display_name" => "Performance",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index",
                                                        "icon" => "home",
                                                        "last_check" => "",
                                                        "enabled"=>false
                                                ),
                                                array(
                                                        "display_name" => "Tagebuch",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index",
                                                        "icon" => "home",
                                                        "last_check" => "",
                                                        "enabled"=>false
                                                ),
                                                array(
                                                        "display_name" => "Trainingspläne",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index",
                                                        "icon" => "home",
                                                        "last_check" => "",
                                                        "enabled"=>false
                                                ),
                                                array(
                                                        "display_name" => "Trainingsübungen",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index",
                                                        "icon" => "home",
                                                        "last_check" => "",
                                                        "enabled"=>false
                                                ),
                                                array(
                                                        "display_name" => "Einstellungen",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Settings" . DIRECTORY_SEPARATOR . "_start" . DIRECTORY_SEPARATOR . "index",
                                                        "icon" => "cogs",
                                                        "last_check" => "",
                                                        "enabled"=>true
                                                ),

                                                array(
                                                        "display_name" => "Kalender",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index",
                                                        "icon" => "calendar",
                                                        "last_check" => "",
                                                        "enabled"=>false
                                                ),
                                                array(
                                                        "display_name" => "Termine",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index",
                                                        "icon" => "home",
                                                        "last_check" => "",
                                                        "enabled"=>false
                                                ),
                                                array(
                                                        "display_name" => "Spiele",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index",
                                                        "icon" => "home",
                                                        "last_check" => "",
                                                        "enabled"=>false
                                                ),
                                                array(
                                                        "display_name" => "Tabelle",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index",
                                                        "icon" => "home",
                                                        "last_check" => "",
                                                        "enabled"=>false
                                                ),
                                                array(
                                                        "display_name" => "Team",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index",
                                                        "icon" => "home",
                                                        "last_check" => "",
                                                        "enabled"=>false
                                                ),

                                                array(
                                                        "display_name" => "Mein Profil",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index",
                                                        "icon" => "home",
                                                        "last_check" => "",
                                                        "enabled"=>false
                                                        ),
                                                array(
                                                        "display_name" => "Mein Verein",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index",
                                                        "icon" => "home",
                                                        "last_check" => "",
                                                        "enabled"=>false
                                                ),
                                                array(
                                                        "display_name" => "News",
                                                        "link" => "",
                                                        "icon" => "",
                                                        "last_check" => "",
                                                        "enabled"=>false
                                                ),
                                                array(
                                                        "display_name" => "Chat",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index",
                                                        "icon" => "bubble",
                                                        "last_check" => "",
                                                        "enabled"=>false
                                                ),
                                                array(
                                                        "display_name" => "Einstellungen",
                                                        "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index",
                                                        "icon" => "cogs",
                                                        "last_check" => "",
                                                        "enabled"=>false
                                                )

                                        )
                                )
                        );
                        array_push($output, array("display_name" => "Spieler", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index", "icon" => "ic_user3", "last_check" => ""));
                        array_push($output, array("display_name" => "Messages", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Message" . DIRECTORY_SEPARATOR . "_list" . DIRECTORY_SEPARATOR . "index", "icon" => "ic_bell", "last_check" => "", "badge"=>2));
                        // Example
                        // array_push($output, array("display_name" => "More", "link" => "https://hdfilme.net/prodigy-ubernaturlich-2018-11225-stream", "icon" => "movie", "last_check" => ""));
                        // array_push($output, array("display_name" => "Shares", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "More" . DIRECTORY_SEPARATOR . "manage" . DIRECTORY_SEPARATOR . "index", "icon" => "share3", "last_check" => "", "badge"=>0));


                        foreach ($_POST as $index => $item) {
                                array_push($params, array($index => $item));
                        }

                }

                return $output;

        }

        private function getStaticSlideMenu()
        {


                if ($this->pars->data_fetch == DATA_FETCH::ASSOC) {

                        $params = array();
                        $output = array();

                        array_push($output, array(
                                "display_name" => "Termin",
                                "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Meeting" . DIRECTORY_SEPARATOR . "_list" . DIRECTORY_SEPARATOR . "index",
                                "icon" => APP_ICON::ICON_LIST,
                                "last_check" => "Back link from Termin",
                                "unwind_get_data_store"=>"javascript:new Layout().getUnwindDataStore();",
                                // "unwind_action" => "javascript:javascript:unwindAction(); new Meeting().updateAvailability();",
                                ACTIVITY::ACTIVITY=>ACTIVITY::go(ACTIVITY::ACTIVITY_1)

                        ));
                        array_push($output, array("display_name" => "Kalender",
                                "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Calendar" . DIRECTORY_SEPARATOR . "monthview" . DIRECTORY_SEPARATOR . "index",
                                "icon" => APP_ICON::ICON_CALENDAR,
                                "last_check" => "Back link from Team",
                                "unwind_get_data_store"=>"javascript:new Layout().getUnwindDataStore();",
                                // "unwind_action" => "javascript:javascript:unwindAction(); new Calendar().updateAvailability();",
                                ACTIVITY::ACTIVITY=>ACTIVITY::go(ACTIVITY::ACTIVITY_1)
                        ));
                        array_push($output, array("display_name" => "Messages",
                                "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Message" . DIRECTORY_SEPARATOR . "_list" . DIRECTORY_SEPARATOR . "index",
                                "icon" => APP_ICON::ICON_MESSAGE, "last_check" => "Back link from Team", "badge"=>2,
                                "unwind_get_data_store"=>"javascript:new Layout().getUnwindDataStore();",
                                // "unwind_action" => "javascript:javascript:unwindAction(); new Meeting().updateAvailability();",
                                ACTIVITY::ACTIVITY=>ACTIVITY::go(ACTIVITY::ACTIVITY_1)
                        ));


                        // Team
                        array_push($output, array(
                                "display_name" => "Team",
                                "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Team" . DIRECTORY_SEPARATOR . "_start" . DIRECTORY_SEPARATOR . "index",
                                "icon" => APP_ICON::ICON_MATCH_DAY,
                                // "last_check" => "Back link from Team",
                                // "unwind_get_data_store"=>"javascript:new Layout().getUnwindDataStore();",
                                // "unwind_action" => "javascript:javascript:unwindAction(); new Meeting().updateAvailability();",
                                ACTIVITY::ACTIVITY=>ACTIVITY::go(ACTIVITY::ACTIVITY_1)
                                /*"right_bar_button" => array(
                                        "title"=>"Speichern",
                                        "code"=>"javascript:document.write('Functionally Perfect')"
                                        )*/
                        ));
                        array_push($output, array(
                                "display_name" => "Spieltag",
                                "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Extras" . DIRECTORY_SEPARATOR . "_start" . DIRECTORY_SEPARATOR . "index/?".EXTRAS_REDIRECT::REDIRECT_KEY."=" . EXTRAS_REDIRECT::REDIRECT_FUSSBALLDE . "&subview=overview",
                                "icon" => APP_ICON::ICON_MATCH_DAY,
                                "last_check" => "Back link from Team",
                                ACTIVITY::ACTIVITY=>ACTIVITY::go(ACTIVITY::ACTIVITY_1)
                        ));
                        array_push($output, array(
                                "display_name" => "Tabelle",
                                "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Extras" . DIRECTORY_SEPARATOR . "_start" . DIRECTORY_SEPARATOR . "index/?".EXTRAS_REDIRECT::REDIRECT_KEY."=".EXTRAS_REDIRECT::REDIRECT_FUSSBALLDE."&subview=table",
                                "icon" => APP_ICON::ICON_TABLE,
                                "last_check" => "Back link from Team",
                                ACTIVITY::ACTIVITY=>ACTIVITY::go(ACTIVITY::ACTIVITY_1)
                        ));
                        array_push($output, array(
                                "display_name" => "Dokument",
                                "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Extras" . DIRECTORY_SEPARATOR . "_start" . DIRECTORY_SEPARATOR . "index/?".EXTRAS_REDIRECT::REDIRECT_KEY."=".EXTRAS_REDIRECT::REDIRECT_FUSSBALLDE."&subview=document",
                                "icon" => APP_ICON::ICON_DOCUMENT_PDF,
                                "last_check" => "Back link from Team",
                                ACTIVITY::ACTIVITY=>ACTIVITY::go(ACTIVITY::ACTIVITY_1)
                        ));

                        array_push($output, array(
                                "display_name" => "Anzeige",
                                "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Ad" . DIRECTORY_SEPARATOR . "ads" . DIRECTORY_SEPARATOR . "index/",
                                "icon" => APP_ICON::ICON_DOCUMENT_PDF,
                                // "last_check" => "Events",
                                ACTIVITY::ACTIVITY=>ACTIVITY::go(ACTIVITY::ACTIVITY_1),
                                /*"right_bar_button" => array(
                                        "title"=>"Neue Anzeige",
                                        "icon"=>APP_ICON::ICON_ADD,
                                        "action"=> "javascript:alert(123);"
                                )*/
                        ));



                        array_push($output, array(
                                "display_name" => "Einstellungen",
                                "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Settings" . DIRECTORY_SEPARATOR . "_start" . DIRECTORY_SEPARATOR . "index",
                                "icon" => APP_ICON::ICON_SETTINGS,
                                "last_check" => "Back link from Team",
                                "unwind_get_data_store"=>"javascript:new Layout().getUnwindDataStore();",
                                // "unwind_action" => "javascript:javascript:unwindAction(); new Meeting().updateAvailability();",
                                ACTIVITY::ACTIVITY=>ACTIVITY::go(ACTIVITY::ACTIVITY_1),
                                /*"right_bar_button" => array(
                                        "title"=>"Speichern",
                                        "code"=>"javascript:document.write('Functionally Perfect')"
                                        )*/
                        ));




                        foreach ($_POST as $index => $item) {
                                array_push($params, array($index => $item));
                        }

                }



                // echo json_encode(array("data"=>array(array("slide_menu"=>$output, "bottom_menu"=>$output))));

                return $output;


        }


        function appInfo(){

                return (object) json_decode(file_get_contents("Config/app.config.json"),true);

        }

        // abstract function getDynamicMenu();

        /**
         * @return array
         * With this method create only Sample Menu if not overwrite
         * For Custom Dynamic Menu, Please Create same Method in _Public and Create your menu like sample Menu in table which you need!
         */

        function getDynamicMenu()
        {
                // TODO: Implement getDynamicMenu() method.

                $this->pars->is_sample = true;
                $this->model->pars = $this->pars;
                $menus = $this->model->{__FUNCTION__}();

                if ($this->pars->data_fetch == DATA_FETCH::ASSOC) {

                        return array(
                                "slide_menu" => $this->prepareMenuItem(
                                        $menus, X2_USER_MENU::X2UserMenuMenuSlide
                                ),
                                "bottom_menu" => $this->prepareMenuItem(
                                        $menus, X2_USER_MENU::X2UserMenuMenuBottom
                                )
                        );
                }

                return array(
                        "slide_menu" => array(),
                        "bottom_menu" => array()
                );


        }

        /*
         * Need While Using Dynamic Menu
         */
        protected function prepareMenuItem( $items = array(), $userMenuGroup ){

                $menu = array();

                // Ignore array elements forever
                $banned_keys = array("menu_key", "status", "role", "menu_group","id", "sort");

                /**
                 * This Variables cannot be null
                 * Ignore if the array elements is null
                 */
                $vars_cannot_be_null = array("activity", "right_bar_button");

                if( count($items) ){

                        foreach ( $items as $index => $item ) {

                                if( intval($item["menu_group"]) === intval($userMenuGroup) && $item["status"] ){

                                        $newItem = array();
                                        foreach ($item as $k => $v ) {

                                                if( !is_null($v) && !empty($v) ){

                                                        if( !in_array($k, $banned_keys) ){

                                                                switch ($k){

                                                                        case "link":
                                                                                // Pretty link
                                                                                $newItem[$k] = preg_replace('/\$base_url/', Config::BASE_URL, $v );
                                                                                break;

                                                                        case ACTIVITY::ACTIVITY:
                                                                                $activity = constant($v);
                                                                                $newItem[$k] = ACTIVITY::go($activity);

                                                                                break;

                                                                        default:

                                                                                if(Helper::isJSON($v))
                                                                                {
                                                                                        $v = json_decode($v,true);
                                                                                }

                                                                                $newItem[$k] = $v ;

                                                                                break;

                                                                }

                                                        }
                                                } else {
                                                        if( !in_array($k, $vars_cannot_be_null) ){
                                                                $newItem[$k] = "";
                                                        }

                                                }

                                                /*// Pretty link
                                                $it["link"] = preg_replace('/\$base_url/', Config::BASE_URL, $it["link"] );

                                                if( !is_null($it[ACTIVITY::ACTIVITY]) ){
                                                        $activity = constant($it[ACTIVITY::ACTIVITY]);
                                                        $it[ACTIVITY::ACTIVITY] = ACTIVITY::go($activity);
                                                }*/


                                        }

                                        array_push($menu,$newItem);

                                }

                        }

                        return $menu;


                }

                return array();



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



}

