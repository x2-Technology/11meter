<ul class="x2-list" data-with="searchbar" id="clubs">

    <?php foreach ( $this->data->clubs as $index => $club) { ?>

        <li class="cell" data-group="<?= $club["pretty_association_name"]; ?>" data-sort="<?= $club["teamName2"]; ?>" data-id="<?=$club["id"];?>">
            
            <?php 
                // value="<?=$club["association_id"].",".$club["id"];"
            ?>
            
            <input type="radio" name="club[]" id="club_<?=$club["id"];?>" value="<?=$club["id"];?>" >
            <label for="club_<?=$club["id"];?>"><?= $club["teamName2"]; ?></label>
        </li>

    <?php }?>


</ul>