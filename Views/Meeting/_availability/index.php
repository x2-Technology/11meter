<form>
    <?php 

    // highlight_string(var_export($this->data->user, true));
    // if( DEVICE_TYPE::IOS != $_SESSION[REPOSITORY::CURRENT_DEVICE] && DEVICE_TYPE::ANDROID != $_SESSION[REPOSITORY::CURRENT_DEVICE] ) {
    if( DEVICE_TYPE::IOS != REPOSITORY::read(REPOSITORY::CURRENT_DEVICE) && DEVICE_TYPE::ANDROID != REPOSITORY::read(REPOSITORY::CURRENT_DEVICE) ) { ?>
        <a onclick="new Layout().save('_availability')">Submit</a>
    <?php } ?>

    <ul class="x2-list">

            <!--HEADER-->
            <?= $this->data->header; ?>

            <input type="hidden" name="meeting_id" value="<?= $this->data->meeting["id"]; ?>">
            <input type="hidden" name="selected_availability" id="selected_availability" value="<?= $this->data->meeting["my_availability"]; ?>">


            <li class="cell image-cell">

                <span style="height: 40px; width: 40px; border-radius: 100px; background-color: gray; float: left;">
                    <img data-role="image-preview"
                         data-jump="1"
                         data-name="<?= $this->data->user["final_name"]; ?>"
                         src="<?= $this->data->user["member_image_thumb"]; ?>" onerror="this.src='/images/avatar.png'"
                         data-original-src="<?= $this->data->user["member_image"]; ?>"
                         style="width: 100%; height: 100%; border-radius: 50%">
                </span>
                <label class="single-line"><?= $this->data->user["final_name"]; ?></label>
            </li>

            <li class="section bg-warning text-dark">
                Wähle deine Vefügbarkeit
            </li>

            <li class="cell">
                    <div class="container-fluid">
                        <div class="row">
                                <?php if (true) { ?>

                                        <?php $isActive = $this->data->meeting["my_availability"] == ANWESENHEIT::YES ? "availability-active" : "availability-inactive"; ?>

                                    <div class="col-4 text-center ">
                                        <a class="btn font-size-4vh my-availability box-border box-with-border-radius-10 w-100 p-10 bg-dark ui-widget-shadow <?= $isActive; ?>"
                                           data-avalilability="<?= ANWESENHEIT::YES; ?>">
                                            <i class="icon <?= PRESENCE_ICON::YES ?>"></i>
                                        </a>
                                    </div>

                                        <?php $isActive = $this->data->meeting["my_availability"] == ANWESENHEIT::NO ? "availability-active" : "availability-inactive"; ?>
                                    <div class="col-4 text-center ">
                                        <a class="btn font-size-4vh my-availability box-border box-with-border-radius-10 w-100 p-10 bg-dark ui-widget-shadow <?= $isActive; ?>"
                                           data-avalilability="<?= ANWESENHEIT::NO; ?>">
                                            <i class="icon <?= PRESENCE_ICON::NO ?>"></i>
                                        </a>
                                    </div>

                                        <?php $isActive = $this->data->meeting["my_availability"] == ANWESENHEIT::MAYBE ? "availability-active" : "availability-inactive"; ?>
                                    <div class="col-4 text-center ">
                                        <a class="btn font-size-4vh my-availability box-border box-with-border-radius-10 w-100 p-10 bg-dark ui-widget-shadow <?= $isActive; ?>"
                                           data-avalilability="<?= ANWESENHEIT::MAYBE; ?>">
                                            <i class="icon <?= PRESENCE_ICON::MAYBE ?>"></i>
                                        </a>
                                    </div>

                                <?php } ?>

                                <?php if (false) { ?>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary active my-availability">
                                            <input type="radio" name="options" id="option1" autocomplete="off" checked> Active
                                        </label>
                                        <label class="btn btn-secondary my-availability">
                                            <input class="my-availability" type="radio" name="options" id="option2"
                                                   autocomplete="off"> Radio
                                        </label>
                                        <label class="btn btn-secondary my-availability">
                                            <input class="my-availability" type="radio" name="options" id="option3"
                                                   autocomplete="off"> Radio
                                        </label>
                                    </div>


                                <?php } ?>
                        </div>
                    </div>

            </li>

            <li class="cell nopadding">
                <ul class="x2-list" id="subview" >
                        <?= $this->data->subview; ?>
                </ul>

            </li>



    </ul>

    <div class="meeting-details list-group">
            <ul class="x2-list">

            </ul>
    </div>
</form>
