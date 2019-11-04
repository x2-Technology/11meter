<?php
$data = $this->data["post"]; // array("display_name" => "TERMIN DETAILS", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "!" . DIRECTORY_SEPARATOR . "details", "icon" => "ic_home", "back_link" => "Back link from Kalendar");
$data = json_encode($data);
$data = preg_replace("/\"/", "\'", $data );

#highlight_string(var_export($this->data["weather"]["weather"], true));

?>
<div class="meeting-header align-items-center pr-2 pl-0 pt-0 pb-2 position-relative w-100" style="height: 170px;">

        <div class="d-sm-table-cell position-fixed w-100" style="height: 170px; display: table-cell; overflow: hidden;
                background:linear-gradient( rgba(0, 0, 0, 0.9), rgba(73,129,66,0.6) ),url(<?= $this->data["db"]["img_header_background"]; ?>) bottom no-repeat;
                background-size:cover;
                z-index: 1;
                border-bottom: 1px solid #939393;
                box-shadow: 0 0 10px #656565;"
        >

            <div class="mt-50"></div>
            <!--TYPE-->
            <div class="w-100 text-center font-bold text-light"><?= $this->data["db"]["display_name"]; ?></div>
            <!--PRETTY DATE-->
            <div class="w-100 text-center font-normal text-light"><?= $this->data["db"]["meeting_pretty_date"]; ?></div>
            <!--TIME BETWEEN-->
            <div class="w-100 text-center font-bold">
                <span style="color: #2aee42;"><i class="icon icon-stopwatch"></i><?= $this->data["db"]["meeting_start"];?></span>
                -
                <span style="color: #ee2015;"><i class="icon icon-stopwatch"></i> <?= $this->data["db"]["meeting_end"];?></span>
            </div>
            <!--WEATHER-->
                <?php if( !is_null($this->data["weather"]["weather"]) ) { ?>
                    <div class="font-bold pos-absolute font-size-22" style="right: 20px; top: 20px; ">
                        <!--<i class="icon-sun text-warning"> 18°</i>-->
                        <div class="pos-relative">
                            <small class="float-right">
                                <img src="<?= Config::WEATHER_ICON_BASE_URL . DIRECTORY_SEPARATOR . $this->data["weather"]["weather"][0]["icon"] . ".png"; ?>" width="32" class="mr-0" />
                                <span class="text-light font-normal clear-both" style="font-size: 18px;"><?= floor( $this->data["weather"]["main"]["temp"] ) . "°"; ?></span>
                            </small>
                            <div class="clearfix"></div>
                            <small class="float-right">
                                <span class="float-left font-mini text-info"><?= $this->data["weather"]["weather"][0]["description"]; ?></span>
                            </small>
                        </div>
                    </div>
                <?php } ?>


        </div>

</div>