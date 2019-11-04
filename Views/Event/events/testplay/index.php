<ul class="x2-list">

        <li class="section mt20"></li>

        <? $k = "status"; ?>
        <li class="cell required switch">
            <label for="xs" class="">Status</label>
            <div class="switch">

                    <?php
                    $checked = "";
                    if (count($this->data->user_used_role)) {
                            if ($this->data->user_used_role[$k]) {
                                    $checked = "checked=checked";
                            }
                    }
                    ?>

                <input type="checkbox" name="<?= $k; ?>" id="<?= $k; ?>" <?= $checked; ?> >
                <label for="<?= $k; ?>" class="label-primary"></label>
            </div>
        </li>

        <li class="section"></li>


        <li class="cell">
                <a>
                        <select>
                                <option>Mannschaft</option>
                        </select>
                </a>
        </li>

        <li class="section"></li>
        <li class="cell form">
            <label for="playdate">Datum</label>
            <input type="date" id="playdate" name="date" value="" />
        </li>
        <li class="cell select">
            <select>
                <option>Spielklasse Gegner</option>
            </select>
        </li>
        <li class="cell select">
            <select>
                <option>Austragungsort</option>
            </select>
        </li>


        <li class="section">Spielbeginn</li>
        <li class="cell select">
            <select>
                <option >Vorschläge</option>
            </select>
        </li>

        <li class="cell form">
            <label for="start-play-time">Uhrzeit</label>
            <input type="time" name="playtime" id="start-play-time" />
        </li>

</ul>

<?php if( count($this->data->play_area) ){ ?>

        <?php foreach ( $this->data->play_area as $area ) { ?>
                <?= $area; ?>
        <?php } ?>

<?php  } ?>

<ul class="x2-list">

        <li class="section">Spielfeldbelag</li>
        <li class="cell select">
            <select>
                <option >Spielfeldbelag</option>
            </select>
        </li>


        <li class="section">Bemerkung</li>
        <li class="cell form box-no-border">
            <textarea class="box-no-border full-width" name="address" id="play-town-address" rows="2" ></textarea>
        </li>

</ul>


<div class="view-footer">
        <input type="button" id="role_add" class="text-primary x2-mobile-button" value="Speichern" />
        <?php if( !is_null($this->data->event_id )) { ?>
                <input type="button" id="role_delete" class="text-danger x2-mobile-button" value="Löschen" data-role="role-delete" data-user-used-role-id="<?= $this->data->user_used_role_id; ?>" />
        <?php } ?>
</div>


