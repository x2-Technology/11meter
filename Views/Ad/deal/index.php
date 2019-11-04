<?php
    $d = $this->data->ad_data;
    #highlight_string(var_export($d, true));


    // BUTTONS STATUS
    $acceptButton   = "btn-primary";
    $declineButton  = "btn-danger";


    if( intval($d["ad_owner"]) === intval($this->data->my_id) ){
            if( !is_null($d["owner_accepted_at"]) ):
                    $acceptButton = "disabled btn-secondary ";
            endif;

            if( !is_null($d["owner_declined_at"]) ):
                    $declineButton = "disabled btn-secondary";
            endif;
    }

    else {
            if( !is_null($d["accepted_at"]) ):
                    $acceptButton = "disabled btn-secondary";
            endif;

            if( !is_null($d["declined_at"]) ):
                    $declineButton = "disabled btn-secondary";
            endif;
    }


    $owner_status           = true;
    $owner_status_text      = "Warten auf bestätigung";
    $owner_status_color     = "text-warning";
    $owner_status_date      = "";
    $owner_status_comment   = "";

    $partner_status         = true;
    $partner_status_text    = "Warten auf bestätigung";
    $partner_status_color   = "text-warning";
    $partner_status_date    = "";
    $partner_status_comment = "";

    if( !is_null($d["owner_accepted_at"]) ){
            $owner_status_text      = "Akzeptiert";
            $owner_status_color     = "text-success";
            $owner_status_date = date_create($d["owner_accepted_at"])->format("d.m.Y H:i");
    }

    if( !is_null($d["owner_declined_at"]) ){
            $owner_status           = false;
            $owner_status_text      = "Abgelehnt";
            $owner_status_color     = "text-danger";
            $owner_status_date          = date_create($d["owner_declined_at"])->format("d.m.Y H:i");
            $owner_status_comment       = $d["owner_declined_comment"];
    }

    if( !is_null($d["accepted_at"]) ){
            $partner_status_text      = "Akzeptiert";
            $partner_status_color     = "text-success";
            $partner_status_date = date_create($d["accepted_at"])->format("d.m.Y H:i");
    }

    if( !is_null($d["declined_at"]) ){

            $partner_status           = false;
            $partner_status_text      = "Abgelehnt";
            $partner_status_color     = "text-danger";
            $partner_status_date = date_create($d["declined_at"])->format("d.m.Y H:i");
            $partner_status_comment       = $d["declined_comment"];
    }












?>

<ul class="x2-list">

    <?php




    if(
            (is_null($d["owner_declined_at"] ) &&  is_null($d["declined_at"]))
            &&
            (is_null($d["owner_accepted_at"] ) ||  is_null($d["accepted_at"]))

        ) :?>

        <li class="section">
            Was willst du machen?
        </li>

        <li class="section p-20 ">

            <div class="btn-group w-100" role="group" aria-label="Basic example">

                <button type="button" class="btn col-6 <?= $acceptButton; ?>" id="accept" >Akzeptieren</button>

                <button type="button" class="btn col-6 <?= $declineButton; ?>" id="decline" >Ablehnen</button>
            </div>

        </li>


    <?php elseif( $owner_status && $partner_status ) :?>

        <li class="section">
            Status
        </li>

        <li class="cell">

            <span class="text-success font-bold text-center w-100">
                Herlich Glückwunsh!
            </span>

        </li>


        <li class="section p-20 ">

            <div class="btn-group w-100" role="group" aria-label="Basic example">

                <button type="button" class="btn col-6 <?= $acceptButton; ?>" id="accept" >Akzeptieren</button>

                <button type="button" class="btn col-6 <?= $declineButton; ?>" id="decline" >Ablehnen</button>
            </div>

        </li>

    <?php elseif ( !$owner_status || !$partner_status ) : ?>

        <li class="section">
            Status
        </li>

        <li class="cell">

            <span class="text-danger font-bold text-center w-100">
                Schade, Schif gelaufen!
            </span>

        </li>

    <?php else : ?>



    <?php endif;?>





    <li class="section">

        <?php
            if( intval($this->data->my_id) === intval($this->data->ad_data["ad_owner"]) ){
                echo "Du";
            } else {
                echo $this->data->ad_data["pretty_ad_owner_name"];
            }
        ?>

    </li>
    <li class="cell" data-sub-title="">

        <table class="table-sm">

            <tr>
                <td>Status</td>
                <td>:</td>
                <td class="<?=$owner_status_color?>"><?=$owner_status_text?></td>
            </tr>
            <tr>
                <td>Datum</td>
                <td>:</td>
                <td><?=$owner_status_date?></td>
            </tr>
            <?php if( !$owner_status ): ?>
            <tr>
                <td>Kommentar</td>
                <td>:</td>
                <td><?=$owner_status_comment?></td>
            </tr>
            <?php endif; ?>
        </table>
    </li>


    <li class="section">
            <?php
            if( intval($this->data->my_id) === intval($this->data->ad_data["person_id"]) ){
                    echo "Du";
            } else {
                    echo $this->data->ad_data["pretty_trainer_name"];
            }
            ?>
    </li>
    <li class="cell" data-sub-title="">
        <table class="table-sm">
            <tr>
                <td>Status</td>
                <td>:</td>
                <td class="<?=$partner_status_color?>"><?=$partner_status_text?></td>
            </tr>
            <tr>
                <td>Datum</td>
                <td>:</td>
                <td><?=$partner_status_date#?></td>
            </tr>
            <?php if( !$partner_status ): ?>
            <tr>
                <td>Kommentar</td>
                <td>:</td>
                <td><?=$partner_status_comment?></td>
            </tr>
            <?php endif; ?>
        </table>
    </li>






</ul>