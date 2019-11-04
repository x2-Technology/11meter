<div class="message-list list-group">

        <?php

        if( count($this->data->rows) ){

                foreach ($this->data->rows as $row) {
                        echo $row;
                }
        } else { ?>

            <div class="mt-20 text-center full-width font-bold font-mini font-italic text-dark">Keine Message vorhanden!!!</div>


        <?php }

        ?>
</div>