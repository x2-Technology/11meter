<?php
$data = $this->data["post"]; // array("display_name" => "TERMIN DETAILS", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "!" . DIRECTORY_SEPARATOR . "details", "icon" => "ic_home", "back_link" => "Back link from Kalendar");
$data = Helper::JSONCleaned($data);

?>

<li class="cell image-cell pl-3">

        <?php
        switch ( $this->data["db"]["anwesenheit"] ){
                case ANWESENHEIT::NO: $presence_ico = PRESENCE_ICON::NO; break;
                case ANWESENHEIT::MAYBE: $presence_ico = PRESENCE_ICON::MAYBE; break;
                default: $presence_ico = PRESENCE_ICON::YES;
        }
        ?>

        <img data-role="image-preview" data-jump="2" data-name="<?= $this->data["db"]["member_final_name"]; ?>"
             src="<?= $this->data["db"]["member_image_thumb"]; ?>"
             data-original-src="<?= $this->data["db"]["member_image"]; ?>"
             onerror="this.src='<?= $this->data["db"]["member_image_avatar"]; ?>'"
        />
        <label class="single-line"><?= $this->data["db"]["member_final_name"]; ?></label>
        <span class="badge">
            <i class="icon icon-size-table-cell <?= $presence_ico; ?> "></i>
        </span>


</li>