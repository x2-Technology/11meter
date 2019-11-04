<form>

    <div class="container-fluid mt-40 mb-40">

        <h3 class="text-center">Wie haben Sie uns gefunden ?</h3>

    </div>

    <ul class="x2-list">

            <?php if( count($this->data->huf_data) ) {?>

                    <?php foreach ($this->data->huf_data as $index => $huf) { ?>


                    <li class="cell cell-check">
                        <input type="checkbox" id="feedback_huf_<?= $index; ?>" name="feedback_huf[]" value="<?= $index; ?>">
                        <label for="feedback_huf_<?= $index; ?>" ><?= $huf["display_name"]; ?></label>
                    </li>

                    <?php }?>

            <?php }?>

    </ul>



</form>
