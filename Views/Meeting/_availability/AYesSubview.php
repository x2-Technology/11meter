<li class="section border-top-0">
    Ich komme...
</li>
<li class="cell">
    <span class="select">
        <select name="reason">
                <?php if( count($this->data->reasons ) ) { ?>
                        <?php foreach ($this->data->reasons as $index => $reason) { ?>
                                <?php $selected = $this->data->meeting["my_reason"] == $reason["id"] ? "selected=selected" : ""; ?>
                        <option value="<?=$reason["id"]?>" <?= $selected; ?> ><?=$reason["display_name"]?></option>
                        <?php } ?>
                <?php } ?>
        </select>
    </span>
</li>
<li class="section">
    Sonstiges...
</li>
<li class="cell nopadding">
    <textarea name="reason_comment" id="" class="form-control ui-resizable-disabled box-no-border" placeholder="Kommentar"><?= $this->data->meeting["my_reason_custom_comment"]; ?></textarea>
</li>