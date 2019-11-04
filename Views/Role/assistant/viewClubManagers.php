<ul class="x2-list">

        <li class="section">
            MANAGER ROLLE
        </li>

        <li class="cell select">

                <select name="manage_role" id="manage_role" >

                        <option value="0">Auswählen</option>

                        <?php if( count($this->data->manage_roles) ) { ?>

                                <?php foreach ($this->data->manage_roles as $index => $manage_role ) { ?>

                                        <?php $selectable = !is_null( $manage_role["selectable"] ) && !$manage_role["selectable"] ? "disabled" : ""; ?>

                                        <option value="<?= $index; ?>" <?= $selectable; ?>><?= $manage_role             ["name"]; ?></option>


                                <?php }?>

                        <?php }?>

                </select>

        </li>


    <li class="section"></li>

<? $k = "licence_until"; ?>
<li class="form cell">
    <label for="<?=$k;?>">VORNAME</label>
    <input type="text" maxlength="4" name="<?=$k;?>" id="<?=$k;?>" value="<?= $this->data->user_used_role["licence_until"]; ?>" >
</li>

<? $k = "licence_until"; ?>
<li class="form cell">
    <label for="<?=$k;?>">NAME</label>
    <input type="text" maxlength="4" name="<?=$k;?>" id="<?=$k;?>" value="<?= $this->data->user_used_role["licence_until"]; ?>" >
</li>


</ul>
