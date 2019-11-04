<?php
    // highlight_string(var_export($this->data->user, true));
    $p = $this->data->performance;

    $p["weekly"]["total"] = 8;
    $p["weekly"]["attend"] = 6;

    $weeklyTotalPerformance = $p["weekly"]["attend"] * 100 / $p["weekly"]["total"] ;
    // highlight_string(var_export($weeklyTotalPerformance, true));

?>

<ul class="x2-list">


    <li class="cell no-cell-border nopadding " style="background-color: #303030 !important;">

        <div class="container-fluid nomargin">
            <div class="row">

                <div class="col">

                    <div class="form-group font-bold nopadding nomargin">

                        <div class="pos-relative float-left">
                            <span style=" transform: rotate(-90deg); position: absolute; top: 40px; left: -40px; float: left;color: #626262 !important; text-shadow: 1px 1px 1px #2d2d2d;" class="font-bold text-light">Performance</span>
                            <span
                                    class="font-bold text-center font-1VH float-right pl-10 text-light"
                                    style="font-size: 55px;color:#626262 !important; text-shadow: 1px 1px 1px #2d2d2d;" id="totalPerformance"
                                    data-count="<?= $weeklyTotalPerformance; ?>"
                                    data-operator="%"
                                    data-start-value="00%"
                            ></span>
                        </div>

                    </div>

                    <div class="clearfix"></div>
                    <div class="form-group font-bold nopadding nomargin">

                        <i data-rating="1" class="rating icon icon-star-empty text-warning float-left ml-10 icon-size-table-cell"></i>
                        <i data-rating="2" class="rating icon icon-star-empty text-warning float-left ml-10 icon-size-table-cell"></i>
                        <i data-rating="3" class="rating icon icon-star-empty text-warning float-left ml-10 icon-size-table-cell"></i>
                        <i data-rating="4" class="rating icon icon-star-empty text-warning float-left ml-10 icon-size-table-cell"></i>
                        <i data-rating="5" class="rating icon icon-star-empty text-warning float-left ml-10 icon-size-table-cell"></i>

                    </div>
                    <div class="clearfix"></div>
                    <div class="text-warning font-small text-warning pl-10 mt-10">
                        Fast geschaft!!!
                    </div>


                </div>

                <div class="col row-h-200 nopadding">
                    <div class="rings-wrapper">

                        <svg viewBox="0 0 40 40">

                            <path class="circle-highlight box-training" stroke-dasharray="100, 100" d="M19 03 a 15 15 0 0 1 0 32 a 15 15 0 0 1 0 -32" />
                            <path class="circle-highlight box-engage" stroke-dasharray="80, 100" d="M19 08.5 a 10 10 0 0 1 0 21 a 10 10 0 0 1 0 -21" />
                            <path class="circle-highlight box-other" stroke-dasharray="50, 100" d="M19 14.1 a 05 05 0 0 1 0 10 a 05 05 0 0 1 0 -10" />

                            <path class="circle box-training "  d="M19 03 a 15 15 0 0 1 0 32 a 15 15 0 0 1 0 -32"   data-full="<?= $p["weekly"]["total"]; ?>" data-value="<?= $p["weekly"]["attend"]; ?>"  stroke-dasharray="0, 100"  />
                            <path class="circle box-engage"     d="M19 08.5 a 10 10 0 0 1 0 21 a 10 10 0 0 1 0 -21" data-full="4" data-value="3" stroke-dasharray="0, 100"  />
                            <path class="circle box-other"      d="M19 14.1 a 05 05 0 0 1 0 10 a 05 05 0 0 1 0 -10" data-full="12" data-value="5" stroke-dasharray="0, 100"   />
                        </svg>

                    </div>

                </div>
            </div>
        </div>



    </li>
    <li class="cell">
        <div class="form-group font-bold font-italic nopadding nomargin">
                <?= $this->data->user["teamrolle"]; ?>
        </div>

        <div class="form-group nomargin nomargin">
                <?= $this->data->user["final_name"]; ?>
        </div>
    </li>

    <li class="section font-bold">
        Diese Woche
        <span class="x2-badge" data-value="23.Kw"></span>
    </li>

    <li class="cell">
        <div class="form-group font-normal font-italic nopadding nomargin">

            <span class="box box-training"></span><span class="ml-10">Trainiert 50%</span>
            <div class="clearfix"></div>
            <span class="box box-engage"></span><span class="ml-10">Engegiert 10%</span>
            <div class="clearfix"></div>
            <span class="box box-other"></span><span class="ml-10">Other 5%</span>


        </div>

    </li>







</ul>