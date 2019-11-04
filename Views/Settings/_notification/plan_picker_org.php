<input type="hidden" data-role="plan-picker" value="<?= $this->data->pars->picker; ?>"/>

<ul class="list-group">

    <li class="list-group-item box-no-border text-center font font-mini p-20"></li>
    <li class="list-group-item box-no-border text-center font font-mini pb-20">Erinniere jede Meeting Termin before</li>
    <li class="list-group-item box-no-border text-center font font-mini p-30"></li>

    <li class="list-group-item text-center relative ">
        <div class="container">
            <div class="row">

                    <?php $day = 16; ?>
                <div class="p-2 col box-no-border">
                    <div class="plan-picker box border box-with-border-radius-10 box-no-padding pb-10">
                        <div class="plan-picker-header full-width box-with-border-radius-bottom-right-none box-with-border-radius-bottom-left-none box-no-border p-10">
                            Day
                        </div>
                        <select data-role="plan-picker" data-picker="d" name="day" id="day">
                                <?php
                                for ($i = 0; $i < $day; $i++) { ?>
                                        <?php
                                        $val = $i;
                                        $view = $i < 10 ? "0" . $i : $i;
                                        $select = $i == $this->data->pars->d ? "selected='selected'" : "";
                                        ?>
                                    <option value="<?= $i; ?>" <?= $select; ?> ><?= $view; ?></option>
                                <?php } ?>
                        </select>
                        <div class="p-3 full-width"></div>
                    </div>

                </div>

                    <?php $hour = 24; ?>

                <div class="p-2 col box-no-border">
                    <div class="plan-picker box border box-with-border-radius-10 box-no-padding pb-10">
                        <div class="plan-picker-header full-width box-with-border-radius-bottom-right-none box-with-border-radius-bottom-left-none box-no-border p-10">
                            Hour
                        </div>
                        <select data-role="plan-picker" data-picker="h" name="day" id="day">
                                <?php for ($i = 0; $i < $hour; $i++) { ?>
                                        <?php
                                        $val = $i;
                                        $view = $i < 10 ? "0" . $i : $i;
                                        $select = $i == $this->data->pars->h ? "selected='selected'" : "";
                                        ?>
                                    <option value="<?= $i; ?>" <?= $select; ?> ><?= $view; ?></option>
                                <?php } ?>
                        </select>
                        <div class="p-3 full-width"></div>
                    </div>

                </div>

                    <?php $minute = 60; ?>

                <div class="p-2 col box-no-border">
                    <div class="plan-picker box border box-with-border-radius-10 box-no-padding pb-10" style="overflow: hidden">
                        <div class="plan-picker-header full-width box-with-border-radius-bottom-right-none box-with-border-radius-bottom-left-none box-no-border p-10">
                            Minute
                        </div>
                        <select data-role="plan-picker" data-picker="m" name="day" id="day">
                                <?php for ($i = 0; $i < $minute; $i++) { ?>
                                        <?php
                                        $val = $i;
                                        $view = $i < 10 ? "0" . $i : $i;
                                        $select = $i == $this->data->pars->m ? "selected='selected'" : "";
                                        ?>
                                    <option value="<?= $i; ?>" <?= $select; ?> ><?= $view; ?></option>
                                <?php } ?>
                        </select>
                        <div class="p-3 full-width"></div>
                    </div>

                </div>



            </div>
        </div>

    </li>

</ul>





