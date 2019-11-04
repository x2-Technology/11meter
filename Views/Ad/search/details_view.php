<div class="view-body">
    <ul class="x2-list border-bottom-0" id="ad-details">
            <?= $this->data->header;?>
    </ul>

    <?php if($this->data->my_id !== $this->data->ad_data["ad_owner"] && !$this->data->ad_data["is_interested"] ) { ?>


    <ul class="x2-list border-bottom-0" id="team-select">

        <li class="section">
            Mein Mannschaft
        </li>

        <!--INTERESTED TEAM SELECT -->
            <?php if( count($this->data->availability_clubs_with_teams) ) {


                    if( count($this->data->availability_clubs_with_teams) === 1 ) {

                            $availability_clubs_with_team = $this->data->availability_clubs_with_teams[0];

                            ?>

                        <!--FOR SINGLE TEAM NO NEED OTHER VIEW-->
                        <li class="cell disabled" disabled>
                            <select id="interested_team" name="interested_team">
                                <option value="<?= $availability_clubs_with_team[1];?>">
                                        <?= $availability_clubs_with_team[0]; ?>
                                </option>
                            </select>
                            <label for="interested_team" class="d-none"></label>
                        </li>



                    <?php } elseif( count( $this->data->availability_clubs_with_teams ) > 1) { ?>

                        <!--GOTO VIEW CONTROLLER FOR MULTIPLE AVAILABILITY TEAMS-->

                        <li class="cell required select">
                            <select id="interested_team" name="interested_team" >

                                <option value="0" >Meine Mannschaft</option>
                                    <?php foreach ($this->data->availability_clubs_with_teams as $availability_clubs_with_team) { ?>


                                        <option value="<?= implode(",", $availability_clubs_with_team[1]); ?>" >
                                                <?= $availability_clubs_with_team[0]; ?>
                                        </option>

                                    <?php }  ?>

                            </select>
                            <label for="interested_team" class="d-none"></label>
                        </li>


                    <?php } else { ?>

                        <!--NO TEAM FOR ROLE PROCESS NOT POSSIBLE-->
                        <li class="cell disabled" disabled >
                            <label for="ad_owner_team">Sie haben keine Mannschaft</label>
                        </li>

                    <?php }
            }

            else { ?>

                <!--NO TEAM FOR ROLE PROCESS NOT POSSIBLE-->
                <li class="cell disabled" disabled >
                    <label for="ad_owner_team">Mannschaft</label>
                </li>

            <?php } ?>

    </ul>

    <?php } ?>

</div>


<!--<div class="view-footer">
    <?php /*if($this->data->my_id !== $this->data->ad_data["ad_owner"]) { */?>
        <input type="button" id="interested_to_ad" class="text-primary x2-mobile-button" value="Ich habe intersse" />
    <?php /*} else { */?>
        <button type="button" id="interested_to_ad" class="text-primary x2-mobile-button with-badge" data-badge-value="<?/*=$this->data->ad_data["ad_interested"];*/?>" >Interesse</button>
    <?php /*} */?>
</div>-->