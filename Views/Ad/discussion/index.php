
<ul class="x2-list border-bottom-0" id="ad-details">
        <?= $this->data->header;?>
</ul>

<?php
    #highlight_string(var_export($this->data->ad_data, true));

    $accepted = false;
    $declined = false;
    $declined_at = "";
    $accepted_at = "";
    $d = $this->data->ad_data;

    $is_my_ad = $this->data->my_id === $d["ad_owner"] ? true:false;


    if( $is_my_ad ){
        $accepted = !is_null($d["owner_accepted_at"]);
        $declined = !is_null($d["owner_declined_at"]);

            if($accepted){
                $accepted_at = date_create($d["owner_accepted_at"])->format("d.m.Y - H:i");
            }

            if($declined){
                    $declined_at = date_create($d["owner_declined_at"])->format("d.m.Y - H:i");
            }
    }
    else {
        $accepted = !is_null($d["accepted_at"]);
        $declined = !is_null($d["declined_at"]);
    }



?>

<!--STATUS CELL-->
<ul class="x2-list" id="ad-status">
    <?= $this->data->ad_status_cell; ?>
</ul>

<ul class="discussion" id="discussions">
        <?= $this->data->discussions;?>
</ul>
<?php
    #highlight_string(var_export($d, true));
?>

<div class="footer" id="chat-footer">
        <form>
            <div class="row">
                    <div class="col-10 pl-5">
                            <input type="text" name="message" id="message-field" placeholder="Schreibt was" required>
                    </div>
                <div class="col-2 wrapper-chat-button pos-relative p-0">
                    <button type="button" class="h-100 w-100 pos-absolute btn-primary text-center" id="send-message"
                    >
                        <i class="icon icon-paperplane mr-2 d-block"></i>
                        <span class="d-none w-100" id="chat-indicator">
                            <span class="d-table-cell text-center">
                                <span class="loader-mini" ></span>
                            </span>
                        </span>
                    </button>
                </div>
            </div>
        </form>
</div>


