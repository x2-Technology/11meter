<?php $d = $this->data->ad_data;?>
    <li class="cell ">

            <div class="container-fluid">
                    <div class="row">
                            <div class="col text-center font-size-18 font-bold"><?= $d["ad_group"]; ?></div>
                    </div>

                    <div class="row text-center">
                            <div class="col font-small">
                                    <i class="icon icon-calendar"></i> <?= $d["pretty_german_day_name_from_ad_date"]; ?>, <?= $d["pretty_ad_date"]; ?>
                                    <br>
                                    <i class="icon icon-watch2"></i> <?= $d["pretty_ad_time"]; ?>
                            </div>
                    </div>
            </div>


    </li>


    <?php if($this->data->my_id !== $this->data->ad_data["ad_owner"] ) { ?>


        <?php if( $this->data->ad_data["is_interested"] ) { ?>

            <!-- GOTO DISCUSSION VIEW -->
            <li class="cell">
                <a data-data="<?= Helper::JSONCleaned($this->data->discussions_view_controller_data); ?>">
                    Diskussion
                </a>
            </li>



        <?php } else { ?>


            <!-- INTERESTED CAN SETTING  -->
            <li class="section transparent">
                <input type="button" id="interested_to_ad" class="text-primary x2-mobile-button" value="Ich habe intersse" />
            </li>

        <?php }  ?>



    <?php } else { ?>
        <li class="cell">
            <a data-data="<?= Helper::JSONCleaned($this->data->ad_interested_people_view_controller_data);?>" >
                Interessierte Mitglied
                <span class="additional-icon"><span class="with-badge" data-badge-value="<?= $this->data->ad_data["ad_interested"]; ?>"></span> </span>
            </a>
        </li>
    <?php } ?>


<li class="section">
        Details
</li>

<li class="cell font-small">

        <div class="container-fluid nopadding">
                <div class="row nopadding">
                        <div class="col-3 pl-0 font-bold">Verein</div>
                        <div class="col-9 pl-0"><?= $d["pretty_my_club_name_for_ad"]; ?></div>
                </div>

                <div class="row nopadding">
                        <div class="col-3 pl-0 font-bold">Mannschaft</div>
                        <div class="col-9 pl-0"><?= $d["pretty_my_team_name_for_ad"]; ?> <?= $d["ad_owner_team_group"]; ?>, <?= $d["pretty_my_team_league_for_ad"]; ?></div>
                </div>


                <?php if( !is_null($d["ad_in_local"]) && $d["ad_in_local"] ){ ?>

                    <hr />

                    <div class="row nopadding">
                            <div class="col-3 pl-0 font-bold">Heim</div>
                            <div class="col-9 pl-0"><?= $d["ad_in_local_address"]; ?></div>
                    </div>


                    <?php if( !is_null($this->data->ad_data["place_covering_local"]) ) :?>
                        <?php
                                $place_covering_local = json_decode($this->data->ad_data["place_covering_local"]);
                                $pretty_place_covering = array();
                                if( count($place_covering_local) ){
                                    foreach ($place_covering_local as $item) {
                                            array_push($pretty_place_covering, $this->data->place_coverings_data[$item]["name"]);
                                    }
                                }
                                ?>
                                <div class="row nopadding">
                                    <div class="col-3 pl-0 font-bold">Spielfeldbelag</div>
                                    <div class="col-9 pl-0 font-italic text-info"><?= implode(", ",  $pretty_place_covering); ?></div>
                                </div>
                    <?php endif;?>


                <?php }?>


                <?php if( !is_null($d["ad_in_outwards"]) && $d["ad_in_outwards"] ){ ?>

                    <hr >

                    <div class="row nopadding">
                        <div class="col-3 pl-0 font-bold">Outwards</div>
                        <div class="col-9 pl-0"><?= $d["pretty_outwards_area_name"]; ?>
                            <?php if( !is_null($d["ad_in_outwards_km"]) ) :?>
                                , (<span class="text-info font-mini font-italic">Umgebung:<?= $d["ad_in_outwards_km"]; ?> km</span>) </div>
                            <?php endif;?>
                    </div>


                    <?php if( !is_null($this->data->ad_data["place_covering_outwards"]) ) :?>
                            <?php
                            $place_covering_outwards = json_decode($this->data->ad_data["place_covering_outwards"]);
                            $pretty_place_covering = array();
                            if( count($place_covering_outwards) ){
                                foreach ($place_covering_outwards as $item) {
                                        array_push($pretty_place_covering, $this->data->place_coverings_data[$item]["name"]);
                                }
                            }
                            ?>
                    <div class="row nopadding">
                        <div class="col-3 pl-0 font-bold">Spielfeldbelag</div>
                        <div class="col-9 pl-0 font-italic text-info"><?= implode(", ",  $pretty_place_covering); ?></div>
                    </div>
                    <?php endif;?>




                <?php }?>



                <?php if(!is_null($d["ad_opponent_leagues_suggestion"])) :

                        $leaguesData = $this->data->dfb_leagues;

                        $interested_leagues = json_decode($d["ad_opponent_leagues_suggestion"]);
                        $pretty_leagues_names = array();
                        if( count($interested_leagues) ){
                                foreach ($interested_leagues as $interested_league) {
                                        array_push($pretty_leagues_names, $leaguesData[$interested_league]["name"]);
                                }
                        }
                        ?>

                        <hr />
                        <div class="row nopadding">
                            <div class="col-3 pl-0 font-bold">Spielklasse</div>
                            <div class="col-9 pl-0 font-italic text-info"><?= implode(", ", $pretty_leagues_names); ?></div>
                        </div>

                <?php endif; ?>


                <?php if(!is_null($d["ad_opponent_teams_suggestion"])) :

                        $teamsData = $this->data->dfb_teams;

                        $interested_teams = json_decode($d["ad_opponent_teams_suggestion"]);
                        $pretty_team_names = array();
                        if(count($interested_teams)){
                                foreach ($interested_teams as $interested_team) {
                                        array_push($pretty_team_names, $teamsData[$interested_team]["name"]);
                                }
                        }
                        ?>

                        <hr />
                        <div class="row nopadding">
                            <div class="col-3 pl-0 font-bold">Mannschaft</div>
                            <div class="col-9 pl-0 font-italic text-info"><?= implode(", ", $pretty_team_names); ?></div>
                        </div>



                <?php endif; ?>


        </div>

</li>