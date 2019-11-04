<ul class="x2-list">
        <input type="hidden" id="listing-label" value="<?= $this->data->listing_label; ?>">
        <?php

        if( count($this->data->rows) ){

            foreach ($this->data->rows as $row) {
                    echo $row;
            }
        } else { ?>

            <div class="mt-20 text-center full-width font-bold font-mini font-italic text-dark">Keine Termin vorhanden!!!</div>


        <?php }

        ?>
</ul>