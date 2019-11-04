<?php
        $row_data = Helper::JSONCleaned($this->data["row_data"]); // array("display_name" => "TERMIN DETAILS", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "!" . DIRECTORY_SEPARATOR . "details", "icon" => "ic_home", "back_link" => "Back link from Kalendar");
?>
<li class="cell action">
        <a data-data="<?= $row_data; ?>" class="font-size-14">
                <?= $this->data["db"]["name"]; ?>
        </a>
</li>