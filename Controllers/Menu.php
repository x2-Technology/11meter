<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 26.09.18
 * Time: 23:00
 */

/**
 * Class Menu
 * @deprecated
 * @see _Public -> Extended Class Abstracted
 */
class Menu extends Controller
{
        /**
         * Menu constructor.
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


        function fetchAll()
        {

                // Fetch from Database
                $menu = $this->public->getMenu();

                return array( "data" => array ( array( "slide_menu" => $this->getSlideMenu(), "bottom_menu" => $this->getBottomBarMenu() ) ) );
                // return array( "slide_menu" => $this->getSlideMenuWithData($menu), "bottom_menu" => $this->getBottomBarMenuWithData($menu) );
                // return array( "slide_menu" => $this->getSlideMenuWithData($menu), "bottom_menu" => $this->getBottomBarMenu_static() );
        }

        function testMenu(){

                $menu = $this->public->getMenu();

                $prettyMenu = $this->prepareMenuItem( $menu, X2_USER_MENU::X2UserMenuMenuSlide );

                // highlight_string(var_export($prettyMenu, true));


        }

        public function getSlideMenuWithData( $data = array() )
        {


                if ($this->pars->data_fetch == DATA_FETCH::ASSOC) {

                        return $this->prepareMenuItem( $data, X2_USER_MENU::X2UserMenuMenuSlide );
                }

                return array();

        }

        /**
         * @return array
         * Static
         */
        public function getSlideMenu_()
        {


                if ($this->pars->data_fetch == DATA_FETCH::ASSOC) {

                        $params = array();
                        $output = array();

                        // ACTIVITY Not Need here, while call operation from Native content
                        /*array_push($output, array(
                            "display_name" => "Home",
                            "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Home" . DIRECTORY_SEPARATOR . "_start" . DIRECTORY_SEPARATOR . "index",
                            "icon" => "ic_home",
                            "last_check" => "",
                            "unwind_get_data_store"=>"javascript:new Layout().getUnwindDataStore();",
                            // "unwind_action" => "javascript:javascript:unwindAction(); new Home().updateAvailability();",
                            "right_bar_button"=> array(
                                    // Button Title
                                "title"=>"Speichern",
                                "icon"=>"floppy-disk",
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
                            )
                        ));*/
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
                                "display_name" => "Einstellungen",
                                "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Settings" . DIRECTORY_SEPARATOR . "_start" . DIRECTORY_SEPARATOR . "index",
                                "icon" => APP_ICON::ICON_SETTINGS,
                                "last_check" => "Back link from Team",
                                "unwind_get_data_store"=>"javascript:new Layout().getUnwindDataStore();",
                                // "unwind_action" => "javascript:javascript:unwindAction(); new Meeting().updateAvailability();",
                                ACTIVITY::ACTIVITY=>ACTIVITY::go(ACTIVITY::ACTIVITY_1)
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


        /**
         * @return array
         * @Menu Static && sample for Database
         */
        private function getBottomBarMenu_static()
        {


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
                        array_push($output, array("display_name" => "Spieler", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Member" . DIRECTORY_SEPARATOR . "owner" . DIRECTORY_SEPARATOR . "index", "icon" => "ic_user3", "last_check" => ""));
                        array_push($output, array("display_name" => "Messages", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "Message" . DIRECTORY_SEPARATOR . "_list" . DIRECTORY_SEPARATOR . "index", "icon" => "ic_bell", "last_check" => "", "badge"=>2));
                        // Example
                        // array_push($output, array("display_name" => "More", "link" => "http://app.my-team-manager.de/test_team_agent_list.php", "icon" => "ic_more2", "last_check" => ""));
                        array_push($output, array("display_name" => "Share", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR . "More" . DIRECTORY_SEPARATOR . "manage" . DIRECTORY_SEPARATOR . "index", "icon" => "share3", "last_check" => "", "badge"=>0));


                        foreach ($_POST as $index => $item) {
                                array_push($params, array($index => $item));
                        }

                }


                // echo json_encode(array("data"=>array(array("slide_menu"=>$output, "bottom_menu"=>$output))));

                return $output;


        }


        /**
         * @return array
         * @Menu Dynamic
         */
        private function getBottomBarMenuWithData( $data = array() )
        {


                if ($this->pars->data_fetch == DATA_FETCH::ASSOC)
                {
                        return $this->prepareMenuItem($data, X2_USER_MENU::X2UserMenuMenuBottom );
                }

                return array();
        }


        private function prepareMenuItem( $items = array(), $userMenuGroup ){

                $menu = array();

                // Ignore array elements forever
                $banned_keys = array("menu_key", "status", "user_used_role", "menu_group","id", "sort");

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


        function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}