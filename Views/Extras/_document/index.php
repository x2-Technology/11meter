<!--<div class="content-fluid">
    <iframe src="<?/*= $this->data->url; */?>" class="nomargin nopadding box-no-border" style="display: inline-block">

    </iframe>
</div>-->
<ul class="x2-list">
        <?php
        foreach ( $this->data->cells as $cell ) { ?>

                <?php $cellData = Helper::JSONCleaned($cell["cell_data"]); ?>
                <li class="cell action">
                    <a data-data="<?= $cellData; ?>" class="font-size-14">
                            <?= $cell["cell_data"]["display_name"]; ?>
                    </a>

                </li>

        <?php } ?>
</ul>

