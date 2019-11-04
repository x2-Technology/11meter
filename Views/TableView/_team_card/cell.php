<?php if( !is_null( $this->data->pars->view_controller_data ) ){ ?>

        <!--VIEW CONTROLLER-->
    <?php $cellData = Helper::JSONCleaned($this->data->view_controller_data); ?>
    <li class="cell" data-sub-title="" data-sub-title-color="text-info" >
        <a data-data="<?= $cellData; ?>" class="font-size-14">
                <?= $this->data->team["name"]; ?>
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
