<?php if( !is_null( $this->data->view_controller_data ) ){ ?>

        <?php
            #highlight_string(var_export($this->data->fetched_team, true));
        
        ?>
        
        <!--VIEW CONTROLLER-->
    <?php $cellData = Helper::JSONCleaned($this->data->view_controller_data); ?>
    <li class="cell" data-sub-title=" <?= $this->data->fetched_team["pretty_team_name"]; ?>, <?= $this->data->fetched_team["pretty_league_name"]; ?>" data-sub-title-color="text-info" >
        <a data-data="<?= $cellData; ?>" class="font-size-14">
                <label><?= $this->data->fetched_team["pretty_club_name"]; ?></label>

                <div class="d-table-cell vertical-align-middle">
                    <select id="trainer_" name="trainer_" class="text-info">
                        <option value="0"></option>
                    </select>
                    <label for="trainer_" class="d-none"></label>
                </div>
            <input type="hidden" name="club_id" id="club_id" value="<?= $this->data->fetched_team["club_id"]; ?>" />
            <input type="hidden" name="team_id" id="team_id" value="<?= $this->data->fetched_team["team_id"]; ?>" />
            <!--<input type="hidden" name="team_group_id" id="team_group_id" value="<?/*= $this->data->fetched_team["team_group_id"]; */?>" />-->
            <!--TEAM GROUP TRAINER SECILDIKTEN SONRA SECILECEK-->


            <input type="hidden" name="league_id" id="league_id" value="<?= $this->data->fetched_team["league_id"]; ?>" />
            <input type="hidden" name="role_id" id="role_id" value="<?= $this->data->fetched_team["role_id"]; ?>" />

        </a>
    </li>

<?php } else { ?>

        <!--RADIO OR CHECKBOX-->
    <li class="cell" >
        <input type="<?= (!is_null($this->data->pars->row_type) ? $this->data->pars->row_type : "radio"); ?>" name="team_[]" id="team_<?= $this->data->team["id"]; ?>" value="<?= $this->data->team["id"]; ?>" >
        <label for="team_<?= $this->data->team["id"]; ?>">
                <?= $this->data->team["name"]; ?>
        </label>


    </li>


<?php } ?>
