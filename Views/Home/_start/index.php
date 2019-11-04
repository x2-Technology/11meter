<?php
?>
<ul class="x2-list" >
    
    <redirect class="d-none" data-value="<?= Helper::JSONCleaned($this->data->redirect); ?>"></redirect>


    <!--ADVERTISEMENT-->
    <li class="cell nopadding">
        <div id='wrapper'>
                <?= $this->data->ads; ?>
        </div>
    </li>


    <!--NEWS-->
    <li class="cell row-h-150">

        <?php // highlight_string(var_export($this->data->weather, true)); ?>
        <div class="container nopadding">

        <div class="float-left pos-relative">
                <span class="font-bold font-small mb-5 w-100 text-center pos-absolute font-1VH" style="transform: rotate(-90deg); top: 95px;">
                    Performance
                </span>

            <div class="second circle pos-absolute ml-10">
                <!--<svg viewBox="0 0 100 250" class="pos-absolute">
                    <path id="curve" fill="transparent" d="M 50 25 A 60 90 1 0 1 120 290 " />
                    <text width="500">
                        <textPath xlink:href="#curve">
                            Performance
                        </textPath>
                    </text>
                </svg>-->
                <div class="pos-absolute font-large" >
                    <div class="display-table w-100 h-100">
                        <div class="progress-numerical d-table-cell vertical-align-middle text-center font-bold font-size-14 font-italic">loading</div>
                    </div>
                </div>
            </div>



        </div>



        <div class="float-right pos-relative">
            <div class="float-left">
                <span class="font-bold font-small " style="rotation: 50deg">Weather</span>
                <h1 class="" style="font-size: 7vh;margin-top: 9px;margin-right: 10px;"><?= $this->data->weather->temperature->now;  ?></h1>
            </div>

            <img class="pos-absolute" style="width: 60px; top: -5px; right: -5px;" src="<?= Config::WEATHER_ICON_BASE_URL . DIRECTORY_SEPARATOR . $this->data->weather->weather->icon . ".png"; ?>" >
        </div>
        </div>

    </li>

    <?php
        if( !is_null($this->data->nextMeeting) ){ ?>

            <li class="section">
                Nächste Termin
            </li>

                <?= $this->data->nextMeeting; ?>

        <?php }
    ?>








</ul>