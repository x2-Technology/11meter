<?php $data = $this->data->club;
    // highlight_string(var_export($this->data->tableStyle, true));
?>

<?php if( $this->data->tableStyle === "default" ) { ?>

    <li class="cell ltr">
        <a data-data="" class="action-link">
                <span><i class="icon icon-link text-danger"></i></span>
                <?= $data[$this->data->display_column_name]; ?>
                <input type="hidden" name="<?= $this->data->prefix; ?>[]" value="<?=$data["id"];?>" >
        </a>
    </li>

<?php } else { ?>
    <li class="cell ltr" >
        <input type="<?= $this->data->input_type; ?>" name="<?= $this->data->prefix; ?>[]" id="<?= $this->data->prefix; ?>_<?=$data["id"];?>" value="<?=$data["id"];?>" >
        <label for="<?= $this->data->prefix; ?>_<?=$data["id"];?>"><?= $data[$this->data->display_column_name]; ?></label>
    </li>
<?php } ?>

