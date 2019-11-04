<?php 

    #highlight_string(var_export($this->data->crated_ad_from_database, true));

    $isEditable = !$this->data->is_editable ? "disabled " : "";



    // DATA FOR PUBLIC ALREADY CREATED
    if( $this->data->inquiry_type === INQUIRY_TYPE::INQUIRY_PUBLIC ){
            $ad_data_from_db = $this->data->crated_ad_from_database;
    }

    // DATA FOR PRIVATE ALREADY CREATED
    else if( $this->data->inquiry_type === INQUIRY_TYPE::INQUIRY_TARGET ){

        $ad_data_from_db                    = $this->data->crated_ad_from_database;
        $ad_details_json_data_for_this_ad   = json_decode($this->data->crated_ad_from_database["ad_details_json_data"], true);

    }

    

    #highlight_string(var_export($ad_data_from_db, true));




    if ($this->data->error) { ?>
        <div data-role="role-error" data-show-with="alert" data-message="<?= $this->data->error_message; ?>"></div>
    <?php } ?>
<form>
<ul class="x2-list">



        <input type="hidden" name="inquiry_type" id="inquiry_type" value="<?= $this->data->inquiry_type; ?>">

        <!--AD PARTNERS ID-->
        <?php if( !is_null($ad_data_from_db["ad_partners_id"]) ) { ?>
            <input type="hidden" name="ad_partners_id" id="ad_partners_id" value="<?= $ad_data_from_db["ad_partners_id"]; ?>">
        <?php }?>


        <li class="section mt20"></li>

        <!--STATE ONLY FOR PUBLIC -->
        <? $k = "status"; ?>

        <?php if( $this->data->inquiry_type === INQUIRY_TYPE::INQUIRY_PUBLIC ) { ?>

            <li class="cell <?=$isEditable;?>">
                    <label for="xs" class="">Status</label>
                    <div class="switch">

                            <?php
                            $checked = "";
                            if (count($this->data->user_used_role)) {
                                    if ($this->data->user_used_role[$k]) {
                                            $checked = "checked=checked";
                                    }
                            }
                            ?>

                            <input type="checkbox" name="<?= $k; ?>" id="<?= $k; ?>" <?= $checked; ?> >
                            <label for="<?= $k; ?>" class="label-primary"></label>
                    </div>
            </li>

        <?php } ?>


        <!--TEAM SELECT -->
        <?php if( count($this->data->availability_clubs_with_teams) ) {


                if( count($this->data->availability_clubs_with_teams) === 1 ) {

                        $availability_clubs_with_team = $this->data->availability_clubs_with_teams[0];

                        ?>

                        <!--FOR SINGLE TEAM NO NEED OTHER VIEW-->
                        <li class="cell disabled" disabled>
                                <select id="team">
                                        <option value="<?= $availability_clubs_with_team[1];?>">
                                                <?= $availability_clubs_with_team[0]; ?>
                                        </option>
                                </select>
                                <label for="team" class="d-none"></label>
                        </li>



                <?php } elseif( count( $this->data->availability_clubs_with_teams ) > 1) { ?>

                        <!--GOTO VIEW CONTROLLER FOR MULTIPLE AVAILABILITY TEAMS-->

                        <?php
                            $isEditableForTeam = !is_null($ad_data_from_db["ad_owner_club"]) ? "disabled" : "";
                        ?>

                        <li class="cell select <?=$isEditableForTeam;?> required" >
                                <select id="ad_owner_team" name="ad_owner_team">




                                        <option value="0" >Meine Mannschaft</option>
                                        <?php foreach ($this->data->availability_clubs_with_teams as $availability_clubs_with_team) { ?>


                                                <!--// FOR EDIT OPTION AND FOR PUBLIC-->
                                                <?php
                                                    $selected = "";

                                                    if( count($ad_data_from_db) ){

                                                        if(
                                                                intval($ad_data_from_db["ad_owner_club"]) === intval($availability_clubs_with_team[1][0])  &&
                                                                intval($ad_data_from_db["ad_owner_team"]) === intval($availability_clubs_with_team[1][1])
                                                        ){

                                                          $selected = "selected='selected'";

                                                        }
                                                    }
                                                ?>


                                                <!--
                                                    0.Club Id
                                                    1.Team Id
                                                    2.Team Group Id
                                                    3.League Id
                                                -->

                                                <option value="<?= implode(",", $availability_clubs_with_team[1]); ?>" <?= $selected; ?> >
                                                        <?= $availability_clubs_with_team[0]; ?>
                                                </option>

                                        <?php }  ?>

                                </select>
                                <label for="ad_owner_team" class="d-none"></label>
                        </li>


                <?php } else { ?>

                <!--NO TEAM FOR ROLE PROCESS NOT POSSIBLE-->
                        <li class="cell disabled" disabled >
                                <label for="ad_owner_team">Mannschaft</label>
                        </li>

        <?php }
        }

        else { ?>

                <!--NO TEAM FOR ROLE PROCESS NOT POSSIBLE-->
                <li class="cell disabled" disabled >
                        <label for="ad_owner_team">Mannschaft</label>
                </li>

        <?php } ?>

        <!--DATE-->
        <li class="cell form required <?=$isEditable;?>">
                <label for="ad_date">Datum</label>
                <input type="date" id="ad_date" name="ad_date" value="<?= $ad_details_json_data_for_this_ad["ad_date"];?>" />
        </li>


        <!--OPPONENT TEAM -->

        <?php
            $isEditableOpponentTeam = !is_null($ad_data_from_db["pretty_club_name"]) ? "disabled" : "";
            

            $sub_title = $ad_data_from_db["opponent_team_sub_title_for_cell"];

            // echo $sub_title;

        ?>


        <li class="cell <?=$isEditableOpponentTeam;?>"  data-sub-title="<?=htmlspecialchars($sub_title);?>" data-sub-title-color="text-info" data-sub-title-html="true" id="opponent_team"  >
            <a data-data="<?= Helper::JSONCleaned($this->data->teams_view_controller_data); ?>">
                <label>Gegner Mannschaft</label>

                <!--SINGLE TEAM-->
                <?php if( $this->data->inquiry_type === INQUIRY_TYPE::INQUIRY_PUBLIC ) { ?>

                    <select id="opponent_team" name="opponent_team[]" class="text-info" >
                        <option value="0"></option>
                    </select>
                    <label for="opponent_team" class="d-none"></label>


                <!--MULTIPLE TEAM-->
                <?php } else if ( $this->data->inquiry_type === INQUIRY_TYPE::INQUIRY_TARGET ){ ?>

                    <div id="teams">
                        <!--MULTIPLE TEAMS LAYOUT HERE IN CONTAINER, REQUEST VIA HTTP, AND THIS ONLY FOR VIEW-->

                    </div>


                <?php } ?>



            </a>
        </li>


        <!--OPPONENT LEAGUE ONLY FOR PUBLIC INQUIRY-->
        <?php if( $this->data->inquiry_type === INQUIRY_TYPE::INQUIRY_PUBLIC ){ ?>
            <li class="cell" data-sub-title="" data-sub-title-color="text-info">
                    <a data-data="<?= Helper::JSONCleaned($this->data->leagues_view_controller_data); ?>">
                            <label >Gegner Spielklasse</label>
                            <!--<input type="hidden" name="opponent_team_league[]" id="opponent_league" />-->
                            <div id="teams_leagues">

                                <!-- LEAGUES ELEMENTS CREATING VIA JS-->
                                <!-- WITH FUNCTION updateRowLeague -->

                            </div>

                    </a>
            </li>
        <?php } ?>


        <!--EVENT START TIME -->
        <!-- DO THIS SELECT ELEMENT TO REQUIRED -->
    <?php
        #echo $ad_details_json_data_for_this_ad["ad_suggestion"];
    ?>
        <li class="cell required <?=$isEditable;?>">

            <a data-data="<?= Helper::JSONCleaned($this->data->playtime_view_controller_data); ?>">
                <label>Spielbeginn</label>
                <select class="text-info" id="ad_suggestion" name="ad_suggestion"  >
                    <option value="<?= $ad_data_from_db["ad_suggestion"]; ?>" data-time="<?= $ad_data_from_db["ad_suggestion"]; ?>" ><?= $ad_data_from_db["pretty_ad_time"]; ?></option>
                </select>
                <label for="ad_suggestion" class="d-none"></label>

                <input type="hidden" name="ad_time" id="ad_time" value="<?= $ad_details_json_data_for_this_ad["ad_time"];?>" />

            </a>


        </li>


        <!-- SECTION -->

        <li class="section"></li>
        <li class="section bg-warning">AUSTRAGUNGSORT</li>

        <li class="cell switch <?=$isEditable;?>">
                <label for="xs" class="">Heimspiel</label>
                <div class="switch">

                        <?php
                            $checked = $ad_details_json_data_for_this_ad["ad_in_local"] === "true" ? "checked='checked'":"";
                        ?>

                        <input type="checkbox" name="ad_in_local" id="ad_in_local" <?=$checked;?> >
                        <label for="ad_in_local" class="label-primary"></label>
                </div>
        </li>

        <?php $key = "ad_in_local_address"; ?>
        <li class="cell form required <?=$isEditable;?>">
                <label for="ad_in_local_address" class="d-none"></label>
                <textarea class="box-no-border full-width" name="<?= $key; ?>" id="<?= $key; ?>" rows="2" placeholder="Anschrift" ><?=$ad_details_json_data_for_this_ad[$key];?></textarea>
        </li>

        <!--ALAN FOR LOCAL SINGLE-->

        <?php
            //echo $ad_details_json_data_for_this_ad["place_covering_local"];
            // $place_covering_local_array = json_decode($ad_details_json_data_for_this_ad["place_covering_local"]);
            $place_covering_local_array = $ad_details_json_data_for_this_ad["place_covering_local"];
            $place_covering_local_pretty_content = array();
            if( count($place_covering_local_array) ){
                foreach ($place_covering_local_array as $item) {
                    array_push(
                            $place_covering_local_pretty_content,
                            $ad_data_from_db["place_covering_data"][$item]["name"]
                    );
                }
            }
            $place_covering_local_pretty_content = implode(", ", $place_covering_local_pretty_content);
        ?>
        <li class="cell <?=$isEditable;?>" data-sub-title="<?=$place_covering_local_pretty_content;?>" data-sub-title-color="text-info" id="place_covering_local">
            <a data-data="<?= Helper::JSONCleaned($this->data->place_covering_local_view_controller_data); ?>">
                <label>Spielfeldbelag</label>
                <!--CREATING INPUT ELEMENTS VIA JS-->
                <?php
                    if( count($place_covering_local_array) ){
                            foreach ($place_covering_local_array as $item) { ?>
                                <input type="hidden" name="place_covering_local[]" value="<?=$item;?>" />
                            <?php }
                    }
                ?>

            </a>
        </li>

        <!-- SECTION OUTWARDS-->

        <?php $key = "ad_in_outwards"; ?>
        <li class="cell required switch <?=$isEditable;?>">
                <label for="xs" class="">Auswärts</label>
                <div class="switch">
                        <?php
                        $checked = $ad_details_json_data_for_this_ad[$key] === "true" ? "checked='checked'":"";
                        ?>
                        <input type="checkbox" id="<?=$key;?>" name="<?=$key;?>" <?= $checked; ?> >
                        <label for="<?=$key;?>" class="label-primary"></label>
                </div>
        </li>


        <?php if( $this->data->inquiry_type === INQUIRY_TYPE::INQUIRY_PUBLIC ) { ?>
            <li class="cell <?=$isEditable;?>" data-sub-title="" data-sub-title-color="text-info" data-role="environment">
                <a data-data="<?= Helper::JSONCleaned($this->data->environment_view_controller_data); ?>" data-role="environment" >
                    <!--suppress SpellCheckingInspection -->
                    <label>Umkreis</label>
                    <select id="ad_in_outwards_area" name="ad_in_outwards_area"  >
                        <option value="0" ></option>
                    </select>
                    <label for="ad_in_outwards_area" class="d-none"></label>
                    <input type="hidden" name="ad_in_outwards_km" id="ad_in_outwards_km" value="" />
                </a>
            </li>

            <!-- ALAN KAPLAMA FOR OUTWARDS MULTIPLE -->
            <?php
                $place_covering_outwards_array = $ad_details_json_data_for_this_ad["place_covering_local"];
                $place_covering_outwards_pretty_content = array();
                if( count($place_covering_outwards_array) ){
                        foreach ($place_covering_outwards_array as $item) {
                                array_push(
                                        $place_covering_outwards_pretty_content,
                                        $ad_data_from_db["place_covering_data"][$item]["name"]
                                );
                        }
                }
                $place_covering_outwards_pretty_content = implode(", ", $place_covering_outwards_pretty_content);
            ?>


            <li class="cell <?=$isEditable;?>" data-sub-title="" data-sub-title-color="text-info" id="place_covering_outwards">
                <a data-data="<?= Helper::JSONCleaned($this->data->place_covering_outwards_view_controller_data); ?>">
                    <label>Spielfeldbelag</label>
                    <?php
                        if( count($place_covering_outwards_array) ){
                                foreach ($place_covering_outwards_array as $item) { ?>
                                    <input type="hidden" name="place_covering_outwards[]" value="<?=$item;?>" />
                                <?php }
                        }
                    ?>
                </a>
            </li>
        <?php }?>


        <li class="section">Bemerkung</li>
        <li class="cell form box-no-border">
            <textarea class="box-no-border full-width" name="comment" id="comment" rows="2" ><?=$ad_details_json_data_for_this_ad["comment"];?></textarea>
        </li>



</ul>
</form>


<div class="view-footer">
        <input type="button" id="ad_save" class="text-primary x2-mobile-button" value="Speichern" />
        <?php if( !is_null($this->data->event_id )) { ?>
                <input type="button" id="ad_delete" class="text-danger x2-mobile-button" value="Löschen" data-role="role-delete" data-user-used-role-id="<?= $this->data->user_used_role_id; ?>" />
        <?php } ?>
</div>


