
<div class="view-wrapper bg-white">

    <div class="view-body container-fluid pt-20" >

        <div class="mt-100">

            <div class="col text-center text-dark"><h4>CODE EINGEBEN</h4></div>
        </div>

        <div class="row">
            <?php $k = "_code"; ?>
            <div class="col-2"></div>
            <div class="col"><input class="full-width form-control text-center font-size-18" id="<?= $k; ?>" name="<?= $k; ?>" value="" type="text"  style="text-transform: uppercase"/></div>
            <div class="col-2"></div>
        </div>

        <div class="text-info font-mini font-italic mt-10">

            <div class="col text-center">Bitte geben Sie here Code, was Sie erhalten</div>
        </div>


    </div>

    <div class="view-footer">
        <input type="button" id="check_code" class="text-white x2-mobile-button bg-info" value="Check" />
    </div>
</div>
