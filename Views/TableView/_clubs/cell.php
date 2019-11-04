<?php if( !is_null( $this->data->pars->view_controller_data ) ){ ?>

        <!--VIEW CONTROLLER-->
    <?php $cellData = Helper::JSONCleaned($this->data->view_controller_data); ?>
    <li class="cell" data-sub-title="" data-sub-title-color="text-info" >
        <a data-data="<?= $cellData; ?>" class="font-size-14">
                <?= $this->data->fetched_club["teamName2"]; ?>
        </a>
    </li>

<?php } else { ?>

        <!--RADIO OR CHECKBOX-->
    <li class="cell" >
        <input
                type="<?= (!is_null($this->data->pars->row_type) ? $this->data->pars->row_type : "radio"); ?>"
                name="club_[]" id="club_<?= $this->data->fetched_club["id"]; ?>"
                value="<?= $this->data->fetched_club["id"]; ?>"
                data-pretty-name="<?= $this->data->fetched_club["teamName2"]; ?>"
        >

        <label for="club_<?= $this->data->fetched_club["id"]; ?>">
                <?= $this->data->fetched_club["teamName2"]; ?>
                (<?= $this->data->fetched_club["id"]; ?>)
        </label>


    </li>


<?php } ?>
