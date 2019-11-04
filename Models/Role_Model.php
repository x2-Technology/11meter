<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 24.02.19
 * Time: 18:01
 */

namespace manage;

use Model;
use Database;
use REPOSITORY;
use REGISTER_ROLE;
use CONFIRMATION_TYPE;

class Role_Model extends Model
{

        function __construct()
        {
                parent::__construct();
        }

        public function connect()
        {
                parent::connect(); // TODO: Change the autogenerated stub
        }


        /**
         * @return Database
         * Role Clubs to Database
         */
        function add()
        {

                // Add Database

                #print_r($this->pars->clubs);
                $this->connect();
                $this->db = new Database(); // $this->connect();
                $this->db->setTable("user_using_roles");
                if (count($this->pars->clubs)) {

                        foreach ($this->pars->clubs as $club) {

                                $club = (object)$club;


                                $league_and_club = explode(",", $club->club);


                                $this->db->set("status", $club->status);
                                $this->db->set("visibility", 1);
                                // $this->db->set("association_id", $league_and_club[0]);
                                $this->db->set("club_id", $club->club);
                                $this->db->set("activity_from", $club->activity_from);
                                $this->db->set("activity_to", $club->activity_to);
                                $this->db->set("season_id", $club->season);

                                if (!is_null($this->pars->licence)) {
                                        $this->db->set("licence", $this->pars->licence);
                                }

                                if (!is_null($this->pars->licence_until)) {
                                        $this->db->set("licence_until", $this->pars->licence_until);
                                }

                                /*
                                 * Role with Code **/
                                if (!is_null($this->pars->code)) {
                                        $this->db->set("_code", $this->pars->code);
                                }

                                if (count($club->team)) {
                                        $this->db->set("team", json_encode($club->team));
                                }

                                if (count($club->team_group)) {
                                        $this->db->set("team_group", json_encode($club->team_group));
                                }

                                if (count($club->team_league)) {
                                        $this->db->set("team_league", json_encode($club->team_league));
                                }

                                if (count($club->team_dfb_name)) {
                                        $this->db->set("team_dfb_name", json_encode($club->team_dfb_name));
                                }

                                if (count($club->team_dfb_link)) {
                                        $this->db->set("team_dfb_link", json_encode($club->team_dfb_link));
                                }


                                if (empty($club->user_used_role_id) || (!is_numeric($club->user_used_role_id) && !empty($club->user_used_role_id))) {
                                        $this->db->set("role_id", $club->role);
                                        $this->db->set("user_id", REPOSITORY::read(REPOSITORY::CURRENT_USER)["id"]);

                                        $this->db->Insert();
                                } else {
                                        // $this->db->setCondition("id", $club->user_used_role_id, "AND");
                                        // $this->db->setCondition("confirmed_by_club", NULL, 'OR');
                                        // $this->db->setCondition("confirmed_by_club", CONFIRMATION_TYPE::TYPE_NOT_CHECKED );
                                        $this->db->setConditionSpecial("id={$club->user_used_role_id} AND (confirmed_by_club IS NULL OR confirmed_by_club=" . CONFIRMATION_TYPE::TYPE_NOT_CHECKED . ")");

                                        $this->db->Update();
                                }


                        }


                }


                return $this->db;

        }


        /**
         *
         * This operation for Group 4
         * Add role for Club Admin
         * And Create Club from template DFB
         */
        function addRoleForClubAdmin()
        {
                return $this->add();
        }


        function delete()
        {


                $sql = "DELETE FROM user_using_roles WHERE id=" . $this->pars->id;

                if (!is_null($this->pars->id)) {

                        $this->connect();
                        $this->db->setQuery($sql);
                        $this->db->Delete();

                        return $this->db;


                }

                return (object)array(
                        "resulta" => true,
                        "process" => true
                );

        }

        function fetchUserUsedRoles()
        {

                #print_r($this->pars);
                #highlight_string(var_export($this->pars, true));
                $this->connect();


                $statement = array();

                if (!is_null($this->pars->user_used_role_id)) {

                        array_push($statement, "id=" . $this->pars->user_used_role_id);
                }

                else {

                        array_push($statement, "user_id=" . REPOSITORY::read(REPOSITORY::CURRENT_USER)["id"]);


                }

                if (!is_null($this->pars->role_id)) {

                        switch (gettype($this->pars->role_id)){

                                case "array":
                                case "object":

                                        $statement_role = array();

                                        if( count($this->pars->role_id) ){
                                                foreach ( $this->pars->role_id as $role_id ) {
                                                        array_push($statement_role, "role_id=" . intval($role_id) );
                                                }

                                                $statement_role = "(" . implode(" OR ", $statement_role ). ")";

                                                array_push($statement, $statement_role );
                                        }


                                        break;



                                case "integer":
                                        $statement_role = "role_id=" . $this->pars->role_id;
                                        array_push($statement, $statement_role );
                                        break;

                                case "string":
                                        $this->pars->role_id = intval($this->pars->role_id);
                                        $statement_role = "role_id=" . $this->pars->role_id;
                                        array_push($statement, $statement_role );
                                        break;
                        }




                }




                $sql = "
                          SELECT user_using_roles.*,
                          /**
                          * Converted 3 data 
                          * need for role edit
                          */
                          id as user_used_role_id,
                          club_id as club,
                          season_id as season,
                          
                          
                          (SELECT DATE_FORMAT(user_using_roles.activity_from, '%d.%m.%Y')) as pretty_activity_from,
                          (SELECT DATE_FORMAT(user_using_roles.activity_to, '%d.%m.%Y')) as pretty_activity_to,
                          (SELECT DATE_FORMAT(user_using_roles.licence_until, '%d.%m.%Y')) as pretty_licence_until,
                          
                          /*External Database*/
                          (SELECT dfb.associations.name FROM dfb.associations WHERE associations.id=user_using_roles.association_id) as pretty_association_name,
                          (SELECT dfb.dfb_league_clubs.teamName2 FROM dfb.dfb_league_clubs WHERE dfb_league_clubs.id=user_using_roles.club_id) as pretty_club_name,
                          
                          (SELECT name FROM seasons WHERE seasons.id=season_id) as pretty_season,
                          (SELECT icon FROM register_roles WHERE register_roles.id=role_id) as role_icon,
                          (SELECT color FROM register_roles WHERE register_roles.id=role_id) as role_color,
                          (SELECT name FROM register_roles WHERE register_roles.id=role_id) as display_name,
                          (SELECT logo FROM confirmation_types WHERE id=(IF(confirmed_by_club IS NULL,3,confirmed_by_club))) as confirmed_by_club_logo,
                          (CASE WHEN confirmed_by_club IS NULL THEN false WHEN confirmed_by_club=3 THEN false ELSE true END ) as role_locked
                         FROM user_using_roles WHERE " . implode(" AND ", $statement);

                $this->db->setQuery($sql);
                $this->db->setSingleValueWithKey(true);
                $data = $this->db->fetch();

                #echo $this->db->getQueryString();
                #print_r($data);

                return $data;


        }


        /*
         * Check Required Club has Admin
         * */
        function checkAdminForClub()
        {

                $sql = "SELECT * FROM user_using_roles WHERE club_id={$this->pars->club} AND role_id=" . REGISTER_ROLE::ROLE_CLUB_ADMIN . " LIMIT 1";

                $this->db = new Database();
                $this->db->setQuery($sql);
                return $this->db->fetch();

        }

        /**
         * Add Club
         * With his Admin
         * This operation work after Role Club Admin Add
         */
        function addLocalClub()
        {


                $banned_cols = array(
                        "pretty_club_name",
                        "club",         // club_id ve club ayni anlama geliyor yani id
                        "club_id",      // club_id ve club ayni anlama geliyor yani id
                        "roles_table_should_reload",
                        "unwindFrom",
                        "clubs",
                        "role",
                        "register_role",
                        "username",
                        "password",
                        "user_used_role_id"
                );


                $getDFBClubData = $this->getDFBClubData();

                // print_r($getDFBClubData);




                $this->db = new Database();

                $this->db->setTable("clubs");
                $this->db->set("name", $getDFBClubData["teamName2"]);


                foreach ($this->pars as $index => $par) {
                        if (!in_array($index, $banned_cols)) {
                                $this->db->set($index, $par);
                        }
                }

                $this->db->set("dfb_id", $getDFBClubData["id"]);
                $this->db->setUpdateColsByInsert(array(
                        "register_id", "street", "post_code", "town", "logo", "tel", "email", "status", "facebook", "instagram", "twitter", "youtube", "founding_year", "homepage"
                ));


                $this->db->InsertOrUpdate();
                #echo $this->db->getQueryString();


                return $this->db;

        }

        function manageClubAdmin(){

                #print_r($this->pars);
                $banned_cols = array();

                $this->pars->name = $this->pars->admin_name;
                $this->pars->surname = $this->pars->admin_surname;

                unset($this->pars->admin_name);
                unset($this->pars->admin_surname);

                $this->db = new Database();
                $this->db->setTable("club_managers");
                if(count($this->pars)){
                        foreach ($this->pars as $k => $v )  {
                              $this->db->set($k, $v);
                        }
                }

                $this->db->setUpdateColsByInsert(array(
                   "username","password"
                ));
                $this->db->InsertOrUpdate();

                #echo $this->db->getQueryString();

                return $this->db;





        }


        private function getDFBClubData()
        {


                $club_id = !is_null($this->pars->club_id) ? $this->pars->club_id : $this->pars->club;

                $sql = "SELECT * FROM dfb.dfb_league_clubs WHERE id={$club_id}";
                $this->db = new Database();
                $this->db->setQuery($sql);
                $data = $this->db->fetch();

                // print_r($this->db->getQueryString());

                return $data;

        }


        function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}

namespace load;

use Model;
use manage\Role_Model as Role_Manage;
use Database;
use REGISTER_ROLE;

class Role_Model extends Model
{
        public function __construct()
        {
                parent::__construct();
        }

        public function connect()
        {
                parent::connect(); // TODO: Change the autogenerated stub
        }


        function getUserRole()
        {

                $roleManage = new Role_Manage();
                $roleManage->pars = $this->pars;

                $user_used_roles = $roleManage->fetchUserUsedRoles();

                if (!is_null($user_used_roles)) {
                        // Required Role
                        return array_shift($user_used_roles);

                }

                return array();

        }

        function getRegisteredClubData(){

                #highlight_string(var_export($this->pars, true));
                
                $this->db = new Database();

                $sql = "SELECT * FROM clubs c
                        LEFT JOIN (SELECT dfb_club_id, club_id, manager_role, username, password FROM club_managers ) cm ON ( cm.dfb_club_id=c.dfb_id AND cm.manager_role = 1 )
                        WHERE c.register_id=".$this->pars->register_id." AND c.dfb_id=" . $this->pars->club_id . " LIMIT 1";
                
                
                
                $this->db->setQuery($sql);

                #echo $this->db->getQueryString();

                return $this->db->fetch();
        }


        function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}

namespace assistant;

use Model;
use Database;

class Role_Model extends Model
{
        public function __construct()
        {
                parent::__construct();
        }

        public function connect()
        {
                parent::connect(); // TODO: Change the autogenerated stub
        }

        function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

        function fetchDFBClubData()
        {

                // $this->connect();
                $this->db = new Database("dfb");
                $this->db->setTable("dfb_league_clubs");
                $this->db->setCondition("id", $this->pars->club);
                return $this->db->fetch();


        }






}