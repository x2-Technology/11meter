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

        <?php
        $i = 0;
        $parentID = 0;

        foreach ($data as $d) { // highlight_string(var_export($d, true));?>


                    <?php $v = $d["key"] ?>

                    <!--MAIN SETTING-->
                    <?php if (is_null($d["parent"])) { $parentID = $d["id"]; $marginTop = $i ? "mt-20" : "mt-0"; ?>

                        <div class="list-group <?= $marginTop; ?>">

                        <!--H E A D E R-->
                        <li class="list-group-item d-flex justify-content-between position-relative pl-10 box-with-border-radius-none box-no-border font-small">
                                <?= $d["name"]; ?>
                        </li>

                        <div class="list-group-item d-flex justify-content-between position-relative pl-10 pr-5 box-with-border-radius-none p-10"
                             style="display: table-cell; vertical-align: bottom;">
                            <span class="float-left mt-3">Erinnert</span>
                                <?php
                                $checked = $d["setting_value"] ? "checked='checked'" : "";
                                ?>
                            <div class="material-switch">
                                <input id="<?= $v; ?>" name="<?= $v; ?>" type="checkbox" <?= $checked; ?> >
                                <label for="<?= $v; ?>" class="label-primary"></label>
                            </div>
                        </div>
                    <?php } ?>

                    <!--SUB SETTING -->
                    <?php if (!is_null($d["parent"])) { ?>

                            <?php
                            $_ = htmlspecialchars(json_encode($d, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');
                            ?>

                        <li class="list-group-item d-flex justify-content-between position-relative pl-10 pr-5 box-with-border-radius-none action">
                            <a data-data="<?= $_; ?>" class="font-size-14 full-width">
                                Planen
                                <span class="float-right">
                                    <label class="m-0"></label>
                                    <input type="hidden"
                                           data-role="plan-picker"
                                           name="<?= $d["key"]; ?>"
                                           value="<?= $d["setting_value"]; ?>"
                                           title="">
                                </span>

                            </a>
                            <span class="badge badge-pill font-size-14"><i class="icon icon-arrow-right4"></i> </span>
                        </li>

                    <?php } ?>

                    <!--CLOSE OPENED LIST GROUP TAG IF PARENT IS-->
                    <?php if ( $d["id"] !== $parentID ) { ?>
                        </div>
                    <?php } ?>



        <?php  $i++; } ?>


</form>
