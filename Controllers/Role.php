<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 24.02.19
 * Time: 17:48
 * User Role Management
 */


namespace manage;

use Controller;
use FETCH_STRUCTURE;
use ACTIVITY;
use VIEW_CONTROLLER;
use RightBarButton;
use ViewController;
use load\Role as Load_Role;
use TEAMROLLE;
use REPOSITORY;
use REGISTER_ROLE;
use CLUB_MANAGER_ROLE;
use Helper;

class Role extends Controller
{

        /**
         * Rolee constructor.
         * @param $pars
         * @throws \ReflectionException
         */
        function __construct($pars)
        {
                parent::__construct($pars);
        }

        public function __destruct()
        {
                // REPOSITORY::kill(REPOSITORY::USER_ROLES);

        }

        private function checkAvailableFilteredSelectableUserRolesForNewAdd()
        {

                $availableUniqueRoles = array(REGISTER_ROLE::ROLE_PLAYER);

                $getAllRoles = $this->public->getRoles();
                        $fetchUserUsedRoles = $this->model->fetchUserUsedRoles();


                if (count($fetchUserUsedRoles)) {
                        foreach ($fetchUserUsedRoles as $index => $fetchUserUsedRole) {

                                if (in_array($fetchUserUsedRole["role_id"], $availableUniqueRoles)) {

                                        // TODO -> Do Item None Seen
                                        // unset($getAllRoles[$getUserRole["role_id"]]);

                                        // TODO -> Do Item Disable
                                        $getAllRoles[$fetchUserUsedRole["role_id"]]["selectable"] = false;

                                }


                        }


                }

                #highlight_string(var_export($getAllRoles, true));
                return $getAllRoles;
        }


        function fetchRole()
        {

                $this->model->pars = $this->pars;
                $data = $this->fetchUserUsedRoles();


                if (count($data)) {
                        $data = array_shift($data);

                        $data["team"] = json_decode($data["team"]);
                        $data["_code"] = json_decode($data["_code"]);
                        $data["team_group"] = json_decode($data["team_group"]);
                        $data["team_dfb_name"] = json_decode($data["team_dfb_name"]);
                        $data["team_dfb_link"] = json_decode($data["team_dfb_link"]);


                        // REPOSITORY::killAll();

                        REPOSITORY::writes(REPOSITORY::USER_ROLES, $data["user_used_role_id"], $data);

                        // print_r(REPOSITORY::reads(REPOSITORY::USER_ROLES, $data["user_used_role_id"]));

                        return REPOSITORY::reads(REPOSITORY::USER_ROLES, $data["user_used_role_id"]);
                }

                return null;

        }


        public function index()
        {
                // TODO: Implement index() method.

                /**
                 * Remove All Repository
                 * For Role
                 */
                REPOSITORY::kills(REPOSITORY::USER_ROLES);


                $roles = $this->checkAvailableFilteredSelectableUserRolesForNewAdd();


                // highlight_string(var_export($roles, true));

                // highlight_string(var_export($this->public->getTrainerLicence(), true));


                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                    "roles" => $roles
                );


                #print_r($this->pars);

                if (!is_null($this->pars->user_used_role_id)) {

                        // TODO Load User Using Role

                        try {
                                $loadRole = new Load_Role($this->pars);
                                $loadedUserUsedRole = $loadRole->index();

                                #highlight_string(var_export($loadedUserUsedRole, true));

                                $this->view->data["user_used_role_status"] = $loadedUserUsedRole["status"];
                                $this->view->data["user_used_role_id"] = $this->pars->user_used_role_id;
                                $this->view->data["user_used_role"] = $loadedUserUsedRole["user_used_role"];
                                $this->view->data["user_managed_role"] = $loadedUserUsedRole["content"];


                        } catch (\ReflectionException $e) {
                        }


                }

                #highlight_string(var_export($this->view->data, true));

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);
        }

        function prepareClubsDataForRole()
        {

                $_ = array();

                foreach (REPOSITORY::reads(REPOSITORY::USER_ROLES) as $index => $role) {

                        unset($role["unwindFrom"]);
                        unset($role["buttonDataForTeamAdd"]);
                        unset($role["output"]);
                        unset($role["is_new"]);

                        $role["role"] = $this->pars->role;
                        $role["status"] = $this->pars->status;


                        array_push($_, $role);
                }

                return $_;

        }

        function add()
        {


                /**
                 * Optimize
                 * Data for Club Admin
                 */
                if (intval($this->pars->role) === REGISTER_ROLE::ROLE_CLUB_ADMIN) {

                        return $this->addRoleForClubAdmin();
                }


                // Default
                // Fetch All Roles from Repository
                $this->pars->clubs = $this->prepareClubsDataForRole();
                $this->model->pars = $this->pars;
                $data = $this->model->{__FUNCTION__}();
                $message = "";

                if (!$data->resulta && !$data->process) {
                        $message = "Fehler aufgetreten beim Rolle Prozess?";
                        // return $this->fetchUserUsedRolesWithIcon()["content"];

                }

                $user_used_roles_rows = $this->fetchUserUsedRolesRows();

                // REPOSITORY::kill(REPOSITORY::CURRENT_CLUB);

                return array(
                        // "userUsingRole"=>$userUsingRole,
                        // "redirect"=>"/Role/manage/fetchUserUsedRolesWithTable",
                    "showAlert" => false,
                    "fetchUserUsedRolesRows" => $user_used_roles_rows["content"],
                    "total_role" => $user_used_roles_rows["total_role"],
                    "messageTitle" => "Fehler",
                    "messageBody" => $message,
                    "roles_table_should_reload" => $data->resulta && $data->process
                );

        }

        /* * *
         * This operation for Group 4
         * Add role for Club Admin
         * And Create Club from template DFB
         * * */
        function addRoleForClubAdmin()
        {


                // Check required Club has Admin
                if (is_null($this->pars->user_used_role_id)) {

                        $requested_club_admin = $this->checkAdminForClub();

                        if (count($requested_club_admin)) {

                                if ($requested_club_admin["user_id"] === REPOSITORY::read(REPOSITORY::CURRENT_USER)["id"]) {

                                        return array(
                                            "messageTitle" => "Anfrage nicht möglich",
                                            "messageBody" => "Sie sind schon Admin für diese Verein!",
                                            "showAlert" => false
                                        );

                                } else {

                                        return array(
                                            "messageTitle" => "Anfrage nicht möglich",
                                            "messageBody" => "Diese verwein verwaltet von anderen user!",
                                            "showAlert" => false
                                        );

                                }
                        }
                }

                // Fetch All Roles from Repository
                $this->pars->clubs = array(
                    array(
                        "status" => $this->pars->status,
                        "club" => $this->pars->club,
                        "activity_from" => NULL,
                        "activity_to" => NULL,
                        "season" => NULL,
                        "role" => intval($this->pars->role),
                        "team" => array(),
                        "team_group" => array(),
                        "team_dfb_name" => array(),
                        "team_dfb_link" => array(),
                        "user_used_role_id" => $this->pars->user_used_role_id
                    )
                );


                $this->model->pars = $this->pars;
                $roleData = $this->model->{__FUNCTION__}();


                // INSERT OR UPDATE
                $clubData = $this->addLocalClub();


                #print_r($clubData);


                $report = array();

                if (!$roleData->resulta) {

                        array_push($report, "Fehler aufgetreten beim Rolle Prozess?");


                } else {

                        if (!$clubData->resulta) {
                                array_push($report, "Fehler aufgetreten beim Club Prozess?");
                        } else {

                                // Need Data for Club Admin

                                $new_pars = array();


                                if (is_null($this->pars->user_used_role_id) && empty(is_null($this->pars->user_used_role_id))) {

                                        $new_pars["club_id"] = $clubData->getLastInsert();

                                        $new_pars["admin_name"] = REPOSITORY::read(REPOSITORY::CURRENT_USER)["vorname"];
                                        $new_pars["admin_surname"] = REPOSITORY::read(REPOSITORY::CURRENT_USER)["nachname"];
                                        $new_pars["status"] = true;
                                        $new_pars["status_message"] = NULL;
                                        $new_pars["can_login_from_web"] = true;
                                        $new_pars["from_at"] = NULL;
                                        $new_pars["until_to"] = NULL;

                                }

                                $new_pars["manager_role"] = CLUB_MANAGER_ROLE::ADMIN;
                                $new_pars["register_id"] = REPOSITORY::read(REPOSITORY::CURRENT_USER)["id"];
                                $new_pars["dfb_club_id"] = !is_null($this->pars->club_id) ? $this->pars->club_id : $this->pars->club;
                                $new_pars["username"] = $this->pars->username;
                                if (!empty($this->pars->password)) {

                                        $helper = new Helper();

                                        $new_pars["password"] = $helper->idEncoder($this->pars->password);
                                }


                                #print_r($new_pars );
                                $this->model->pars = (object)$new_pars;
                                $clubAdmin = $this->model->manageClubAdmin();


                                if (!$clubAdmin->resulta) {
                                        array_push($report, "Fehler aufgetreten beim Club Admin Prozess?");
                                }

                        }


                }

                $user_used_roles_rows = $this->fetchUserUsedRolesRows();

                return array(
                    "showAlert" => false,
                    "fetchUserUsedRolesRows" => $user_used_roles_rows["content"],
                    "total_role" => $user_used_roles_rows["total_role"],
                    "messageTitle" => "Fehler",
                    "messageBody" => implode(",", $report),
                    "roles_table_should_reload" => $roleData->resulta && $roleData->process,
                        // "clubAdminQuery"        => $clubAdmin->getQueryString()
                    "clubAddQuery" => $clubData->getQueryString()
                );


        }

        function edit()
        {
                return $this->add();
        }

        function delete()
        {


                // TODO Delete Member Required Role
                $this->model->pars = $this->pars;
                $data = $this->model->{__FUNCTION__}();


                return array(
                    "resulta" => $data->resulta && $data->process,
                    "messageTitle" => "Fehler",
                    "messageBody" => "Fehler aufgetreten beim Rolle löschen!",
                    "user_removed_role_id" => $this->pars->id,
                    "roles_table_should_reload" => $data->resulta && $data->process
                );


        }


        function fetchUserUsedRoles()
        {
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();
        }


        // function fetchUserUsedRolesFromMemberLicence()
        function fetchUserPrettyRolesRowsForTableViewReload()
        {
                // $userUsingRole = array_shift($this->fetchUserUsedRoles());

                // $userUsingRole["club"] = $userUsingRole["club_id"];

                $user_used_roles_rows = $this->fetchUserUsedRolesRows();

                return array(
                        // "userUsingRole"=>$userUsingRole,
                        // "redirect"=>"/Role/manage/fetchUserUsedRolesWithTable",
                    "fetchUserUsedRolesRows" => $user_used_roles_rows["content"],
                    "total_role" => $user_used_roles_rows["total_role"],
                    "roles_table_should_reload" => true

                );

        }


        // Goto Roles With Pretty Icons View
        function fetchUserUsedRolesWithIcon()
        {

                // Get All Roles for User
                $user_used_roles = $this->fetchUserUsedRoles();


                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                $pretty_roles = array();

                $_added_role = [];

                if (count($user_used_roles)) {

                        /**
                         * Each of all User Roles
                         */
                        foreach ($user_used_roles as $index => $user_used_role) {

                                /**
                                 * If Role already not added
                                 */

                                if (!in_array($user_used_role["role_id"], $_added_role)) {

                                        /**
                                         * Prepare Same Data For Role Row
                                         * for View
                                         */
                                        $this->view->data = array(
                                            "icon" => $user_used_role["role_icon"],
                                            "color" => $user_used_role["role_color"],
                                            "role_id" => $user_used_role["role_id"]
                                        );


                                        /**
                                         * Get Role Pretty Row For Table View
                                         */
                                        $pretty_role = $this->view->fileContent($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "user_used_roles_icon_view.php");

                                        /**
                                         * Add Temporarily Role to Array
                                         * for Double adding denied
                                         */
                                        array_push($_added_role, $user_used_role["role_id"]);

                                        /**
                                         * Add Role
                                         */
                                        array_push($pretty_roles, $pretty_role);
                                }


                        }

                        return array(
                            "content" => implode("", $pretty_roles),
                            "disabled" => false,
                            "total_role" => count($user_used_roles)
                        );

                }


                return array(
                    "content" => "Keine Rolle!",
                    "disabled" => true,
                    "total_role" => count($user_used_roles)
                );


        }


        // Goto Roles with Table View for Edit
        function fetchUserUsedRolesWithTable()
        {

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                $user_used_roles_rows = $this->fetchUserUsedRolesRows();

                $this->view->data = array(
                    "user_used_roles" => $user_used_roles_rows["content"],
                    "total_role" => $user_used_roles_rows["total_role"]
                );


                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "user_used_roles_table_view");


        }

        // Goto Roles with Table View for Edit
        private function fetchUserUsedRolesRows()
        {

                #print_r($this->pars);

                unset($this->pars->user_used_role_id);


                // Get All Roles for User
                $user_used_roles = $this->fetchUserUsedRoles();
                $dfb_teams = $this->public->getDFBClubTeams();
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                $pretty_roles = array();

                if (count($user_used_roles)) {

                        foreach ($user_used_roles as $index => $user_used_role) {


                                // TODO Get Petty Teams Names
                                $prettyTeamNames = array();
                                if (!is_null($user_used_role["club_with_teams"])) {

                                        $object_club_with_teams = json_decode($user_used_role["club_with_teams"]);

                                        if (!json_last_error()) {

                                                if (count($object_club_with_teams)) {

                                                        foreach ($object_club_with_teams as $object_club_with_team) {

                                                                array_push(
                                                                    $prettyTeamNames,
                                                                    $dfb_teams[$object_club_with_team]["name"]
                                                                );
                                                        }
                                                }
                                        }
                                }


                                // View Roles
                                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().dismissViewController();", NULL);

                                // TeamRol Data
                                $newRoleViewController = new ViewController(
                                    "Rolle " . $user_used_role["display_name"],
                                    "Manage deine Rolle",
                                    "Role",
                                    "manage",
                                    "index",
                                    array("user_used_role_id" => $index), // Selected (If )
                                    ACTIVITY::ACTIVITY_4,
                                    VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                                    NULL
                                );

                                $newRoleViewController->setUnwindAction("alert(123)");

                                $this->view->data = array(
                                    "display_name" => $user_used_role["display_name"],
                                    "roleViewControllerData" => $newRoleViewController->prepare(),
                                    "user_used_role_id" => $index,
                                    "season" => $user_used_role["pretty_season"],
                                    "club_name" => $user_used_role["pretty_club_name"],
                                    "teams" => implode(", ", $prettyTeamNames),
                                    "activity_from" => $user_used_role["pretty_activity_from"],
                                    "activity_to" => $user_used_role["pretty_activity_to"]

                                );


                                $pretty_role = $this->view->fileContent($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "user_used_role_row.php");

                                array_push($pretty_roles, $pretty_role);

                        }

                        return array(
                            "total_role" => count($user_used_roles),
                            "content" => implode("", $pretty_roles)
                        );

                }

                return array();

        }


        // Javascript interface
        function addRoleWithAlertController()
        {


                // View Roles
                $rightBarButton = new RightBarButton("Ok", \APP_ICON::ICON_ADD, "javascript:Layout().addRoleWithAlertConfirmation()", NULL);


                // TeamRol Data
                $addRoleWithManuallyViewControllerData = new ViewController(
                    "Benutzer Rolle",
                    NULL,
                    "Role",
                    "manage",
                    "index",
                    array(),
                    ACTIVITY::ACTIVITY_4,
                    VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                    null//$rightBarButton->prepare()
                );

                // TeamRol Data
                $addRoleWithCodeViewControllerData = new ViewController(
                    "Code eingeben",
                    NULL,
                    "Settings",
                    "_code",
                    "index",
                    array(),
                    ACTIVITY::ACTIVITY_4,
                    VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                    null//$rightBarButton->prepare()
                );


                return array(
                    "message" => "Einfügen Sie Rolle mit ?",
                    "title" => "Role einfügen",
                    "with_manually" => array("title" => "Manuell", "action" => "javascript:Layout().goViewControllerWithRoleAlertController(" . json_encode($addRoleWithManuallyViewControllerData->prepare()) . ")"),
                    "with_licence" => array("title" => "Lizenz", "action" => "javascript:Layout().goViewControllerWithRoleAlertController(" . json_encode($addRoleWithCodeViewControllerData->prepare()) . ")"),
                );

        }


        function checkAdminForClub()
        {

                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();

        }

        function addLocalClub()
        {

                $this->pars->register_id = REPOSITORY::read(REPOSITORY::CURRENT_USER)["id"];


                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();

                /*return array(
                        "resulta"               => $data->resulta && $data->process,
                        "messageTitle"          => !$data->resulta ? "Fehler aufgetreten" : !$data->process ? "Alles klar" : "Erfolgreich",
                        "messageBody"           => !$data->resulta ? $data->errInfo : !$data->process ? "Keine daten aktualisiert" : "Daten aktualisiert"
                );*/
        }


}


namespace load;

use Controller;
use REPOSITORY;
use RightBarButton;
use ViewController;
use ACTIVITY;
use VIEW_CONTROLLER;
use FETCH_STRUCTURE;
use ReflectionException;
use APP_ICON;
use Helper;
use assistant\Role as Role_Assistant;
use TermsAndConditions as TAC;
use REGISTER_ROLE;

class Role extends Controller
{


        /*
         * Sample User Roles JSON for MySQL
         * {
                15:[21,24],     <- PLayer Role with Clubs ID
                20:[32,34],     <- Fan Role with Clubs ID
         *      22:[519],       <- Parent of Player with Player ID ( User can't User Parent if Player ) ( Partner Program successfully after approving )
         *      10:[32,34]      <- Role Trainer with teams
         * } */


        /*const   DEFAULT_PROFILE = 15; // Player
        const        VORSTAND_1 = 1;
        const        Vorstand_2 = 2;
        const        Vorstand_3 = 3;
        const        Kassierer_1 = 4;
        const        Kassierer_2 = 5;
        const        Schriftfuehrer_1 = 6;
        const        Schriftfuehrer_2 = 7;
        const        Kassenpruefer = 8;
        const        Jugendleiter = 9;
        const        Trainer = 10;
        const        CoTrainer = 11;
        const        Torwarttrainer = 12;
        const        Betreuer = 13;
        const        Gegner = 14;
        const        Spieler = 15;
        const        Mitglied = 16;
        const        developer = 17;
        const        SuperAdmin = 18;
        const        Andere = 19;
        const        Fan = 20;
        const        VIPFan = 21;
        const        SpielerEltern = 22;
        const        TrainerCommunity = 23;
        const        Erziehungsberechtigte = 24;
        const        Athletictrainer = 25;
        const        Vorstandsmitglied = 26;
        const        Spielleiter = 27;
        const        Jugendkoordinator = 28;
        const        AdminVerein = 29;*/


        /**
         * Role constructor.
         * @param $pars
         * @throws ReflectionException
         */
        function __construct($pars)
        {
                parent::__construct($pars);
        }

        public function index()
        {
                // TODO: Implement index() method.

                // echo $this->render()["resulta"] === false;

                return $this->render();


        }

        public function getUserRole()
        {

                #highlight_string(var_export($this->pars, true));
                // Get User Requested Role
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();

        }


        private function render()
        {


                #print_r($this->pars);
                #highlight_string(var_export($this->pars, true));
                #print_r($this->assistantViewData());

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                    "user" => REPOSITORY::read(REPOSITORY::CURRENT_USER),
                        // "role" => $this->pars->user_used_role,
                    "user_used_role_id" => $this->pars->user_used_role_id,
                    "viewControllerForRoleAssistantData" => $this->viewControllerForRoleAssistantData(),
                    "licences" => $this->public->getTrainerLicence(),
                    "viewControllerForCodeAddData" => $this->viewControllerForCodeAddData(),

                    "clubViewData" => $this->viewClubData(),
                    "clubManagersViewData" => $this->viewClubManagersData(),

                        /**
                         * With Club Admin Role
                         */
                    "termsAndConditionsViewData" => $this->termsAndConditionsViewData(),


                );


                if (!is_null($this->pars->user_used_role_id)) {

                        // $user_used_role = $this->getUserRole();
                        $user_used_role = $this->getUserRole();

                        #print_r($user_used_role);


                        #highlight_string(var_export($user_used_role, true));
                        $this->view->data["user_used_role"] = $user_used_role;
                        // Add Parameter
                        $this->pars->role = $user_used_role["role_id"];


                        /**
                         * Club With Teams
                         * In Pretty Content
                         */
                        if (!is_null($user_used_role)) {

                                $club_with_teams = NULL;

                                // Add Parameter season
                                $this->pars->season_id = $user_used_role["season_id"];


//                                /**
//                                 * May Be Multiple Clubs, While Data is JSON String
//                                 */
//                                if( !is_null($user_used_role["club_with_teams"]) ){
//
//                                        /**
//                                         * Club With Teams from JSON String To Array
//                                         */
//                                        $club_with_teams = $user_used_role["club_with_teams"];
//                                        if( Helper::isJSON($club_with_teams)){
//                                                $club_with_teams = json_decode($club_with_teams, true);
//                                        }
//
//                                }

                                /*
                                 * Prepare Parameter
                                 * for Role Assistant / Pretty Club
                                 * Table Rows
                                 * */
                                // echo $club_with_teams;
                                #highlight_string(var_export($club_with_teams, true));
                                $this->pars->club = $user_used_role["club_id"];
                                // $this->pars->teams              = $club_with_teams;
                                // $this->pars->teams              = preg_replace("/\"/i", "", $user_used_role["club_with_teams"]);
                                $this->pars->season = $user_used_role["season_id"];
                                $this->pars->activity_from = $user_used_role["activity_from"];
                                $this->pars->activity_to = $user_used_role["activity_to"];

                                $this->pars->clubName = $user_used_role["pretty_club_name"];


                                try {

                                        // Selected Club Details View Controller Data for Edit
                                        $roleAssistant = new Role_Assistant($this->pars);

                                        /*
                                         * Add View Data Parameter
                                         * */
                                        $this->view->data["user_clubs_for_role"] = $roleAssistant->preparePrettyClubRowForRole();

                                } catch (ReflectionException $e) {
                                }


                                $this->view->data["season"] = $user_used_role["pretty_season"];


                        }


                }


                /**
                 * Prepare Output
                 */

                $_output = [];
                $_output["resulta"] = false;

                #print_r($this->pars);

                if (!is_null($this->pars->role)) {

                        $targetProfileView = $this->pars->role = is_null($this->pars->role) ? REGISTER_ROLE::ROLE_PLAYER : $this->pars->role;

                        $register_roles = $this->public->getRoles()[$this->pars->role];


                        if ($this->view->data["user_used_role"]["role_id"] == REGISTER_ROLE::ROLE_CLUB_ADMIN) {

                                /***
                                 * Get Club Registered Data from Database for this Role
                                 */
                                $this->model->pars = (object)array(
                                    "register_id" => REPOSITORY::read(REPOSITORY::CURRENT_USER)["id"],
                                    "club_id" => $this->view->data["user_used_role"]["club_id"]
                                );

                                $getRegisterClubData = $this->model->getRegisteredClubData();
                                $helper = new Helper();
                                $getRegisterClubData["password_pure"] = $helper->idDecoder($getRegisterClubData["password"]);

                                // highlight_string(var_export($getRegisterClubData, true));

                                $this->view->data["registered_club_data_for_admin"] = $getRegisterClubData;


                        }

                        $file = $this->view->fileContent(
                            $this->getReflectedClass()->getShortName(),
                            $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "profile_group_" . $register_roles["role_group"] . ".php");

                        if ($file) {

                                $_output["user_used_role"] = $user_used_role;
                                $_output["resulta"] = true;
                                $_output["content"] = $file;

                                return $_output;
                        }


                        $_output["content"] = $this->view->fileContent(
                            $this->getReflectedClass()->getShortName(),
                            $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "profile_none.php"
                        );
                        return $_output;
                }


                // Role Error

                $_output["content"] = $this->view->fileContent(
                    $this->getReflectedClass()->getShortName(),
                    $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "profile_error.php"
                );

                return $_output;
        }

        /**
         * View Data for Assistant
         */
        public function viewControllerForRoleAssistantData($activity = null)
        {

                #highlight_string(var_export($this->pars, true));;
                #$rightBarButton = new RightBarButton("Einfügen", APP_ICON::ICON_ADD, "javascript:new Layout().save('');", NULL );

                #echo "Pars" . json_encode($this->pars);
                #echo "Pars" . $this->pars->user_used_role;

                $vcParams = array();
                if (!is_null($this->pars->user_used_role_id)) {
                        #if( count($this->pars ) ){
                        $vcParams = $this->pars;
                }

                // highlight_string(var_export($vcParams, true));

                $viewController = new ViewController(
                    "Assistant",
                    "Rolle Wizard",
                    "Role",
                    "assistant",
                    "index",
                    $vcParams,
                    is_null($activity) ? ACTIVITY::ACTIVITY_5 : $activity,
                    VIEW_CONTROLLER::X2UINavigationBarBackgroundShow,
                    null
                );


                return $viewController->prepare();


        }

        private function viewControllerForCodeAddData()
        {

                $viewController = new ViewController(
                    "Settings",
                    "Code eingeben",
                    "Settings",
                    "_code",
                    "index",
                    array(
                        "unwindFrom" => "settings__code_index"
                    ),
                    ACTIVITY::ACTIVITY_5,
                    true,
                    null
                );

                return $viewController->prepare();


        }

        private function viewClubManagersData()
        {

                $viewController = new ViewController(
                    "Club Managers",
                    "Manage Club Managers",
                    "Role",
                    "assistant",
                    "viewClubManagers",
                    array(),
                    ACTIVITY::ACTIVITY_5,
                    true,
                    null
                );

                return $viewController->prepare();


        }


        private function termsAndConditionsViewData()
        {

                /**
                 * Sadece Sartlar o yüzden oly terms
                 */
                include "Controllers/TermsAndConditions.php";
                include "Models/TermsAndConditions_Model.php";


                $rightBarButton = new RightBarButton("Akzeptieren", APP_ICON::ICON_OK, "javascript:new Layout().acceptedTAC();", NULL);

                $viewController = new ViewController(
                    "Terms and contisions",
                    "For Club Create",
                    "TermsAndConditions",
                    "!",
                    "index",
                    array(
                        "tac_id" => TAC::TAC_CREATE_CLUB
                    ),
                    ACTIVITY::ACTIVITY_5,
                    true,
                    $rightBarButton->prepare()
                );

                return $viewController->prepare();


        }


        private function viewClubData()
        {

                try {
                        $assistant = new Role_Assistant($this->pars);
                        return $assistant->viewClubData();
                } catch (ReflectionException $e) {
                }
                return null;

        }

}


/**
 * Add Role Assistant
 * Helper for Season, Club, Teams
 */

namespace assistant;

use _teams\Extras;
use _teams\TableView;
use Cmfcmf\OpenWeatherMap\Exception;
use Controller;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use REPOSITORY;
use FETCH_STRUCTURE;
use ViewController;
use ACTIVITY;
use VIEW_CONTROLLER;
use RightBarButton;
use load\Role as Role_Load;
use Helper;
use TEAM_SELECT_FOR;

class Role extends Controller
{


        /**
         * Role constructor.
         * @param $pars
         * @throws \ReflectionException
         */
        function __construct($pars)
        {
                parent::__construct($pars);
        }

        function fetchCurrentlyUserRoleFromRepository()
        {

                #print_r(REPOSITORY::reads(REPOSITORY::USER_ROLES, $this->pars->user_used_role_id));

                if (!is_null(REPOSITORY::reads(REPOSITORY::USER_ROLES, $this->pars->user_used_role_id))) {









                        return REPOSITORY::reads(REPOSITORY::USER_ROLES, $this->pars->user_used_role_id);
                }

                return array();

        }


        public function index()
        {
                // TODO: Implement index() method.


                #highlight_string(var_export($this->pars, true));

                if (!is_null($this->pars->user_used_role_id)) {

                        /*
                        #echo $this->pars->user_used_role_id;
                        // Store variable user_used_role from params
                        $user_used_role = $this->pars->user_used_role;

                        // Fetch Role from repository
                        $repository = REPOSITORY::reads(REPOSITORY::USER_ROLES, $this->pars->user_used_role_id);

                        // highlight_string(var_export($repository, true));

                        // Rewrite Role params from Repository with array object
                        $this->pars = (object)$repository;

                        // Add param user_used_role to params from stored variable
                        $this->pars->user_used_role = $user_used_role;

                        $this->pars->role = $this->pars->role_id;

                        // $requested_user_role = $this->pars;
                        */

                        $user_used_role = (object) REPOSITORY::reads(REPOSITORY::USER_ROLES, $this->pars->user_used_role_id);




                }

                // $requested_user_role = $this->pars;

                #highlight_string(var_export($requested_user_role, true));

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                    "user" => REPOSITORY::read(REPOSITORY::CURRENT_USER),
                    // "role" => $this->pars->role,
                    // "pars" => $requested_user_role,
                    "user_used_role" => $user_used_role,
                    "seasons" => $this->public->getSeasons(),
                    "seasonViewData" => $this->viewSeasonData(),
                    "clubViewData" => $this->viewClubData(),
                    "teamViewData" => $this->teamsViewControllerData(),
                    "clubCanBeChange" => !is_numeric($this->pars->user_used_role_id)

                );


                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


                /*



                                        $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                                        $this->view->data = array(
                                            "user" => REPOSITORY::read(REPOSITORY::CURRENT_USER),
                                            "role" => $this->pars->role,
                                            "pars" => $requested_user_role,
                                            "seasons" => $this->public->getSeasons(),
                                            "seasonViewData" => $this->viewSeasonData(),
                                            "clubViewData" => $this->viewClubData(),
                                            "teamViewData" => $this->viewTeamData(),
                                            "clubCanBeChange" => !is_numeric($this->pars->user_used_role_id)

                                        );
                                        $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

                                        return true;*/

                /*}


                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "assistant_error");*/


        }

        /**
         * @return array
         * Work With TableView Controller
         */
        private function viewSeasonData()
        {


                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().selectSeasonAndDismissWithData()", NULL );

                $vcParams = array();
                // $vcParams["uid"] = $userID;

                $viewController = new ViewController(
                    "Season",
                    "Wähle Rolle Season",
                    "TableView",
                    "_season",
                    "index",
                    $vcParams,
                    // ACTIVITY::ACTIVITY_6,
                    ACTIVITY::ACTIVITY_HELPER_1,
                    VIEW_CONTROLLER::X2UINavigationBarBackgroundShow,
                    $rightBarButton->prepare()
                );

                return $viewController->prepare();


        }


        /**
         * @return array
         * Work With TableView Controller
         */
        public function viewClubData()
        {


                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().selectClubAndDismissWithData();", NULL);

                $vcParams = array();
                // $vcParams["uid"] = $userID;

                /*$viewController = new ViewController(
                    "Verein",
                    "Wähle Rolle Verein",
                    "Role",
                    "assistant",
                    "club",
                    $vcParams,
                    ACTIVITY::ACTIVITY_6,
                    VIEW_CONTROLLER::X2UINavigationBarBackgroundShow,
                    $rightBarButton->prepare()
                );*/

                $viewController = new ViewController(
                        "Verein",
                        "Wähle Rolle Verein",
                        "TableView",
                        "_clubs",
                        "index",
                        $vcParams,
                        ACTIVITY::ACTIVITY_HELPER_1,
                        VIEW_CONTROLLER::X2UINavigationBarBackgroundShow,
                        $rightBarButton->prepare()
                );


                // Additional Bottom View
                $viewController->setViewBottomViewWithAction("Keine Verein gefunden?", "javascript:Layout().clubNotFoundReport();");
                // $viewController->setViewBottomViewWithLabel("Custom Text");


                return $viewController->prepare();


        }


        /**
         * @return array
         * Work With TableView Controller
         */
        public function teamsViewControllerData(){


                try {
                        include "Controllers/TableView.php";
                        include "Models/TableView_Model.php";

                        $tableViewController = new TableView($this->pars);
                        return $tableViewController->dynamicTeamsDetailsViewControllerForSelectedClub();

                } catch (\ReflectionException $e) {
                }

                return null;

        }




        /**
         * Season View
         */
        function season()
        {


                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                    "seasons" => $this->public->getSeasons()
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


        }

        /**
         * Clubs View
         */
        function club()
        {
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                    "clubs" => $this->public->getDFBClubs()
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }

        /**
         * Teams View
         */
        function team()
        {

                #highlight_string(var_export($this->pars, true));


                $team_rows = array();

                $DFBClubTeams = $this->public->getDFBClubTeams();
                if (count($DFBClubTeams)) {
                        foreach ($DFBClubTeams as $index => $DFBClubTeam) {


                                $vcParams = array();
                                // $vcParams["uid"] = $userID;
                                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:new Layout().collectSelectedTeamGroupsAndDismissWithData();", NULL);

                                $subTeamDetailsViewController = new ViewController(
                                    "Mannschaftzahl",
                                    get_class($this),
                                    "Role",
                                    "assistant",
                                    "sub_teams",
                                    $vcParams,
                                    ACTIVITY::ACTIVITY_7,
                                    VIEW_CONTROLLER::X2UINavigationBarBackgroundShow,
                                    $rightBarButton->prepare()
                                );


                                $this->view->data = array(
                                    "pars" => $this->pars,
                                    "dfb_team" => $DFBClubTeam,
                                    "subTeamDetailsViewController" => $subTeamDetailsViewController->prepare()

                                );

                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                                array_push($team_rows,

                                    $this->view->fileContent(
                                        $this->getReflectedClass()->getShortName(),
                                        $this->getReflectedClass()->getNamespaceName() .
                                        DIRECTORY_SEPARATOR .
                                        "team_row.php"
                                    )
                                );

                        }
                }




                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                    "pars" => $this->pars,
                    "teams" => implode("", $team_rows)
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }

        /**
         * Clubs View ???????
         */
        function sub_teams()
        {

                $vcParams = array();
                // $vcParams["uid"] = $userID;
                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().collectSelectedLeagueAndDismissWithData();", NULL);

                $leaguesViewController = new ViewController(
                        "Spielklasse",
                        "Wähle bitte Spielklasse",
                        "Extras",
                        "_leagues",
                        "index",
                        $vcParams,
                        ACTIVITY::ACTIVITY_8,
                        VIEW_CONTROLLER::X2UINavigationBarBackgroundShow,
                        $rightBarButton->prepare()
                );

                #highlight_string(var_export($leaguesViewController->prepare(), true));

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "sub_teams"             => $this->public->getDFBClubSubTeams(),
                        "leagues_view_controller_data" => $leaguesViewController->prepare()
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }


        /**
         * User Selected Pure Teams
         * not connected dfb
         */
        function selectedTeams()
        {


                #print_r($this->pars);
                /**
                 * Need Base Team is JSON combined
                 * for getDFBClubTeams
                 * Posted Json like [{"team":5, "subTeam":2}, {"team":2, "subTeam":4}]
                 * Need Json like [5, 2]
                 */

                $dataTeams      = $this->public->getDFBClubTeams();
                $dataTeamGroups = $this->public->getDFBClubSubTeams();
                $dataLicences   = $this->public->getLicences();
                $dataLeagues    = $this->public->fetchLeagues();

                #print_r($dataLeagues);

                if (gettype($this->pars->team) === "string") {
                        $this->pars->team = json_decode($this->pars->team);
                }

                if (gettype($this->pars->team_group) === "string") {
                        $this->pars->team_group = json_decode($this->pars->team_group);
                }

                if (gettype($this->pars->team_league) === "string") {
                        $this->pars->team_league = json_decode($this->pars->team_league);
                }

                if (gettype($this->pars->_code) === "string") {
                        $this->pars->_code = json_decode($this->pars->_code);
                }


                if (gettype($this->pars->club) === "string") {
                        $this->pars->club = json_decode($this->pars->club);
                }


                try {
                        $rows = array();

                        if (count($this->pars->team)) {


                                $vcParams = array(
                                    "club" => $this->pars->club,
                                    "external" => true
                                );

//                                // $this->pars->id = $vcParams["club"];
//                                // $club = $this->public->getDFBClubs();
//
//                                // $vcParams["uid"] = $userID;
//                                $rightBarButton = new RightBarButton("Bind", "link2", "javascript:Layout().connectMyTeamWithDfbTeamAndGoBack();", NULL);
//
//                                $dfbOfficialPageConnectViewControllerData = new ViewController(
//                                        "DFB Verbindung",
//                                        "Verbinde deine Mannschaft mit DFB", //"$club["teamName2"],
//                                        "Role",
//                                        "assistant",
//                                        "dfbConnect",
//                                        $vcParams,
//                                        ACTIVITY::ACTIVITY_6,
//                                        VIEW_CONTROLLER::X2UINavigationBarBackgroundShow,
//                                        $rightBarButton->prepare()
//                                );


                                for ($i = 0; $i < count($this->pars->team); $i++) {


//                                        $vcParams = array(
//                                                "clubId"   => $this->pars->club[$i],
//                                                "external" => true
//                                        );
//
//                                        $this->pars->id = $vcParams["clubId"];
//                                        $club = $this->public->getDFBClubs();
//
//                                        // $vcParams["uid"] = $userID;
//                                        $rightBarButton = new RightBarButton("Bind", "link2", "javascript:Layout().connectMyTeamWithDfbTeamAndGoBack();", NULL);
//
//                                        $dfbOfficialPageConnectViewControllerData = new ViewController(
//                                                "DFB",
//                                                $club["teamName2"],
//                                                "Role",
//                                                "assistant",
//                                                "dfbConnect",
//                                                $vcParams,
//                                                ACTIVITY::ACTIVITY_6,
//                                                VIEW_CONTROLLER::X2UINavigationBarBackgroundShow,
//                                                $rightBarButton->prepare()
//                                        );


                                        // $dfbOfficialPageConnectViewControllerData->setExternalUrl($club["vereinsseite"]);
                                        // $dfbOfficialPageConnectViewControllerData->setRunnableScript("1345221.js");

                                        $rightBarButton = new RightBarButton("Bind", "link2", "javascript:Layout().connectMyTeamWithDfbTeamAndGoBack();", NULL);

                                        $dfbOfficialPageConnectViewControllerData = new ViewController(
                                            "DFB Verbindung",
                                            "Verbinde {$dataTeams[$this->pars->team[$i]]["name"]} mit DFB", //"$club["teamName2"],
                                            "Role",
                                            "assistant",
                                            "dfbConnect",
                                            $vcParams,
                                            ACTIVITY::ACTIVITY_6,
                                            VIEW_CONTROLLER::X2UINavigationBarBackgroundShow,
                                            $rightBarButton->prepare()
                                        );

                                        $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                                        $this->view->data = array(
                                                        // "clubId"        => $this->pars->club[$i],
                                                    "club"              => $this->pars->club,
                                                    "team"              => $dataTeams[$this->pars->team[$i]],
                                                    "_code"             => $dataLicences[$this->pars->_code[$i]],
                                                    "team_group"        => $dataTeamGroups[$this->pars->team_group[$i]],
                                                    "team_league"       => $dataLeagues[$this->pars->team_league[$i]],

                                                    "team_dfb_name" => $this->pars->team_dfb_name[$i],
                                                    "team_dfb_link" => $this->pars->team_dfb_link[$i],

                                                    "dfbConnect" => $dfbOfficialPageConnectViewControllerData->prepare(),
                                                    "role_locked" => $this->pars->role_locked



                                        );

                                        $row = $this->view->fileContent($this->getReflectedClass()->getShortName() . DIRECTORY_SEPARATOR . $this->getReflectedClass()->getNamespaceName(), "row_selected_team.php");

                                        array_push($rows, $row);


                                }

                                return implode("", $rows);


                        }


                } catch (Exception $exc) {

                        echo $this->pars->teams;


                }

                return array();

        }

        /**
         *
         * All Prepared Club with Pretty Content To Role
         *
         * @throws \ReflectionException
         */
        function preparePrettyClubRowForRole()
        {

                $originalPars = (array)$this->pars;

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);


                #print_r($this->pars);

                /**
                 * Set User Role Id
                 * Temporarily
                 */
                $user_used_role_id = $this->pars->user_used_role_id;
                if (is_null($user_used_role_id) || empty($user_used_role_id)) {
                        $user_used_role_id = \Helper::passwordGenerator(null, 7)->md5;
                        $this->pars->user_used_role_id = $user_used_role_id;
                }


                if (count($this->pars->teams)) {
                        $this->pars->teams = implode("-", $this->pars->teams);
                }

                $this->pars->buttonDataForTeamAdd = $this->teamsViewControllerData();



                $season = $this->public->getSeasons()[$this->pars->season];
                $this->pars->season = $season["id"];
                $this->pars->pretty_selected_season_name = $season["name"];


                /**
                 * Create or Edit User Roles Repository
                 * USER_ROLES is fixed
                 * Sub Array determined via Temporarily user_used_role key
                 * or by edit user_used_role_id id;
                 */
                REPOSITORY::writes(REPOSITORY::USER_ROLES, $user_used_role_id, (array)$this->pars);


                /**
                 * Fetch Data likely with pars
                 * Same id's into pars
                 * with this ids fetch need data
                 * club Name, Team Names, Season Name
                 */
                $this->view->data = $this->preparePrettyClubDataForRow();


                /**
                 * Will create url for ViewController
                 * And same pars now unless
                 * can remove
                 * need only temporarily or real role id
                 */
                unset($this->pars->output);
                unset($this->pars->activity_from);
                unset($this->pars->activity_to);
                unset($this->pars->club);
                unset($this->pars->unwindFrom);
                unset($this->pars->is_new);
                unset($this->pars->season);

                /**
                 * Add only
                 * temporarily or real role id
                 */
                $this->pars = (object)array(
                    "user_used_role_id" => $user_used_role_id
                );

                /**
                 * Prepare Assistant ViewController URl data
                 */
                $assistant = new Role_Load($this->pars);
                $clubOfRoleDetailsViewControllerData = $assistant->viewControllerForRoleAssistantData(ACTIVITY::ACTIVITY_5);

                /**
                 * Add Prepared Assistant URl data to view data
                 */
                $this->view->data["clubOfRoleDetailsViewControllerData"] = $clubOfRoleDetailsViewControllerData;
                $this->view->data["pars"] = $this->pars;
                $this->view->data["user_used_role_id"] = $user_used_role_id;
                $this->view->data["clubName"] = $originalPars["pretty_club_name"];
                $this->view->data["confirmed_by_club_logo"] = $originalPars["confirmed_by_club_logo"];
                $this->view->data["role_locked"] = $originalPars["role_locked"];

                #print_r($originalPars["pretty_club_name"]);

                /**
                 * Send data to row file and return as pretty
                 */
                $clubForRole = $this->view->fileContent($this->getReflectedClass()->getShortName() . DIRECTORY_SEPARATOR . $this->getReflectedClass()->getNamespaceName(), "prepared_club_for_role.php");


                return array(
                    "RowClubForRole" => $clubForRole,
                    "repository" => REPOSITORY::reads(REPOSITORY::USER_ROLES),
                    "pars" => $originalPars
                );


        }


        /**
         * Call this function if user updated his #
         * Club Data for Role
         * After assistant/index
         */

        function preparePrettyClubDataForRow()
        {

                // echo count($this->pars->teams);
                $seasonId = $this->pars->season;
                $club = $this->pars->club;
                $implodedTeams = $this->pars->teams;
                $activity_from = $this->pars->activity_from;
                $activity_to = $this->pars->activity_to;

                $response = array();

                $response["user_used_role_id"] = $this->pars->user_used_role_id;


                $pretty_activity_from = $this->pars->pretty_activity_from;
                $response["pretty_activity_from"] = $pretty_activity_from;
                $response["activity_from"] = $activity_from;
                if (!isset($pretty_activity_from)) {
                        if (!is_null($activity_from) && !empty($activity_from)) {
                                $pretty_activity_from = date_create($activity_from)->format("d.m.Y");

                                $response["activity_from"] = $activity_from;
                                $response["pretty_activity_from"] = $pretty_activity_from;
                        }
                }

                $pretty_activity_to = $this->pars->pretty_activity_to;
                $response["pretty_activity_to"] = $pretty_activity_to;
                $response["activity_to"] = $activity_to;
                if (!isset($pretty_activity_to)) {
                        if (!is_null($activity_to) && !empty($activity_to)) {
                                $pretty_activity_to = date_create($activity_to)->format("d.m.Y");

                                $response["activity_to"] = $activity_to;
                                $response["pretty_activity_to"] = $pretty_activity_to;
                        }
                }

                $season = NULL;
                if ($seasonId) {
                        $season = $this->public->getSeasons();
                        $season = $season[$seasonId];
                        $response["season"] = $season;
                }

                $club = NULL;
                if ($club) {

                        $this->pars->id = intval($club);
                        $club = $this->public->getDFBClubs();
                        $response["club"] = $club;
                }


                $teams = NULL;
                if (isset($implodedTeams)) {

                        $explodedTeams = explode("-", $implodedTeams);
                        $this->pars->teams = $explodedTeams;
                        $teams = $this->public->getDFBClubTeams();
                        $response["teams"] = $teams;
                }

                return $response;

        }


        /**
         * @deprecated
         */
        function dfbConnect()
        {

                /**
                 * Get DFB target Club Data
                 */

                // $teamsFromRepository = REPOSITORY::read(REPOSITORY::CURRENT_DFB_CLUB_TEAMS );

                #highlight_string(var_export($this->fetchDFBClubData(), true));

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                    "pars" => $this->pars,
                        // "temporarilyDfbTeams" => $teamsFromRepository
                    "fetchDFBClubData" => $this->fetchDFBClubData()
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


        }


        /**
         * Fetch Club Data from Database
         * In This data found the URl of target Club
         * this url will using in external view in operation in native
         * and collect and return the Active teams of club
         * than this teams bind with selected club team
         *
         */
        function fetchDFBClubData()
        {

                #highlight_string(var_export($this->pars, true));
                $this->model->pars = $this->pars;
                return array_merge(
                    $this->model->{__FUNCTION__}(),
                    array("runnableScript" => "1345221.js")
                );

        }






        function preparePrettyTableRowsFromSelectedTeamsForClubFromDFB()
        {


                // Goto Row
                $data = json_decode($this->pars->data);


                $rows = array();

                if (count($data)) {

                        $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);


                        foreach ($data as $d) {

                                $d->uniqueId = uniqid();
                                $this->view->data = array(
                                    "team" => $d
                                );

                                $row = $this->view->fileContent($this->getReflectedClass()->getShortName() . DIRECTORY_SEPARATOR . $this->getReflectedClass()->getNamespaceName(), "row_dfb_team.php");

                                array_push($rows, $row);
                        }

                        $rows = implode("", $rows);
                        // REPOSITORY::write(REPOSITORY::CURRENT_DFB_CLUB_TEAMS, $rows);
                        return $rows;

                }

                return array();

        }


        /*
         * Manage Club Managers
         * */
        function viewClubManagers()
        {

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                $this->view->data = array();

                try {
                        $object = new \ReflectionClass(get_class($this));
                } catch (\ReflectionException $e) {
                }

                $this->view->render($object->getShortName(), $object->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


        }


}