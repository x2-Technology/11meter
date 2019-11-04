<?php $my_ads = $this->data->my_ads; ?>

<?/*= $this->data->ad_id; */?>

<?php if( count($my_ads)) { ?>

        <ul class="x2-list">

              <?= $my_ads; ?>

        </ul>



<?php } else { ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 font-italic font-bold text-secondary text-center pt-50">
                    Keine interessant!
                </div>
            </div>
        </div>

<?php } ?>

