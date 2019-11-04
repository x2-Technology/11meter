<?php /** @noinspection ALL */

/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 09.12.18
 * Time: 21:43
 */


namespace _start;
use Controller;
use ReflectionException;
use REPOSITORY;
use EXTRAS_REDIRECT;
use FETCH_STRUCTURE;

class Extras extends Controller
{
        /**
         * Extras constructor.
         * @param $pars
         * @param bool $public_load
         * @throws ReflectionException
         */
        function __construct($pars)
        {
                parent::__construct($pars);
        }

        function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

        public function index()
        {

                $me = REPOSITORY::read(REPOSITORY::CURRENT_USER);
                $assignedTeams = (array)json_decode($me["mannschaft"]);

                // array_push($assignedTeams, '37');
                        
                $hasTeams = count($assignedTeams);

                // Transfer Data
                $this->pars->club_id = $me["club_id"];

                if ($hasTeams) {

                        if ($hasTeams > 1) {

                                $NAMESPACE = "_teams";
                                $this->pars->teams = $assignedTeams;
                        }

                        else {

                                $this->pars->teams = $assignedTeams[0];

                                switch ($this->pars->redirect){
                                        case EXTRAS_REDIRECT::REDIRECT_FUSSBALLDE:
                                                $NAMESPACE = "_" . $this->pars->subview;
                                                break;

                                        case EXTRAS_REDIRECT::REDIRECT_DOCUMENT:
                                                break;


                                }

                        }


                        try {
                                $class = "\\$NAMESPACE\\Extras";
                                #echo $class;

                                $t = new $class($this->pars);
                                $t->index();
                                

                        } catch (ReflectionException $e) {

                        }



                } else {

                        $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                        $this->view->data = array(
                            "message" => "Sie sind mit keinem Team verbunden!!!"
                        );
                        $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


                }

        }





}


namespace _teams;

use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use ACTIVITY;
use Config;
use EXTRAS_REDIRECT;

class Extras extends Controller
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

                $cells = $this->cells();

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "cells" => $cells
                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


        }


        private function cells()
        {

                $this->model->pars = $this->pars;
                $teams = $this->model->fetchTeams()["data"];

                // Substring Translate
                $substringTranslate = array(
                        "document"=>"Dokument", "overview"=>"Alles zur Liga", "table"=>"Tabelle"
                );

                $final_team_rows = array();
                if (count($teams)) {

                        foreach ($teams as $index => $team) {

                                #highlight_string(var_export($this->pars, true));

                                $cell_data = array();
                                $cell_data["display_name"] = $team["name"] . " " . $substringTranslate[$this->pars->subview] ;
                                $cell_data["link"] =
                                        Config::BASE_URL .
                                        DIRECTORY_SEPARATOR .
                                        "Extras" .
                                        DIRECTORY_SEPARATOR .
                                        "_" . $this->pars->subview .
                                        DIRECTORY_SEPARATOR .
                                        "index/?teams=" . $index
                                ;
                                $cell_data[ACTIVITY::ACTIVITY] = ACTIVITY::go(ACTIVITY::ACTIVITY_2);


                                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_ARRAY);
                                $this->view->data = array(
                                        "cell_data" => $cell_data,
                                        "db" => $team
                                );

                                $row = $this->view->fileContent($this->getReflectedClass()->getShortName() . DIRECTORY_SEPARATOR . $this->getReflectedClass()->getNamespaceName(), "cell.php");

                                array_push($final_team_rows, array("cell" => $row, "data" => $team));
                        }

                }

                return $final_team_rows;


        }


        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

}


// Fussball de Overview
namespace _overview;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use REPOSITORY;
class Extras extends Controller
{

        const LOCATION = "app.my-team-manager.de";
        /**
         * Extras constructor.
         * @param $pars
         * @param bool $public_load
         * @throws ReflectionException
         */
        function __construct($pars)
        {
                parent::__construct($pars);
        }

        function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

        public function index()
        {
                
                // team
                $this->model->pars = $this->pars;
                $team = $this->model->fetchTeam()["data"];

                $dataURL = "//www.fussball.de/widget2/-/schluessel/" . $team["_spieltag"] . "/target/widget2/caller/" . self::LOCATION;




                // TODO: Implement index() method.
                $this->view->data = array(
                        "url"=>$dataURL
                );
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);
        }
        
        
        


}

// Fussball de Table
namespace _table;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use REPOSITORY;
class Extras extends Controller
{

        const LOCATION = "app.my-team-manager.de";
        /**
         * Extras constructor.
         * @param $pars
         * @param bool $public_load
         * @throws ReflectionException
         */
        function __construct($pars)
        {
                parent::__construct($pars);
        }

        function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }

        public function index()
        {


                // team
                $this->model->pars = $this->pars;
                $team = $this->model->fetchTeam()["data"];

                $dataURL = "//www.fussball.de/widget2/-/schluessel/" . $team["_tabelle"] . "/target/widget2/caller/" . self::LOCATION;
                #highlight_string(var_export($dataURL, true));

                // TODO: Implement index() method.
                $this->view->data = array(
                        "url"=>$dataURL
                );
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);
        }





}

namespace _document;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use REPOSITORY;
use Config;
use ACTIVITY;
class Extras extends Controller{

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



                #highlight_string(var_export($this->pars, true));

                /*$this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "groups" => $groups
                );

                $row = $this->view->fileContent($this->getReflectedClass()->getShortName() . DIRECTORY_SEPARATOR . $this->getReflectedClass()->getNamespaceName(), "_groups.php");

                array_push($final_team_rows, array("groups" => $groups));

                */

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "cells"=>$this->groupCells()
                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


        }



        private function groupCells()
        {

                $this->model->pars = $this->pars;
                $cells = $this->model->fetchGroups()["data"];

                #highlight_string(var_export($cells, true));
                $final_group_cells = array();
                if (count($cells)) {

                        foreach ($cells as $index => $cell) {

                                #highlight_string(var_export($this->pars, true));

                                $cell_data = array();
                                $cell_data["display_name"] = $cell["name"];
                                $cell_data["link"] =
                                        Config::BASE_URL .
                                        DIRECTORY_SEPARATOR .
                                        "Extras" .
                                        DIRECTORY_SEPARATOR .
                                        $this->getReflectedClass()->getNamespaceName() .
                                        DIRECTORY_SEPARATOR .
                                        "groupDocs/?group_id=" . $index . "&team=" . $cell["mannschaft_id"]
                                ;
                                $cell_data[ACTIVITY::ACTIVITY] = ACTIVITY::go(ACTIVITY::ACTIVITY_3);


                                array_push($final_group_cells, array(
                                        "db" => $cell,
                                        "cell_data" => $cell_data,
                                ));
                        }

                }

                return $final_group_cells;


        }


        function groupDocs(){

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "cells"=>$this->groupDocCells()
                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . "documents");


        }


        private function groupDocCells()
        {

                #highlight_string(var_export($this->pars, true));
                $this->model->pars = $this->pars;

                // Only 1 item Docs included in JSon string in column
                $cell = $this->model->fetchGroupDocs()["data"];

                #highlight_string(var_export($cells, true));
                $final_docs_cells = array();
                if ( !is_null($cell["file"])) {

                        $files = json_decode($cell["file"], true);
                        #highlight_string(var_export($files, true));

                        if( count($files) ){

                                foreach ($files as $index => $file) {


                                        $cell_data = array();
                                        $cell_data["display_name"] = $file["f_name"];
                                        $cell_data["link"] =
                                                Config::BASE_URL .
                                                DIRECTORY_SEPARATOR .
                                                "Extras" .
                                                DIRECTORY_SEPARATOR .
                                                $this->getReflectedClass()->getNamespaceName() .
                                                DIRECTORY_SEPARATOR .
                                                "view/?club_id=" . $cell["club_id"] . "&team_id=" . $this->pars->team . "&group_id=" . $cell["id"] . "&file=" . $file["f_file"]
                                        ;
                                        $cell_data[ACTIVITY::ACTIVITY] = ACTIVITY::go(ACTIVITY::ACTIVITY_4);


                                        array_push($final_docs_cells, array(
                                                "cell_data" => $cell_data,
                                        ));
                                }
                        }
                }

                return $final_docs_cells;


        }

        public function view()
        {
                // TODO: Implement index() method.


                $src  = "";
                $src .= Config::CLUB_DOCS_BASE_URI;
                $src .= DIRECTORY_SEPARATOR;
                $src .= $this->pars->club_id;
                $src .= DIRECTORY_SEPARATOR;
                $src .= "docs";
                $src .= DIRECTORY_SEPARATOR;
                $src .= $this->pars->team_id;
                $src .= DIRECTORY_SEPARATOR;
                $src .= $this->pars->group_id;
                $src .= DIRECTORY_SEPARATOR;
                $src .= $this->pars->file;

                // highlight_string(var_export($this->pars, true));

                /*$this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "groups" => $groups
                );

                $row = $this->view->fileContent($this->getReflectedClass()->getShortName() . DIRECTORY_SEPARATOR . $this->getReflectedClass()->getNamespaceName(), "_groups.php");

                array_push($final_team_rows, array("groups" => $groups));

                */

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->data = array(
                        "src"=>$src
                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__ );


        }





}










// DEPRECATED HERE USE IN TABLE VIEW


namespace _season;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use REPOSITORY;
use Config;
use ACTIVITY;
class Extras extends Controller{

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
                        "seasons"=>$this->public->getSeasons()
                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


        }

}

namespace _leagues;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use REPOSITORY;
use Config;
use ACTIVITY;
class Extras extends Controller{

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

}

namespace _postcodes;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use REPOSITORY;
use Config;
use ACTIVITY;
class Extras extends Controller{

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
                        "postcodes"=>$this->public->fetchPostCodes()
                );
                $this->view->render($this->getReflectedClass()->getShortName(), $this->getReflectedClass()->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__);


        }

}

namespace _time_suggestion;
use Controller;
use FETCH_STRUCTURE;
use ReflectionException;
use REPOSITORY;
use Config;
use ACTIVITY;
class Extras extends Controller{

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

class Extras extends Controller{

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
                        "Extras",
                        "_postcodes",
                        "index",
                        array(), // Selected (If )
                        ACTIVITY::ACTIVITY_6,
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

class Extras extends Controller{

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


