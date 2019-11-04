<?php
$data = $this->data["post"]; // array("display_name" => "TERMIN DETAILS", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "!" . DIRECTORY_SEPARATOR . "details", "icon" => "ic_home", "back_link" => "Back link from Kalendar");
$data = Helper::JSONCleaned($data);

?>

<div data-id="<?= $this->data["db"]["id"]; ?>"
     class=" meeting-item list-group-item d-flex justify-content-between align-items-center pr-2 pl-0 pt-0 pb-2 position-relative box-with-border-radius-none row-h-130"
     style="display: table-cell; overflow: hidden;">


    <!--INFO BUTTON ON TOP-->


    <a data-data="<?= $data; ?>" class="w-100">
        <table class="w-100 h-100 nopadding nomargin pos-absolute" style="top:0; left:0">
            <tbody class="nomargin nopadding">

            <tr>
                <td class="nopadding min-width"
                    style="background-color: <?= $this->data["db"]["title_color"]; ?>;width: 10px;">

                </td>
                <td class="nopadding align-top">




                    <!--TOP-->
                    <table class="w-100 h-100 table-sm" >

                        <!--INFO TOP-->
                        <tr>
                            <td class="p-0 min-height">
                                <div class="font-mini text-center mt-5 ">

                                    <!--WEATHER-->
                                        <?php if (!is_null($this->data["weather"]) && !is_null($this->data["weather"]["weather"])) { ?>
                                            <span class="font-small" style="margin-top: -.5vh;">
                                                <img src="<?= Config::WEATHER_ICON_BASE_URL . DIRECTORY_SEPARATOR . $this->data["weather"]["weather"][0]["icon"] . ".png"; ?>"
                                                     width="22"/>
                                                <span class="text-dark font-mini clear-both pr-5"
                                                      style="border-right: 1px solid #838383;"><?= floor($this->data["weather"]["main"]["temp"]) . "°"; ?></span>
                                                </span>
                                            <span class="ml-2 mr-2"></span>
                                        <?php } ?>
                                    <!--DATE-->
                                    <span><i class="icon icon-calendar mr-2"></i><?= $this->data["db"]["meeting_pretty_date"]; ?></span>
                                    <!--TIME-->
                                    <span class="ml-2 mr-2"></span>
                                    <span>
                                        <small class="font-mini font-bold">
                                            <span class="text-success">
                                                    <i class="icon icon-stopwatch"></i>
                                                    <?= $this->data["db"]["meeting_start"]; ?>
                                            </span> -
                                            <span class="text-success">
                                                 <?= $this->data["db"]["meeting_end"]; ?> Uhr</span>
                                    </small>
                                    </span>

                                </div>

                                <!--INFO ICON ON TOP ABSOLUTE POS-->
                                <div style="position:absolute; right: 10px; top: 10px;">
                                        <?php if( $this->data["db"]["missing_data"]) { ?>
                                            <i class="icon icon-info font-size-22 text-danger"></i>
                                        <?php } else {
                                                if( $this->data["db"]["beschreibung"]){ ?>
                                                    <i class="icon icon-info font-size-22 text-info"></i>
                                                <?php }
                                        } ?>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="min-height pt-5">
                                <div class="w-100 float-left pl-5">

                                        <?php
                                        $subtitle = "";
                                        if ($this->data["db"]["heim_gast"] === "gast") {
                                                $subtitle = MEETING_LOCATION_TYPE[MEETING_LOCATION_TYPE_AWAY];
                                        } ?>


                                    <small class="font-medium font-bold float-left "
                                           style="padding-left:2px; border-left: 4px solid #<?= $this->data["db"]["title_color"]; ?>; color: <?= $this->data["db"]["title_color"]; ?>;"><?= $this->data["db"]["display_name"]; ?> <?= $subtitle; ?></small>

                                </div>

                            </td>
                        </tr>

                        <!--BODY-->
                        <tr>
                            <td class="align-top nomargin nopadding">
                                <div class="w-100 h-100 pl-10">
                                    <div class="w-70 float-left h-100">

                                        <!--TEAMS-->
                                        <div class="w-100 text-ellipsis" style="clear: both;">
                                            <small class="font-small   ">
                                                <span class="font-bold"><?= $this->data["db"]["my_team"]; ?></span>
                                                    <?php if (!is_null($this->data["db"]["opponent_team"])) { ?>
                                                        <span class="ml-2 mr-2 text-dark">vs.</span>
                                                        <span class="font-bold"><?= $this->data["db"]["opponent_team"]; ?></span>
                                                    <?php } ?>
                                            </small>
                                        </div>

                                        <table class="font-mini min-width mt-5">

                                            <!--Start Road-->
                                                <?php if (!is_null($this->data["db"]["abfahrt_ort"])) { ?>
                                            <tr>
                                                <td class="min-width font-bold p-0">
                                                    <i class="icon icon-bus mr-2"></i>
                                                </td>
                                                <td class="min-width font-bold p-0 pl-1 font-normal">
                                                    <span class="font-bold"><?= $this->data["db"]["meeting_drive_time"]; ?></span>
                                                    <span class="font-normal"><?= $this->data["db"]["abfahrt_ort"]; ?></span>
                                                </td>
                                            </tr>
                                            <tr><td class="min-height p-0 pt-1"></td></tr>
                                                <?php } ?>

                                            <!--MEET-->
                                            <tr >
                                                <td class="min-width font-bold p-0">
                                                    <i class="icon icon-clock mr-2"></i>
                                                </td>
                                                <td class="min-width font-bold p-0 pl-1 font-normal">
                                                    <span class="font-bold">
                                                        <?= $this->data["db"]["meeting_meet"]; ?>
                                                    </span>
                                                    <span class="font-normal">
                                                        Treff Vorort
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr><td class="min-height p-0 pt-1"></td></tr>

                                            <!--Location-->

                                            <tr >
                                                <td class="min-width font-bold p-0">
                                                    <i class="icon icon-location2 mr-2"></i>
                                                </td>
                                                <td class="min-width font-bold p-0 pl-1">
                                                        <?= $this->data["db"]["ort"]; ?>
                                                </td>

                                            </tr>


                                        </table>





                                        <!--OTHER INFO-->
                                            <?php if (FALSE) { ?>
                                                <div class="mt-5">
                                                    <i class="icon icon-info2 text-info "></i>
                                                    <small class="font-mini">Other Info sadkslaj dalks jdl kas jdlka
                                                        sjdsak ljdla skdc jas kldj aksldd jaskld jsakld jsakd ljs akl
                                                        djas kl djsakld jaslk d
                                                    </small>
                                                </div>
                                            <?php } ?>


                                    </div>

                                        <?php
                                            $cageD = "8vw";
                                            $iconD = "6vw";
                                            $border = "border: 1px solid #CCCCCC;";
                                            $border = "border: none;";


                                        ?>


                                    <div class="w-30 float-right h-100 relative">

                                        <div class="d-sm-table-row">

                                            <!--SCORE-->
                                            <div class="pos-absolute" style="right: 0;">

                                                    <?php if ($this->data["db"]["is_active"]) { ?>

                                                            <?php if (!true) { ?>
                                                            <span class="mr-2 p-2 float-left text-center" style="width: <?= $cageD; ?>; height: <?= $cageD; ?>; <?= $border; ?>"><i class="icon icon-warning text-warning" style="font-size: <?= $iconD; ?>"></i></span>
                                                            <?php } ?>

                                                            <!--UNIFORM-->
                                                            <?php if ($this->data["post"]["isMatch"]) { ?>
                                                            <span class="mr-2 p-2 float-left text-center" style="width: <?= $cageD; ?>; height: <?= $cageD; ?>; <?= $border; ?>"><i class="icon icon-uniform text-disabled" style="font-size: <?= $iconD; ?>"></i></span>
                                                            <?php } ?>

                                                            <?php

                                                            switch ($this->data["db"]["my_availability"]) {
                                                                    case ANWESENHEIT::YES:
                                                                            $my_availability = PRESENCE_ICON::YES;
                                                                            break;
                                                                    case ANWESENHEIT::NO:
                                                                            $my_availability = PRESENCE_ICON::NO;
                                                                            break;
                                                                    case ANWESENHEIT::MAYBE:
                                                                            $my_availability = PRESENCE_ICON::MAYBE;
                                                                            break;
                                                                    default:
                                                                            $my_availability = PRESENCE_ICON::NONE;

                                                                            break;
                                                            }

                                                            ?>

                                                            <span class="mr-2 p-2 float-left text-center" id="my-availability" style="<?= $cageD; ?>; height: <?= $cageD; ?>; <?= $border; ?>"><i class="icon <?= $my_availability; ?>" style="font-size: <?= $iconD; ?>"></i></span>


                                                    <?php } else {  ?>

                                                        <?php if ($this->data["post"]["isMatch"]) { ?>

                                                                <?php

                                                                    $club_logo_src      = $this->data["db"]["my_team_icon"];
                                                                    $opponent_logo_src  = $this->data["db"]["opponent_team_icon"];
                                                                    $club_logo          = $this->data["db"]["icon_club_avatar"];
                                                                    $opponent_logo      = $this->data["db"]["icon_club_avatar"];

                                                                ?>

                                                            <span class="mr-2 p-2 float-left text-center"
                                                                  style="width: <?= $cageD; ?>; height: <?= $cageD; ?>; <?= $border; ?>"><img
                                                                        src="<?= $club_logo; ?>"
                                                                        style="height: <?= $iconD; ?>;"></span>
                                                            <span class="mr-2 p-2 float-left text-center font-italic"
                                                                  style="height: <?= $cageD; ?>; <?= $border; ?>">vs</span>
                                                            <span class="mr-2 p-2 float-left text-center"
                                                                  style="width: <?= $cageD; ?>; height: <?= $cageD; ?>; <?= $border; ?>"><img
                                                                        src="<?= $opponent_logo; ?>"
                                                                        style="height: <?= $iconD; ?>;"></span>

                                                        <?php } ?>

                                                    <?php }  ?>

                                            </div>

                                        </div>


                                        <div class="d-sm-table-row pos-absolute bottom-fix mb-5" style="right: 0;">

                                            <div class="pos-relative">

                                                    <!--RESERVED FOR OTHER PROCESS-->
                                                <?php if ($this->data["db"]["heim_gast"] === "gast" && $this->data["db"]["is_active"] ) { ?>
                                                    <?php
                                                        $color  = is_null($this->data["db"]["transfer_method_decided"]) ? "text-secondary" : "text-success";
                                                        $icon   = is_null($this->data["db"]["transfer_method_decided"]) ? "car" : $this->data["db"]["transfer_method_decided"] === "mit" ? "bus" : "car";
                                                        ?>
                                                    <span class="mr-2 p-2 float-left text-center <?= $color; ?>" style="<?= $cageD; ?>; height: <?= $cageD; ?>; <?= $border; ?>">
                                                        <i class="icon icon-<?= $icon; ?>" style="font-size: <?= $iconD; ?>"></i>
                                                    </span>
                                                <?php } ?>


                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </td>
                        </tr>

                        <!--BOTTOM-->
                        <tr>
                            <td class="nopadding nomargin text-sm-right min-height">
                                <div class="float-left w-100 pl-10 pb-5">




                                </div>
                            </td>
                        </tr>


                    </table>


                </td>
                <td class="min-width nopadding">
                    <span class="badge"><i class="icon icon-arrow-right4"></i> </span>
                </td>
            </tr>
            </tbody>
        </table>
    </a>

</div>


<!--
<div class="w-100 d-flex justify-content-between p-5 box-with-border-radius-3 text-sm-left" style="
color: linear-gradient(3.27rad, rgb(31, 172, 208), #17d1a4 31.93%, #116800) !important;color: #1e1e1e;">


</div>-->