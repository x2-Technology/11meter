
<?php $disabled = !$this->data->season["status"] ? "disabled=\"disabled\"" : ""; ?>


<?php if( !is_null( $this->data->pars->view_controller_data ) ){ ?>

        <!--VIEW CONTROLLER-->
    <?php $cellData = Helper::JSONCleaned($this->data->view_controller_data); ?>
    <li class="cell ltr" <?= $disabled; ?> data-sub-title="" data-sub-title-color="text-info" >
        <a data-data="<?= $cellData; ?>" class="font-size-14">
                <?= $this->data->season["teamName2"]; ?>
        </a>
    </li>

<?php } else { ?>



        <!--RADIO OR CHECKBOX-->
    <li class="cell ltr" <?= $disabled; ?> >
        <input
                type="<?= (!is_null($this->data->pars->row_type) ? $this->data->pars->row_type : "radio"); ?>"
                name="season[]" id="season_<?= $this->data->season["id"]; ?>"
                value="<?= $this->data->season["id"]; ?>"
                data-pretty-name="<?= $this->data->season["name"]; ?>"
        >

        <!--Season View Controller Yapilacak-->

        <label for="season_<?= $this->data->season["id"]; ?>">
                <?= $this->data->season["name"]; ?>
        </label>


    </li>


<?php } ?>
