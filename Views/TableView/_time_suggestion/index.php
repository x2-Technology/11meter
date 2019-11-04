<ul class="x2-list">
    <li class="section"></li>
        <?php if( count($this->data->fetch_time_suggetions) ) { ?>
            <li class="cell select">

                <select id="ad_suggestion" name="ad_suggestion" >
                        <?php foreach($this->data->fetch_time_suggetions as $key => $value) { ?>
                            <option value="<?= $key; ?>"><?= $value["name"]; ?></option>
                        <?php }?>
                </select>
                <label for="ad_suggestion" class="d-none"></label>

            </li>
        <?php }?>

    <li class="cell form required">
        <label for="ad_time">Uhrzeit</label>
        <input type="time" name="ad_time" id="ad_time"  />
    </li>

</ul>