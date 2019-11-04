<!--RADIO OR CHECKBOX-->
<?php
    $disabled = intval($this->data->user_role["confirmed_by_club"]) === CONFIRMATION_TYPE::TYPE_REJECTED ? "disabled" : "";
?>

<li class="cell illustrated <?= $disabled;?>" <?= $disabled;?> >


    <img src="/images/<?= $this->data->confirmed_via_club_logo; ?>" width="20" height="20">

    <div class="d-table-cell vertical-align-middle w-100">
        <table class="row-table">
            <tbody>
            <tr><td></td><td></td></tr>
            <tr><td class="label">Verein</td><td>: <?= $this->data->club; ?></td></tr>
            <tr><td class="label">Mannschaft</td><td>: <?= $this->data->team . " " . $this->data->team_group; ?></td></tr>
            <tr><td class="label">Spielklasse</td><td>: <?= $this->data->league;?></td></tr>
            <tr><td class="label">Tarainer:</td><td>: <?= $this->data->owner;?></td></tr>
            </tbody>
        </table>
    </div>

    <?php

        $val = array();

        array_push($val, $this->data->club);
        array_push($val, $this->data->team);
        array_push($val, $this->data->team_group);
        array_push($val, $this->data->league);
        array_push($val, $this->data->owner);


        $val = implode(",",$val);

    ?>



    <input
            type="<?= (!is_null($this->data->pars->row_type) ? $this->data->pars->row_type : "radio"); ?>"
            name="team[]"
            id="team_<?= $this->data->user_role["id"]; ?>"
            value="<?= $val; ?>"
            data-db-data="<?= $this->data->value_combination_for_database; ?>" >

    <label for="team_<?= $this->data->user_role["id"]; ?>" >

    </label>

</li>
