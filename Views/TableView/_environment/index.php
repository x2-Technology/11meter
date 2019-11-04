<ul class="x2-list">
    <li class="cell required ">
        <?php
            #highlight_string(var_export($this->data->default_town, true));
        ?>
        <a data-data="<?= Helper::JSONCleaned($this->data->postcodes_view_controller_data); ?>">

            <label>Ort</label>

            <select name="environment_area_id" id="environment_area_id" class="text-info" >
                <option value="<?= $this->data->default_town["post_code_id"]; ?>"><!--LOAD NAME AFTER PAGE LOAD--></option>
            </select>
            <label for="environment_area_id" class="d-none"></label>
            <input type="hidden" name="pretty_environment_area" id="pretty_environment_area" value="" >
        </a>
    </li>

    <li class="cell form box-no-border required">
        <label for="environment_area_km">Km</label>
        <input type="tel" maxlength="4" name="environment_area_km" id="environment_area_km" />
    </li>
</ul>