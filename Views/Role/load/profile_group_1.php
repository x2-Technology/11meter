<?php
    #highlight_string(var_export($this->data->user_used_role, true));;
    #echo count($this->data->licences);
?>


<input type="hidden" name="user_used_role_id" id="user_used_role_id" value="<?= $this->data->user_used_role_id; ?>"/>





<li class="section pt-30">

</li>

<? $k = "status"; ?>
<li class="cell required">
    <label for="xs" class="">Status</label>
    <div class="switch">

            <?php
            $checked = "";
            if (count($this->data->user_used_role)) {
                    if ($this->data->user_used_role[$k]) {
                            $checked = "checked=checked";
                    }
            }
            ?>

        <input type="checkbox" name="<?= $k; ?>" id="<?= $k; ?>" <?= $checked; ?> >
        <label for="<?= $k; ?>" class="label-primary"></label>
    </div>
</li>


<li class="section">
    Trainer Lizenz
</li>

<!--CELL SELECT-->
<? $k = "licence"; ?>
<li class="cell select">

    <select name="<?= $k; ?>" id="<?= $k; ?>"    >
        <option value="0">Auswählen</option>
            <?php if( count($this->data->licences) ) { ?>

                    <?php foreach ($this->data->licences as $index => $licence) { ?>

                            <?php $selectable = !is_null($licence["selectable"]) && !$licence["selectable"] ? "disabled" : ""; ?>
                            <?php $selected = $this->data->user_used_role["licence"] == $index ? "selected='selected'" : ""; ?>

                        <option value="<?= $index; ?>" <?= $selectable; ?> <?= $selected; ?> ><?= $licence["name"]; ?></option>


                    <?php }?>

            <?php }?>
    </select>

</li>

<? $k = "licence_until"; ?>
<li class="form cell">
    <label for="<?=$k;?>">Gültig bis</label>
    <input type="date" name="<?=$k;?>" id="<?=$k;?>" value="<?= $this->data->user_used_role["licence_until"]; ?>" >
</li>



<li class="section"></li>

<?php


if (!count($this->data->user_used_role_id) ) { ?>

        <? $k = "club"; ?>
    <li class="cell border-bottom">
        <input type="button" value="VEREIN EINFÜGEN"
               data-data="<?= Helper::JSONCleaned($this->data->viewControllerForRoleAssistantData); ?>">
    </li>

<?php } ?>


<div class="p-0 relative w-100 float-left mt-20">
    <ul class="x2-list" id="role_club">

        <!--LOAD CLUB WITH TEAMS -->
            <?php

            // echo $this->data->user_clubs_for_role;

            ?>

    </ul>
</div>