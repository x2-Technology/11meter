<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 27.09.18
 * Time: 09:44
 */

namespace _start;

use Controller;
use FETCH_STRUCTURE;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use ReflectionException;
use REPOSITORY;

class Team extends Controller
{
        /**
         * Team constructor.
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

                $me = REPOSITORY::read(REPOSITORY::CURRENT_USER);
                $assignedTeams = (array)json_decode($me["mannschaft"]);

                //array_push($assignedTeams, '37');

                $hasTeams = count($assignedTeams);

                // Transfer Data
                $this->pars->club_id = $me["club_id"];

                if ($hasTeams) {

                        $NAMESPACE = "_team";
                        $this->pars->teams = $assignedTeams[0];
                        if ($hasTeams > 1) {
                                $NAMESPACE = "_teams";
                                $this->pars->teams = $assignedTeams;
                        }

                        try {
                                $class = "\\$NAMESPACE\\Team";
                                $t = new $class($this->pars);
                                $t->index();
                        } catch (ReflectionException $e) {
                        }


                } else {

                        // echo "player has no any Team assigned";

                        $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                        $this->view->data = array(
                            "message" => "Sie sind mit keinem Team verbunden!!!"
                        );
                        $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


                }
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}

namespace _teams;

use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use ACTIVITY;
use Config;

class Team extends Controller
{
        /**
         * Team constructor.
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

                $rows = $this->getRows();

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "rows" => $rows
                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


        }


        private function getRows()
        {


                $this->model->pars = $this->pars;
                $teams = $this->model->fetchTeams()["data"];


                $final_team_rows = array();
                if (count($teams)) {

                        foreach ($teams as $index => $team) {

                                #highlight_string(var_export($team["name"], true));

                                $row_data = array();
                                $row_data["display_name"] = $team["name"];
                                $row_data["link"] = Config::BASE_URL . DIRECTORY_SEPARATOR . "Team" . DIRECTORY_SEPARATOR . "_team" . DIRECTORY_SEPARATOR . "index/?teams=" . $index;
                                $row_data[ACTIVITY::ACTIVITY] = ACTIVITY::go(ACTIVITY::ACTIVITY_2);


                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);
                                $this->view->data = array(
                                        "row_data" => $row_data,
                                        "db" => $team
                                );

                                $row = $this->view->fileContent($this->getReflectedClass()->getShortName() . DIRECTORY_SEPARATOR . $this->getReflectedClass()->getNamespaceName(), "row.php");

                                array_push($final_team_rows, array("row" => $row, "data" => $team));
                        }

                }

                return $final_team_rows;


        }


        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}

namespace _team;

use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use TEAMROLLE;
use Config;
use REPOSITORY;

class Team extends Controller
{
        /**
         * Team constructor.
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

                $rows = $this->getRows();

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);
                $this->view->data = array(
                        "rows" => $rows,
                        "header" => $this->getHeader()
                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


        }

        private function getRows()
        {


                $this->model->pars = $this->pars;
                $fetchPlayers = $this->model->fetchPlayers()["data"];


                // Spread out to 3 Groups
                $trainers = array();
                $players = array();

                if (count($fetchPlayers)) {

                        foreach ($fetchPlayers as $index => $item) {


                                if ($item["is_player"]) {

                                        // OR SHORTENED CODE

                                        /*
                                        $presence_data = array();
                                        $presence_data["display_name"]                   = "Anwesenheit";//  $rowData["display_name"];
                                        $presence_data["meeting_pretty_date"]            = ""; // $rowData["meeting_pretty_date"];
                                        $presence_data["link"]                           = Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "_presence" . DIRECTORY_SEPARATOR . "index/?meeting_id=" . $this->pars->id;
                                        $presence_data["last_check"]                     = "";
                                        $presence_data["meeting_id"]                     = $item["id"];
                                        $presence_data[ACTIVITY::ACTIVITY]               = ACTIVITY::go(ACTIVITY::ACTIVITY_4);
                                        */
                                        $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);
                                        $this->view->data = array(
                                                "db" => $item,
                                                // "presence_data"         => $presence_data
                                        );

                                        $row = $this->view->fileContent($this->getReflectedClass()->getShortName() . DIRECTORY_SEPARATOR . $this->getReflectedClass()->getNamespaceName(), "row.php");

                                        array_push($players, array("row" => $row, "data" => $item));


                                } else if ($item["is_trainer"]) {

                                        $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);
                                        $this->view->data = array(
                                                "db" => $item
                                        );

                                        $row = $this->view->fileContent($this->getReflectedClass()->getShortName() . DIRECTORY_SEPARATOR . $this->getReflectedClass()->getNamespaceName(), "row.php");

                                        array_push($trainers, array("row" => $row, "data" => $item));
                                }

                        }

                }

                $rows = array(TEAMROLLE::SPIELER => $players, TEAMROLLE::TRAINER => $trainers);

                return $rows;


        }

        private function getHeader()
        {
                $me = REPOSITORY::read(REPOSITORY::CURRENT_USER);

                $fetchTeam = $this->model->fetchTeam()["data"];

                $teamImage =
                        Config::CLUB_DOCS_BASE_URI .
                        DIRECTORY_SEPARATOR .
                        $me["club_id"] .
                        DIRECTORY_SEPARATOR .
                        Config::CLUB_FOLDER_DOCS .
                        $this->pars->teams .
                        DIRECTORY_SEPARATOR .
                        "team.png";

                $clubLogo =
                        Config::CLUB_DOCS_BASE_URI .
                        DIRECTORY_SEPARATOR .
                        $me["club_id"] .
                        DIRECTORY_SEPARATOR .
                        "club_logo.png";


                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "team_image" => $teamImage,
                        "club_logo" => $clubLogo,
                        "team_name" => $fetchTeam["name"],
                        "club_name" => $me["club_name"]
                );

                return $this->view->fileContent($this->getReflectedClass()->getShortName() . DIRECTORY_SEPARATOR . $this->getReflectedClass()->getNamespaceName(), "header.php");

        }


        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}