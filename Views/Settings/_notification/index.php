<?php

/*
$data = $this->data["db"]; // array("display_name" => "TERMIN DETAILS", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "!" . DIRECTORY_SEPARATOR . "details", "icon" => "ic_home", "back_link" => "Back link from Kalendar");
$pp_meeting_data = $this->data["pp_meeting_data"]; // array("display_name" => "TERMIN DETAILS", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "!" . DIRECTORY_SEPARATOR . "details", "icon" => "ic_home", "back_link" => "Back link from Kalendar");
$pp_meeting_data = htmlspecialchars(json_encode($pp_meeting_data, JSON_UNESCAPED_UNICODE),ENT_QUOTES, 'UTF-8');

$pp_birthday_data = $this->data["pp_birthday_data"]; // array("display_name" => "TERMIN DETAILS", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "!" . DIRECTORY_SEPARATOR . "details", "icon" => "ic_home", "back_link" => "Back link from Kalendar");
$pp_birthday_data = htmlspecialchars(json_encode($pp_birthday_data, JSON_UNESCAPED_UNICODE),ENT_QUOTES, 'UTF-8');
*/

// User Settings with Data
$data = $this->data["settings_with_data"]; // array("display_name" => "TERMIN DETAILS", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "!" . DIRECTORY_SEPARATOR . "details", "icon" => "ic_home", "back_link" => "Back link from Kalendar");
// $data = htmlspecialchars(json_encode($data, JSON_UNESCAPED_UNICODE),ENT_QUOTES, 'UTF-8');


?>
<form id="form" action="#" method="post" enctype="multipart/form-data">

        <ul class="x2-list mb-0 mt-0">
        <?php
        $i = 0;
        $parentID = 0;

        foreach ($data as $d) { // highlight_string(var_export($d, true));?>


                    <?php $v = $d["key"] ?>

                    <!--MAIN SETTING-->
                    <?php if (is_null($d["parent"])) { $parentID = $d["id"]; $marginTop = $i ? "mt-0" : "mt-0"; ?>



                            <!--H E A D E R-->
                            <li class="section">
                                <?= $d["name"]; ?>
                            </li>

                            <li class="cell pos-relative">
                                Erinnert
                                <?php $checked = $d["setting_value"] ? "checked='checked'" : ""; ?>
                                <div class="material-switch pos-absolute" style="right: 10px; top: 10px;">
                                    <input id="<?= $v; ?>" name="<?= $v; ?>" type="checkbox" <?= $checked; ?> >
                                    <label for="<?= $v; ?>" class="label-primary"></label>
                                </div>

                            </li>

                    <?php } ?>

                    <!--SUB SETTING -->
                    <?php if (!is_null($d["parent"])) { ?>

                            <?php $_ = htmlspecialchars(json_encode($d, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8'); ?>

                            <li class="cell action">
                                <a data-data="<?= $_; ?>" >
                                    Planen
                                    <label class="m-0 float-right"></label>
                                    <input type="hidden"
                                           data-role="plan-picker"
                                           name="<?= $d["key"]; ?>"
                                           value="<?= $d["setting_value"]; ?>"
                                           title="">


                                </a>
                            </li>

                    <?php } ?>

                    <!--CLOSE OPENED LIST GROUP TAG IF PARENT IS-->
                    <?php if ( $d["id"] !== $parentID ) { ?>
                    <?php } ?>



        <?php  $i++; } ?>

        </ul>

</form>
