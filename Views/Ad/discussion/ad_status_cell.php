<?php
    $d = $this->data->ad_data;
?>
<li class="cell border-top-0">

        <?php
        $general_status_text            = "Warten auf bestätigung";
        $general_status_color           = "text-warning";

        if( !is_null($d["owner_accepted_at"]) && !is_null($d["accepted_at"]) ){
                $general_status_text            = "Akzeptiert";
                $general_status_color           = "text-success";
        }

        if(
                (!is_null($d["owner_declined_at"]) && !is_null($d["declined_at"]))
                ||
                (!is_null($d["owner_declined_at"]) || !is_null($d["declined_at"]))

        ){
                $general_status_text            = "Abgelehnt";
                $general_status_color           = "text-danger";
        }




        ?>

    <a data-data="<?= Helper::JSONCleaned($this->data->deal_view_controller_data);?>">
        Status
        <span class="float-right <?=$general_status_color;?>"><?=$general_status_text;?></span>
    </a>
</li>

<li class="section">
    Diskussion
</li>