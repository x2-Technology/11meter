<!--RADIO OR CHECKBOX-->
<?php
    $disabled = intval($this->data->user_role["confirmed_by_club"]) === CONFIRMATION_TYPE::TYPE_REJECTED ? "disabled" : "";
?>

<li
        class="cell <?= $disabled;?>" <?= $disabled;?>
        data-sub-title="<?= $this->data->team . " " . $this->data->team_group; ?>, <?= $this->data->league;?>"
        data-sub-title-color="text-info"
        data-sub-title-html="true" >

        <a data-data="">

            <!--<img src="/images/<?/*= $this->data->confirmed_via_club_logo; */?>" width="20" height="20">-->
            <label><?= $this->data->club; ?></label>


            <select id="trainer" name="trainer" class="text-info">
                <option value="0">?</option>
            </select>
            <label for="trainer" class="d-none"></label>


        </a>







    <?php

        $val = array();

        array_push($val, $this->data->club);
        array_push($val, $this->data->team);
        array_push($val, $this->data->team_group);
        array_push($val, $this->data->league);
        array_push($val, $this->data->owner);


        $val = implode(",",$val);

    ?>



    <!--<input
            type="<?/*= (!is_null($this->data->pars->row_type) ? $this->data->pars->row_type : "radio"); */?>"
            name="team[]"
            id="team_<?/*= $this->data->user_role["id"]; */?>"
            value="<?/*= $val; */?>"
            data-db-data="<?/*= $this->data->value_combination_for_database; */?>" >

    <label for="team_<?/*= $this->data->user_role["id"]; */?>" >
            <?/*= $this->data->club; */?>
    </label>-->

</li>
