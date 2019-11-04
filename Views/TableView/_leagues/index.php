<ul class="x2-list">

    <?php
    foreach ( $this->data->leagues as $index => $leagues ) { ?>

        <?php $disabled = !$leagues["status"] ? "disabled" : ""; ?>

        <li class="cell <?= $disabled; ?>" data-unwind="true" >
            <?php if( !is_null($this->data->row_type) && $this->data->row_type === "checkbox"  ) { ?>
                <input type="checkbox" name="league_id[]" id="league_id<?=$index;?>" value="<?= $index; ?>" data-pretty-league-name="<?= $leagues["name"]; ?>" >
                <label for="league_id<?=$index;?>"><?= $leagues["name"]; ?></label>
            <?php } else { ?>
                <!-- Default radio -->
                <input type="radio" name="league_id[]" id="league_id<?=$index;?>" value="<?= $index; ?>" data-pretty-league-name="<?= $leagues["name"]; ?>" >
                <label for="league_id<?=$index;?>"><?= $leagues["name"]; ?></label>
            <?php } ?>
        </li>

    <?php } ?>
</ul>