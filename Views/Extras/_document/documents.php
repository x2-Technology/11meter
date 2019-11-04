<ul class="x2-list">

        <?php

           if( count($this->data->cells) ){

                   foreach ($this->data->cells as $cell) { ?>

                           <?php $cellData = Helper::JSONCleaned($cell["cell_data"]); ?>
                           <li class="cell action">
                               <a data-data="<?= $cellData; ?>" >
                                       <?= $cell["cell_data"]["display_name"]; ?>
                               </a>
                           </li>


                   <?php }
               
           } ?>



</ul>