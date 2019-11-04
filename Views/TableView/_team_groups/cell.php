
<?php if( !is_null( $this->data->view_controller_data ) ){ ?>

    <?php $view_controller= Helper::JSONCleaned($this->data->view_controller_data); ?>

    <!--VIEW CONTROLLER-->
    <li class="cell" data-sub-title="" data-sub-title-color="text-info" >
        <a data-data="<?= $view_controller; ?>" >
                <?= $this->data->team_group["name"]; ?>

            <input type="hidden" name="team_group_id" id="team_group_id" value="<?=$this->data->team_group["id"];?>" />
            <input type="hidden" name="selected_league" id="selected_league" value="" />
            <input type="hidden" name="pretty_selected_league_name" id="pretty_selected_league_name" value="" />
        </a>
    </li>

<?php } else { ?>

    <!--RADIO OR CHECKBOX-->
    <li class="cell" >
        <input
                type="<?= (!is_null($this->data->pars->row_type) ? $this->data->pars->row_type : "radio"); ?>"
                name="team_group[]" id="team_group<?= $this->data->team_group["id"]; ?>"
                value="<?= $this->data->team_group["id"]; ?>"
                data-id="<?= $this->data->team_group["id"]; ?>"
                data-pretty-name="<?= $this->data->team_group["name"]; ?>"

        >
        <label for="team_group<?= $this->data->team_group["id"]; ?>">
                <?= $this->data->team_group["name"]; ?>
        </label>


    </li>


<?php } ?>
