<?php
        #highlight_string(var_export($this->data, true));
?>
<?php if( strlen($this->data->text1)) { ?>

        <li>
                <div class="d-table w-100" >
                        <div class="d-table-cell <?= $this->data->pos1; ?>" >
                                    <span class="p-10"><?= trim($this->data->text1);?></span>
                        </div>
                </div>
        </li>

<?php } ?>

<?php if( strlen($this->data->text2) ) { ?>

        <li>
                <div class="d-table w-100" >
                        <div class="d-table-cell <?= $this->data->pos2; ?>" >
                                            <span class="p-10"><?= trim($this->data->text2);?></span>
                        </div>
                </div>
        </li>

<?php } ?>