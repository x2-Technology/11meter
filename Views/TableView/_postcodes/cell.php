<?php
    #highlight_string(var_export($this->data, true));
?>
<li class="cell" >
    <input type="radio"
           name="postcode[]"
           id="postcode<?=$this->data->postcode["zc_id"];?>"
           value="<?=$this->data->postcode["zc_id"];?>"
           data-postcode="<?= $this->data->postcode["zc_zip"]; ?>"
           data-area-name="<?= $this->data->postcode["zc_location_name"]; ?>"
    >
    <label for="postcode<?=$this->data->postcode["zc_id"];?>"><?= $this->data->postcode["zc_zip"]; ?> - <?= $this->data->postcode["zc_location_name"]; ?></label>
</li>
