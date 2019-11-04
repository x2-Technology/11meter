
<li class="section" >Eingefügte Verein</li>

<?php if( count($this->data->season) ) { ?>
    <li class="cell ltr" data-removeable="true" >
        <label><?= $this->data->season["name"]; ?></label>
        <input type="hidden" name="season" value="<?=$this->data->season["id"];?>" >
    </li>
<?php } ?>

<?php if( count($this->data->club) ) { ?>
    <li class="cell ltr" data-removeable="true" >
        <label><?= $this->data->club["teamName2"]; ?></label>
        <input type="hidden" name="club" value="<?=$this->data->club["id"];?>" >
    </li>
<?php } ?>

<?php if( count($this->data->teams) ) { ?>

        <li class="section" >
            Mannschaften
        </li>

        <?php foreach ( $this->data->teams as $index => $team ) { ?>

            <li class="cell ltr" data-removeable="true" >
                <label><?= $team["name"]; ?></label>
                <input type="hidden" name="team[]" value="<?=$team["id"];?>" >
            </li>

        <?php }?>

<?php } ?>



