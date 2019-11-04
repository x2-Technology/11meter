<ul class="list-group">
    <!--<li class="list-group-item box-no-padding box-with-border-radius-none box-no-border">
        <div class="btn-group col-12 btn-group-toggle box-no-padding" role="group" aria-label="Basic example">
            <button type="button" class="col-5 btn btn-secondary box-with-border-radius-none ">Monatlich</button>
            <button type="button" class="col-5 btn btn-secondary box-with-border-radius-none">Wöchentlich</button>
            <button type="button" class="col-5 btn btn-secondary box-with-border-radius-none">Täglich</button>
        </div>
    </li>-->

    <li class="list-group-item box-no-border h-5">

        <div class="w-100 text-center pos-relative">

                <span class="float-left position-static float-left mt-5">
                    <a id="prev-month" data-view="months">
                            <i class="icon icon-arrow-left4 text-primary font-normal"></i>
                        </a>
                </span>

                <span class="float-left position-static float-right mt-5">
                    <a id="next-month" data-view="months">
                            <i class="icon icon-arrow-right4 text-primary font-normal"></i>
                        </a>
                </span>

                <span>
                    <a id="month" data-view="months" class="p-0 btn text-primary font-normal cursor-pointer"><?= date('F'); ?></a>
                    <a id="year" data-view="years" class="p-0 btn text-primary font-normal cursor-pointer"><?= date('Y'); ?></a>
                </span>

        </div>

    </li>


    <li class="list-group-item box-no-padding box-no-border ">
        <div id='calendar'></div>
    </li>

    <li class="list-group-item box-no-border bg-warning box-with-border-radius-none" style="height: 40px;">
        <span class="badge float-left">
            <i class="icon icon-calendar float-left"></i>
        </span>
        <div id="selected-date-container" class="font-small float-left pos-relative"></div>
        <span class="badge float-right">Events</span>
    </li>
</ul>

<ul class="list-group" id="selected-date-events-list-container" >

</ul>
