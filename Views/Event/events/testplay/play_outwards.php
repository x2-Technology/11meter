<ul class="x2-list">

        <li class="section bg-warning">AUSWÄRTS

        </li>

        <li class="cell required switch">
                <label for="xs" class="">Auswärts</label>
                <div class="switch">
                        <input type="checkbox" name="play-area-outwards" id="play-area-outwards" <?= $checked; ?> >
                        <label for="play-area-outwards" class="label-primary"></label>
                </div>
        </li>

        <li class="section">Umkreis</li>

        <li class="cell form">
                <label for="start-play-time">Ort</label>
                <input type="text" name="playtime" id="start-play-time" />
        </li>

        <li class="cell form box-no-border">
                <label for="start-play-time">Km</label>
                <input type="tel" maxlength="4" name="playtime" id="start-play-time" />
        </li>
</ul>