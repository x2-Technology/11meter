<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 2019-06-11
 * Time: 16:30
 */

namespace _teams;
use Model;
use Database;
class TableView_Model extends Model{

        function __construct()
        {
                parent::__construct();
        }

        function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

        public function connect()
        {
                parent::connect(); // TODO: Change the autogenerated stub
        }
}

namespace _team_groups;
use Model;
use Database;
class TableView_Model extends Model{

        function __construct()
        {
                parent::__construct();
        }

        function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

        public function connect()
        {
                parent::connect(); // TODO: Change the autogenerated stub
        }

}


namespace _season;
use Model;
use Database;
use Config;
class TableView_Model extends Model{

        public function __construct()
        {
                parent::__construct();
        }
        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

        public function connect()
        {
                parent::connect(); // TODO: Change the autogenerated stub
        }

}

namespace _leagues;
use Model;
use Database;
use Config;
class TableView_Model extends Model{

        public function __construct()
        {
                parent::__construct();
        }
        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

        public function connect()
        {
                parent::connect(); // TODO: Change the autogenerated stub
        }

        function fetchLeaguesById(){

                $statement = "";

                if( count($this->pars->requestableLeagues) ){

                        $statement = array();

                        foreach ($this->pars->requestableLeagues as $index => $requestableLeague) {
                                array_push($statement, "id=$index");
                        }

                        $statement = "WHERE (" . implode(" OR ", $statement) . ")";
                }




                $sql = "SELECT * FROM leagues {$statement}";


                $this->db = new Database();
                $this->db->setQuery($sql);
                $this->db->setSingleValueWithKey(true);

                $data = $this->db->fetch();


                return $data;





        }

}

namespace _postcodes;
use Model;
class TableView_Model extends Model{

        public function __construct(){parent::__construct();}
        public function __destruct(){parent::__destruct();}
        public function connect(){parent::connect();}

}


namespace _time_suggestion;
use Model;
class TableView_Model extends Model{

        public function __construct(){parent::__construct();}
        public function __destruct(){parent::__destruct();}
        public function connect(){parent::connect();}

}

namespace _environment;
use Model;
class TableView_Model extends Model{

        public function __construct(){parent::__construct();}
        public function __destruct(){parent::__destruct();}
        public function connect(){parent::connect();}

        /**
         * @return array
         * From Postcodes Table
         */
        public function fetchEnvironmentData(){

                $statement = !is_null($this->pars->postcode_id) ? "WHERE id={$this->pars->postcode_id}" : "";

                $sql = "SELECT * FROM postcode {$statement}";
                $this->connect();
                $this->db->setQuery($sql);
                $data = $this->db->fetch();

                return array(
                        "resulta" => $this->db->resulta,
                        "process" => $this->db->process,
                        "data"    => $data,
                        "sql"     => $this->db->getQueryString(),
                        "errInfo" => $this->db->errInfo,
                        "errCode" => $this->db->errCode
                );

        }



}


namespace _place_covering;
use Model;
class TableView_Model extends Model{

        public function __construct(){parent::__construct();}
        public function __destruct(){parent::__destruct();}
        public function connect(){parent::connect();}

}


namespace _members;
use Model;
use Database;

class TableView_Model extends Model{

        public function __construct()
        {
                parent::__construct();
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }


        function fetchMembersById(){

                        $statement = "";

                        if( count($this->pars->requestableMembers) ){

                                $statement = array();

                                foreach ($this->pars->requestableMembers as $index => $requestableMember) {
                                        array_push($statement, "id=$index");
                                }
                                $statement = "WHERE (" . implode(" OR ", $statement) . ")";
                        }

                        $sql = "SELECT *,
                                (SELECT CONCAT(vorname, ' ', nachname)) as pretty_name   
                                FROM kontakt {$statement}";

                        $this->db = new Database();
                        $this->db->setQuery($sql);
                        $this->db->setSingleValueWithKey(true);

                        $data = $this->db->fetch();


                        return $data;





                }


}

namespace _clubs;
use Model;
use Database;

class TableView_Model extends Model{

        public function __construct()
        {
                parent::__construct();
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }


        function fetchClubsById(){

                $statement = "";

                if( count($this->pars->requestableClubs) ){

                        $statement = array();

                        foreach ($this->pars->requestableClubs as $index => $requestableClub) {
                                array_push($statement, "id=$index");
                        }
                        $statement = "WHERE (" . implode(" OR ", $statement) . ")";
                }

                $sql = "SELECT * FROM dfb.dfb_league_clubs {$statement}";

                $this->db = new Database();
                $this->db->setQuery($sql);
                $this->db->setSingleValueWithKey(true);

                $data = $this->db->fetch();


                return $data;

        }

        function fetchClubsByName(){

                $statement = "";

                if( is_null($this->pars->seach) ){


                        $statement = "WHERE teamName2 LIKE '%" . $this->pars->search . "%'";
                }

                $sql = "SELECT * FROM dfb.dfb_league_clubs {$statement}";

                $this->db = new Database();
                $this->db->setQuery($sql);
                $this->db->setSingleValueWithKey(true);

                $data = $this->db->fetch();


                return $data;

        }


        /**
         * Found outsourcing club data from Fußball.de with user
         * Add to database
         * @return array
         */
        function addFoundClubToDatabase()
        {

                $this->db = new Database("dfb");
                $this->db->setTable("dfb_league_clubs");
                $this->db->set("clubKey", $this->pars->teamName);
                $this->db->set("teamName", $this->pars->teamName);
                $this->db->set("teamName2", $this->formatClubName($this->pars->teamName));
                $this->db->set("vereinsseite", preg_replace("/#!\//", "", $this->pars->vereinsseite));
                $this->db->set("custom_add", 1);
                $this->db->Insert();
                return array(
                        "resulta" => $this->db->resulta,
                        "process" => $this->db->process,
                        "lastInsertId" => $this->db->lastInsertId,
                        "errCode" => $this->db->errCode,
                        "errInfo" => $this->db->errInfo,
                        "errMessage" => $this->db->queryError($this->db->errCode, $this->formatClubName($this->pars->teamName)),
                        "sql" => $this->db->getQueryString()
                );
        }

        private function formatClubName($clubName)
        {
                // $clubName = "TBAs JAHN 1896 ZEISKAM";
                $clubNameParts = explode(" ", $clubName);
                $parsedClubName = array();
                for ($i = 0; $i < count($clubNameParts); $i++) {
                        if ($i !== 0) {
                                $part = strtolower($clubNameParts[$i]);
                                array_push($parsedClubName, ucwords($part));
                        }
                }
                $fo = $clubNameParts[0];
                if (strlen($fo) < 4) {
                        $fo = strtoupper($fo);
                } else {
                        $fo = strtolower($fo);
                        $fo = ucwords($fo);
                }

                array_unshift($parsedClubName, $fo);
                return implode(" ", $parsedClubName);
        }


}


namespace _trainer_teams;
use Model;
use Database;

class TableView_Model extends Model{

        public function __construct()
        {
                parent::__construct();
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

        function fetchTeamsById(){

                $statement = "";

                if( count($this->pars->requestableTeams) ){

                        $statement = array();

                        foreach ($this->pars->requestableTeams as $index => $requestableTeam) {
                                array_push($statement, "id=$index");
                        }

                        $statement = "WHERE (" . implode(" OR ", $statement) . ")";
                }

                $sql = "SELECT * FROM club_teams_pool {$statement}";
                $this->db = new Database();
                $this->db->setQuery($sql);
                $this->db->setSingleValueWithKey(true);

                $data = $this->db->fetch();
                return $data;
        }

}

/**
 * @deprecated
 * @use Instead of self class
 */
namespace _team_card;
use Model;
use Database;

class TableView_Model extends Model{

        public function __construct()
        {
                parent::__construct();
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }


}


namespace _trainers;
use Model;
use Database;

class TableView_Model extends Model{

        public function __construct()
        {
                parent::__construct();
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

        function teamTrainers(){


                $team_id=$this->pars->team_id;
                $club_id=$this->pars->club_id;

                $sql = "SELECT id, user_id,
                        (SELECT CONCAT(vorname, ' ' ,nachname) FROM kontakt WHERE id=user_using_roles.user_id) as trainer_final_name,
                        (SELECT name FROM register_roles WHERE id=role_id) as pretty_trainer_type_name
                        FROM user_using_roles WHERE IN_INDEXED_ARRAY(team,{$team_id}) AND club_id={$club_id}";

                $this->db = new Database();
                $this->db->setQuery($sql);
                $this->db->setSingleValueWithKey(true);
                $data = $this->db->fetch();

                #echo $this->db->getQueryString();
                return $data;

        }


}

namespace _registered_teams;
use Model;
use Database;

class TableView_Model extends Model{

        public function __construct()
        {
                parent::__construct();
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

        function fetchTeamsById(){

                $statement = "";

                if( count($this->pars->requestableTeams) ){

                        $statement = array();

                        foreach ($this->pars->requestableTeams as $index => $requestableTeam) {
                                array_push($statement, "id=$index");
                        }

                        $statement = "WHERE (" . implode(" OR ", $statement) . ")";
                }

                $sql = "SELECT * FROM club_teams_pool {$statement}";
                $this->db = new Database();
                $this->db->setQuery($sql);
                $this->db->setSingleValueWithKey(true);

                $data = $this->db->fetch();
                return $data;
        }

}

namespace _filtered_teams_card;
use Model;
use Database;

class TableView_Model extends Model{

        public function __construct()
        {
                parent::__construct();
        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }





        function fetchedTeamsFromUsingTrainerRoles(){

                #highlight_string(var_export($this->pars, true));

                $leagues                = $this->pars->selected_league;
                $teams                  = json_encode($this->pars->team);
                $club_id                = $this->pars->selected_club;
                $environment_zip        = $this->pars->environment_zip;

                $statementLeague        = "( IF(team_league IS NOT NULL, SOURCE_JSON_IN_SCOOP_JSON( '{$leagues}', team_league ), 0 ))";
                $statementTeam          = "( IF(team IS NOT NULL, SOURCE_JSON_IN_SCOOP_JSON( '{$teams}', team ), 0 ))";

                $statementEnvironmentPostcodes   = "";

                if( !is_null( $this->pars->selected_club ) ){

                        $statementClubId        = "AND club_id = {$club_id}";
                        $statementEnvironmentPostcodes   = "";

                } else {

                        $statementClubId        = "";
                        if( !is_null($environment_zip)){

                                $environment_zip = json_encode($environment_zip);
                                $statementEnvironmentPostcodes   = "
                                
                                AND (
      (SELECT IN_INDEXED_ARRAY('{$environment_zip}', ((SELECT post_code FROM clubs WHERE id=user_using_roles.club_id))))
      OR
      (SELECT IN_INDEXED_ARRAY('{$environment_zip}', ((SELECT plz FROM kontakt WHERE id=user_using_roles.user_id)))))
                                ";

                        }

                }



                #echo $leagues . "<br />";
                #echo json_encode($teams) . "<br />";
                $sql = "
                        
                        SELECT *,
                         (SELECT teamName2 FROM dfb.dfb_league_clubs WHERE id=user_using_roles.club_id ) as pretty_club_name
                         FROM user_using_roles 
                        WHERE 
                        {$statementLeague}
                        AND 
                        {$statementTeam}
                        {$statementClubId}
                        {$statementEnvironmentPostcodes}
                 
                ";
                
                $this->db = new Database();
                $this->db->setQuery($sql);
                $this->db->setSingleValueWithKey(true);
                $data = $this->db->fetchGroups("club_id", "id");

                #echo $this->db->getQueryString();

                return $data;

                


        }



        function getEnvironmentAreaById(){

                $sql = "SELECT * FROM zip_coordinates WHERE zc_id=" . intval($this->pars->environment_area_id);

                $this->db = new Database();
                $this->db->setQuery($sql);
                return $this->db->fetch();




        }


}
