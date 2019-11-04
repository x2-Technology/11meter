<ul class="x2-list" data-with="searchbar_">

    <?php foreach ( $this->data->seasons as $index => $season) { ?>

        <?php $disabled = !$season["status"] ? "disabled=\"disabled\"" : ""; ?>

        <li class="cell ltr" <?= $disabled; ?> >
            <input type="radio" name="season[]" id="season_<?=$season["id"];?>" value="<?=$season["id"];?>" >
            <label for="season_<?=$season["id"];?>"><?= $season["name"]; ?></label>
        </li>

    <?php }?>


</ul>