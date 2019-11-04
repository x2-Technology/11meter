
<li class="section border-top-0">
    Abwesend...
</li>
<li class="cell">
    <span class="select">
        <?php
                #highlight_string(var_export($this->data->reasons, true));
        ?>
        <select name="reason">
                <?php
                if( count($this->data->reasons ) ) { ?>
                        <?php foreach ($this->data->reasons as $index => $reason) { ?>
                                <?php $selected = $this->data->meeting["my_reason"] == $reason["id"] ? "selected=selected" : ""; ?>
                        <option value="<?=$reason["id"]?>" <?= $selected; ?> ><?=$reason["display_name"]?></option>
                        <?php } ?>
                <?php } ?>
        </select>
    </span>
</li>
<li class="section">
    Von-Bis...
</li>
<li class="cell">
    <div class="container-fluid">
        <div class="row nopadding">
                <?php $v = "reason_from"; ?>
            <div class="col form-group ">
                <input
                        type="date"
                        class="reason-between form-control-underline form-control box-with-border-radius-none"
                        name="<?= $v; ?>"
                        id="<?= $v; ?>"
                        value="<?= $this->data->meeting[$v]; ?>" />
            </div>
                <?php $v = "reason_to"; ?>
            <div class="col">
                <input
                        type="date"
                        class="reason-between form-control form-control-underline form-control box-with-border-radius-none"
                        name="<?= $v; ?>"
                        id="<?= $v; ?>"
                        value="<?= $this->data->meeting[$v]; ?>" />
            </div>
        </div>
        <div class="row">
            <div class="col font-mini">
                <span class="text-info font-size-14 font-italic font-mini">
                    <i class="icon icon-warning text-warning"> Diese Termin wird bearbeiten!</i>
                    <span class="clearfix pl-5"></span>
                    <i class="icon icon-checkmark-circle pr-10"> Ohne Zeitraum!</i>
                    <span class="clearfix p-10"></span>
                    <i class="icon icon-checkmark-circle"> Termin datum in bestimmte Zeitraum!</i>
            </div>
        </div>
    </div>

</li>

<li class="section">
    Sonstiges...
</li>
<li class="cell nopadding">
    <textarea name="reason_comment" id="" class="form-control ui-resizable-disabled box-no-border" placeholder="Kommentar"><?= $this->data->meeting["my_reason_custom_comment"]; ?></textarea>
</li>
