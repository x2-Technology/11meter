<?php
/*
$presence_data = $this->data["presence_data"]; // array("display_name" => "TERMIN DETAILS", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "!" . DIRECTORY_SEPARATOR . "details", "icon" => "ic_home", "back_link" => "Back link from Kalendar");
// $presence_data = json_encode($presence_data);
// $presence_data = preg_replace("/\"/", "\'", $presence_data);
$presence_data = htmlspecialchars(json_encode($presence_data, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');

$availability_data = $this->data["availability_data"]; // array("display_name" => "TERMIN DETAILS", "link" => Config::BASE_URL . DIRECTORY_SEPARATOR. "Meeting". DIRECTORY_SEPARATOR . "!" . DIRECTORY_SEPARATOR . "details", "icon" => "ic_home", "back_link" => "Back link from Kalendar");
// $availability_data = json_encode($availability_data);
// $availability_data = preg_replace("/\"/", "\'", $availability_data);
$availability_data =  htmlspecialchars(json_encode($availability_data, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');
*/
$presence_data = Helper::JSONCleaned($this->data["presence_data"]);
$availability_data = Helper::JSONCleaned($this->data["availability_data"]);
$feedback_data = Helper::JSONCleaned($this->data["feedback_data"]);
/*$keys = array("presence", "availability", "feedback");
$data = array();
foreach ($keys as $key) {
    $data[$key] = Helper::JSONCleaned( $this->data[ $key . "_data" ] );
}*/


?>


<?php

// highlight_string(var_export($this->data->user, true));
// if( DEVICE_TYPE::IOS != $_SESSION[REPOSITORY::CURRENT_DEVICE] && DEVICE_TYPE::ANDROID != $_SESSION[REPOSITORY::CURRENT_DEVICE] ) {
if (DEVICE_TYPE::IOS != REPOSITORY::read(REPOSITORY::CURRENT_DEVICE) && DEVICE_TYPE::ANDROID != REPOSITORY::read(REPOSITORY::CURRENT_DEVICE)) { ?>
    <a onclick="new Layout().shareWithWhatsApp()">Share</a>
<?php } ?>

<div class="meeting-details list-group">

    <!--HEADER-->
        <?= $this->data["header"]; ?>

    <!--INFO-->
    <div class="list-group-item d-flex justify-content-between position-relative">


        <div class="row font-small">
            <span class="font-normal w-100 "><i class="icon icon-info text-info mr-2"></i><span class="font-normal">Treff Vorort : </span><span
                        class="font-bold"><i
                            class="icon icon-clock mr-2"></i><?= $this->data["db"]["meeting_meet"]; ?></span></span>
            <span class="font-normal w-100 "><i
                        class="icon icon-info text-info mr-2"></i><?= $this->data["db"]["ort"]; ?></span>
        </div>


    </div>


        <?php

        use \_details\Meeting as DETAIL;

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
                default;
                        $my_availability = PRESENCE_ICON::NONE;
        }

        foreach ($this->data["detail_items"] as $index => $detail_item) {

                $detail_item_data = Helper::JSONCleaned($detail_item);
                $isAvailability = false;
                $isFeedback = false;
                $isShow  = true;

                $dataId = "";


                switch ($index) {

                        case DETAIL::DETAIL_MY_POSSIBILITY:
                                $dataLink = $this->data["db"]["is_active"] ? "data-data='{$detail_item_data}'" : "";
                                $isAvailability = true;
                                $isShow = true;

                                // Data id need for my possibility for unwind control
                                // Send data back for possibility icon JS Search this id with item and replace icon if necessary
                                $dataId = "data-id='" . $this->data["db"]["id"] ."'";

                                break;

                        case DETAIL::DETAIL_TEAM_PRESENCE:
                                $dataLink = "data-data='{$detail_item_data}'";
                                $isShow = true;

                                break;

                        case DETAIL::DETAIL_MEETING_FEEDBACK:
                                $dataLink = "data-data='{$detail_item_data}'";
                                $isShow = $this->data["db"]["feedback_possible"];
                                break;


                } ?>


            <?php if( $isShow ) { ?>

                <div class="list-group-item d-flex justify-content-between position-relative pl-10 pr-5 meeting-details-item" <?= $dataId; ?>  >
                    <a <?= $dataLink; ?> class="w-100">
                        <span class="w-100">
                            <!--TITLE-->
                            <span class="font-size-14 float-left"><?= $detail_item["display_name"]; ?></span>

                            <span class="badge float-right ">

                                <!--AVAILABILITY ICON IF REQUESTED-->
                                <?php if ($isAvailability) { ?>
                                    <span class="badge float-left font-size-14" id="my-availability"><i class="icon <?= $my_availability; ?>"></i> </span>
                                <?php } ?>

                                <!--ARROW RIGHT-->
                                <?php if( !empty($dataLink)) { ?>
                                    <span class="badge float-right">
                                        <span class="badge"><i class="icon icon-arrow-right4 font-size-14 "></i> </span>
                                    </span>
                                <?php } ?>
                            </span>
                        </span>
                    </a>
                </div>
            <?php }?>


        <?php } ?>

</div>
