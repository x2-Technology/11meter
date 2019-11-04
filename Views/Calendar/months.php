


<div class="container nopadding">
        <div class="row nopadding">
                <?php

                $monthsData     = $this->data->m_short;
                $monthsDataLong = $this->data->m_long;
                $i = 0;
                foreach ($monthsData as $monthData ){

                        $newColumn = !($i % 3);


                        if( !($i % 3) ){  ?> <div class="btn-group w-100 col-12"> <?php } ?>

                        <?php $mc = ($i + 1) == date("m") ? "btn-info":"btn-light"; ?>

                        <a data-valnumeric="<?= $i; ?>" data-valstring="<?= $monthsDataLong[$i]; ?>" class="btn <?= $mc; ?> col-5 box-with-border-radius-none"><?= $monthData; ?></a>

                        <?php if( ($i - 1) % 3 == 1 ){ ?> </div> <?php }

                        $i++;
                }


                ?>
        </div>
</div>