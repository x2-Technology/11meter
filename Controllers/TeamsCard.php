<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 2019-06-17
 * Time: 17:10
 */

/**
 * Direkt Anfrage Yapabilmek icin Takimlar olusturuluyor
 */

class TeamsCard extends Controller
{

        public function index()
        {


                // REPOSITORY::kill(REPOSITORY::CURRENT_FILTER_FOR_CARD_TEAMS);
                // REPOSITORY::kill(REPOSITORY::CURRENT_APPENDED_CARD_TEAMS);



                $this->view->data = array(

                        "opponent_teams_view_controller" => $this->opponentTeamsViewController(),
                        "opponent_leagues_view_controller" => $this->leaguesViewController(),
                        "environment_view_controller" => $this->environmentViewController(),
                        "result_for_filter_view_controller" => $this->resultForFilterViewController(),
                        "clubs_view_controller" => $this->clubsViewController()

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
                        ACTIVITY::ACTIVITY_HELPER_2,
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
                        ACTIVITY::ACTIVITY_HELPER_2,
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
                        "Bitte entscheide umkreis",
                        "TableView",
                        "_environment",
                        "index",
                        array(), // Selected (If )
                        ACTIVITY::ACTIVITY_HELPER_2,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }


        private function resultForFilterViewController(){




                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().collectSelectedTeamsForCardAndDismissWithData();", NULL);


                // TeamRol Data
                $leagueViewController = new ViewController(
                        "Ergebnisse",
                        "",
                        "TableView",
                        "_filtered_teams_card",
                        "index",
                        array(),
                        ACTIVITY::ACTIVITY_HELPER_2,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }

        private function clubsViewController(){




                $rightBarButton = new RightBarButton("Ok", NULL, "javascript:Layout().selectedCardClubsAndDismissWithData();", NULL);


                // TeamRol Data
                $leagueViewController = new ViewController(
                        "Verein",
                        "Bitte tippen Sie Vereinname ein",
                        "TableView",
                        "_clubs",
                        "index",
                        array(),
                        ACTIVITY::ACTIVITY_HELPER_2,
                        VIEW_CONTROLLER::X2UINavigationBackButtonShow,
                        $rightBarButton->prepare()
                );

                return $leagueViewController->prepare();
        }

        function collectFilterData(){


                unset($this->pars->filters["unwindFrom"]);
                unset($this->pars->filters["output"]);

                if(count($this->pars->filters)){


                        $CURRENT_FILTER_FOR_CARD_TEAMS = REPOSITORY::reads(REPOSITORY::CURRENT_FILTER_FOR_CARD_TEAMS);
                        REPOSITORY::writes(
                                REPOSITORY::CURRENT_FILTER_FOR_CARD_TEAMS,
                                array_merge((is_null($CURRENT_FILTER_FOR_CARD_TEAMS) ? array():$CURRENT_FILTER_FOR_CARD_TEAMS),$this->pars->filters)
                        );


                        #print_r(REPOSITORY::reads(REPOSITORY::CURRENT_FILTER_FOR_CARD_TEAMS));

                        return REPOSITORY::reads(REPOSITORY::CURRENT_FILTER_FOR_CARD_TEAMS);

                }


                return NULL;
        }

        function fetchFilterData(){

                return REPOSITORY::reads(REPOSITORY::CURRENT_FILTER_FOR_CARD_TEAMS);

        }


        function fetchTeamsWithFilterData(){

                $filterData = $this->fetchFilterData();


                print_r($filterData);



                /// TODO Now Find the Teams as Filtered Data



        }


        
        
        function addSelectedTeamsCardTeamsToRepositoryAndReturnWithPrettyCells(){


                $this->addCardTeamItemsToRepository();

                return $this->cellsCardItemsFromRepository();


        }

        /**
         * @return array
         * Loading Cell with Page Load
         */
        public function loadCardTeamsItems(){
                return $this->cellsCardItemsFromRepository();
        }


        /**
         * This Operation prepared for Card Selected teams items with Repository
         */
        
        private function addCardTeamItemsToRepository( ){

                $card_teams = $this->pars->card_teams;

                

                if( !is_null($card_teams) && count($card_teams) ){

                        foreach ($card_teams as $card_team ) {


                                $this->model->pars = (object) $card_team;
                                $fetchUserUsingRoleById = $this->model->fetchUserUsingRoleById();


                                $roleClub               = $fetchUserUsingRoleById["club_id"];
                                $roleTeams              = json_decode($fetchUserUsingRoleById["team"]);
                                $roleTeamsGroups        = json_decode($fetchUserUsingRoleById["team_group"]);
                                $roleTeamsLeagues       = json_decode($fetchUserUsingRoleById["team_league"]);


                                // Found target Index from Team
                                $targetIndex = 0;
                                if( count($roleTeams) ){

                                        foreach ($roleTeams as $roleTeam ) {

                                                if( intval($roleTeam) === intval($card_team["team_id"]) ){
                                                        break;
                                                }
                                                $targetIndex++;
                                        }
                                }


                                // Target Team
                                $targetTeam             = $roleTeams[$targetIndex];
                                $targetTeamGroup        = $roleTeamsGroups[$targetIndex];
                                $targetTeamLeague       = $roleTeamsLeagues[$targetIndex];


                                // Request Key
                                $requestTeamKey = array();
                                // array_push($requestTeamKey, $card_team["role_id"]);
                                array_push($requestTeamKey, $card_team["club_id"]);
                                array_push($requestTeamKey, $targetTeam);
                                array_push($requestTeamKey, $targetTeamGroup);
                                array_push($requestTeamKey, $targetTeamLeague);
                                array_push($requestTeamKey, $card_team["trainer_id"]);

                                $requestTeamKey = implode("_",$requestTeamKey);

                                // Pretty Virtual Data From DB

                                $cardItem = array(
                                        "club_id"       => $roleClub,
                                        "team_id"       => $targetTeam,
                                        "team_group_id" => $targetTeamGroup,
                                        "league_id"     => $targetTeamLeague,
                                        "trainer_id"    => $card_team["trainer_id"],
                                );





                                $this->model->pars      = (object)$cardItem;
                                $prettyCellData         = $this->model->fetchPrettyCellDataFromVirtualDatabase();

                                // First Item Of Array
                                $prettyCellData = array_shift($prettyCellData) ;

                                // Extend the Repository Card Item Data
                                REPOSITORY::writes(REPOSITORY::CURRENT_APPENDED_CARD_TEAMS, $requestTeamKey, array_merge(
                                        $cardItem, $prettyCellData
                                ));


                        }


                }


        }


        /**
         * @return array
         * Javascript HttpRequest Operation
         * With this operation, Selected Teams added for Card before finally,
         * User have always possibility remove already selected item from Cart
         * And this operation returning pretty cell content for card with Selected Teams Items Repository
         * Items collection from Repository and converting to real data With Database
         */
        public function cellsCardItemsFromRepository(){


                $appendedCardItems      = REPOSITORY::reads(REPOSITORY::CURRENT_APPENDED_CARD_TEAMS);
                
                #print_r($appendedCardItems);
                $cells                  = array();

                if( count($appendedCardItems) ){

                        foreach ($appendedCardItems as $k => $appendedCardItem) {


                                $this->view->data = array(
                                        "cell"=>$appendedCardItem,
                                        "cell_key"=>$k
                                );

                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                                $cell = $this->view->fileContent(
                                        get_class($this), "cell_team_card_item.php");


                                array_push($cells, array(
                                        "cell"=>$cell,
                                        "cell_key"=>$k
                                ));

                        }

                        return $cells;

                }

                return array();


        }


        // Remove All Items From Repository For Box
        public function removeAllCardItemsFromRepository(){

                REPOSITORY::kills(REPOSITORY::CURRENT_APPENDED_CARD_TEAMS);
                REPOSITORY::kills(REPOSITORY::CURRENT_FILTER_FOR_CARD_TEAMS);

        }


        /**
         * @return array|null
         * Javascript HttpRequest
         * this Operation finally response Card Items with Array and Pretty HTML element content
         * After request will Opponent team Row content will update
         */
        public function getFinallyCardTeamItemsFromRepository(){


                $card_teams = $this->pars->card_teams;

                $repositoryCardTeams = REPOSITORY::reads(REPOSITORY::CURRENT_APPENDED_CARD_TEAMS);

                /**
                 * Prepare for finally
                 */
                $this->removeAllCardItemsFromRepository();

                $finallyCardTeams = array();

                if( count($card_teams) ){

                        foreach ($card_teams as $card_team) {
                                // array_push($finallyCardTeams, $repositoryCardTeams[$card_team]);

                                /**
                                 * Update & Replace & Trim
                                 * Finally Cart Items
                                 * From Repository, while the Repository has All items
                                 * With this operation if any removed from List with user defined
                                 * Will not more listing with upper foreach filtering
                                 *
                                 */
                                REPOSITORY::writes(REPOSITORY::CURRENT_APPENDED_CARD_TEAMS, $card_team, $repositoryCardTeams[$card_team] );

                                $finallyCardTeams[$card_team] = $repositoryCardTeams[$card_team];


                        }




                        /**
                         * Return
                         */
                        return array(
                                "finally"               => $finallyCardTeams,
                                "finallyPrettyElements" => $this->prettyFinallySelectedTeamElementsForCell($finallyCardTeams),
                        );
                }

                return null;


        }


        /**
         * @param array $selectedTeamItems
         * This is a for Upper Method is a private method help for pretty finally content for 
         * selected Teams Items for Ad Controller
         */
        private function prettyFinallySelectedTeamElementsForCell( $selectedTeamItems = array() ){

                #print_r($selectedTeamItems);
                
                $finallyPrettyCellElements = array();

                if( count($selectedTeamItems ) ){

                        foreach ($selectedTeamItems  as $key => $selectedTeamItem ) {


                                $this->view->data = array(
                                        "data"=>$selectedTeamItem
                                );

                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                                $item = $this->view->fileContent(
                                        get_class($this), "for_ad_finally_opponent_team_items.php");

                                array_push($finallyPrettyCellElements, $item );

                        }

                        return implode("<div class='clearfix'></div>", $finallyPrettyCellElements);

                }

                return null;

        }



        /**
         * @param array $selectedTeamItems
         * This Method likely upeer method
         * Upper method work combine with repository
         * But this method income the Data from created Ad ( Database )
         */
        function createdAdOpponentTeamPrettyContentForSubTitleForCell( $selectedTeamItems = array() ){

                #print_r($selectedTeamItems);

                $finallyPrettyCellElements = array();

                if( count($selectedTeamItems ) ){

                        foreach ($selectedTeamItems  as $key => $selectedTeamItem ) {


                                $this->view->data = array(
                                        "data"=>$selectedTeamItem
                                );

                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                                $item = $this->view->fileContent(
                                        get_class($this), "for_ad_finally_opponent_team_items.php");

                                array_push($finallyPrettyCellElements, $item );

                        }

                        return implode("<div class='clearfix'></div>", $finallyPrettyCellElements);

                }

                return null;

        }


















}