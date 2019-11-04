<?php if( !is_null( $this->data->view_controller_data ) ){ ?>

        <!--VIEW CONTROLLER-->
    <?php $cellData = Helper::JSONCleaned($this->data->view_controller_data); ?>
    <li class="cell" data-sub-title="" data-sub-title-color="text-info" >
        <a data-data="<?= $cellData; ?>" class="font-size-14">
                <?= $this->data->team["name"]; ?>

                <input type="hidden" name="team_id" id="team_id" value="<?= $this->data->team["id"]; ?>" />
                <input type="hidden" name="team_name" id="team_name" value="<?= $this->data->team["name"]; ?>" />
                <input type="hidden" name="team_group" id="team_group" value="" />
                <input type="hidden" name="selected_league" id="selected_league" value="" />
                <input type="hidden" name="pretty_selected_team_group_name" id="pretty_selected_team_group_name" value="" />
                <input type="hidden" name="pretty_selected_league_name" id="pretty_selected_league_name" value="" />

        </a>
    </li>

<?php } else { ?>

        <!--RADIO OR CHECKBOX-->
    <li class="cell" >
        <input
                type="<?= (!is_null($this->data->pars->row_type) ? $this->data->pars->row_type : "radio"); ?>"
                name="team_[]" id="team_<?= $this->data->team["id"]; ?>"
                value="<?= $this->data->team["id"]; ?>"
                data-id="<?= $this->data->team["id"]; ?>"
                data-pretty-name="<?= $this->data->team["name"]; ?>"

        >
        <label for="team_<?= $this->data->team["id"]; ?>">
                <?= $this->data->team["name"]; ?>
        </label>


    </li>


<?php } ?>
