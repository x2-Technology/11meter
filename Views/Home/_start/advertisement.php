<?php
$ads = $this->data->ads;
$showIndicators = false;
?>


    <div id="ads-carousel" class="carousel slide nopadding" data-ride="carousel">

        <!-- Indicators -->
        <ol class="carousel-indicators">
                <?php if ($showIndicators) { ?>
                        <?php $i = 0; ?>
                        <?php foreach ($ads as $index => $activeAdd) { ?>
                                <?php $active = !$i ? "active" : ""; ?>

                        <li data-target="#ads-carousel" data-slide-to="<?= $i; ?>" class="<?= $active; ?>"></li>

                                <?php $i++; ?>
                        <?php } ?>
                <?php } ?>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">

                <?php
                $i = 0;

                foreach ($ads as $index => $activeAdd) {

                        $active = !$i ? "active" : ""; ?>

                    <div class='carousel-item <?= $active; ?>'>
                        <div class='ads-block row nomargin '>
                                <?php adsBlock($activeAdd, $this->data->imageBasePath); ?>
                        </div>
                    </div>

                        <?php
                        $i++;

                }
                ?>

        </div>

        <!-- Left and right controls -->

            <?php if ($showIndicators) { ?>
                <a class="carousel-control-prev  font-bold font-size-22 text-primary" href="#ads-carousel" role="button"
                   data-slide="prev">
                    <i class="icon icon-arrow-left4"></i>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next font-bold font-size-22 text-primary" href="#ads-carousel" role="button"
                   data-slide="next">
                    <i class="icon icon-arrow-right4"></i>
                    <span class="sr-only">Next</span>
                </a>
            <?php } ?>

    </div>


    <?php function adsBlock($ads = array(), $imageBasePath) { ?>

            <?php if (count($ads) === 1) { ?>

                <?php $toJSON = htmlspecialchars(json_encode($ads[0]["data"], JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8'); ?>

                <div data-role='advertisement' class='advertisement col one-block' style='background-image: url(<?= $imageBasePath . $ads[0]["groupId"] . DIRECTORY_SEPARATOR . $ads[0]["file"]; ?>);' data-data='<?= $toJSON; ?>'></div>

            <?php } ?>

            <?php if (count($ads) === 2) { ?>

                <?php $toJSON = htmlspecialchars(json_encode($ads[0]["data"], JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8'); ?>
                <div class='col'>
                        <div data-role='advertisement' class='advertisement col' style='background-image: url(<?= $imageBasePath . $ads[0]["groupId"] . DIRECTORY_SEPARATOR . $ads[0]["file"]; ?>);' data-data='<?= $toJSON; ?>'></div>
                </div>

                <?= $toJSON = htmlspecialchars(json_encode($ads[1]["data"], JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8'); ?>
                <div class='col'>
                    <div data-role='advertisement' class='advertisement col' style='background-image: url(<?= $imageBasePath . $ads[1]["groupId"] . DIRECTORY_SEPARATOR . $ads[1]["file"]; ?>);' data-data='<?= $toJSON; ?>'></div>
                </div>

            <?php } ?>

            <?php if (count($ads) === 3) { ?>

                <div class="col">

                    <?php $toJSON = htmlspecialchars(json_encode($ads[0]["data"], JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8'); ?>
                    <div class="col h-50 p-5">
                        <div data-role='advertisement' class='advertisement h-100' style='background-image: url(<?= $imageBasePath . $ads[0]["groupId"] . DIRECTORY_SEPARATOR . $ads[0]["file"]; ?>);' data-data='<?= $toJSON; ?>'></div>
                    </div>

                    <?php $toJSON = htmlspecialchars(json_encode($ads[1]["data"], JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8'); ?>
                    <div class="col h-50 p-5">
                        <div data-role='advertisement' class='advertisement h-100' style='background-image: url(<?= $imageBasePath . $ads[1]["groupId"] . DIRECTORY_SEPARATOR . $ads[1]["file"]; ?>);' data-data='<?= $toJSON; ?>'></div>
                    </div>

                </div>

                <?php $toJSON = htmlspecialchars(json_encode($ads[2]["data"], JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8'); ?>
                <div class='col p-5 h-100'>
                    <div data-role='advertisement' class='advertisement w-100 h-100' style='background-image: url(<?= $imageBasePath . $ads[2]["groupId"] . DIRECTORY_SEPARATOR . $ads[2]["file"]; ?>);' data-data='<?= $toJSON; ?>'></div>
                </div>

    <?php } ?>


<?php } ?>