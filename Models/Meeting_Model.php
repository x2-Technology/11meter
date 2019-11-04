<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 27.09.18
 * Time: 12:03
 */

namespace _list;

use Model;
use Database;
use FETCH_TYPE;
use Config;
use REPOSITORY;

class Meeting_Model extends Model
{

        public function __construct()
        {
                parent::__construct();
        }

        public function connect()
        {
                // TODO: Implement connect() method.
                $this->db = new Database();
        }


        function fetchAll()
        {

                // $this->connect();

                $this->db = new Database();

                #highlight_string(var_export(REPOSITORY::readAll(), true));
                $cuser          = REPOSITORY::read(REPOSITORY::CURRENT_USER);
                $uid            = $cuser["uid"];
                $my_teams       = $cuser["mannschaft"];



                $sql = "SELECT *,
                    (SELECT anls.name FROM anlass as anls WHERE anls.id = meeting.anlass ) as display_name,
                    (SELECT anls.color FROM anlass as anls WHERE anls.id = meeting.anlass ) as title_color,
                    (SELECT CONCAT((SELECT de FROM day_names WHERE num=DAYOFWEEK(meeting.datum)), ', ' ,  DATE_FORMAT(meeting.datum,'%d.%m.%Y'))) as meeting_pretty_date,
                    (SELECT DATE_FORMAT(meeting.treff,'%H:%i')) as meeting_meet,
                    (SELECT DATE_FORMAT(meeting.beginn,'%H:%i')) as meeting_start,
                    (SELECT DATE_FORMAT(meeting.ende,'%H:%i')) as meeting_end,
                    (SELECT DATE_FORMAT(meeting.abfahrt_zeit,'%H:%i')) as meeting_drive_time,
                    (SELECT ms.club_id FROM mannschaft as ms WHERE ms.id=(SELECT TRIM(BOTH '\"' FROM (SELECT JSON_EXTRACT(meeting.mannschaft, '$[0]'))))) as club_id, 
                    (SELECT GET_TEAMS_FOR_MEETING(meeting.mannschaft)) as my_team,
                    (SELECT CONCAT('" . Config::CLUB_DOCS_BASE_URI . "/', club_id, '/club_logo.png')) as my_team_icon,
                    IF( meeting.gegner IS NOT NULL, (SELECT kontakt.nachname FROM kontakt WHERE kontakt.id=meeting.gegner), NULL ) as opponent_team,
                    (SELECT CONCAT('" . Config::CLUB_DOCS_BASE_URI . "','/', club_id, '/members/', meeting.gegner, '.png')) as opponent_team_icon,
                    (SELECT CONCAT('" . Config::CLUB_DOCS_BASE_URI . "','/club-avatar.png')) as icon_club_avatar,
                    (SELECT CONCAT('" . Config::CLUB_DOCS_BASE_URI . "','/occasion/', meeting.anlass, '.jpg')) as img_header_background,
                    (SELECT IF( fulldate > NOW(), TRUE, FALSE ) ) as is_active,
                    (SELECT transfer_method FROM anwesenheit WHERE kontakt={$uid} AND termin=meeting.id) as transfer_method_decided,
                    
                    (SELECT anwesenheit FROM anwesenheit WHERE termin=meeting.id AND kontakt={$uid}) as my_availability,
                    
                    /* Member Availability Reason from Date, Resulta from 'Sub Query' from Anwesenheit (need original column name here for Save to Anwesenheit again for Availability Status )*/
                    (SELECT reason_from FROM anwesenheit WHERE termin=meeting.id AND kontakt={$uid}) as reason_from,
                    /*Member Availability Reason until to Date, Resulta from 'Sub Query' from Anwesenheit (need original column name here for Save to Anwesenheit again for Availability Status )*/
                    (SELECT reason_to FROM anwesenheit WHERE termin=meeting.id AND kontakt={$uid}) as reason_to,
                    
                    (SELECT IF(my_availability IS NULL, TRUE, FALSE )) as missing_data,
                    (SELECT reason FROM anwesenheit WHERE termin=meeting.id AND kontakt={$uid}) as my_reason,
                    /*(SELECT abwesenheit_grund.name from abwesenheit_grund WHERE id=my_reason) as my_reason_text,*/
                    (SELECT display_name from meeting_reasons_with_point WHERE id=my_reason) as my_reason_text,
                    (SELECT reason_comment FROM anwesenheit WHERE termin=meeting.id AND kontakt={$uid}) as my_reason_custom_comment,
                    
                    (IF(fulldate < NOW(), true, false)) as feedback_possible  
              
              FROM termine as meeting ";


                // highlight_string(var_export($this->pars, true));
                if (count($this->pars)) {

                        if (!is_null($this->pars->queryCustomStatement)) {

                                $statement = $this->pars->queryCustomStatement;

                        }

                        else {
                                if (!is_null($this->pars->id)) {
                                        $statement = " id=" . $this->pars->id;
                                }


                        }

                        if (!empty($statement)) {
                                $sql .= " WHERE " . $statement . " AND SOURCE_JSON_IN_SCOOP_JSON('{$my_teams}', meeting.mannschaft)";
                        }


                } else {

                        $statement = " fulldate > NOW() AND SOURCE_JSON_IN_SCOOP_JSON('{$my_teams}', meeting.mannschaft)";
                        // $sql .= " WHERE " . $statement . " AND SOURCE_JSON_IN_SCOOP_JSON('{$my_teams}', meeting.mannschaft)";
                        // $sql .= " ORDER BY datum ASC LIMIT 1000;";

                }


                $this->db = new Database();
                $this->db->setQuery($sql);

                $this->db->setConditionSpecial($statement);
                // $this->db->setLimit(2);
                // $this->db->setLimit($this->LIMIT);
                $this->db->setOrderBy($this->ORDER_BY);
                #echo $this->db->getOrderBy();

                $this->db->setSingleValueWithKey(true);
                $this->db->setFetchType(FETCH_TYPE::ASSOC);
                $this->db->setRowKey("id");
                $data = $this->db->fetch();
                #echo $this->db->getQueryString();
                #highlight_string(var_export($data, true));




                return $data;


        }

        public function fetchNext(){

                $this->ORDER_BY = array("fulldate", Database::ORDER_ASC);
                $this->pars->queryCustomStatement = "fulldate > NOW()";
                return $this->fetchAll();
        }

        public function fetchPrev(){
                $this->ORDER_BY = array("fulldate", Database::ORDER_DESC);
                $this->pars->queryCustomStatement = "fulldate < NOW()";
                return $this->fetchAll();
        }


        function fetch()
        {


        }


        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }
}


namespace _details;

use Model;
use Database;

class Meeting_Model extends Model
{
        public function __construct()
        {
                parent::__construct();
        }

        public function connect()
        {
                // TODO: Implement connect() method.
                $this->db = new Database();
        }

        function fetch()
        {

                $list = new \_list\Meeting_Model();

                $list->pars = $this->pars;


                // -> default fetch is singleValueWith key option
                // -> because of the data take of with array_shift
                #highlight_string(var_export($list->fetchAll(), true));
                return array_shift($list->fetchAll());

        }


        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }
}


namespace _presence;

use Model;
use Config;
use Database;
use FETCH_TYPE;
use TEAMROLLE;
use VAR_EXTENSION;
use ANWESENHEIT;

class Meeting_Model extends Model
{


        public function connect()
        {
                // TODO: Implement connect() method.
                $this->db = new Database();
        }


        function fetchAll()
        {

                #highlight_string(var_export($this->pars, true));
                $this->connect();

                $sql = "SELECT *
                              , (SELECT kontakt.final_name FROM kontakt WHERE kontakt.id = anwesenheit.kontakt) as member_final_name
                              , (SELECT ms.club_id FROM mannschaft as ms WHERE ms.id=(SELECT TRIM(BOTH '\"' FROM (SELECT JSON_EXTRACT((SELECT mannschaft FROM termine WHERE termine.id=anwesenheit.termin), '$[0]'))))) as club_id
                              , (SELECT CONCAT( REPLACE( ( SELECT vorname FROM kontakt WHERE id = anwesenheit.kontakt ), ' ', '_' ), '_', REPLACE( ( SELECT nachname FROM kontakt WHERE id = anwesenheit.kontakt ), ' ', '_' ), '_', ( SELECT YEAR(geburtsdatum) FROM kontakt WHERE id = anwesenheit.kontakt ))) as member_image_formatted_name
                              , (SELECT CONCAT('" . Config::CLUB_DOCS_BASE_URI . "', '/' ,club_id, '/members/', member_image_formatted_name ,'.png')) as member_image
                              , (SELECT CONCAT('" . Config::CLUB_DOCS_BASE_URI . "', '/' ,club_id, '/members/', member_image_formatted_name ,'" . VAR_EXTENSION::THUMB . ".png')) as member_image" . VAR_EXTENSION::THUMB . "
                              , (SELECT '/images/avatar.png') as member_image_avatar
                              
                              , IF( (SELECT kontakt.teamrolle FROM kontakt WHERE kontakt.id = anwesenheit.kontakt)=" . TEAMROLLE::COTRAINER . " OR (SELECT kontakt.teamrolle FROM kontakt WHERE kontakt.id = anwesenheit.kontakt)=" . TEAMROLLE::TORWARTTRAINER . " OR (SELECT kontakt.teamrolle FROM kontakt WHERE kontakt.id = anwesenheit.kontakt)=" . TEAMROLLE::TRAINER . ", TRUE, FALSE) as is_trainer 
                              , IF( (SELECT kontakt.teamrolle FROM kontakt WHERE kontakt.id = anwesenheit.kontakt)=" . TEAMROLLE::SPIELER . ", TRUE, FALSE) as is_player
                              
                              , IF( feedback IS NOT NULL, feedback, " . MEETING_FEEDBACK_TYPE_IN_TIME . ") as feedback_option
                              
                              , (SELECT display_name FROM anwesenheits WHERE id=anwesenheit.anwesenheit) as presence_display_name
 
                        FROM anwesenheit WHERE anwesenheit.termin = " . $this->pars->meeting_id . " ORDER BY member_final_name ASC;";


                $this->db->setQuery($sql);
                $this->db->setSingleValueWithKey(true);
                $this->db->setFetchType(FETCH_TYPE::ASSOC);
                $this->db->setRowKey("id");
                $data = $this->db->fetch();
                #highlight_string(var_export($this->db->getQueryString(), true));
                #highlight_string(var_export($data, true));
                return $data;
                #echo $this->db->getQueryString();


        }


}


namespace _availability;

use Model;
use Database;
use ANWESENHEIT;

class Meeting_Model extends Model
{


        public function connect()
        {
                // TODO: Implement connect() method.
                $this->db = new Database();
        }

        function save()
        {

                $updated_meetings = array();
                // If possibility is NO 
                // Check out of for the multiple Meetings
                if( $this->pars->selected_availability == ANWESENHEIT::NO ){

                        #highlight_string(var_export($this->pars, true));
                        // Check Meetings between date
                        $sqlStatement = "";
                        if( !empty($this->pars->reason_from) && !empty($this->pars->reason_to) ){

                                // Do Stuff
                                $sqlStatement = "datum between '" . $this->pars->reason_from . "' AND '" . $this->pars->reason_to . "';";

                        }

                        else if(!empty($this->pars->reason_from) && empty($this->pars->reason_to)){

                                // Do Stuff
                                $sqlStatement = "datum > '" . $this->pars->reason_from . "';";
                        }

                        else if(empty($this->pars->reason_from) && !empty($this->pars->reason_to)){

                                // Do Stuff
                                $sqlStatement = "datum BETWEEN NOW() AND '" . $this->pars->reason_to . "';";
                        }

                        else if(empty($this->pars->reason_from) && empty($this->pars->reason_to)){

                                // Do Stuff
                                // Do Nothing Only for selected Meeting

                        }

                        if( empty($sqlStatement)){

                                $sqlStatement = "id=" . $this->pars->meeting_id;
                        }

                        $sql = "SELECT * FROM termine WHERE " . $sqlStatement;

                        // echo $sql;
                        $this->db = new Database();
                        $this->db->setQuery($sql);
                        $this->db->setSingleValueWithKey(true);
                        $meetings = $this->db->fetch();
                        if( count($meetings) ){
                                $updated_meetings = array_keys($meetings);
                        }
                        #highlight_string(var_export($updated_meetings, true));;
                        #echo $this->db->getQueryString();

                } else {



                        $updated_meetings = array($this->pars->meeting_id);

                }

                #highlight_string(var_export($updated_meetings, true));

                $this->db = new Database();

                if( count($updated_meetings) ){


                        // Bind with key
                        $_ = array();
                        foreach ($updated_meetings as $index => $updated_meeting) {
                                array_push($_, "(termin={$updated_meeting} AND kontakt={$this->pars->uid})");
                        }

                        $updateStatement = implode(" OR ", $_);

                        $reason         = is_null($this->pars->reason)  ? "NULL" : $this->pars->reason;
                        $reasonFrom     = empty($this->pars->reason_from)    ? "NULL" : "'" . date_create($this->pars->reason_from)->format("Y-m-d") . "'";
                        $reasonTo       = empty($this->pars->reason_to)      ? "NULL" : "'" . date_create($this->pars->reason_to)->format("Y-m-d") . "'";
                        $av             = $this->pars->selected_availability;
                        $reason_comment        = empty($this->pars->reason_comment) ? "NULL" : "'" . $this->pars->reason_comment . "'";

                        $sql = "UPDATE anwesenheit SET 
                              anwesenheit={$av}, 
                              reason_from={$reasonFrom}, 
                              reason_to={$reasonTo}, 
                              reason={$reason}, 
                              reason_comment={$reason_comment} WHERE " . $updateStatement;

                        $this->db->setQuery($sql);
                        $this->db->queryExecute();
                        $this->db->extras = $updated_meetings;

                } else {
                        $this->db->resulta = true;
                        $this->db->process = false;
                }


                return $this->db;


        }

}


namespace _feedback;

use Model;
use Config;
use Database;
use _presence\Meeting_Model as Presence_Meeting_Model;
use ANWESENHEIT;
use phpDocumentor\Reflection\Types\This;

class Meeting_Model extends Model
{


        public function connect()
        {
                // TODO: Implement connect() method.
                $this->db = new Database();
        }


        function fetchAll()
        {
                $presence_model = new Presence_Meeting_Model();
                $presence_model->pars = $this->pars;
                $data = $presence_model->{__FUNCTION__}();
                #highlight_string(var_export($data, true));
                return $data;
        }


        function save(){


                $feedbackReasons = $this->public->getReasons('listable_feedback');

                #highlight_string(var_export($feedbackReasons, true));


                $this->connect();

                $sql = "";

                $this->db = new Database();

                $report = "";

                if( count($this->pars->fb) )
                {
                        foreach ( $this->pars->fb as $fb) {

                                // $anwesenheit                    = 0;
                                // $termin_feedback_with_point     = NULL;

                                $anwesenheit    = "anwesenheit=" . ANWESENHEIT::YES;
                                $feedback       = "feedback=" . $fb["option"];

                                if( $feedbackReasons[$fb["option"]]["absence_declared"] ){

                                        $anwesenheit = "anwesenheit=" . ANWESENHEIT::NO;
                                        // $termin_feedback_with_point = "termin_feedback_with_point=NULL";
                                }



                                /*switch ($fb["option"])

                                {
                                        case MEETING_FEEDBACK_TYPE_NONE: // All ok
                                                // No Stuff
                                                $anwesenheit = "anwesenheit=" . ANWESENHEIT::NO;
                                                $termin_feedback_with_point = "termin_feedback_with_point=NULL";
                                                break;

                                        case MEETING_FEEDBACK_TYPE_IN_TIME: // All ok
                                                // No Stuff
                                                $anwesenheit = "anwesenheit=" . ANWESENHEIT::YES;
                                                $termin_feedback_with_point = "termin_feedback_with_point=NULL";
                                                break;

                                        case MEETING_FEEDBACK_TYPE_DELAYED: // Delayed
                                                $anwesenheit = "anwesenheit=" . ANWESENHEIT::YES;
                                                $termin_feedback_with_point = "termin_feedback_with_point=" . MEMBER_PRESENCE_TYPE_NO_IN_TIME;
                                                break;

                                        case MEETING_FEEDBACK_TYPE_DFB: // With Sorry
                                                $anwesenheit = "anwesenheit=" . ANWESENHEIT::NO;
                                                $termin_feedback_with_point = "termin_feedback_with_point=" . MEMBER_PRESENCE_TYPE_DFB;
                                                break;

                                        case MEETING_FEEDBACK_TYPE_EXCUSED: // With Sorry
                                                $anwesenheit = "anwesenheit=" . ANWESENHEIT::NO;
                                                $termin_feedback_with_point = "termin_feedback_with_point=" . MEMBER_PRESENCE_TYPE_UNKNOWN;
                                                break;


                                        case MEETING_FEEDBACK_TYPE_UNEXCUSED: // Without Sorry
                                                $anwesenheit = "anwesenheit=" . ANWESENHEIT::NO;
                                                $termin_feedback_with_point = "termin_feedback_with_point=" . MEMBER_PRESENCE_TYPE_UNEXCUSED;
                                                break;


                                        case MEETING_FEEDBACK_TYPE_INJURED: // Verletzt
                                                $anwesenheit = "anwesenheit=" . ANWESENHEIT::NO;
                                                $termin_feedback_with_point = "termin_feedback_with_point=" . MEMBER_PRESENCE_TYPE_INJURED;
                                                break;

                                }*/

                                /*$bonus = $fb["bonus"] == "true" ? true : "NULL";
                                $sql .= "UPDATE anwesenheit 
                                            SET 
                                            {$anwesenheit}, 
                                            {$termin_feedback_with_point},  
                                            bonus={$bonus}
                                            WHERE termin={$this->pars->meeting_id} AND kontakt={$fb["player"]};";*/

                                $sql .= "UPDATE anwesenheit 
                                            SET 
                                            {$anwesenheit}, 
                                            feedback=" . $fb["option"] . "
                                            WHERE termin={$this->pars->meeting_id} AND kontakt={$fb["player"]};";

                                if( $fb["player"] == 283 ){
                                        $report = $sql;
                                }



                        }


                        $this->db->setQuery($sql);
                        $this->db->queryExecute();

                        #echo $report;

                        return (object) array(
                                "resulta"       => $this->db->resulta,
                                "process"       => $this->db->process,
                                "sql"           => $this->db->getQueryString(),
                                "errCode"       => $this->db->errCode,
                                "errInfo"       => $this->db->errInfo
                        );



                }






                return (object) array(
                        "resulta"       => false,
                        "process"       => $this->db->process,
                        "sql"           => $this->db->getQueryString(),
                        "errCode"       => $this->db->errCode,
                        "errInfo"       => highlight_string(var_export($this->pars, true))
                );


        }


}