<ul class="x2-list">
    
    <!--LOCAL OR OUTWARDS-->
    <input type="hidden" name="place_covering_for" id="place_covering_for" value="<?= $this->data->place_covering_for; ?>" >


        <?php
        
        #highlight_string(var_export($this->data, true));

    foreach ( $this->data->place_coverings as $index => $covering ) { ?>

        <?php $covering_disabled = !$covering["status"] ? "disabled" : ""; ?>

        <!--<li class="cell <?/*= $covering_disabled; */?>" >
            <input type="checkbox" name="place_covering[]" id="place_covering<?/*=$index;*/?>" value="<?/*= $index; */?>" data-pretty-name="<?/*= $covering["name"]; */?>" >
            <label for="place_covering<?/*=$index;*/?>"><?/*= $covering["name"]; */?></label>
            <input type="hidden" name="place_covering_pretty_name[]" id="place_covering_pretty_name<?/*=$index;*/?>" value="<?/*= $index; */?>" >
        </li>-->

        <li class="cell <?= $disabled; ?>" data-unwind="true" >
                <?php if( !is_null($this->data->row_type) && $this->data->row_type === "checkbox"  ) { ?>
                    <input type="checkbox" name="place_covering[]" id="place_covering<?=$index;?>" value="<?= $index; ?>" data-pretty-league-name="<?= $covering["name"]; ?>" >
                    <label for="place_covering<?=$index;?>"><?= $covering["name"]; ?></label>
                <?php } else { ?>
                    <!-- Default radio -->
                    <input type="radio" name="place_covering[]" id="place_covering<?=$index;?>" value="<?= $index; ?>" data-pretty-league-name="<?= $covering["name"]; ?>" >
                    <label for="place_covering<?=$index;?>"><?= $covering["name"]; ?></label>
                <?php } ?>
        </li>

    <?php } ?>
</ul>