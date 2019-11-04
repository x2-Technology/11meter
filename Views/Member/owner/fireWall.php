<?php
        $user = $this->data->user;
        $text = $this->data->text;
?>
<div class="container-fluid">


        <ul class="x2-list">

                <li class="cell box-no-border mt-30 mb-30"></li>

                <li class="cell box-no-border">

                        <div class="col text-center text-success">
                                <i class="icon icon-checkmark3 font-size-10vh"></i>
                        </div>

                </li>

                <li class="cell box-no-border">

                        <div class="col text-center text-dark">
                               <h3>Hallo</h3>
                        </div>

                </li>


                <li class="cell box-no-border">

                        <div class="col text-center text-dark">
                                <?= $text; ?>
                        </div>

                </li>

                <li class="cell box-no-border">

                        <div class="col text-center text-dark">
                                <?= Config::APP_NAME; ?> Team.
                        </div>

                </li>







        </ul>





</div>