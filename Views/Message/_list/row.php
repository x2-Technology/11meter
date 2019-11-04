<?php
    $data = $this->data["post"];
    // highlight_string(var_export($this->data["db"], true));
    $data = htmlspecialchars(json_encode($data, JSON_UNESCAPED_UNICODE),ENT_QUOTES, 'UTF-8');
?>

<?php
    $isRead     = intval($this->data["db"]["is_read"]) !== 1 ? "active":"inactive";
?>

<div id="<?=$this->data["db"]["id"]; ?>" data-id="<?=$this->data["db"]["id"]; ?>" class="message-<?=$isRead;?> message-item list-group-item d-flex justify-content-between align-items-center pr-2 pl-0 pt-0 pb-2 position-relative box-with-border-radius-none" style="height: 60px;">


    <a data-data="<?= $data;?>" class="w-100 h-100">
        <span class="badge float-left pl-10 pt-5"><i class="message-status icon icon-circle2 font-small"></i></span>
        <div class="container-fluid h-100 pos-relative">
            <div class="mt-5 d-table">
                <div class="d-table-cell w-100">
                    <div class="pos-relative w-100">
                        <div class="pos-absolute w-100">
                            <div class="pos-absolute w-90 text-ellipsis">
                                <span class="font-small font-bold"><?= $this->data["db"]["display_name"]; ?></span>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="d-table-cell pt-2 text-right"><span class="font-mini font-bold"><?= $this->data["post"]["message_pretty_date"]; ?></span> </div>
            </div>
            <div class="clearfix"></div>
            <div class="d-table pl-10">
                <div class="d-table-cell w-100">
                <div class="pos-absolute w-90 block-with-multiline-ellipsis-text text-<?=$isRead;?>" style="height: 20px;">
                    <span class="font-mini"><?= $this->data["post"]["message"]; ?></span>
                </div>

                </div>
            </div>

        </div>

    </a>
    <div class="float-right">
        <span class="badge"><i class="icon icon-arrow-right4"></i></span>
    </div>

</div>
