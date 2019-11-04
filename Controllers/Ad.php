<?php /** @noinspection SpellCheckingInspection */

/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 2019-05-24
 * Time: 09:48
 * Ilanlar Class'i
 */

namespace ads;
use Controller;
use FETCH_STRUCTURE;
use REPOSITORY;
use RightBarButton;
use ViewController;
use ACTIVITY;
use VIEW_CONTROLLER;
use APP_ICON;
use INQUIRY_TYPE;
use TeamsCard as TEAMS_CARD;


class Ad extends Controller
{
        var $INQUIRY_TYPE = INQUIRY_TYPE::INQUIRY_PUBLIC;

        public function __construct($pars)
        {
                parent::__construct($pars);
        }


        public function index()
        {
                
                #highlight_string(var_export($this->fetchOwnerTotalPublicAds(), true));

                // TODO: Implement index() method.
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                $this->view->data = array(
                        "my_ads_view_controller_data_private"           => $this->ViewAdsViewController(INQUIRY_TYPE::INQUIRY_TARGET, null, "Meine private Anzeige"),
                        "my_ads_view_controller_data_public"            => $this->ViewAdsViewController(INQUIRY_TYPE::INQUIRY_PUBLIC, null, "Meine öffentliche Anzeige"),
                        "ads_search_view_controller_data"               => $this->viewAdSeachViewControllerData(),
                        "totals"                                        => array(
                                "private"       => $this->fetchOwnerTotalPrivateAds(),
                                "public"        => $this->fetchOwnerTotalPublicAds(),
                        )
                );


                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__ );


        }

        private function fetchOwnerTotalPrivateAds(){
                $this->pars->my_id = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();
        }

        private function fetchOwnerTotalPublicAds(){
                $this->pars->my_id = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();
        }


        public function myAds(){


                $parsArray = (array) $this->pars;

                // Look $INQUIRY_TYPE !!!!
                $this->INQUIRY_TYPE = $parsArray[INQUIRY_TYPE::INQUIRY_TYPE_KEY];


                $this->view->data = array(
                        "my_ads"=> $this->myAdsPrettyCustomCell(),
                        "ad_id"=>$this->pars->ad_id/*If request from Public Ad list*/
                );

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "my_ads" );



        }


        function fetchMyAds(){

                $this->pars->ad_owner   = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];
                $this->pars->my_id      = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();

        }


        function fetchMyAdsPrivate(){

                /**
                 * Deprecated
                 * Parameter use instead of my_id
                 */
                $this->pars->ad_owner   = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];

                $this->pars->my_id      = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();

        }


        /**
         * @return array|null
         * @deprecated
         * @use insted of myAdsPrettyCustomCell
         */
        private function collectedMyAdsArrayData()
        {

                $myAds          = $this->fetchMyAds();
                $finalMyAds     = array();


                if ( count( $myAds ) ){
                        foreach ( $myAds as $index => $myAd ) {
                                $myAd["view_controller"] = $this->adManageViewControllerData($index, false);
                                array_push($finalMyAds, $myAd);
                        }

                        return $finalMyAds;
                }

                return null;

        }


        private function myAdsPrettyCustomCell(){



                if( $this->INQUIRY_TYPE === INQUIRY_TYPE::INQUIRY_PUBLIC ){
                        $myAds          = $this->fetchMyAds();
                } else {
                        $myAds          = $this->fetchMyAdsPrivate();
                }

                $finalMyAds     = array();
                $fetchedTeams             = $this->public->getDFBClubTeams();
                $fetchedLeagues           = $this->public->fetchLeagues();

                #highlight_string(var_export($fetchedLeagues, true));
                #highlight_string(var_export($this->pars, true));

                if ( count( $myAds ) ){
                        foreach ( $myAds as $index => $myAd ) {


                                #highlight_string(var_export($myAd, true));
                                // echo $index;

                                $team_suggestion        = array_unique( json_decode($myAd["ad_opponent_teams_suggestion"]) );
                                $league_suggestion      = array_unique( json_decode($myAd["ad_opponent_leagues_suggestion"]) );

                                $new_pretty_teams_name          = array();
                                $new_pretty_leagues_name        = array();

                                foreach ( $team_suggestion as $item ) {
                                       array_push($new_pretty_teams_name, $fetchedTeams[$item]["name"]);
                                }

                                foreach ( $league_suggestion as $item ) {
                                        array_push($new_pretty_leagues_name, $fetchedLeagues[$item]["name"]);
                                }


                                // DETAILS VIEW CONTROLLER FOR AD
                                if( $this->INQUIRY_TYPE === INQUIRY_TYPE::INQUIRY_PUBLIC ){

                                        /**
                                         * TO List Private Ad, while this Ad is pulic
                                         * Public Ads details cannot be direkt Details of Ad rather
                                         * Can be Interedsed list, likely Private Ad list ( Direct to this list )
                                         *
                                         */

                                        $detailsViewController = $this->ViewAdsViewController(INQUIRY_TYPE::INQUIRY_TARGET, $index, "Interresierte Mietglied" );
                                } else {
                                        $detailsViewController = $this->adDiscussionViewController($myAd);
                                }



                                // Additional Data
                                $myAd["teams_suggestion"]       = implode(",", $new_pretty_teams_name);
                                $myAd["league_suggestion"]      = implode(",", $new_pretty_leagues_name);


                                #highlight_string(var_export($myAd, true));
                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                                $this->view->data = array(
                                        "details_view_controller"       => $detailsViewController,
                                        "cell_name"                     => $myAd["ad_group"],
                                        "ad_id"                         => $index,
                                        "ad_partners_id"                => $myAd["ad_partners_id"],
                                        "ad_details"                    => $myAd
                                );


                                #echo "INQUIRY_TYPE:" . $this->INQUIRY_TYPE;

                                $cellFile = "testplay_target_cell.php";
                                if( $this->INQUIRY_TYPE === INQUIRY_TYPE::INQUIRY_PUBLIC ){
                                        $cellFile = "testplay_public_cell.php";
                                }

                                #echo $cellFile;


                                $pretty_ad_cell = $this->view->fileContent( $this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . $cellFile );


                                array_push($finalMyAds, $pretty_ad_cell);




                        }

                        return implode("", $finalMyAds);
                }

                return null;


        }


        /**
         * If user Updated Private Ad
         * With unwind update Private Ad Table View Target cell
         */
        function updatedPrivateAdCellViaUser(){

                $ad_data = $this->pars->ad_data;

                $detailsViewController = $this->adDiscussionViewController($ad_data );



                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "details_view_controller"       => $detailsViewController,
                        "cell_name"                     => $ad_data["ad_group"],
                        "ad_id"                         => $ad_data["id"],
                        "ad_partners_id"                => $ad_data["ad_partners_id"],
                        "ad_details"                    => $ad_data
                );

                return array(
                        "ad_id" => $ad_data["id"],
                        "cell"  => $this->view->fileContent( $this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "testplay_target_cell.php" ),
                        "ad_data" => $ad_data
                );


        }






        private function ViewAdsViewController( $inquiry_type = INQUIRY_TYPE::INQUIRY_PUBLIC, $adId = NULL, $title = "Anzeige"  ){

                /**
                 * for + or edit button adId is ad new or for edit
                 */

                $rightBarButton = new RightBarButton("Ok", APP_ICON::ICON_ADD, "javascript:Layout().addNewAd('" . json_encode($this->adManageViewControllerData( $inquiry_type, NULL )). "');", NULL);


                // TeamRol Data
                $leagueViewController = new ViewController(
                        $title,
                        $title,
                        "Ad",
                        "ads",
                        "myAds",
                        array(INQUIRY_TYPE::INQUIRY_TYPE_KEY=>$inquiry_type, "ad_id"=>$adId /* Need converting from Public to Private */),
                        ($inquiry_type === INQUIRY_TYPE::INQUIRY_PUBLIC ? ACTIVITY::ACTIVITY_3:ACTIVITY::ACTIVITY_8),
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        is_null($adId) ? $rightBarButton->prepare():NULL
                );

                return $leagueViewController->prepare();
        }



        private function viewAdSeachViewControllerData(){

                /**
                 * for + or edit button adId is ad new or for edit
                 */
                $rightBarButton = new RightBarButton("filter", APP_ICON::ICON_FILTER, "javascript:Layout().addNewAd('" . json_encode($this->viewAdSeachFilterViewControllerData()). "');", NULL);


                // TeamRol Data
                $leagueViewController = new ViewController(
                        "Anzeige Suche",
                        "Öffentliche Anzeige",
                        "Ad",
                        "search",
                        "index",
                        array(),
                        ACTIVITY::ACTIVITY_4,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }

        private function viewAdSeachFilterViewControllerData(){

                /**
                 * for + or edit button adId is ad new or for edit
                 */
                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().unwindWithFilteredDataForAdSearch();", NULL);


                // TeamRol Data
                $leagueViewController = new ViewController(
                        "Filter",
                        "",
                        "Ad",
                        "search",
                        "filterView",
                        array(),
                        ACTIVITY::ACTIVITY_5,
                        NULL,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }

        private function adManageViewControllerData( $inquiry_type = INQUIRY_TYPE::INQUIRY_PUBLIC, $adId = null ){

                $rightBarButton = new RightBarButton("Speichern", APP_ICON::ICON_SAVE, "javascript:Layout().collectAdDataAndAddToDatabase();", NULL);

                $myData = array();

                // Determine INQUIRY_TYPE;
                $myData[INQUIRY_TYPE::INQUIRY_TYPE_KEY] = $inquiry_type;
                $myData["ad_id"]                        = $adId;
                $title = !is_null($adId) ? "Bearbeiten" : "Neu Anzeige";
                $sTitle = ($inquiry_type === INQUIRY_TYPE::INQUIRY_PUBLIC ? "Öffentlische" : "Direkt" );


                // TeamRol Data
                $leagueViewController = new ViewController(
                        $title,
                        $sTitle,
                        "Ad",
                        "testplay",
                        "manage",
                        $myData,
                        ACTIVITY::ACTIVITY_10,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }



        private function adDiscussionViewController($ad_data){

                #highlight_string(var_export($ad_data, true));;

                // $rightBarButton = new RightBarButton("Bearbeiten", APP_ICON::ICON_EDIT, "javascript:Layout().adEdit();", NULL);
                $rightBarButton = new RightBarButton("Bearbeiten", APP_ICON::ICON_EDIT, "javascript:Layout().addNewAd('" . json_encode($this->adManageViewControllerData( INQUIRY_TYPE::INQUIRY_TARGET, $ad_data["ad_partners_id"] )). "');", NULL);

                $myData = array("ad_partners_id"=>$ad_data["ad_partners_id"]);


                // TeamRol Data
                $leagueViewController = new ViewController(
                        $ad_data["ad_group"],
                        $ad_data["pretty_ad_date"] . " " . $ad_data["pretty_ad_time"],
                        "Ad",
                        "discussion",
                        "index",
                        $myData,
                        ACTIVITY::ACTIVITY_9,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();



        }


        function getAdViewControllerData(){

                return $this->adManageViewControllerData( INQUIRY_TYPE::INQUIRY_TARGET, false );

        }


        function userInterestedTheAd(){

                \Config::DB_Password;
                $this->pars->current_selected_ad = REPOSITORY::reads(REPOSITORY::CURRENT_SELECTED_AD_FROM_SEARCH);
                $this->pars->interested_id = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];

                $this->model->pars = $this->pars;
                $data = $this->model->{__FUNCTION__}();

                return array(
                        "resulta"=>$data->resulta,
                        "process"=>$data->process,
                        "errCode"=>$data->errCode,
                        "errInfo"=>$data->errInfo,
                        "ad_id"  => $this->pars->current_selected_ad["id"]
                );

        }





}

namespace testplay;
use Cmfcmf\OpenWeatherMap\Exception;
use Controller;
use FETCH_STRUCTURE;
use manage\Role as RoleManage;
use REGISTER_ROLE;
use ADS_GROUPS;
use ViewController;
use ACTIVITY;
use VIEW_CONTROLLER;
use RightBarButton;
use AD_SUGGETION;
use REPOSITORY;
use APP_ICON;
use INQUIRY_TYPE;
use LISTING_TEAMS;
use ads\Ad as ADS_AD;
use TeamsCard AS TEAMS_CARD;

class Ad extends Controller
{

        // var $INQUIRY_TYPE = INQUIRY_TYPE::INQUIRY_TARGET;
        var $INQUIRY_TYPE = INQUIRY_TYPE::INQUIRY_PUBLIC;

        public function __construct($pars)
        {
                parent::__construct($pars);
        }


        public function index()
        {
                // TODO: Implement index() method.

                $this->view->data = array(

                        "add_ad_view_controller_data"    => $this->ViewAdsViewController(),
                );

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__ );


        }


        public function manage()
        {
                $parsArray = (array) $this->pars;

                
                #highlight_string(var_export($parsArray, true));
                
                /**
                 * Return the data from Database
                 */
                $createdAdData = array();

                // Look $INQUIRY_TYPE !!!!
                $this->INQUIRY_TYPE     = $parsArray[INQUIRY_TYPE::INQUIRY_TYPE_KEY];
                
                $is_editable            = true;
                /**
                 * Public if min 1 person interested not more editable,
                 * editable only with private from Public Ad
                 */
                if( $this->pars->inquiry_type === INQUIRY_TYPE::INQUIRY_TARGET /* REPALACE PUBLIC */ ){

                        if( !is_null($parsArray["ad_id"]) ){
                                $createdAdData = $this->fetchPrivateCreatedAdById();
                                $createdAdData["place_covering_data"] = $this->public->fetchPlaceCovering();
                        }

                }

                else if( $this->pars->inquiry_type === INQUIRY_TYPE::INQUIRY_PUBLIC ){

                        $interestedCount = 0;
                        if( !is_null($this->pars->ad_id) ){
                                // Live Tracker for Public Ad
                                $interestedCount = 1;
                        }



                        if( $interestedCount > 0 ){
                                $is_editable = false;
                        }

                        if( !is_null($parsArray["ad_id"]) ){
                                $createdAdData = $this->fetchPrivateCreatedAdById();
                                $createdAdData["place_covering_data"] = $this->public->fetchPlaceCovering();
                        }

                }






                #highlight_string(var_export($parsArray, true));

                // Kill Ad Data id is new
                $this->pars->mode = "edit";
                if( !is_null($this->pars->new_ad) && $this->pars->new_ad ){
                        REPOSITORY::kill(REPOSITORY::CURRENT_AD_DISCUSSION_DATA);
                        $this->pars->mode = "new";
                }
                // RESET ALREADY ITEMS IN REPOSITORY
                REPOSITORY::kill(REPOSITORY::CURRENT_FILTER_FOR_CARD_TEAMS);
                REPOSITORY::kill(REPOSITORY::CURRENT_APPENDED_CARD_TEAMS);

                

                // TODO: Implement index() method.

                $error                  = false;
                $error_message          = "";
                $user_used_roles        = $this->fetchUserUsedRoles();
                $fetchDFBClubTeams      = $this->public->getDFBClubTeams();
                $fetchDFBTeamLeagues    = $this->public->getDFBLeagueGroups();

                $availability_clubs_with_teams  = array();
                $leagues_view_controller_data   = array(); // Spielklasse
                $desired_opponent_team          = array(); // Spielklasse

                #highlight_string(var_export($user_used_roles, true));
                
                if( !count($user_used_roles) ){

                     $error = !$error;
                     $error_message = "Barrierefreiheit nur für autorisierte nutzer!";
                }

                else {

                        foreach ($user_used_roles as $index => $user_used_role) {

                                $club_teams = $user_used_role["team"];
                                $club_teams = json_decode($club_teams);

                                $club_teams_group = $user_used_role["team_group"];
                                $club_teams_group = json_decode($club_teams_group);

                                $teams_leagues = $user_used_role["team_league"];
                                $teams_leagues = json_decode($teams_leagues);

                                if( count($club_teams) ){

                                        for( $i=0; $i< count($club_teams); $i++)
                                        {
                                                array_push($availability_clubs_with_teams, array(
                                                        $user_used_role["pretty_club_name"] . " > " . $fetchDFBClubTeams[$club_teams[$i]]["name"],
                                                        array($user_used_role["club_id"], $club_teams[$i], $club_teams_group[$i], $teams_leagues[$i] ),
                                                ));
                                        }

                                }
                        }

                        if( !count($availability_clubs_with_teams) ){
                                $error = !$error;
                                $error_message = "Die Rolle, was Sie benutzen, leider mit keinem Mannschaft verbunden!";
                        }

                        else {


                                $leagues_view_controller_data   = $this->viewLeaguesTableViewData();

                                // echo "INQUIRY_TYPE:" . $this->INQUIRY_TYPE;

                                switch ($this->INQUIRY_TYPE){

                                        case INQUIRY_TYPE::INQUIRY_PUBLIC:
                                                $teams_view_controller_data     = $this->viewTeamsTableViewDataForPublic();
                                                break;

                                        case INQUIRY_TYPE::INQUIRY_TARGET:
                                                $teams_view_controller_data     = $this->viewTeamsTableViewDataForTarget();
                                                break;
                                }

                        }




                }




                // ALERT
                // Preare data for created ad for Opponent team
                if( !is_null($parsArray["ad_id"]) ){

                        include "Controllers/TeamsCard.php";
                        include "Models/TeamsCard_Model.php";
                        try {
                                $teamsCard = new TEAMS_CARD($this->pars);

                                $createdAdData["trainer_id"] = $createdAdData["person_id"];
                                $pretty_opponent_teams_sub_title_content = $teamsCard->createdAdOpponentTeamPrettyContentForSubTitleForCell(array("UNKNOWN_KEY"=>$createdAdData));

                                $createdAdData["opponent_team_sub_title_for_cell"] = $pretty_opponent_teams_sub_title_content;

                        } catch (\ReflectionException $e) {
                        }

                }


                #highlight_string(var_export($opponentTeamSubTitleFull, true));



                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(

                        "availability_clubs_with_teams"       => $availability_clubs_with_teams,
                        "club_teams_pool"       => $fetchDFBClubTeams,
                        "error"                 => $error,
                        "error_message"         => $error_message,
                        "leagues_view_controller_data"  => $leagues_view_controller_data,
                        "teams_view_controller_data"    => $teams_view_controller_data,


                        "playtime_view_controller_data"                 => $this->viewPlayTimeViewControllerData(),
                        "environment_view_controller_data"              => $this->viewEnvironmentViewControllerData(),
                        "place_covering_local_view_controller_data"     => $this->viewPlaceCoveringLocalViewControllerData(),
                        "place_covering_outwards_view_controller_data"  => $this->viewPlaceCoveringOutwardsViewControllerData(),

                        "inquiry_type" => $this->INQUIRY_TYPE,
                        "mode" => $this->pars->mode,
                        
                        "is_editable"=>$is_editable,

                        'crated_ad_from_database' =>$createdAdData
                );


                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__ );


        }

        function ownerAvailabilityTamsForAd(){







        }




        function fetchPublicCreatedAdById(){
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();
        }

        function fetchPrivateCreatedAdById(){

                // Find the ad partners ID
                /**
                 * Deprecated Parameter use instead of my_id
                 */
                $this->pars->ad_owner           = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];

                $this->pars->my_id              = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];
                $this->pars->ad_partners_id     = $this->pars->ad_id;
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();
        }







        /**
         * Fetch User roles
         */

        public function fetchUserUsedRoles(){


                try {

                        include 'Controllers/Role.php';
                        include 'Models/Role_Model.php';
                        $this->pars->role_id = json_decode($this->availabilityRoles()["accessibility_role"]);
                        $role = new RoleManage($this->pars);

                        $data = $role->{__FUNCTION__}();

                        return $data;


                } catch (\ReflectionException $e) {
                }

                return null;

        }

        /**
         * User have a availability for this As (Ilan)
         */
        private function availabilityRoles(){

                // Get Ad Group
                $this->pars->ad_group_id = ADS_GROUPS::ADS_FRIENDSHIP_GAMES;
                $this->model->pars = $this->pars;
                return $this->model->fetchAdGroup();

        }


        private function viewLeaguesTableViewData(){

                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().collectSelectedLeagueAndDismissWithData();", NULL);


                // TeamRol Data
                $leagueViewController = new ViewController(
                        "Spilklasse ",
                        "Wähle Gegner Spielklasse",
                        "TableView",
                        "_leagues",
                        "index",
                        array("row_type"=>"checkbox"), // Selected (If )
                        ACTIVITY::ACTIVITY_HELPER_1,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }

        /**
         * The Teams from Teams Pool Anonym
         * @param int $inquiry_type
         * @return array
         */
        private function viewTeamsTableViewDataForTarget(){

                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().collectSelectedTeamsForCardAndDismissWithData();", NULL);


                // TeamRol Data
                $leagueViewController = new ViewController(
                        "Mansschaft",
                        "Wähle Gegner Mannschaft",
                        "TeamsCard",
                        "!", // team card ile istene takilarin paket
                        "index",
                        array(),
                        ACTIVITY::ACTIVITY_HELPER_1,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }

        /**
         * The Teams from Teams Pool Anonym
         * @param int $inquiry_type
         * @return array
         */
        private function viewTeamsTableViewDataForPublic( $inquiry_type = INQUIRY_TYPE::INQUIRY_PUBLIC /** This operation decide Team Table Single or Multiple selecting */ ){


                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().collectSelectedTeamsAndDismissWithData();", NULL);

                // TeamRol Data
                $leagueViewController = new ViewController(
                        "Mannschaft",
                        "",
                        "TableView",
                        "_teams",
                        "index",
                        array(),
                        ACTIVITY::ACTIVITY_HELPER_1,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();

        }

        private function viewPlayTimeViewControllerData(){

                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:new Layout().setTimeSuggestionAndUnwind();", NULL);


                // TeamRol Data
                $leagueViewController = new ViewController(
                        "Spielbeginn",
                        "Wähle deine möglichkeit",
                        "TableView",
                        "_time_suggestion",
                        "index",
                        array(),
                        ACTIVITY::ACTIVITY_HELPER_1,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }

        private function viewEnvironmentViewControllerData(){

                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:new Layout().selectEnvironmentAndUnwind();", NULL);

                $param = array();
                if(count($this->pars)){
                        foreach ($this->pars as $index => $par) {
                                $param[$index]=$par;
                        }
                }

                #$param = array();

                #print_r($param);

                // $param =  !is_null($this->pars->club_id) ? array("postcode"=>$this->pars->postcode) : array();

                // ronment/index/?club_id=7&output=json&postcode_id=5&pretty_postcode_name=234556
                // TeamRol Data
                $leagueViewController = new ViewController(
                        "Umkreis",
                        "Entscheide umkreis",
                        "TableView",
                        "_environment",
                        "index",
                        array("club_id"=>$this->pars->club_id,"postcode_id"=>$this->pars->postcode_id,"pretty_postcode_name"=>$this->pars->pretty_postcode_name ),
                        ACTIVITY::ACTIVITY_HELPER_1,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }


        private function viewPlaceCoveringLocalViewControllerData(){
                $this->pars->place_covering_for = "place_covering_local";
                $this->pars->view_sub_title = "Nur eine art möglich!";
                return $this->viewPlaceCoveringViewControllerData();
        }

        private function viewPlaceCoveringOutwardsViewControllerData(){
                $this->pars->place_covering_for = "place_covering_outwards";
                $this->pars->view_sub_title = "Mehrere art möglich!";
                return $this->viewPlaceCoveringViewControllerData("checkbox");
        }

        /**
         * FieldCovering
         * @return array
         */
        private function viewPlaceCoveringViewControllerData( $selectableFor = "radio" ){

                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:new Layout().selectPlaceCoveringAndUnwind();", NULL);

                // TeamRol Data
                $leagueViewController = new ViewController(
                        "Spielfeldbelag",
                        (!is_null($this->pars->view_sub_title) ? $this->pars->view_sub_title : ""),
                        "TableView",
                        "_place_covering",
                        "index",
                        array("row_type"=>$selectableFor, "place_covering_for"=>$this->pars->place_covering_for),
                        ACTIVITY::ACTIVITY_HELPER_1,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }

        /**
         * @return array
         * Httprequest Javascript
         */
        function fetchLocalClubsWithDataOfClubTown(){


                #echo $this->pars->club_id;
                if(!intval($this->pars->club_id)){
                        return null;
                }


                $fetchedLocalClubs = $this->public->fetchLocalClubs();

                $output = array(
                        "club_street"=>""
                );

                if(!is_null($fetchedLocalClubs)){

                        $localClub = array_shift($fetchedLocalClubs);

                        $this->pars->postcode_id                = $localClub["post_code_id"];

                        // ADD TO REPOSITORY THE SELECTED MY CLUB LOCATION DATA FOR AD (ILAN)
                        REPOSITORY::writes(REPOSITORY::CURRENT_ENVIRONMENT_DATA, $localClub);


                        $output["club_street"] = $localClub["street"];


                        // return array( "club_street"=> $localClub["street"] , "environment_view_controller_data" => json_encode($envirenmentViewControllerData) );

                }

                $envirenmentViewControllerData                  = $this->viewEnvironmentViewControllerData();
                $output["environment_view_controller_data"]     = json_encode($envirenmentViewControllerData);

                return $output;


        }



        private function ViewAdsViewController(){

                $rightBarButton = new RightBarButton("Ok", APP_ICON::ICON_ADD, "javascript:alert('Add new Ad');", NULL);


                // TeamRol Data
                $leagueViewController = new ViewController(
                        "Meine Anzeige",
                        "",
                        "Ad",
                        "ads",
                        "myAds",
                        array(),
                        ACTIVITY::ACTIVITY_4,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }




        /**
         * User Selected Pure Teams
         * not connected dfb
         */
        function selectedTeams()
        {

                $dataTeams = $this->public->getDFBClubTeams();

                if (gettype($this->pars->team) === "string") {
                        $this->pars->team = json_decode($this->pars->team);
                }

                try {
                        $selectedTeams = array();

                        if (count($this->pars->team)) {

                                for ($i = 0; $i < count($this->pars->team); $i++) {
                                        array_push($selectedTeams,$dataTeams[$this->pars->team[$i]]);
                                }

                                return $selectedTeams;


                        }


                } catch (Exception $exc) {

                        echo $this->pars->teams;


                }

                return array();

        }

        /**
         * User Selected League
         */
        function selectedLeagues()
        {
                $l = $this->public->fetchLeagues();
                $user_desired_leagues = json_decode($this->pars->selected_league);
                $selected_leagues = array();

                foreach ( $user_desired_leagues as $user_desired_league ) {
                        array_push($selected_leagues, $l[intval($user_desired_league)]);
                }

                return $selected_leagues;
        }


        /**
         * Create Ad (Ilan)
         */
        function create(){

                #print_r($this->pars);

                $checkedRequiredData = $this->checkAdRequiredData();

                if(!$checkedRequiredData["error"]){
                // if(true){

                        /**
                         * Deprecated Variable
                         * Use intead of my_id
                         */
                        $this->pars->ad_owner   = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];
                        $this->pars->my_id      = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];

                        $this->model->pars = $this->pars;
                        return $this->model->{__FUNCTION__}();
                }
                else {

                        return array(

                                "resulta"=>!$checkedRequiredData["error"],
                                "message"=>$checkedRequiredData["message"],
                                "title"=>"Diese felt noch!"

                        );


                }




        }


        private function checkAdRequiredData(){


                #print_r($this->pars);

                $error = false;

                $message = array();
                if( !$this->pars->ad_owner_team ){
                        array_push($message, "Deine Mannschaft");
                        $error = true;
                }

                if( !count($this->pars->opponent_team_league) ){
                        array_push($message, "Spielklasse");
                        $error = true;
                }

                if( !count($this->pars->opponent_team) ){
                        array_push($message, "Gegner Mannschaft");
                        $error = true;
                }

                if( !$this->pars->ad_date ){
                        array_push($message, "Event Datum");
                        $error = true;
                }

                if( !$this->pars->ad_suggestion ){
                        array_push($message, "Bitte bestimmen Sie Zeit!");
                        $error = true;
                } else {
                        if( intval($this->pars->ad_suggestion) === AD_SUGGETION::EXCACT_TIME && empty(trim($this->pars->ad_time)) ){
                                array_push($message, "bestimmte Uhrzeit aushewählt, bitte eingeben!");
                                $error = true;
                        }
                }


                if( "true" === $this->pars->ad_in_local && empty(trim($this->pars->ad_in_local_address)) ){
                        array_push($message, "Heim aushewählt, bitte addresse eingeben!");
                        $error = true;
                }

                if( $this->pars->ad_in_outwards === "true" ){

                        /*
                        if( $this->INQUIRY_TYPE !== INQUIRY_TYPE::INQUIRY_TARGET ){

                                if( empty(trim($this->pars->ad_in_outwards_area)) ){
                                        array_push($message, "Auswärts aushewählt, bitte ort eingeben!");
                                        $error = true;
                                }

                                if( !strlen($this->pars->ad_in_outwards_km) ){
                                        array_push($message, "Auswärts aushewählt, bitte Km eingeben!");
                                        $error = true;
                                }

                        }
                        */

                }




                return array(
                        "error"=>$error,
                        "message"=>implode("\n", $message)
                );


        }


        /**
         * Ad Detail
         * @deprecated
         * @use insted of discussion/index
         */
        function detail(){

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "pars"=>$this->pars
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__ );

        }





}





namespace discussion;

use Cmfcmf\OpenWeatherMap\Exception;
use Controller;
use FETCH_STRUCTURE;
use manage\Role as RoleManage;
use REGISTER_ROLE;
use ADS_GROUPS;
use ViewController;
use ACTIVITY;
use VIEW_CONTROLLER;
use RightBarButton;
use AD_SUGGETION;
use REPOSITORY;
use APP_ICON;
use INQUIRY_TYPE;
use LISTING_TEAMS;

class Ad extends Controller{

        public function __construct($pars)
        {
                parent::__construct($pars);
        }


        public function __destruct()
        {
                // REPOSITORY::kill(REPOSITORY::CURRENT_AD_DISCUSSION_DATA);
        }


        public function index()
        {
                // TODO: Implement index() method.

                #highlight_string(var_export($this->pars, true));

                // highlight_string(var_export(REPOSITORY::readAll(), true));

                /*
                 * Deprecated Parameter
                 * Use istead of my_id
                 */
                $this->pars->ad_owner   = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];
                $this->pars->my_id      = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];


                $this->model->pars = $this->pars;
                $ad_data = array_shift($this->model->fetchAdForPrivateById());



                // AD ADD TO REPOSITORY
                /*
                 * Eget Cookie onceden Role acisa bburda yazildiginda hata veriyor
                 * */
                // REPOSITORY::killAll();
                REPOSITORY::writes(REPOSITORY::CURRENT_AD_DISCUSSION_DATA, $ad_data);
                // return false;

                $this->view->data = array(
                        "header"        => $this->getHeader($ad_data),
                        "ad_status_cell" => $this->getAdStatusCell($ad_data),
                        "discussions"   => $this->getDiscussionsWithPrettyCell(),
                        "ad_data"       => $ad_data,
                        "my_id"         => $this->pars->ad_owner
                        );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__ );


        }

        function getUpdatedHeaderWithPrettyContent(){

                /**
                 * Deprecated Variable
                 * Use intead of my_id
                 */
                $this->pars->ad_owner   = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];
                $this->pars->my_id      = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];



                $this->model->pars = $this->pars;
                $ad_data = array_shift($this->model->fetchAdForPrivateById());

                // REWRITE ADD ON REPOSITORY
                REPOSITORY::writes(REPOSITORY::CURRENT_AD_DISCUSSION_DATA, $ad_data);

                return array(
                        "header"=>$this->getHeader($ad_data),
                        "status"=>$this->getAdStatusCell($ad_data),
                        "ad_data"=>$ad_data
                );

        }


        function getHeader($data){

                $this->view->data = array(
                        "ad_data"=>$data
                );

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                return $this->view->fileContent( $this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "header.php" );

        }


        function getAdStatusCell($data){


                $this->view->data = array(
                        "ad_data" => $data,
                        "my_id"   => REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"],
                        "deal_view_controller_data"=>$this->dealViewControllerData()
                );

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                return $this->view->fileContent( $this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "ad_status_cell.php" );

        }

        function reloadHeaderAndStatusAfterDealConfirmation(){






        }


        private function dealViewControllerData(){


                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:new Layout().selectPlaceCoveringAndUnwind();", NULL);

                // TeamRol Data
                $vc = new ViewController(
                        "Behandlung",
                        "Behandlung",
                        "Ad",
                        "deal",
                        "index",
                        array(),
                        ACTIVITY::ACTIVITY_10,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        NULL//$rightBarButton->prepare()
                );

                return $vc->prepare();



        }


        private function getDiscussionsWithPrettyCell(){



                $ad_discussion_data_from_repository = REPOSITORY::reads(REPOSITORY::CURRENT_AD_DISCUSSION_DATA);

                $this->pars->ad_partners_id     = $ad_discussion_data_from_repository["ad_partners_id"];
                $this->pars->my_id              = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];
                $this->model->pars              = $this->pars;
                $ad_discussions                 = $this->model->fetchAdDiscussions();

                #highlight_string(var_export( $ad_discussions, true));
                
                $discussionCells = array();
                if( count($ad_discussions) ){
                        foreach ($ad_discussions as $index => $ad_discussion ) {
                              array_push($discussionCells, $this->cell($ad_discussion));
                        }
                }

                return implode("",$discussionCells);

        }

        private function fetchLastDiscussionWithPrettyCell(){


                $this->model->pars = $this->pars;
                $ad_last_discussions = $this->model->fetchAdLastDiscussion();

                return $this->cell($ad_last_discussions);

        }

        private function cell( $data ){

                // highlight_string(var_export($data, true));
                $myText = null;
                $partnerText = null;
                $myPos = null;
                $partnerPos = null;
                if (intval($data["sender_id"]) === intval(REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"])) {

                        $text1 = $data["sender_text"];
                        $text2 = $data["receiver_answer_text"];

                        $pos1 = "me";
                        $pos2 = "partner";

                } else {

                        $text2 = $data["receiver_answer_text"];
                        $text1 = $data["sender_text"];

                        $pos2 = "me";
                        $pos1 = "partner";

                }

                $this->view->data = array(
                        "text1"         => $text1,
                        // "text1_from"    => $text1_from,
                        "text2"         => $text2,
                        "pos1"          => $pos1,
                        // "text2_from"    => $text2_from,
                        "pos2"          => $pos2
                );

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                return $this->view->fileContent( $this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "cell.php" );

        }


        function sendMessage(){

                $ad_discussion_data_from_repository = REPOSITORY::reads(REPOSITORY::CURRENT_AD_DISCUSSION_DATA);

                $my_id = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];

                #print_r($this->pars->my_id);
                $partner_id = 0;
                if( intval($my_id) === intval($ad_discussion_data_from_repository["ad_owner"]) ){
                        $partner_id = intval($ad_discussion_data_from_repository["person_id"]);
                }

                else if( intval($my_id) === intval($ad_discussion_data_from_repository["person_id"]) ){
                        $partner_id = intval($ad_discussion_data_from_repository["ad_owner"]);
                }



                $this->pars->my_id              = $my_id;
                $this->pars->partner_id         = $partner_id;
                $this->pars->ad_partners_id     = $ad_discussion_data_from_repository["ad_partners_id"];
                $this->model->pars              = $this->pars;
                $this->model->{__FUNCTION__}();

                return $this->fetchLastDiscussionWithPrettyCell();

        }

        function readMessage(){

        }


}



namespace deal;
use Controller;
use REPOSITORY;
use FETCH_STRUCTURE;
use ACTIVITY;
use VIEW_CONTROLLER;
use ViewController;
use RightBarButton;
use ads\Ad as AD_ADS;

class Ad extends Controller{


        public function __construct($pars)
        {
                parent::__construct($pars);
        }

        public function index()
        {
                // TODO: Implement index() method.

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "ad_data"=>REPOSITORY::reads(REPOSITORY::CURRENT_AD_DISCUSSION_DATA),
                        "my_id"=>REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"]
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__ );

        }

        function adPrivateDealWithConfirmation(){


                $ad_data = REPOSITORY::reads(REPOSITORY::CURRENT_AD_DISCUSSION_DATA);

                $this->pars->my_id      = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];
                $this->pars->ad_data    = $ad_data;

                $this->model->pars      = $this->pars;

                $data = $this->model->{__FUNCTION__}();

                if( !$data->resulta ){

                        return array(
                                "resulta"=>false,
                                "message"=>$data->errInfo
                        );
                }

                return array(
                        "resulta"=>true,
                        "ad_partners_id"=>$ad_data["ad_partners_id"]
                );





        }

        /**
         * @return |null
         * Ad Declined Comment View
         */
        function _declined_comment_view(){

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array();

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__ );

                return null;

        }


        /**
         * @return |null
         * Ad Declined Comment View Controller Data
         */
        function adDeclinedCommentViewControllerData(){


                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:new Layout().determinedAdDeclinedCommentAndUnwind();", NULL);

                // TeamRol Data
                $vc = new ViewController(
                        "Grund",
                        "Bitte gebe here eine grund",
                        "Ad",
                        "deal",
                        "_declined_comment_view",
                        array(),
                        ACTIVITY::ACTIVITY_11,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $vc->prepare();



        }



        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }
}


namespace search;
use Controller;
use REPOSITORY;
use FETCH_STRUCTURE;
use ACTIVITY;
use VIEW_CONTROLLER;
use ViewController;
use RightBarButton;
use ads\Ad as AD_ADS;
use discussion\Ad as AD_DISCUSSION;
use testplay\Ad as AD_TESTPLAY;
use INQUIRY_TYPE;

class Ad extends Controller{

        public function __construct($pars)
        {
                parent::__construct($pars);
        }

        public function index()
        {
                // TODO: Implement index() method.

                $this->view->data = array(
                        "ads_with_pretyy_cell"=>$this->publicAdsPrettyCustomCell()
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__ );


        }



        private function publicAdsPrettyCustomCell(){



                $ads = $this->fetchAds();

                $finalMyAds     = array();
                $fetchedTeams             = $this->public->getDFBClubTeams();
                $fetchedLeagues           = $this->public->fetchLeagues();
                $my_id                    = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];

                #highlight_string(var_export($fetchedLeagues, true));
                #highlight_string(var_export($this->pars, true));

                if ( count( $ads ) ){
                        foreach ( $ads as $index => $ad ) {


                                #highlight_string(var_export($ad, true));

                                $team_suggestion        = array_unique( json_decode($ad["ad_opponent_teams_suggestion"]) );
                                $league_suggestion      = array_unique( json_decode($ad["ad_opponent_leagues_suggestion"]) );

                                $new_pretty_teams_name          = array();
                                $new_pretty_leagues_name        = array();

                                foreach ( $team_suggestion as $item ) {
                                        array_push($new_pretty_teams_name, $fetchedTeams[$item]["name"]);
                                }

                                foreach ( $league_suggestion as $item ) {
                                        array_push($new_pretty_leagues_name, $fetchedLeagues[$item]["name"]);
                                }


                                $detailsViewController = $this->adDetailsViewController($ad);



                                // Additional Data
                                $ad["teams_suggestion"]       = implode(",", $new_pretty_teams_name);
                                $ad["league_suggestion"]      = implode(",", $new_pretty_leagues_name);


                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                                $this->view->data = array(
                                        "details_view_controller"       => $detailsViewController,
                                        "cell_name"                     => $ad["ad_group"],
                                        "ad_id"                         => $index,
                                        "ad_partners_id"                => $ad["ad_partners_id"],
                                        "ad_details"                    => $ad,
                                        "my_id"                         => $my_id
                                );


                                $cellFile = "testplay_public_cell.php";

                                try {
                                        $ad_ads_class = new \ReflectionClass("ads\Ad");
                                } catch (\ReflectionException $e) {
                                }


                                $pretty_ad_cell = $this->view->fileContent( $ad_ads_class->getShortName(), $ad_ads_class->getNamespaceName() . DIRECTORY_SEPARATOR . $cellFile );


                                array_push($finalMyAds, $pretty_ad_cell);




                        }

                        return implode("", $finalMyAds);
                }

                return null;


        }

        function fetchAds(){

                $this->pars->my_id = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];
                $this->pars->inquiry_type = INQUIRY_TYPE::INQUIRY_PUBLIC;
                $this->model->pars = $this->pars;
                return $this->model->{__FUNCTION__}();

        }


        private function adDetailsViewController( $ad_data ){

                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:new Layout().selectPlaceCoveringAndUnwind();", NULL);

                // TeamRol Data
                $vc = new ViewController(
                        $ad_data["ad_group"],
                        $ad_data["pretty_ad_date"] . " " . $ad_data["pretty_ad_time"],
                        "Ad",
                        "search",
                        "detailsView",
                        array("ad_id"=>$ad_data["id"]),
                        ACTIVITY::ACTIVITY_5,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        NULL//$rightBarButton->prepare()
                );

                return $vc->prepare();

        }

        private function adDiscussionViewController($ad_data){

                
                #highlight_string(var_export($this->pars, true));;


                $ad_partners = $this->fetchPrivateAdFromUserPublicSelectedAd($ad_data);

                #highlight_string(var_export($ad_partners, true));
                
                /***
                 * This is target Ad Partners id
                 */
                $myData = array("ad_partners_id"=>$ad_partners["id"]);

                // TeamRol Data
                $leagueViewController = new ViewController(
                        $ad_data["ad_group"],
                        $ad_data["pretty_ad_date"] . " " . $ad_data["pretty_ad_time"],
                        "Ad",
                        "discussion",
                        "index",
                        $myData,
                        ACTIVITY::ACTIVITY_9,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        NULL
                );

                return $leagueViewController->prepare();



        }

        /**
         * Eger Kullani ci public ilan hosuna gitti ise ve onu favorilerine aldi ise
         * O ilanin detaylarini gördügü anda o ilan la iligi Yazismalarida gormeli 
         * Burada Yazismalarin oldu view direkt ad_partners tabelesinden geliyor
         * Ama burada henuz Public ilana ait private deger yok 
         * o zuzden ad partners tabalasindekki hedef row cekilmeli
         */
        function fetchPrivateAdFromUserPublicSelectedAd( $ad_data ){
                
                
                $this->pars->my_id = REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"];
                $this->pars->ad_data = $ad_data;
                
                $this->model->pars = $this->pars;
                $data = $this->model->{__FUNCTION__}();

                return $data;
                
                
                
        }
        


        /**
         * Public Ad details View
         */
        function detailsView(){


                /**
                 * Deep SQL True
                 * Return More Deep Data from Database
                 * !!! Included SQL Script
                 */
                $this->pars->deep_sql = true;
                $ad_data = $this->fetchAds();
                if( count($ad_data) ){

                        
                        $ad_data = array_shift($ad_data);


                        // Ad This Selected Ad To REPOSITORY
                        REPOSITORY::writes(REPOSITORY::CURRENT_SELECTED_AD_FROM_SEARCH, $ad_data);
                        
                        $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                        $this->view->data = array(
                                "header"                => $this->getHeader($ad_data),
                                "availability_clubs_with_teams" => $this->myAvailabilityTeams(),
                                // "ad_status_cell" => $this->getAdStatusCell($ad_data),
                                "ad_data"       => $ad_data,
                                "my_id"         => REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"]
                        );

                        $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "details_view" );

                } else {

                        echo "Error View";

                }





        }

        private function myAvailabilityTeams(){

                try {
                        $AD_TESTPLAY = new AD_TESTPLAY($this->pars);
                        $user_used_roles        =  $AD_TESTPLAY->fetchUserUsedRoles();
                        $fetchDFBClubTeams      = $this->public->getDFBClubTeams();

                        $availability_clubs_with_teams = array();

                        foreach ($user_used_roles as $index => $user_used_role) {

                                $club_teams = $user_used_role["team"];
                                $club_teams = json_decode($club_teams);

                                $club_teams_group = $user_used_role["team_group"];
                                $club_teams_group = json_decode($club_teams_group);

                                $teams_leagues = $user_used_role["team_league"];
                                $teams_leagues = json_decode($teams_leagues);

                                if( count($club_teams) ){

                                        for( $i=0; $i< count($club_teams); $i++)
                                        {
                                                array_push($availability_clubs_with_teams, array(
                                                        $user_used_role["pretty_club_name"] . " > " . $fetchDFBClubTeams[$club_teams[$i]]["name"],
                                                        // $fetchDFBTeamLeagues[$teams_leagues[$i]]["name"] . " > " . $fetchDFBClubTeams[$club_teams[$i]]["name"],
                                                        array($user_used_role["club_id"], $club_teams[$i], $club_teams_group[$i], $teams_leagues[$i] ),
                                                ));
                                        }

                                }
                        }

                        return $availability_clubs_with_teams;


                } catch (\ReflectionException $e) {
                }


        }

        function getHeader($ad_data){


                
                #highlight_string(var_export($ad_data, true));



                $this->view->data = array(
                        "my_id"         => REPOSITORY::reads(REPOSITORY::CURRENT_USER)["id"],
                        "ad_data"       => $ad_data,
                        "dfb_teams"     => $this->public->getDFBClubTeams(),
                        "dfb_leagues"   => $this->public->getDFBLeagueGroups(),
                        "place_coverings_data" => $this->public->fetchPlaceCovering(),
                        "ad_interested_people_view_controller_data"=> $this->adInterestedPeopleViewControllerData($ad_data),
                        "discussions_view_controller_data" => $this->adDiscussionViewController($ad_data),
                );

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                return $this->view->fileContent( $this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "header.php" );


        }


        private function adInterestedPeopleViewControllerData( $ad_data ){

                
                #highlight_string(var_export($ad_data, true));
                /**
                 * for + or edit button adId is ad new or for edit
                 */
                $rightBarButton = null; // new RightBarButton("Ok", APP_ICON::ICON_ADD, "javascript:Layout().addNewAd('" . json_encode($this->adManageViewControllerData( $inquiry_type, NULL )). "');", NULL);


                // TeamRol Data
                $leagueViewController = new ViewController(
                        " Interessierte Mitglied",
                        $ad_data["ad_group"] . " " . $ad_data["pretty_ad_date"] . " " . $ad_data["pretty_ad_time"],
                        "Ad",
                        "ads",
                        "myAds",
                        array("ad_id"=>$ad_data["id"]),
                        ACTIVITY::ACTIVITY_6,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        null// $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }






        function getAdStatusCell(){



        }

        function getDiscussionsWithPrettyCell(){




        }








        public function filterView(){


                // TODO: Implement index() method.

                $this->view->data = array(
                );

                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "filter_view" );




        }


        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }
}








