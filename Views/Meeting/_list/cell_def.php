<?php
    $data = $this->data["post"]; // array("display_name" => "TERMIN DETAILS", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "!" . DIRECTORY_SEPARATOR . "details", "icon" => "ic_home", "back_link" => "Back link from Kalendar");
    // $data = json_encode($data);
    // $data = preg_replace("/\"/", "\'", $data );
    $data = htmlspecialchars(json_encode($data, JSON_UNESCAPED_UNICODE),ENT_QUOTES, 'UTF-8');

    // highlight_string(var_export($this->data["db"], true));
?>

<div data-id="<?=$this->data["db"]["id"]; ?>" class=" meeting-item list-group-item d-flex justify-content-between align-items-center pr-2 pl-0 pt-0 pb-2 position-relative box-with-border-radius-none row-h-130" style="display: table-cell; overflow: hidden;">

        <a data-data="<?= $data; ?>" class="w-100">
        <table class="w-100 h-100 nopadding nomargin pos-absolute" style="top:0; left:0">
        <tbody class="nomargin nopadding">

        <tr>
            <td class="nopadding min-width" style="background-color: <?= $this->data["db"]["title_color"]; ?>;width: 10px;">

            </td>
            <td class="nopadding align-top">


                <table class="w-100 h-100 table-sm">

                    <!--TOP-->
                    <tr>
                        <td class="min-height pt-5">
                            <div class="w-100 float-left pl-5">

                                    <?php
                                    $subtitle = "";
                                    if( $this->data["db"]["heim_gast"] === "gast" ) {
                                        $subtitle = "( Auswärts )";
                                    } ?>


                                <small class="font-medium font-bold float-left " style="padding-left:2px; border-left: 4px solid #<?= $this->data["db"]["title_color"]; ?>; color: <?= $this->data["db"]["title_color"]; ?>;"><?= $this->data["db"]["display_name"];?> <?= $subtitle; ?></small>
                                <div class="font-mini float-right mt-3 ">

                                            <?php if( !is_null($this->data["weather"]) && !is_null($this->data["weather"]["weather"]) ) { ?>
                                                <span class="float-left mr-10 font-small" style="margin-top: -.5vh;">
                                                    <img src="<?= Config::WEATHER_ICON_BASE_URL . DIRECTORY_SEPARATOR .  $this->data["weather"]["weather"][0]["icon"] . ".png"; ?>" width="22" />
                                                    <span class="text-dark font-mini clear-both pr-5" style="border-right: 1px solid #838383;" ><?= floor( $this->data["weather"]["main"]["temp"] ) . "°"; ?></span>
                                                </span>
                                            <?php } ?>

                                    <span class="float-right">
                                        <i class="icon icon-calendar pr-2"></i><?= $this->data["db"]["meeting_pretty_date"]; ?>
                                    </span>

                                </div>
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
                                            <span class="font-bold"><?= $this->data["db"]["my_team"];?></span>
                                            <?php if( !is_null($this->data["db"]["opponent_team"]) ) { ?>
                                                <span class="ml-2 mr-2 text-dark">vs.</span>
                                                <span  class="font-bold"><?= $this->data["db"]["opponent_team"]; ?></span>
                                            <?php } ?>
                                        </small>
                                    </div>

                                    <!--MEET-->
                                    <div class="mt-5">
                                        <small class="font-mini "><span class="font-mini">Treff Vorort : </span><span  class="font-bold"><i class="icon icon-clock mr-2"></i><?= $this->data["db"]["meeting_meet"];?></span></small>
                                    </div>

                                    <!--DEPART-->
                                        <?php if(!is_null($this->data["db"]["abfahrt_orts"])) { ?>
                                            <div class="w-100 mt-5 pl-5">
                                                <small class="font-small "><span class="font-normal">Abfahrt </span><span  class="font-bold"><?= $this->data["db"]["abfahrt_ort"];?></span> : <span  class="font-bold text-info"><?= $this->data["db"]["meeting_drive_time"];?></span></small>
                                            </div>
                                        <?php }?>

                                    <!--OTHER INFO-->
                                    <?php if(FALSE) { ?>
                                    <div class="mt-5">
                                        <i class="icon icon-info2 text-info "></i>
                                        <small class="font-mini">Other Info sadkslaj dalks jdl kas jdlka sjdsak ljdla skdc jas kldj aksldd jaskld jsakld jsakd ljs akl djas kl djsakld jaslk d</small>
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

                                        <div class="pos-absolute" style="right: 0;">

                                                <?php if($this->data["post"]["isMatch"] ){ ?>

                                                    <?php

                                                        $club_logo_src      = $this->data["db"]["my_team_icon"];
                                                        $opponent_logo_src  = $this->data["db"]["opponent_team_icon"];

                                                        #$club_logo      = !empty($club_logo_src) ? (getimagesize($club_logo_src) ? $club_logo_src : $this->data["db"]["icon_club_avatar"]) : $this->data["db"]["icon_club_avatar"] ;
                                                        #$opponent_logo  = !empty($opponent_logo_src) ? (getimagesize($opponent_logo_src) ? $opponent_logo_src : $this->data["db"]["icon_club_avatar"]) : $this->data["db"]["icon_club_avatar"];

                                                        /*
                                                        list($w, $h) = getimagesize($club_logo_src);
                                                        $nw = 256;
                                                        $nh = 256;
                                                        $thumb_club  = imagecreatetruecolor($nw,$nh);
                                                        $source = imagecreatefrompng($club_logo_src);

                                                        imagecopyresized($thumb_club, $source, 0,0,0,0, $nw, $nh, $w, $h);

                                                        imagepng($thumb_club);

                                                        list($w, $h) = getimagesize($opponent_logo_src);
                                                        $nw = 256;
                                                        $nh = 256;
                                                        $thumb_opponent  = imagecreatetruecolor($nw,$nh);
                                                        $source = imagecreatefrompng($opponent_logo_src);

                                                        imagecopyresized($thumb_opponent, $source, 0,0,0,0, $nw, $nh, $w, $h);

                                                        imagepng($thumb_opponent);

                                                        $club_logo_src = $thumb_club;
                                                        $opponent_logo_src = $thumb_opponent;
                                                        // echo $this->data["db"]["my_team_icon"]
                                                        */

                                                        $club_logo      = $this->data["db"]["icon_club_avatar"];
                                                        $opponent_logo  = $this->data["db"]["icon_club_avatar"];


                                                        ?>

                                                    <span class="mr-2 p-2 float-left text-center" style="width: <?= $cageD; ?>; height: <?= $cageD; ?>; <?= $border; ?>"><img src="<?= $club_logo; ?>" style="<?= $iconD; ?>; height: <?= $iconD; ?>;"></span>
                                                    <span class="mr-2 p-2 float-left text-center font-italic" style="height: <?= $cageD; ?>; <?= $border; ?>">vs</span>
                                                    <span class="mr-2 p-2 float-left text-center" style="width: <?= $cageD; ?>; height: <?= $cageD; ?>; <?= $border; ?>"><img src="<?= $opponent_logo; ?>" style="<?= $iconD; ?>; height: <?= $iconD; ?>;"></span>

                                                <?php } ?>
                                        </div>

                                    </div>
                                    <div class="d-sm-table-row pos-absolute bottom-fix mb-5" style="right: 0;">
                                        <div class="pos-relative">

                                            <?php if( !true ) { ?>
                                                <span class="mr-2 p-2 float-left text-center" style="width: <?= $cageD; ?>; height: <?= $cageD; ?>; <?= $border; ?>"><i class="icon icon-warning text-warning" style="font-size: <?= $iconD; ?>"></i></span>
                                            <?php } ?>
                                            <!--UNIFORM-->
                                            <?php if( $this->data["post"]["isMatch"] ) { ?>
                                                <span class="mr-2 p-2 float-left text-center" style="width: <?= $cageD; ?>; height: <?= $cageD; ?>; <?= $border; ?>"><i class="icon icon-uniform text-disabled" style="font-size: <?= $iconD; ?>"></i></span>
                                            <?php } ?>
                                            
                                            <?php

                                                switch ($this->data["db"]["my_availability"]){
                                                        case ANWESENHEIT::YES:
                                                            $my_availability = PRESENCE_ICON::YES;
                                                            break;
                                                        case ANWESENHEIT::NO:
                                                            $my_availability = PRESENCE_ICON::NO;
                                                                break;
                                                        default;
                                                                $my_availability = PRESENCE_ICON::MAYBE;
                                                }


                                            ?>
                                            
                                            <span class="mr-2 p-2 float-left text-center" id="my-availability" style="<?= $cageD; ?>; height: <?= $cageD; ?>; <?= $border; ?>"><i class="icon <?= $my_availability; ?>" style="font-size: <?= $iconD; ?>"></i></span>

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
                                <small class="font-mini font-bold float-right text-right">
                                    <span style="color: #20a922;"><i class="icon icon-stopwatch"></i><?= $this->data["db"]["meeting_start"];?></span> - <span style="color: #ef0004;"><i class="icon icon-stopwatch"></i> <?= $this->data["db"]["meeting_end"];?></span>
                                </small>

                                <!--DEPART-->
                                <?php if(!is_null($this->data["db"]["abfahrt_ort"])) { ?>
                                    <small class="font-mini font-bold float-left text-left ml-2">
                                            <i class="icon icon-car"></i>
                                            Abfahrt
                                            <span  class="font-bold"><?= $this->data["db"]["abfahrt_ort"];?></span> : <span  class="font-bold text-info"><?= $this->data["db"]["meeting_drive_time"];?></span>
                                        </small>
                                <?php }?>


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