<input type="hidden" data-role="plan-picker" value="<?= $this->data->pars->picker; ?>"/>


<ul class="x2-list">

    <li class="section">
        Tag
    </li>
        <?php $day = 16; ?>
    <li class="cell p-10">
        <div class="select">
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
        </div>
    </li>

    <li class="section">
        Stunde
    </li>
        <?php $hour = 24; ?>
    <li class="cell p-10">
        <div class="select">
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
        </div>
    </li>

    <li class="section">
        Minute
    </li>
        <?php $minute = 60; ?>
    <li class="cell p-10">
        <div class="select">
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

        </div>
    </li>

</ul>






