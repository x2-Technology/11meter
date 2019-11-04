<script>
    new Layout().setUnwindDataStore("new_id", <?= $this->data->message["id"]; ?>);
</script>
<div class="list-group">

    <div class="list-group-item nopadding box-with-border-radius-none box-no-border">
        <?= $this->data->error; ?>
    </div>

    <div class="list-group-item box-with-border-radius-none box-no-border">
        <div class="btn-group">
            <button type="button" class="btn btn-secondary"><i class="icon icon-bin"></i> </button>
            <button type="button" class="btn btn-secondary"><i class="icon icon-mail"></i></button>
        </div>
        <span class="float-right font-bold font-mini"><?= $this->data->message["message_pretty_date"]; ?></span>
    </div>

    <div class="list-group-item box-with-border-radius-none box-no-border pb-0 ">
        <div class="w-100">
            <span class="font-bold font-small">Subject:</span>
            <span class="font-small"><?= $this->data->message["display_name"]; ?></span>
        </div>
    </div>
    <div class="list-group-item box-with-border-radius-none box-no-border pt-0 pb-0">
        <hr />
    </div>

    <div class="list-group-item box-with-border-radius-none box-no-border pt-0">
        <span class="font-small"><?= $this->data->message["message"]; ?></span>
    </div>
    

</div>