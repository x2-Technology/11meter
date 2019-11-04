<ul class="x2-list">

    <!--TABLE FORM CELL DISABLED LABEL + INPUT -->
    <li class="section" data-role="removeable">
        Table Cell With Multiple Icon With DetailsViewController
    </li>

    <li class="cell" data-sub-title="Sub Title">
        <a>
            <label>
                Details View Controller
            </label>

            <span class="additional-icon"><i class="icon icon-earth"></i></span>
            <span class="additional-icon"><i class="icon icon-link"></i></span>
            <span class="additional-icon"><i class="icon icon-checkmark"></i></span>

        </a>
    </li>


    <li class="cell removeable" data-sub-title="3.Mannschaft" >
        <a >
            <label>
                    My name
                <!--<input type="hidden" name="teams[]" value="<?/*=$this->data->team["id"] . "-" . $this->data->subTeam["name"]; */?>" >-->
            </label>
            <span class="additional-icon"><i class="icon icon-link"></i></span>
            <span class="additional-icon"><i class="icon icon-earth"></i></span>
        </a>
    </li>


    <!--TABLE FORM CELL DISABLED LABEL + INPUT -->
    <li class="section" data-role="removeable">
        Table Cell With Switch - A
    </li>

    <li class="cell switch" data-sub-title="Selam">
        <label for="xs" class="mt-5 pt-2">Ich bin offen für Angebote</label>
        <span class="additional-icon"><i class="icon icon-link"></i></span>
        <span class="additional-icon"><i class="icon icon-link"></i></span>
        <span class="additional-icon"><i class="icon icon-link"></i></span>
        <div class="switch">
            <input type="checkbox" name="x" id="x" >
            <label for="x" class="label-primary"></label>
        </div>
    </li>

    <!--TABLE FORM CELL DISABLED LABEL + INPUT -->
    <li class="section">
        Table Cell With Disabled Switch
    </li>

    <li class="cell disabled required" data-sub-title="Disabled Sub Title">
        <label for="xs" class="mt-5 pt-2">Ich bin offen für Angebote</label>
        <div class="switch">
            <input type="checkbox" name="x" id="xd" disabled >
            <label for="xd" class="label-primary"></label>
        </div>
    </li>







    <!--CELL INPUT AND LABEL-->
    <li class="section">
        Default Table Cell
    </li>
    <li class="cell" data-sub-title="Sub title for Default cell">
        Table Cell
    </li>

    <!--CELL INPUT AND LABEL-->
    <li class="section">
        Default Table Cell
    </li>
    <li class="cell" >
        Table Cell
    </li>

    <!--TABLE FORM CELL LABEL + INPUT -->
    <li class="section">
        Table Form Cell
    </li>
    <li class="cell">
        <label for="test">Test</label>
        <input id="test" name="test" value="" type="text" placeholder="Your Name" >
    </li>



    <!--TABLE FORM CELL DISABLED LABEL + INPUT -->
    <li class="section">
        Table Form Cell
    </li>
    <li class="cell disabled"> <!--Required disabled class for li cell-->
        <label for="test">Test</label>
        <input id="test" name="test" value="" type="text" placeholder="Your Name" disabled class="disabled" > <!--Required disabled attribute for input or class disabled for input-->
    </li>



    <li class="section">
        Table Cell Select
    </li>
    <!--CELL SELECT-->
    <li class="cell select" data-sub-title="Sub Title for select">

        <select name="role" id="role" >
            <option value="0">ROLLE</option>
                <?php if( count($this->data->roles) ) { ?>

                        <?php foreach ($this->data->roles as $index => $role) { ?>

                        <option value="<?= $index; ?>"><?= $role["name"]; ?></option>


                        <?php }?>

                <?php }?>
        </select>

        <!--<input class="col-xs-8" type="radio" name="teamrolle[]" id="teamrolle_<?/*= $index; */?>" <?/*= $checked; */?> value="<?/*=$index;*/?>" />
        <label class="col-xs-4" for="teamrolle_<?/*= $index; */?>" ><?/*= $roll["name"]; */?></label>-->
    </li>

    <li class="section">
        Table Cell Select Disabled
    </li>
    <!--CELL SELECT-->
    <li class="cell select disabled" data-sub-title="Select Disabled ">

        <select name="role" id="role" >
            <option value="0">ROLLE</option>
                <?php if( count($this->data->roles) ) { ?>

                        <?php foreach ($this->data->roles as $index => $role) { ?>

                        <option value="<?= $index; ?>"><?= $role["name"]; ?></option>


                        <?php }?>

                <?php }?>
        </select>
    </li>

    <li class="section">
        Table Cell Select With Details View Controller
    </li>
    <!--CELL SELECT-->
    <li class="cell">

        <a>
            <select name="role" id="role" >
                <option value="0" class="hidden">ROLLE</option>
                    <?php if( count($this->data->roles) ) { ?>

                            <?php foreach ($this->data->roles as $index => $role) { ?>

                            <option value="<?= $index; ?>"><?= $role["name"]; ?></option>


                            <?php }?>

                    <?php }?>
            </select>

        </a>


    </li>




    <!--TABLE FORM CELL DISABLED LABEL + INPUT -->
    <li class="section">
        Table Cell Details button
    </li>
    <li class="cell" icon="&#xea07;" > <!--Required disabled class for li cell-->
        <a>Goto Subview

            <span class="additional-icon"><i class="icon icon-earth"></i></span>
            <span class="additional-icon"><i class="icon icon-link"></i></span>
            <span class="additional-icon"><i class="icon icon-checkmark"></i></span>

        </a>
    </li>

    <!--TABLE FORM CELL DISABLED LABEL + INPUT -->
    <li class="section">
        Table Cell Details button but disable
    </li>
    <li class="cell" data-sub-title="Details view Controller 443"> <!--Required disabled class for li cell-->
        <a>Goto Subview



            <!--<span class="additional-icon"><i class="icon icon-earth"></i></span>
            <span class="additional-icon"><i class="icon icon-link"></i></span>
            <span class="additional-icon"><i class="icon icon-checkmark"></i></span>-->

        </a>


    </li>

    <!--TABLE FORM CELL DISABLED LABEL + INPUT -->
    <li class="section">
        Table Cell With Custom Add Button
    </li>
    <li class="cell"> <!--Required disabled class for li cell-->
        <a icon="&#xed65;">Goto Subview


            <span class="additional-icon"><i class="icon icon-earth"></i></span>
            <span class="additional-icon"><i class="icon icon-link"></i></span>
            <span class="additional-icon"><i class="icon icon-checkmark"></i></span>

        </a>
    </li>


    <!--TABLE FORM CELL DISABLED LABEL + INPUT -->
    <li class="section">
        Table Cell With Custom Edit Button
    </li>
    <li class="cell"> <!--Required disabled class for li cell-->
        <a icon="&#xe917;">Goto Subview</a>
    </li>


    <!--TABLE FORM CELL DISABLED LABEL + INPUT -->
    <li class="section">
        Table Cell With Radio Option
    </li>
    <li class="cell"> <!--Required disabled class for li cell-->
        <input id="test1" name="test[]" value="test1" type="radio"/>
        <label for="test1" class="">Test Radio 1</label>
    </li>
    <li class="cell"> <!--Required disabled class for li cell-->
        <input id="test2" name="test[]" value="test2" type="radio"/>
        <label for="test2" class="">Test Radio 1</label>
    </li>


    <!--TABLE FORM CELL DISABLED LABEL + INPUT -->
    <li class="section">
        Table Cell With Checkbox Option
    </li>
    <li class="cell"> <!--Required disabled class for li cell-->
        <input id="test3" name="test_[]" value="test" type="checkbox"/>
        <label for="test3" class="">Test Checkbox 1</label>
    </li>
    <li class="cell"> <!--Required disabled class for li cell-->
        <input id="test4" name="test_[]" value="test" type="checkbox"/>
        <label for="test4" class="">Test Checkbox 2</label>
    </li>


    <!--TABLE FORM CELL DISABLED LABEL + INPUT -->
    <li class="section">
        Table Cell With With Image + Label
    </li>
    <li class="cell illustrated"> <!--Required disabled class for li cell-->
        <img src="/images/avatar.png" width="20" height="20">
        <label for="test3" class="">Sample Name</label>
    </li>

    <!--TABLE FORM CELL DISABLED LABEL + INPUT -->
    <li class="section">
        Table Cell With With Image + Without Label
    </li>
    <li class="cell illustrated"> <!--Required disabled class for li cell-->
        <img src="/images/avatar.png" width="20" height="20">
        Sample Name (No Label)
    </li>

    <!--TABLE FORM CELL DISABLED LABEL + INPUT -->
    <li class="section">
        Table Cell With With Image + With Label + Details View Controller
    </li>
    <li class="cell illustrated"> <!--Required disabled class for li cell-->
        <a>
            <img src="/images/avatar.png" width="20" height="20">
            <label>Sample Name (Details la)</label>
        </a>
    </li>


    <!--TABLE FORM CELL DISABLED LABEL + INPUT -->
    <li class="section">
        Table Cell With With Image + Without Label + Details View Controller
    </li>
    <li class="cell illustrated"> <!--Required disabled class for li cell-->
        <a>
            <img src="/images/avatar.png" width="20" height="20">
            Sample Name (Details without )
        </a>
    </li>







    <!--CELL INPUT RADIO AND LABEL-->
    <!--<li class="cell">
        <label for="test1" class="">Test Radio 1</label>
        <input id="test1" name="test[]" value="test" type="radio"/>
    </li>

    <!--CELL INPUT RADIO AND LABEL-->
    <!--<li class="cell">
        <label for="test2" class="">Test Radio 2</label>
        <input id="test2" name="test[]" value="test" type="radio"/>
        <label for="test2" class=""></label>
    </li>-->





</ul>

<!--DETAILS-->
<ul class="x2-list">



</ul>

<!--DETAILS-->
<ul class="x2-list" id="profile">


    <li class="section mb-30">
        <span class="font-mini font-normal font-italic ">
            Bitte wählen Sie Rolle und<br />
            Beachten Sie, flicht felder kann nicht leer sein!
        </span>
    </li>



</ul>


<div id="player">


</div>