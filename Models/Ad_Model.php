<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 2019-05-24
 * Time: 09:50
 */

namespace ads;
use Model;
use Database;
use AD_SUGGETION;

class Ad_Model extends Model
{
        public function __construct()
        {
                parent::__construct();
        }

        function fetchMyAds(){



                
                $statement = array();
                if( !is_null($this->pars->ad_owner) ){
                        array_push($statement, "ad_owner={$this->pars->ad_owner}");
                }

                if( !is_null($this->pars->inquiry_type) ){
                        array_push($statement, "inquiry_type={$this->pars->inquiry_type}");
                }

                if( !is_null($this->pars->ad_id) ){
                        array_push($statement, "id={$this->pars->ad_id}");
                }



                if( count($statement) ){
                        $statement = " WHERE " . implode(" AND ", $statement);
                } else {
                        $statement = "";
                }


                $deep_sql_part = "";
                if( !is_null($this->pars->deep_sql) && $this->pars->deep_sql ){
                        $deep_sql_part = $this->deepSQLPartForAd();
                }



                $sql = "
                
                SELECT *,
                (SELECT ads_group_name FROM ads_groups WHERE id=ads.ads_group_id) as ad_group,
                (SELECT DATE_FORMAT(ad_date, '%d.%m.%Y')) as pretty_ad_date,
                IF( 
                  ad_suggestion IS NULL, 
                    (SELECT name FROM ad_suggestion WHERE id=".AD_SUGGETION::IT_DOES_NOT_MATTER."),IF(ad_suggestion=".AD_SUGGETION::EXCACT_TIME.", ad_time, (SELECT name FROM ad_suggestion WHERE id=ads.ad_suggestion))) as pretty_ad_time,
                    
                    @dayName := (SELECT JSON_UNQUOTE(JSON_EXTRACT('[\"Montag\", \"Dienstag\",\"Mittwoch\",\"Donnerstag\",\"Freitag\",\"Samstag\",\"Sonntag\"]', CONCAT('$[', WEEKDAY(ads.ad_date) , ']')))) as pretty_german_day_name_from_ad_date,
                    (SELECT SUBSTR(@dayName,1,2)) as pretty_shortened_day_name,
                    
                    (SELECT name FROM leagues WHERE id=ads.ad_owner_league) as pretty_my_team_league_for_ad,
                    (SELECT teamName2 FROM dfb.dfb_league_clubs WHERE id=ads.ad_owner_club) as pretty_my_club_name_for_ad,
                    (SELECT name FROM club_teams_pool WHERE id=ads.ad_owner_team) as pretty_my_team_name_for_ad,
                    (SELECT CONCAT(vorname, ' ', nachname) FROM kontakt WHERE id=ads.ad_owner) as pretty_owner_name_for_ad,
                    (SELECT COUNT(id) FROM ad_partners WHERE ad_id=ads.id AND (accepted_at IS NULL AND declined_at IS NULL AND owner_accepted_at IS NULL AND owner_declined_at IS NULL ) ) as ad_interested,
                    
                    (SELECT 1 FROM ad_partners WHERE ad_id=ads.id AND ad_owner <> {$this->pars->my_id} AND person_id={$this->pars->my_id}) as is_interested, 
                    
                    
                    
                    @l1 := (SELECT (CASE WHEN ad_in_local = 1 THEN '[\"H\"]' ELSE '[]' END )) as unless_col_1,
                    @l2 := (SELECT (CASE WHEN ad_in_outwards = 1 THEN (SELECT JSON_ARRAY_APPEND(@l1,'$','A')) ELSE @l1 END )) as unless_col_2,
                    (SELECT @l2) as location_shortened_suggestions
                    {$deep_sql_part}
 
                FROM ads {$statement}";

                $this->db = new Database();
                $this->db->setQuery($sql);
                $this->db->setSingleValueWithKey(true);
                $data = $this->db->fetch();

                #echo $this->db->getQueryString();

                return $data;

        }

        /**
         * @return string
         * Appended Cols
         * * Pretty Outwards Area Name
         */
        function deepSQLPartForAd(){

                $deep_sql = ",(SELECT zc_location_name FROM zip_coordinates WHERE zc_id=ads.ad_in_outwards_area) as pretty_outwards_area_name";

                return $deep_sql;

        }


        function fetchMyAdsPrivate(){

                #highlight_string(var_export($this->pars, true));

                $whereStatement = "ad_partners.ad_owner={$this->pars->ad_owner} AND ads.inquiry_type={$this->pars->inquiry_type}";

                if( !is_null($this->pars->ad_partners_id) ){
                        $whereStatement = "ad_partners.id=" . $this->pars->ad_partners_id;
                }
                else if ( !is_null($this->pars->ad_id) ){
                        $whereStatement = "ad_partners.ad_id=" . $this->pars->ad_id;
                }


                $sql = "
                SELECT *,
                  ad_partners.id as ad_partners_id,
                  
                  
                  ( SELECT teamName2 FROM dfb.dfb_league_clubs WHERE id=ad_partners.club_id ) as pretty_club_name,
                  ( SELECT name FROM club_teams_pool WHERE id=ad_partners.team_id ) as pretty_team_name,
                  ( SELECT name FROM sub_teams WHERE id=ad_partners.team_group_id ) as pretty_team_group_name,
                  ( SELECT name FROM leagues WHERE id=ad_partners.league_id ) as pretty_league_name,
                  ( SELECT CONCAT(vorname, ' ', nachname ) FROM kontakt WHERE id=ad_partners.ad_owner ) as pretty_ad_owner_name,
                  ( SELECT CONCAT(vorname, ' ', nachname ) FROM kontakt WHERE id=ad_partners.person_id ) as pretty_trainer_name,
                  
                  
                  (SELECT ads_group_name FROM ads_groups WHERE id=ads.ads_group_id) as ad_group,
                  (SELECT DATE_FORMAT(ad_date, '%d.%m.%Y')) as pretty_ad_date,
                  
                  @private_ad_suggestion  := (SELECT JSON_UNQUOTE(JSON_EXTRACT(ad_partners.ad_details_json_data, '$.ad_suggestion' ))) as private_ad_suggestion,
                  @private_ad_time        := (SELECT JSON_UNQUOTE(JSON_EXTRACT(ad_partners.ad_details_json_data, '$.ad_time' ))) as ad_time,
                  
                  IF( @private_ad_suggestion IS NULL,
                                            (SELECT name FROM ad_suggestion WHERE id=".AD_SUGGETION::IT_DOES_NOT_MATTER."),
                                            IF(@private_ad_suggestion=".AD_SUGGETION::EXCACT_TIME.", 
                                                @private_ad_time, 
                                                (SELECT name FROM ad_suggestion WHERE id=@private_ad_suggestion))) as pretty_ad_time,
                                                
                  @dayName := (SELECT JSON_UNQUOTE(JSON_EXTRACT('[\"Montag\", \"Dienstag\",\"Mittwoch\",\"Donnerstag\",\"Freitag\",\"Samstag\",\"Sonntag\"]', CONCAT('$[', WEEKDAY(ads.ad_date) , ']')))) as pretty_german_day_name_from_ad_date,
                  (SELECT SUBSTR(@dayName,1,2)) as pretty_shortened_day_name,
                  (SELECT teamName2 FROM dfb.dfb_league_clubs WHERE id=ads.ad_owner_club)  as pretty_my_club_name,
                  /*(SELECT teamName2 FROM dfb.dfb_league_clubs WHERE id=ad_partners.club_id)   as pretty_opponent_club_name,*/
                  (SELECT name FROM club_teams_pool WHERE id=ads.ad_owner_team) as pretty_my_team_name_for_ad,
                  (SELECT name FROM club_teams_pool WHERE id=ad_partners.team_id) as pretty_opponent_team_name_for_ad,
                  @last_message_data := (SELECT (SELECT JSON_OBJECT('id',id,'sender_id',sender_id,'receiver_id',receiver_id,'sender_text',sender_text,'receiver_answer_text',receiver_answer_text,'sender_send_at',sender_send_at,'receiver_read_at',receiver_read_at)) FROM ad_partners_discussion WHERE ad_partners_id=ad_partners.id AND (sender_id={$this->pars->my_id} OR receiver_id={$this->pars->my_id}) ORDER BY sender_send_at DESC LIMIT 1) as last_message_data,
                  @last_discussion_id  := IF( @last_message_data IS NOT NULL,  (SELECT JSON_EXTRACT(@last_message_data, '$.id')), NULL ) as last_discussion_id,
                  @sender_id           := IF( @last_message_data IS NOT NULL, (SELECT JSON_EXTRACT(@last_message_data, '$.sender_id')), NULL) as sender_id,
                  @receiver_id         := IF( @last_message_data IS NOT NULL, (SELECT JSON_EXTRACT(@last_message_data, '$.receiver_id')), NULL ) as receiver_id,
                  @sender_text         := IF( @last_message_data IS NOT NULL, (SELECT JSON_EXTRACT(@last_message_data, '$.sender_text')), NULL ) as sender_text,
                  @receiver_answer_text := IF( @last_message_data IS NOT NULL, (SELECT JSON_EXTRACT(@last_message_data, '$.receiver_answer_text')), NULL ) as receiver_answer_text,
                  /*@last_message_sender := IF( @sender_id = ad_partners.ad_owner OR @sender_id = ad_partners.person_id, 'Du', (SELECT vorname FROM kontakt WHERE id=@receiver_id)) as last_message_sender,*/
                  @last_message_sender := 
                        IF( @receiver_answer_text IS NOT NULL, 
                        (SELECT CASE WHEN @receiver_answer_text = 'null' THEN
                                /*IF( (@sender_id = ad_partners.ad_owner OR @sender_id = ad_partners.person_id) AND @sender_id = {$this->pars->ad_owner}, 'Du', (SELECT vorname FROM kontakt WHERE id=@receiver_id))*/
                                IF( @sender_id = {$this->pars->my_id}, 'Du', (SELECT vorname FROM kontakt WHERE id=@receiver_id) )
                        ELSE
                                IF( @receiver_id = {$this->pars->my_id} , 'Du', (SELECT CONCAT(vorname, ' ', nachname) FROM kontakt WHERE id=@sender_id))
                        END ), 
                        NULL ) as last_message_sender,
                  (SELECT JSON_UNQUOTE(IF( @receiver_answer_text = 'null', @sender_text, @receiver_answer_text))) as last_message_sender_text,
                  IF( @last_message_sender = 'Du', 'icon-arrow-up-right3','icon-arrow-down-right3') as message_way_icon,
                  IF(
                        owner_declined_at IS NOT NULL OR declined_at IS NOT NULL, 'text-danger', 
                                IF( 
                                        (owner_accepted_at IS NOT NULL AND accepted_at IS NULL) OR 
                                        (owner_accepted_at IS NULL AND accepted_at IS NOT NULL), 'text-primary', 
                                                IF(owner_accepted_at IS NOT NULL AND accepted_at IS NOT NULL, 'text-success', 'text-warning') ) ) as status_color
                  
                  FROM ad_partners
                  LEFT JOIN ads ON ad_partners.ad_id = ads.id
                  WHERE {$whereStatement}";

                $this->db = new Database();
                $this->db->setQuery($sql);
                $this->db->setSingleValueWithKey(true);
                $data = $this->db->fetch();

                #highlight_string(var_export($data, true));
                #echo $this->db->getQueryString();

                return $data;


        }

        public function fetchOwnerTotalPrivateAds(){

                $this->db = new Database();
                $this->db->setQuery("SELECT COUNT(id) as total FROM ad_partners WHERE ad_owner={$this->pars->my_id}");
                return $this->db->fetch();

        }

        public function fetchOwnerTotalPublicAds(){
                $this->db = new Database();
                $this->db->setQuery("SELECT COUNT(id) as total FROM ads WHERE ad_owner={$this->pars->my_id} AND inquiry_type=" . \INQUIRY_TYPE::INQUIRY_PUBLIC );
                return $this->db->fetch();
        }

        function userInterestedTheAd(){

                #print_r($this->pars);

                $currently_selected_ad = $this->pars->current_selected_ad;
                $interested_id = $this->pars->interested_id ;

                /**
                 * User Interested Teams
                 * for this Ad
                 */
                $interested_team_data = $this->pars->interested_team;
                $interested_team_data = explode(",", $interested_team_data);
                $interested_club = $interested_team_data[0];
                $interested_team = $interested_team_data[1];
                $interested_team_group = $interested_team_data[2];
                $interested_league = $interested_team_data[3];


                #print_r($interested_team);

                $this->db = new Database();
                $this->db->setTable("ad_partners");
                $this->db->set("ad_id", $currently_selected_ad["id"]);
                $this->db->set("ad_owner", $currently_selected_ad["ad_owner"]);
                $this->db->set("league_id", $interested_league);
                $this->db->set("club_id", $interested_club);
                $this->db->set("team_id", $interested_team);
                $this->db->set("team_group_id", $interested_team_group );
                $this->db->set("person_id", $interested_id );
                $this->db->set("ad_details_json_data", json_encode($currently_selected_ad));



                $this->db->Insert();

                return $this->db;




        }

        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }
}

namespace testplay;
use Model;
use Database;
use ADS_GROUPS;
use ads\Ad_Model as ADS_AD_MODEL;

class Ad_Model extends Model
{
        public function __construct()
        {
                parent::__construct();
        }

        function fetchAdGroup(){

                $sql = "SELECT * FROM ads_groups";

                if( !is_null($this->pars->ad_group_id) )
                {
                        $sql .= " WHERE id=".$this->pars->ad_group_id;
                }

                $this->db = new Database();
                $this->db->setQuery($sql);
                return $this->db->fetch();


        }

        function create(){

                // If this is a update goto other method
                if( !is_null($this->pars->ad_partners_id) ){

                        return $this->updateAdForPrivate();

                }



                $this->db = new Database();
                $this->db->setTable("ads");

                #print_r($this->pars);


                $to = explode(",",$this->pars->ad_owner_team);

                $this->pars->ad_owner_club      = $to[0];
                $this->pars->ad_owner_team      = $to[1];
                $this->pars->ad_owner_team_group= $to[2];
                $this->pars->ad_owner_league    = $to[3];


                $this->db->set("status", $this->pars->status);
                $this->db->set("ad_owner_club", $this->pars->ad_owner_club);
                $this->db->set("ad_owner_team", $this->pars->ad_owner_team);
                $this->db->set("ad_owner_team_group", $this->pars->ad_owner_team_group);
                $this->db->set("ad_owner_league", $this->pars->ad_owner_league);
                $this->db->set("ad_date", $this->pars->ad_date);
                $this->db->set("ad_suggestion", $this->pars->ad_suggestion);
                $this->db->set("ad_time", $this->pars->ad_time);
                $this->db->set("inquiry_type", $this->pars->inquiry_type);


                /**
                 * For public Ad teams and leagues are suggestions here
                 */

                if( gettype($this->pars->opponent_team) === "object" OR gettype($this->pars->opponent_team) === "array" ){
                     $_ = $this->pars->opponent_team;
                }

                else {
                        // This i a no array
                        // put in array
                        $_ = array();
                        array_push($_, $this->pars->opponent_team);
                }


                $this->db->set("ad_opponent_teams_suggestion", json_encode($_));
                $this->db->set("ad_opponent_leagues_suggestion", json_encode($this->pars->opponent_team_league));
                // -------------



                $this->db->set("ad_in_local", $this->pars->ad_in_local);
                if( $this->pars->ad_in_local ){
                        $this->db->set("ad_in_local_address", $this->pars->ad_in_local_address);
                        $this->db->set("place_covering_local", json_encode($this->pars->place_covering_local));
                }

                $this->db->set("ad_in_outwards", $this->pars->ad_in_outwards);
                if( $this->pars->ad_in_outwards ){
                        $this->db->set("ad_in_outwards_area", $this->pars->ad_in_outwards_area);
                        $this->db->set("ad_in_outwards_km", $this->pars->ad_in_outwards_km);
                        $this->db->set("place_covering_outwards", json_encode($this->pars->place_covering_outwards));
                }

                // $this->db->set("place_covering", $this->pars->place_covering);
                $this->db->set("comment", $this->pars->comment);


                $this->db->set("ad_owner", $this->pars->ad_owner);
                $this->db->set("ads_group_id", ADS_GROUPS::ADS_FRIENDSHIP_GAMES);

                $this->db->Insert();

                $ad_table_db_resulta = $this->db;


                /**
                 * Add Record for Partners
                 */
                if( $ad_table_db_resulta->resulta && $ad_table_db_resulta->process ){

                        $this->adPartners( $ad_table_db_resulta->getLastInsertID() );

                }



                return array(
                        "resulta"=>$this->db->resulta,
                        "message"=>"Ilan basari ile olusturuldu!",
                        "pars"=>$this->pars
                );


        }



        private function adPartners( $adID = NULL ){

                $resulta = array();

                if( is_null($adID) ){
                        return null;
                }

                #print_r($this->pars);

                $opponent_club          = $this->pars->opponent_club;
                $opponent_team          = $this->pars->opponent_team;
                $opponent_team_group    = $this->pars->opponent_team_group;
                $opponent_team_league   = $this->pars->opponent_team_league;
                $opponent_trainer       = $this->pars->opponent_trainer;


                if( !count($opponent_club) ){
                       return null;
                }


                $this->db = new Database();
                $this->db->setTable('ad_partners');


                for( $i=0;$i<count($opponent_club);$i++ ){

                        $this->db->set("ad_id", $adID);
                        $this->db->set("league_id", $opponent_team_league[$i]);
                        $this->db->set("club_id", $opponent_club[$i]);
                        $this->db->set("team_id", $opponent_team[$i]);
                        $this->db->set("team_group_id", $opponent_team_group[$i]);
                        $this->db->set("person_id", $opponent_trainer[$i]);

                        $this->db->set("ad_details_json_data", json_encode($this->pars));
                        $this->db->set("ad_owner", $this->pars->ad_owner);

                        $this->db->Insert();

                        array_push($resulta, $this->db);
                }

                return $resulta;





        }


        private function updateAdForPrivate(){



                $fetchOriginalPrivateAdData = $this->fetchPrivateCreatedAdById();

                $fetchedOriginalPrivateAdDataJSON = json_decode($fetchOriginalPrivateAdData["ad_details_json_data"]);

                // print_r($fetchedOriginalPrivateAdDataJSON);

                // update AD data for private
                // echo json_decode($this->pars->place_covering_local);

                $fetchedOriginalPrivateAdDataJSON->ad_date = $this->pars->ad_date;
                $fetchedOriginalPrivateAdDataJSON->ad_suggestion = $this->pars->ad_suggestion;
                $fetchedOriginalPrivateAdDataJSON->ad_time = $this->pars->ad_time;
                $fetchedOriginalPrivateAdDataJSON->comment = $this->pars->comment;
                $fetchedOriginalPrivateAdDataJSON->ad_in_local = $this->pars->ad_in_local;
                $fetchedOriginalPrivateAdDataJSON->ad_in_local_address = $this->pars->ad_in_local_address;
                $fetchedOriginalPrivateAdDataJSON->place_covering_local = $this->pars->place_covering_local;
                $fetchedOriginalPrivateAdDataJSON->ad_in_outwards = $this->pars->ad_in_outwards;

                $fetchedOriginalPrivateAdDataJSON = json_encode($fetchedOriginalPrivateAdDataJSON);

                $sql = "UPDATE ad_partners SET ad_details_json_data='$fetchedOriginalPrivateAdDataJSON' WHERE id=" . $this->pars->ad_partners_id;
                $this->db = new Database();
                $this->db->setQuery($sql);
                $this->db->queryExecute();
                // echo $this->db->getQueryString();

                return array(
                        "resulta"=>$this->db->resulta,
                        "process"=>$this->db->process,
                        "ad_partners_id"=>$this->pars->ad_partners_id,
                        "errInfo"=>$this->db->errInfo,
                        "errCode"=>$this->db->errCode
                );



        }



        function fetchPublicCreatedAdById(){


                $sql = "SELECT * FROM ads WHERE id=" . $this->pars->ad_id;

                $this->db = new Database();
                $this->db->setQuery($sql);
                return $this->db->fetch();


        }

        function fetchPrivateCreatedAdById(){


                $ads_ad_model = new ADS_AD_MODEL();
                $ads_ad_model->pars = $this->pars;
                $data = $ads_ad_model->fetchMyAdsPrivate();

                if( count($data) === 1 ){
                        return array_shift($data);
                }

                return $data;


        }


        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }
}


namespace discussion;
use Model;
use Database;
use ADS_GROUPS;
use ads\Ad_Model as ADS_AD_MODEL;

class Ad_Model extends Model{

        public function __construct()
        {
                parent::__construct();
        }


        public function __destruct()
        {
                parent::__destruct(); // TODO: Change the autogenerated stub
        }


        function fetchAdForPrivateById(){

                $ads_ad_model = new ADS_AD_MODEL();

                $ads_ad_model->pars = $this->pars;

                $data = $ads_ad_model->fetchMyAdsPrivate();
                #highlight_string(var_export($data, true));
                
                return $data;


        }


        /**
         * @return array|mixed|object|string|null
         * Discussion returned from discussion table
         * The All discussions between owner and interested target person
         */
        function fetchAdDiscussions(){

                $myId = $this->pars->my_id;

                $sql = "SELECT * FROM ad_partners_discussion WHERE ad_partners_id={$this->pars->ad_partners_id}";

                $this->db = new Database();
                $this->db->setQuery($sql);
                $this->db->setSingleValueWithKey(true);
                $data = $this->db->fetch();
                return $data;
        }


        /**
         * @return array|mixed|object|string|null
         * Discussion returned from discussion table
         * The Last discussion between owner and interested target person
         */
        function fetchAdLastDiscussion(){

                $sql = "SELECT * FROM ad_partners_discussion WHERE ad_partners_id={$this->pars->ad_partners_id} ORDER BY ID DESC LIMIT 1";


                $this->db = new Database();
                $this->db->setQuery($sql);
                $data = $this->db->fetch();
                return $data;
        }


        function sendMessage(){


                #print_r($this->pars);
                $lastDiscussion = $this->fetchAdLastDiscussion();

                #print_r($lastDiscussion);


                if(
                        count($lastDiscussion) &&
                        is_null($lastDiscussion["receiver_answer_text"]) &&
                        $this->pars->my_id !== $lastDiscussion["sender_id"]
                ){

                        $sql = "UPDATE ad_partners_discussion SET 
                                receiver_answer_text='{$this->pars->message}',
                                receiver_read_at=NOW() 
                                WHERE id={$lastDiscussion["id"]}";

                } else {

                        $sql = "INSERT INTO ad_partners_discussion(sender_id, receiver_id, sender_text/*, receiver_answer_text, sender_send_at, receiver_read_at, */,ad_partners_id) 
                                  VALUES(
                                  {$this->pars->my_id},
                                  {$this->pars->partner_id},
                                  '{$this->pars->message}' ,
                                  {$this->pars->ad_partners_id}
                                  )";

                }

                #echo $sql;

                $this->db = new Database();
                $this->db->setQuery($sql);
                $this->db->queryExecute();




        }



}


namespace deal;
use Model;
use Database;
use ADS_GROUPS;
use ads\Ad_Model as ADS_AD_MODEL;

class Ad_Model extends Model{

        function adPrivateDealWithConfirmation(){


                # print_r($this->pars);
                $sqlPart = "";
                $ad_data = $this->pars->ad_data;

                #echo $this->pars->confirmation === "true" ? "Confirmed" : "No Confirmed";

                if( $this->pars->confirmation === "true"  )
                {
                        if(  $ad_data["ad_owner"] === $this->pars->my_id ){
                                $sqlPart = "owner_accepted_at=NOW()";
                        }
                        else if($ad_data["person_id"] === $this->pars->my_id){
                                $sqlPart = "accepted_at=NOW()";
                        }
                }
                else {
                        if( $ad_data["ad_owner"] === $this->pars->my_id ){
                                $sqlPart = "owner_declined_at=NOW(), owner_declined_comment='" . $this->pars->comment . "'";
                        }
                        else if( $ad_data["person_id"] === $this->pars->my_id){
                                $sqlPart = "declined_at=NOW(), declined_comment='" . $this->pars->comment . "'";
                        }
                }







                $sql = "UPDATE ad_partners SET {$sqlPart} WHERE id=" . $this->pars->ad_data["ad_partners_id"];

                $this->db = new Database();
                $this->db->setQuery($sql);
                $this->db->queryExecute();

                #echo $this->db->getQueryString();

                return $this->db;



                // Comment now

        }


}

namespace search;
use Model;
use Database;
use ads\Ad_Model as ADS_AD_MODEL;

class Ad_Model extends Model{

        function fetchAds(){

                $Ad_Model = new ADS_AD_MODEL();

                /**
                 * fetchAds instead of fetchMyAds
                 */
                $Ad_Model->pars = $this->pars;

                return $Ad_Model->fetchMyAds();



        }



        function fetchPrivateAdFromUserPublicSelectedAd(){

                $ad_id = $this->pars->ad_data["id"];

                $sql = "SELECT id, person_id, ad_id FROM ad_partners WHERE ad_id={$ad_id} AND person_id={$this->pars->my_id} ORDER BY id DESC LIMIT 1";

                $this->db = new Database();
                $this->db->setQuery($sql);
                // $this->db->setSingleValueWithKey(true);
                return $this->db->fetch();


        }


}