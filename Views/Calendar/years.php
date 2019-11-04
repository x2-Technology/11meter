
<div class="container nopadding">
        <div class="row nopadding">
                <?php

                $yearsData = $this->data->y_data;

                $i = 0;
                foreach ($yearsData as $yearData ){

                        $newColumn = !($i % 3);


                        if( !($i % 3) ){  ?> <div class="btn-group w-100 col-12"> <?php } ?>

                        <?php $mc = $yearData == date("Y") ? "btn-info":"btn-light"; ?>

                        <a data-valnumeric="<?= $yearData; ?>" data-valstring="<?= $yearData; ?>" class="btn <?= $mc; ?> col-5 box-with-border-radius-none"><?= $yearData; ?></a>

                        <?php if( ($i - 1) % 3 == 1 ){ ?> </div> <?php }

                        $i++;
                }


                ?>
        </div>
</div>