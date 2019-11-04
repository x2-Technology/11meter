<?php /** @noinspection SpellCheckingInspection */

/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 2019-06-11
 * Time: 15:40
 */

namespace _teams;
use Controller;
use RightBarButton;
use ViewController;
use ACTIVITY;
use FETCH_STRUCTURE;
use VIEW_CONTROLLER;
use TEAM_SELECT_FOR;


class TableView extends Controller
{

        public function __construct($pars)
        {
                parent::__construct($pars);
        }


        public function index()
        {

                $cells          = array();
                $finalTeams     = $this->public->getDFBClubTeams();
                $parsArray      = (array)$this->pars;
                

                if( !is_null( $parsArray[TEAM_SELECT_FOR::TEAM_SELECT_FOR_KEY] ) ){

                        switch ( $parsArray[TEAM_SELECT_FOR::TEAM_SELECT_FOR_KEY] ){

                                case TEAM_SELECT_FOR::ROLE;
                                        $redirectViewController = $this->redirectToTeamGroupViewController();
                                        break;


                                default:
                                        $redirectViewController = null;
                        }


                }


                #highlight_string(var_export($redirectViewController, true));



                if (count($finalTeams)) {
                        foreach ($finalTeams as $index => $finalTeam) {

                                $this->view->data = array(
                                        "pars"  => $this->pars,
                                        "team"  => $finalTeam,
                                        "view_controller_data"          => $redirectViewController

                                );

                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                                array_push($cells,

                                        $this->view->fileContent(
                                                $this->getReflectedClass()->getShortName(),
                                                $this->getReflectedClass()->getNamespaceName() .
                                                DIRECTORY_SEPARATOR .
                                                "cell.php"
                                        )
                                );

                        }
                }



                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "pars"  => $this->pars,
                        "cells" => $cells
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__ );


        }


        private function teamsWithLeague(){


        }


        private function teamsSubTeams(){


        }




        private function registeredTeams(){



                return "";
        }


        private function publicTeams(){


                return "";

        }

        private function redirectToTeamGroupViewController(){


                $parsArray = (array)$this->pars;



                $vcParams = array();

                if( !is_null( $parsArray[TEAM_SELECT_FOR::TEAM_SELECT_FOR_KEY] )
                        &&
                        $parsArray[TEAM_SELECT_FOR::TEAM_SELECT_FOR_KEY] === TEAM_SELECT_FOR::ROLE
                ){

                        $vcParams[TEAM_SELECT_FOR::TEAM_SELECT_FOR_KEY] = TEAM_SELECT_FOR::ROLE;


                }

                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:new Layout().collectSelectedTeamGroupsAndDismissWithData();", NULL);

                $vc = new ViewController(
                        "Mannschaftzahl",
                        get_class($this),
                        "TableView",
                        "_team_groups",
                        "index",
                        $vcParams,
                        ACTIVITY::ACTIVITY_7,
                        VIEW_CONTROLLER::X2UINavigationBarBackgroundShow,
                        $rightBarButton->prepare()
                );

                return $vc->prepare();




        }

        private function redirectToLeagueViewController(){


                $vcParams = array();
                // $vcParams["uid"] = $userID;
                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:new Layout().collectSelectedTeamGroupsAndDismissWithData();", NULL);

                $vc = new ViewController(
                        "Spielklasse",
                        get_class($this),
                        "TableView",
                        "_leagues",
                        "index",
                        $vcParams,
                        ACTIVITY::ACTIVITY_7,
                        VIEW_CONTROLLER::X2UINavigationBarBackgroundShow,
                        $rightBarButton->prepare()
                );

                return $vc->prepare();




        }

        /**
         * This Function functionally over Javascript
         * Http Request
         * !!! Instead of function -> viewTeam !!!
         * Default DetailsViewController Data likely viewTeamData()
         * After selected Club replaced DetailsViewController Data likely so!
         * @return array
         */
        function dynamicTeamsDetailsViewControllerForSelectedClub()
        {


                // Remove All Teams Of Club if Already Selected
                // REPOSITORY::kills(REPOSITORY::USER_ROLES, $this->pars->user_used_role );


                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().collectSelectedTeamsAndDismissWithData();", NULL);

                $vcParams = array();
                if(!is_null($this->pars->club)):
                        $vcParams["club"] = $this->pars->club;
                endif;
                $vcParams[TEAM_SELECT_FOR::TEAM_SELECT_FOR_KEY] = TEAM_SELECT_FOR::ROLE;

                $viewController = new ViewController(
                        "Mannschaft",
                        "Verein " . $this->pars->clubName,
                        "TableView",
                        "_teams",
                        "index",
                        $vcParams,
                        ACTIVITY::ACTIVITY_6,
                        VIEW_CONTROLLER::X2UINavigationBarBackgroundShow,
                        $rightBarButton->prepare()
                );

                /**
                 * Array Response Data
                 * Converted and included via JS
                 * function JSON.stringify()
                 */
                return $viewController->prepare();


        }


}

namespace _team_groups;
use Controller;
use RightBarButton;
use ViewController;
use ACTIVITY;
use FETCH_STRUCTURE;
use VIEW_CONTROLLER;
use TEAM_SELECT_FOR;

class TableView extends Controller
{

        public function __construct($pars)
        {
                parent::__construct($pars);
        }


        public function index()
        {
                // Redirect either with viewController or input radio or checkbox
                $this->groupWithLeagues();
        }

        private function groupWithLeagues(){






                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "cells" => $this->cells()
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "index" );




        }


        function cells(){


                $teamGroups     = $this->public->getDFBTeamGroups();
                $cells          = array();
                $parsArray      = (array)$this->pars;

                
                if (count($teamGroups)) {
                        foreach ($teamGroups as $index => $teamGroup) {



                                if( !is_null( $parsArray[TEAM_SELECT_FOR::TEAM_SELECT_FOR_KEY] ) ){

                                        switch ( $parsArray[TEAM_SELECT_FOR::TEAM_SELECT_FOR_KEY] ){

                                                case TEAM_SELECT_FOR::ROLE;
                                                        $redirectViewController = $this->redirecttoLeagueViewController();
                                                        break;


                                                default:
                                                        $redirectViewController = null;
                                        }


                                }



                                $this->view->data = array(
                                        "pars"                  => $this->pars,
                                        "team_group"            => $teamGroup,
                                        "view_controller_data"  => $redirectViewController
                                );

                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                                array_push($cells,

                                        $this->view->fileContent(
                                                $this->getReflectedClass()->getShortName(),
                                                $this->getReflectedClass()->getNamespaceName() .
                                                DIRECTORY_SEPARATOR .
                                                "cell.php"
                                        )
                                );

                        }
                }

                return $cells;
        }


        private function redirecttoLeagueViewController(){

                $vcParams = array();
                // $vcParams["uid"] = $userID;
                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().collectSelectedLeagueAndDismissWithData();", NULL);

                $leaguesViewController = new ViewController(
                        "Spielklasse",
                        "Wähle bitte Spielklasse",
                        "TableView",
                        "_leagues",
                        "index",
                        $vcParams,
                        ACTIVITY::ACTIVITY_8,
                        VIEW_CONTROLLER::X2UINavigationBarBackgroundShow,
                        $rightBarButton->prepare()
                );

                return $leaguesViewController->prepare();


        }



}




namespace _season;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use REPOSITORY;
use Config;
use ACTIVITY;
class TableView extends Controller{

        public function __construct($pars)
        {
                parent::__construct($pars);
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }


        // Groups
        public function index()
        {
                // TODO: Implement index() method.

                #highlight_string(var_export($this->public->getSeasons(), true));

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "seasons"=> implode("",$this->cells())
                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


        }

        private function cells(){


                $seasons        = $this->public->getSeasons();
                $cells          = array();
                $parsArray      = (array)$this->pars;


                if (count($seasons)) {
                        foreach ($seasons as $index => $season) {

                                $this->view->data = array(
                                        "pars"          => $this->pars,
                                        "season"        => $season,
                                        "view_controller_data"  => null
                                );

                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                                array_push($cells,

                                        $this->view->fileContent(
                                                $this->getReflectedClass()->getShortName(),
                                                $this->getReflectedClass()->getNamespaceName() .
                                                DIRECTORY_SEPARATOR .
                                                "cell.php"
                                        )
                                );

                        }
                }

                return $cells;
        }





}

namespace _leagues;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use REPOSITORY;
use Config;
use ACTIVITY;
class TableView extends Controller{

        public function __construct($pars)
        {
                parent::__construct($pars);
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }


        // Groups
        public function index()
        {
                // TODO: Implement index() method.

                #highlight_string(var_export($this->public->getSeasons(), true));

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "leagues"       => $this->public->fetchLeagues(),
                        "row_type"      => $this->pars->row_type
                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


        }

        function fetchLeaguesById(){

                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();

        }


}

namespace _postcodes;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use REPOSITORY;
use Config;
use ACTIVITY;
class TableView extends Controller{

        public function __construct($pars)
        {
                parent::__construct($pars);
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }


        // Groups
        public function index()
        {
                // TODO: Implement index() method.

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        // "postcodes"=>$this->fetchPostCodes()
                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


        }


        function loadPostcodesWithPrettyCell(){

                $fetchedPostcodes = $this->fetchPostCodes();

                #highlight_string(var_export($fetchedPostcodes, true));
                $cells = array();

                if(count($fetchedPostcodes)){

                        foreach ($fetchedPostcodes as $index => $fetchedPostcode ) {


                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                                $this->view->data = array(
                                        "postcode" => $fetchedPostcode
                                );

                                $cell = $this->view->fileContent(
                                        $this->getReflectedClass()->getShortName(),
                                        $this->getReflectedClass()->getNamespaceName() .
                                        DIRECTORY_SEPARATOR .
                                        "cell.php");

                                array_push($cells, $cell);



                        }

                        return implode("", $cells);


                }

                return array();

        }


        public function fetchPostCodes(){
                return $this->public->fetchPostCodes();
        }

}

namespace _time_suggestion;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use REPOSITORY;
use Config;
use ACTIVITY;
class TableView extends Controller{

        public function __construct($pars)
        {
                parent::__construct($pars);
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }


        // Groups
        public function index()
        {
                // TODO: Implement index() method.

                $fetch_time_suggetions  = $this->public->fetchTimeSuggestions();

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "fetch_time_suggetions" => $fetch_time_suggetions,
                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


        }

}


/**
 * Umkreis
 */
namespace _environment;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use REPOSITORY;
use Config;
use ACTIVITY;
use RightBarButton;
use ViewController;
use VIEW_CONTROLLER;

class TableView extends Controller{

        public function __construct($pars)
        {
                parent::__construct($pars);
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }


        // Groups
        public function index()
        {
                // TODO: Implement index() method.

                #highlight_string(var_export(REPOSITORY::reads(REPOSITORY::CURRENT_ENVIRONMENT_DATA), true));
                
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "default_town"=>REPOSITORY::reads(REPOSITORY::CURRENT_ENVIRONMENT_DATA),
                        "postcodes_view_controller_data"        => $this->viewPostCodesTableViewData(),
                        "pars" => $this->pars
                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


        }

        private function viewPostCodesTableViewData(){

                $params = array("country_code"=>"DE");




                #highlight_string(var_export($this->pars, true));

                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().selectPostCodeAndUnwind();", NULL);


                // TeamRol Data
                $leagueViewController = new ViewController(
                        "Postleitzahl",
                        "",
                        "TableView",
                        "_postcodes",
                        "index",
                        array(), // Selected (If )
                        ACTIVITY::ACTIVITY_HELPER_3,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }


        function fetchEnvironmentData(){
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();
        }

}

namespace _place_covering;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use REPOSITORY;
use Config;
use ACTIVITY;

class TableView extends Controller{

        public function __construct($pars)
        {
                parent::__construct($pars);
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }


        // Groups
        public function index()
        {
                // TODO: Implement index() method.

                $fetch_place_coverings   = $this->public->fetchPlaceCovering();

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "place_coverings"  => $fetch_place_coverings,
                        "row_type" => $this->pars->row_type,
                        "place_covering_for"=>$this->pars->place_covering_for
                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


        }


        function fetchPlaceCovering(){

                $data = $this->public->{__FUNCTION__}();

                $_ids           = array();
                $_pretty_names  = array();

                if( count($this->pars->place_covering) ){
                        foreach ($this->pars->place_covering as $item) {
                                array_push($_ids, $data[$item]["id"]);
                                array_push($_pretty_names,$data[$item]["name"]);
                        }

                        #print_r($_pretty_names);
                        return array(
                                "ids"           => $_ids,
                                "pretty_names"  => $_pretty_names
                        );
                }

                return null;

        }


}

namespace _members;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use REPOSITORY;
use Config;
use ACTIVITY;

class TableView extends Controller{

        public function __construct($pars)
        {
                parent::__construct($pars);
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }


        // Groups
        public function index()
        {


        }


        function fetchMembersById(){

                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();

        }


}

namespace _clubs;
use Controller;
use FETCH_STRUCTURE;

class TableView extends Controller{

        public function __construct($pars)
        {
                parent::__construct($pars);
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }


        public function index(){


                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(

                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }


        function loadClubsWithPrettyCell(){

                $fetchedClubs = $this->fetchClubsByName();

                $foundedClubsByName = array();

                if(count($fetchedClubs)){

                        foreach ($fetchedClubs as $index => $fetchedClub ) {


                                $this->view->data = array(
                                        "fetched_club" => $fetchedClub,
                                        "row_type"=>"radio"
                                );

                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                                array_push($foundedClubsByName,$this->view->fileContent(
                                        $this->getReflectedClass()->getShortName(),
                                        $this->getReflectedClass()->getNamespaceName() .
                                        DIRECTORY_SEPARATOR .
                                        "cell.php") );

                                // echo $cell;

                        }

                        return implode("", $foundedClubsByName);


                }

                return NULL;

        }

        function fetchClubsByName(){


                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();

        }

        function fetchClubsById(){

                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();

        }

        /**
         * When user not found desired club in clubs list
         * than user can report this club to system
         * and system will search this club, with user added custom link
         * This operation need exactly url for outsource
         * and this outsource operation need target including script
         * with this method will return target runnableScript
         *
         */
        function fetchFileForClubSearchFromOutSource()
        {

                return array(
                        #"vereinsseite" => "http://www.fussball.de/verein/fv-1920-dudenhofen-suedwest/-/id/00ES8GNBB000002PVV0AG08LVUPGND5I", // preg_replace("/#!\//",'', trim($this->pars->url)) ,
                        "vereinsseite"   => preg_replace("/#!\//",'', trim($this->pars->url)) ,
                        "runnableScript" => "1345222.js"
                );

        }

        /**
         * Found outsourcing club data from Fußball.de with user
         * Add to database
         * @return array
         */
        function addFoundClubToDatabase()
        {
                unset($this->pars->output);

                if (count(array_keys((array)$this->pars))) {

                        $this->model->pars = $this->pars;
                        $data = $this->model->{__FUNCTION__}();

                        if ($data["resulta"] && $data["process"]) {

                                #$this->pars->club = $data["lastInsertId"];
                                #$club = $this->fetchDFBClubData();
                                return $data["lastInsertId"];
                        }

                        return array(
                                "resulta" => false,
                                "title" => "Prozess abgelehnt!",
                                "message" => "{$data["errMessage"]}\nSie können wählen nur aus der Liste!"
                        );

                } else {

                        return array(
                                "resulta" => false,
                                "title" => "Fehler aufgetreten!",
                                "message" => "No data posted!"
                        );

                }


        }


}

/**
 * Antronorlere a ati takimlar listesi
 * User Useing Roles
 * Source User_Using_Roles
 */
namespace _trainer_teams;
use Controller;
use _leagues\TableView as LeaguesTableView;
use _members\TableView as MembersTableView;
use _clubs\TableView as ClubsTableView;
use FETCH_STRUCTURE;
use REPOSITORY;

class TableView extends Controller{

        public function __construct($pars)
        {
                parent::__construct($pars);
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }


        // Groups
        public function index()
        {

                $cells = array();

                // Fetch Base Teams Data
                $trainersRoles = $this->public->fetchTrainerTeams();



                $requestableClubs       = array();
                $requestableTeams       = array();
                $requestableLeagues     = array();
                $requestableMembers     = array();


                // Prepare Query Local Model

                foreach ( $trainersRoles as $index => $trainersRole ) {

                        // Push Or Overwrite Club
                        $requestableClubs[$trainersRole["club_id"]] = $trainersRole["club_id"];


                        // Push Or Overwrite Members
                        $requestableMembers[$trainersRole["user_id"]] = $trainersRole["user_id"];


                        // Collect Query Id's for Team & League
                        if( !is_null($trainersRole["team"]) ){

                                $teams          = json_decode($trainersRole["team"]);
                                $teams_group    = json_decode($trainersRole["team_group"]); // No Need For Query
                                $leagues        = json_decode($trainersRole["team_league"]);

                                if( count($teams) ){

                                        for( $i=0; $i < count($teams); $i++){

                                                $requestableTeams[$teams[$i]]           = $teams[$i];
                                                $requestableLeagues[$leagues[$i]]       = $leagues[$i];

                                        }

                                }

                        }


                }

                $this->pars->requestableTeams           = $requestableTeams;
                $this->pars->requestableLeagues         = $requestableLeagues;
                $this->pars->requestableMembers         = $requestableMembers;

                // Fetch Teams
                $fetchedTeams   = $this->fetchTeamsById();

                //Fetch Leagues
                try {
                        $leagueTableViewController = new LeaguesTableView($this->pars);
                } catch (\ReflectionException $e) {
                }
                $fetchLeagues = $leagueTableViewController->fetchLeaguesById();


                // Fetch Members
                try {
                        $membersTableViewController = new MembersTableView($this->pars);
                } catch (\ReflectionException $e) {
                }
                $fetchMembers = $membersTableViewController->fetchMembersById();

                // Fetch Clubs
                try {
                        $clubsTableViewController = new ClubsTableView($this->pars);
                } catch (\ReflectionException $e) {
                }
                $fetchClubs = $clubsTableViewController->fetchClubsById();



                #highlight_string(var_export($fetchLeagues, true));
                #highlight_string(var_export($fetchedTeams, true));
                #highlight_string(var_export($fetchMembers, true));

                foreach ( $trainersRoles as $index => $trainersRole ) {

                        $t              = $trainersRole["team"];

                        if( !is_null($t) ){

                                $t        = json_decode($t);
                                $t_group  = json_decode($trainersRole["team_group"]);
                                $t_league = json_decode($trainersRole["team_league"]);

                                if( count($t) ){

                                        /*
                                         * Value Combination For Database
                                         * 1.Club
                                         * 2.Team
                                         * 3.Team Group
                                         * 4.League
                                         * 5.Team Owner
                                         */


                                        for( $i=0; $i < count($t); $i++){

                                                $this->view->data = array(
                                                        "user_role"=>$trainersRole,
                                                        "pars"  => $this->pars,
                                                        "club" => $fetchClubs[$trainersRole["club_id"]]["teamName2"],
                                                        "team" => $fetchedTeams[$t[$i]]["name"],
                                                        "team_group" => $t_group[$i],
                                                        "league" => $fetchLeagues[$t_league[$i]]["name"],
                                                        "owner" => $fetchMembers[$trainersRole["user_id"]]["pretty_name"],
                                                        "confirmed_via_club_logo"=>$trainersRole["confirmed_via_club_logo"],
                                                        "value_combination_for_database" =>implode(", ", array(
                                                                $trainersRole["club_id"],
                                                                $t[$i],
                                                                $t_group[$i],
                                                                $t_league[$i],
                                                                $trainersRole["user_id"]
                                                        ))
                                                );

                                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                                                array_push($cells,

                                                        $this->view->fileContent(
                                                                $this->getReflectedClass()->getShortName(),
                                                                $this->getReflectedClass()->getNamespaceName() .
                                                                DIRECTORY_SEPARATOR .
                                                                "cell.php"
                                                        )
                                                );


                                        }
                                }
                        }




                }

                        
                #highlight_string(var_export($this->pars, true));

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "pars"  => $this->pars,
                        "cells" => $cells
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__ );




        }


        function fetchClubsById(){

                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();

        }

        function fetchTeamsById(){
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();
        }


}

/**
 * team Card kullanicinin Direk Istek yapabilecegi kulb ler icin on hazirlik
 * Yani Alisveris sepeti bigi
 */
/**
 * Wating Class not sure
 * @deprecated
 * @use insted of Self Class
 */
namespace _team_card;
use Controller;
use FETCH_STRUCTURE;
use ACTIVITY;
use VIEW_CONTROLLER;
use RightBarButton;
use ViewController;

class TableView extends Controller{


        public function index()
        {

                $this->view->data = array(

                        "opponent_teams_view_controller" => $this->opponentTeamsViewController(),
                        "opponent_leagues_view_controller" => $this->leaguesViewController(),
                        "environment_view_controller" => $this->environmentViewController()

                );

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }

        private function opponentTeamsViewController(){




                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().collectSelectedTeamsAndDismissWithData();", NULL);


                // TeamRol Data
                $leagueViewController = new ViewController(
                        "Mannschaft",
                        "",
                        "TableView",
                        "_teams",
                        "index",
                        array(), // Selected (If )
                        ACTIVITY::ACTIVITY_6,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }

        private function leaguesViewController(){




                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().collectSelectedLeagueAndDismissWithData();", NULL);


                // TeamRol Data
                $leagueViewController = new ViewController(
                        "Mannschaft",
                        "",
                        "TableView",
                        "_leagues",
                        "index",
                        array("row_type"=>"checkbox"), // Selected (If )
                        ACTIVITY::ACTIVITY_6,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }


        private function environmentViewController(){




                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().selectEnvironmentAndUnwind();", NULL);


                // TeamRol Data
                $leagueViewController = new ViewController(
                        "Mannschaft",
                        "",
                        "TableView",
                        "_environment",
                        "index",
                        array(), // Selected (If )
                        ACTIVITY::ACTIVITY_6,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }


}

/**
 * Wating Class not sure
 */
namespace _trainers;
use Controller;
use FETCH_STRUCTURE;
use ACTIVITY;
use VIEW_CONTROLLER;
use RightBarButton;
use ViewController;
use REPOSITORY;

class TableView extends Controller{


        public function index()
        {

                // Fetch Trainers List from selected Teams




                $this->view->data = array(

                        "pars"  => $this->pars,
                        "cells" => implode("", $this->cells())

                );

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


        }


        private function cells(){

                
                #highlight_string(var_export($this->pars, true));

                $this->model->pars = $this->pars;
                $teamTrainers = $this->model->teamTrainers();

                $myId = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];

                #highlight_string(var_export($teamTrainers, true));
                $cells = array();

                if (count($teamTrainers)) {
                        foreach ($teamTrainers as $index => $teamTrainer) {

                                // highlight_string(var_export($teamTrainer, true));
                                $this->view->data = array(
                                        "my_id"         => $myId,
                                        "trainer"       => $teamTrainer,
                                        "row_type"      => "radio"
                                );

                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                                array_push($cells,

                                        $this->view->fileContent(
                                                $this->getReflectedClass()->getShortName(),
                                                $this->getReflectedClass()->getNamespaceName() .
                                                DIRECTORY_SEPARATOR .
                                                "cell.php"
                                        )
                                );

                        }
                }

                return $cells;
        }


}

/**
 * Wating Class not sure
 */
namespace _registered_teams;
use Controller;
use _leagues\TableView as LeaguesTableView;
use _members\TableView as MembersTableView;
use _clubs\TableView as ClubsTableView;
use FETCH_STRUCTURE;

class TableView extends Controller{

        public function __construct($pars)
        {
                parent::__construct($pars);
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }


        // Groups
        public function index()
        {

                $cells = array();

                // Fetch Base Teams Data
                $trainersRoles = $this->public->fetchTrainerTeams();

                #highlight_string(var_export($trainersRoles, true));

                $requestableClubs       = array();
                $requestableTeams       = array();
                $requestableLeagues     = array();
                $requestableMembers     = array();


                // Prepare Query Local Model

                foreach ( $trainersRoles as $index => $trainersRole ) {

                        // Push Or Overwrite Club
                        $requestableClubs[$trainersRole["club_id"]] = $trainersRole["club_id"];


                        // Push Or Overwrite Members
                        $requestableMembers[$trainersRole["user_id"]] = $trainersRole["user_id"];


                        // Collect Query Id's for Team & League
                        if( !is_null($trainersRole["team"]) ){

                                $teams          = json_decode($trainersRole["team"]);
                                $teams_group    = json_decode($trainersRole["team_group"]); // No Need For Query
                                $leagues        = json_decode($trainersRole["team_league"]);

                                if( count($teams) ){

                                        for( $i=0; $i < count($teams); $i++){

                                                $requestableTeams[$teams[$i]]           = $teams[$i];
                                                $requestableLeagues[$leagues[$i]]       = $leagues[$i];

                                        }

                                }

                        }


                }

                $this->pars->requestableTeams           = $requestableTeams;
                $this->pars->requestableLeagues         = $requestableLeagues;
                $this->pars->requestableMembers         = $requestableMembers;

                // Fetch Teams
                $fetchedTeams   = $this->fetchTeamsById();

                //Fetch Leagues
                try {
                        $leagueTableViewController = new LeaguesTableView($this->pars);
                } catch (\ReflectionException $e) {
                }
                $fetchLeagues = $leagueTableViewController->fetchLeaguesById();


                // Fetch Members
                try {
                        $membersTableViewController = new MembersTableView($this->pars);
                } catch (\ReflectionException $e) {
                }
                $fetchMembers = $membersTableViewController->fetchMembersById();

                // Fetch Clubs
                try {
                        $clubsTableViewController = new ClubsTableView($this->pars);
                } catch (\ReflectionException $e) {
                }
                $fetchClubs = $clubsTableViewController->fetchClubsById();



                $registerd_teams = array();

                foreach ( $trainersRoles as $index => $trainersRole ) {

                        $t              = $trainersRole["team"];

                        if( !is_null($t) ){

                                $t        = json_decode($t);
                                $t_group  = json_decode($trainersRole["team_group"]);
                                $t_league = json_decode($trainersRole["team_league"]);

                                if( count($t) ){

                                        /*
                                         * Value Combination For Database
                                         * 1.Club
                                         * 2.Team
                                         * 3.Team Group
                                         * 4.League
                                         * 5.Team Owner
                                         */


                                        for( $i=0; $i < count($t); $i++){

                                                $this->view->data = array(
                                                        "user_role"=>$trainersRole,
                                                        "pars"  => $this->pars,
                                                        "club" => $fetchClubs[$trainersRole["club_id"]]["teamName2"],
                                                        "team" => $fetchedTeams[$t[$i]]["name"],
                                                        "team_group" => $t_group[$i],
                                                        "league" => $fetchLeagues[$t_league[$i]]["name"],
                                                        "owner" => $fetchMembers[$trainersRole["user_id"]]["pretty_name"],
                                                        "confirmed_via_club_logo"=>$trainersRole["confirmed_via_club_logo"],
                                                        "value_combination_for_database" =>implode(", ", array(
                                                                $trainersRole["club_id"],
                                                                $t[$i],
                                                                $t_group[$i],
                                                                $t_league[$i],
                                                                $trainersRole["user_id"]
                                                        ))
                                                );

                                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                                                array_push($cells,

                                                        $this->view->fileContent(
                                                                $this->getReflectedClass()->getShortName(),
                                                                $this->getReflectedClass()->getNamespaceName() .
                                                                DIRECTORY_SEPARATOR .
                                                                "cell.php"
                                                        )
                                                );


                                        }
                                }
                        }




                }


                #highlight_string(var_export($this->pars, true));

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "pars"  => $this->pars,
                        "cells" => $cells
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__ );




        }


        function fetchClubsById(){

                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();

        }

        function fetchTeamsById(){
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();
        }


}

/**
 * Class After Filtered Teams operation
 */
namespace _filtered_teams_card;
use Controller;
use FETCH_STRUCTURE;
use ACTIVITY;
use VIEW_CONTROLLER;
use RightBarButton;
use ViewController;
use REPOSITORY;

class TableView extends Controller{

        public function __construct($pars)
        {
                parent::__construct($pars);
        }


        public function index()
        {

                
                $this->pars = REPOSITORY::reads(REPOSITORY::CURRENT_FILTER_FOR_CARD_TEAMS);
                
                #highlight_string(var_export($this->pars, true));

                $this->view->data = array(

                        // "trainers_view_controller" => $this->trainersViewController(),
                        "result_filtered_teams" => $this->loadFilteredTeamsWithPrettyCell()

                );

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);

        }

        function loadFilteredTeamsWithPrettyCell(){


                try{
                        $fetchedTeams             = $this->public->getDFBClubTeams();
                        $fetchedLeaguesGroups     = $this->public->getDFBLeagueGroups();
                        

                        $this->pars = (object) $this->pars;


                        if( !is_null($this->pars->environment_area_id) ){

                                $environment_area = $this->getEnvironmentAreaById();

                                $ZC = \Zip_Codes::getInstance();

                                $result = $ZC->getEnvironmentAreasWithPostCode(array($environment_area["zc_zip"]),$this->pars->environment_area_km);

                                #highlight_string(var_export($result->array, true));
                                $this->pars->environment_zip = $result->array;

                        }


                        $clubsWithRole                  = $this->fetchedTeamsFromUsingTrainerRoles();
                        $filteredTeamsWithPrettyCell    = array();

                        #highlight_string(var_export($clubsWithRole, true));


                        if(count($clubsWithRole)){

                                foreach ( $clubsWithRole as $index => $clubWithRole ) {


                                        if( count($clubWithRole) ){

                                                foreach ( $clubWithRole as $index2 => $role ) {


                                                        #highlight_string(var_export($role, true));



                                                        $teamsInClub                    = json_decode($role["team"]);
                                                        $teamGroupInTeam                = json_decode($role["team_group"]);
                                                        $teamsLeagueInClub              = json_decode($role["team_league"]);
                                                        $formattedTeamWithLeague        = array();

                                                        #highlight_string(var_export($teamsInClub, true));

                                                        if( count($teamsInClub) ){


                                                                for( $i=0; $i < count($teamsInClub); $i++ ){

                                                                        #echo "League Matching:" . $teamsLeagueInClub[$i] . "  " . $this->pars->selected_league . ", Team Matching:" . $teamsInClub[$i] . "  " . json_encode($this->pars->team) . "</br>";

                                                                        if(
                                                                                in_array( $teamsLeagueInClub[$i], json_decode($this->pars->selected_league) )
                                                                                &&
                                                                                in_array( $teamsInClub[$i], $this->pars->team )

                                                                        ){




                                                                                #echo "<br />LeagueID:" . $fetchedLeaguesGroups[$teamsLeagueInClub[$i]]["name"] . "<br />";

                                                                                $formattedTeamWithLeague[ $teamsInClub[$i] . "_" . $teamsLeagueInClub[$i]] =
                                                                                        array(
                                                                                                "pretty_club_name"      => $role["pretty_club_name"],
                                                                                                "pretty_team_name"      => $fetchedTeams[$teamsInClub[$i]]["name"],
                                                                                                "pretty_team_group_name"=> $teamGroupInTeam[$i],
                                                                                                "pretty_league_name"    => $fetchedLeaguesGroups[$teamsLeagueInClub[$i]]["name"],
                                                                                                "club_id"               => $index,
                                                                                                "team_id"               => $teamsInClub[$i],
                                                                                                //"team_group_id"         => $teamGroupInTeam[$i],
                                                                                                "league_id"             => $teamsLeagueInClub[$i],
                                                                                                "role_id"               => $index2
                                                                                        );

                                                                        }



                                                                }
                                                        }

                                                        
                                                        

                                                        /*highlight_string(var_export($formattedTeamWithLeague, true));


                                                        */

                                                }
                                        }
                                }
                                
                                #highlight_string(var_export($formattedTeamWithLeague, true));


                                if( count($formattedTeamWithLeague) ){


                                        foreach ($formattedTeamWithLeague as $index => $item) {


                                                $this->view->data = array(
                                                        "fetched_team"          => $item,
                                                        "view_controller_data"  => $this->trainersViewController($item["club_id"], $item["team_id"])
                                                );

                                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT );

                                                array_push($filteredTeamsWithPrettyCell,$this->view->fileContent(
                                                        $this->getReflectedClass()->getShortName(),
                                                        $this->getReflectedClass()->getNamespaceName() .
                                                        DIRECTORY_SEPARATOR .
                                                        "cell.php") );


                                        }

                                }


                                return implode("", $filteredTeamsWithPrettyCell);


                        }



                        #highlight_string(var_export($fetchedTeamsFromUsingTrainerRoles, true));



                        

                } catch (\PDOException $exc){

                        echo $exc->getMessage();

                }



                return NULL;

        }

        private function fetchedTeamsFromUsingTrainerRoles(){


                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();

        }

        private function fetchedTeamsFromUsingTrainerRolesAll(){


                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();

        }


        private function trainersViewController( $club_id, $team_id ){




                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().selectTrainerAndDismissWithData();", NULL);


                // TeamRol Data
                $leagueViewController = new ViewController(
                        "Trainer",
                        "Wähle bitte Mannschaft Trainer",
                        "TableView",
                        "_trainers",
                        "index",
                        array("club_id"=>$club_id, "team_id"=>$team_id),
                        ACTIVITY::ACTIVITY_HELPER_3,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }

        private function getEnvironmentAreaById(){

               $this->model->pars = $this->pars;
               return $this->model->{__FUNCTION__}();


        }


}