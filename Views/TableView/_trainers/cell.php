<?php if( !is_null( $this->data->pars->view_controller_data ) ){ ?>

        <!--VIEW CONTROLLER-->
    <?php $cellData = Helper::JSONCleaned($this->data->view_controller_data); ?>
    <li class="cell" data-sub-title="" data-sub-title-color="text-info" >
        <a data-data="<?= $cellData; ?>" class="font-size-14">
                <?= $this->data->team["name"]; ?>
        </a>
    </li>

<?php } else { ?>

        <?php
            $disabled = "";
            if( intval($this->data->trainer["user_id"]) === intval($this->data->my_id) ){
                $disabled = "disabled";
            }
        ?>

        <!--RADIO OR CHECKBOX-->
    <li class="cell <?=$disabled;?>"  >

        <input
                type="<?= (!is_null($this->data->pars->row_type) ? $this->data->pars->row_type : "radio"); ?>"
                name="trainer_[]" id="trainer_<?= $this->data->trainer["id"]; ?>"
                value="<?= $this->data->trainer["user_id"]; ?>"
                data-pretty-name="<?= $this->data->trainer["trainer_final_name"]; ?>"
        >
        <label for="trainer_<?= $this->data->trainer["id"]; ?>">
                <?= $this->data->trainer["trainer_final_name"]; ?>
                (<?= $this->data->trainer["pretty_trainer_type_name"]; ?>) (<?=$this->data->my_id;?>)
        </label>





    </li>


<?php } ?>
