<?php
$data = $this->data["post"]; // array("display_name" => "TERMIN DETAILS", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "!" . DIRECTORY_SEPARATOR . "details", "icon" => "ic_home", "back_link" => "Back link from Kalendar");
// $data = json_encode($data);
// $data = preg_replace("/\"/", "\'", $data);
$data = Helper::JSONCleaned($data);

?>


<li class="cell image-cell" data-playerid="<?= $this->data["db"]["kontakt"]; ?>" >

            <img data-role="image-preview" data-jump="2" data-name="<?= $this->data["db"]["member_final_name"]; ?>"
                 src="<?= $this->data["db"]["member_image_thumb"]; ?>"
                 data-original-src="<?= $this->data["db"]["member_image"]; ?>"
                 onerror="this.src='<?= $this->data["db"]["member_image_avatar"]; ?>'"
            />

            <label class="single-line"><?= $this->data["db"]["member_final_name"]; ?>

            </label>

    <!-- OPTIONS -->
        <?php
        $anwesenheit    = $this->data["db"]["anwesenheit"];
        $feedback       = $this->data["db"]["feedback"];
        $reason         = $this->data["db"]["feedback"];
        // $MEETING_FEEDBACK_TYPES     = MEETING_FEEDBACK_TYPES;

        ?>


    <div class="float-right mt-2">
        <div class="select mt-5 text-warning">
            <select class="text-primary" dir="rtl" id="feedback_option" name="<?= $this->data["db"]["kontakt"]; ?>[]" data-checkbox="<?= $v; ?>" >

                <?php


                foreach ( $this->data["feedbackReasons"] as $index => $feedbackReason ) {

                        $selected = "";

                        if( $index == $feedback ){
                                $selected = "selected=selected";
                        }

                        ?>

                    <option value="<?= $index; ?>" <?= $selected; ?> ><?= $feedbackReason["display_name"]; ?></option>

                <?php } ?>

                <?php ?>

        </select>
        </div>
    </div>

</li>
