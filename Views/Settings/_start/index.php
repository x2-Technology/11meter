<?php
$cellData = $this->data->cell_data;
?>
<!--<ul class="list-group">
    <?php /*foreach ( $cellData as $cell ) { */?>

        <li class="list-group-item d-flex justify-content-between position-relative pl-10 pr-5 box-with-border-radius-none action">
            <a data-data="<?/*= Helper::JSONCleaned($cell); */?>" class="font-size-14 full-width" >
                <?/*= $cell["display_name"]; */?>
            </a>
            <span class="badge badge-pill font-size-14"><i class="icon icon-arrow-right4"></i> </span>
        </li>

    <?php /*}*/?>
</ul>-->
<ul class="x2-list" id="manage">
        <?php foreach ( $cellData as $cell ) { ?>

            <li class="cell">
                <a data-data="<?= Helper::JSONCleaned($cell); ?>" >
                        <?= $cell["display_name"]; ?>
                </a>
            </li>

        <?php }?>
</ul>