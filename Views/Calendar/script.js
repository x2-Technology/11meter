/**
 * Created by tSoftX on 12/02/2017.
 */

$(function () {
    new Layout().init();
});

let Layout = function () {
        
        let L = this;
        let customDate = null;
        this.datePicker = null;
        this.storeEvents = null;
        this.storeTotalEvents = 0;
        this.monthNames = [];
        this.years = [];
        
        // √
        this.init = function () {
            
            this.datePicker = $("#calendar");
            
            this.calendar();
            this.initButtons();
            this.fetchMonth(); // Load with current month and year
            
            
            return this;
        };
        
        // √
        this.calendar = function () {
            
            this.datePicker
                .datepicker(
                    {
                        showWeek: true,
                        isRTL: false,
                        weekHeader: "W",
                        showAnim: "fold",
                        selectOtherMonths: true,
                        firstDay: 1,
                        dayNamesMin: ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"],
                        prevText: "Prev",
                        nextText: "Next",
                        monthNamesShort: ["Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"],
                        dateFormat: "yy-mm-dd",
                        autoSize: true,
                        // changeMonth: true,
                        // changeYear: true,
                        inline: false,
                        
                        onSelect: function (dateText, inst) {
                            
                            
                            setTimeout(function () {
                                L.loadMonthEventsWithData(0, 0, function () {
                                
                                });
                            }, 0);
                            
                            
                            L.listDayEvents(dateText);
                            
                        },
                        
                        onChangeMonthYear: function (y, m) {
                        
                        }
                    });
            
            
        };
        
        // √
        this.initButtons = function () {
            
            document.getElementById("month").onmousedown = function (ev) {
                L.viewMonthYear(this);
            };
            
            document.getElementById("year").onmousedown = function (ev) {
                L.viewMonthYear(this);
            };
            
            document.getElementById("next-month").onmousedown = function (ev) {
                L.seekMonth(this);
            };
            document.getElementById("prev-month").onmousedown = function (ev) {
                L.seekMonth(this);
            };
            
        };
        
        // √
        this.fetchMonth = function (m, Y) {
            
            
            let l = new $.tsoftx.loader();
            l.show(function () {
                
                setTimeout(function () {
                    
                    newData = {};
                    if (m !== undefined)
                        newData.month = m;
                    
                    if (Y !== undefined)
                        newData.year = Y;
                    
                    console.log("New Data", newData);
                    let db = new $.tsoftx.ajax();
                    db
                        .setCnt("Calendar")
                        .setNsp("monthview")
                        .setMtd("fetchMonth")
                        .setData(newData)
                        .setProcessWithSession(false)
                        .execute(function () {
                            
                            L.storeEvents = this.events;
                            L.storeTotalEvents = this.count;
                            L.listDayEvents(L.datePicker.datepicker('getDate'));
                            
                            L.monthNames = this.month_names;
                            L.years = this["years"];
                            
                            
                            // Todo Other Case
                            // console.log("Month Data", data);
                            L.loadMonthEventsWithData(500, 150, function () {
                                l.dismiss();
                            });
                            
                            
                        }, function () {
                        
                        });
                    
                    
                }, 1000);
                
                
            });
            
            
        }
        
        // √
        this.loadMonthEventsWithData = function (delay, delayNextDiff, callback) {
            
            let $tbl = $(L.datePicker).find("table.ui-datepicker-calendar");
            let cell;
            console.log("L.storeEvents", L.storeTotalEvents);
            
            let i = 0;
            if( L.storeEvents.length ) {
                
                $.each(L.storeEvents, function (m, dys_group) {
        
                    // Month
                    $.each(dys_group, function (d, dMeetings) {
            
                        $.each(dMeetings, function (k, v) {
                
                            setTimeout(function () {
                                console.log("Month: %s Day: %s Year: %s Meeting Id: %s", m, d, k, k);
                    
                                cell = $tbl.find("td").filter(function () {
                                    return $(this).data("month") + 1 === parseInt(m) && $(this).data("day") === parseInt(d);
                                }).find("div.day-events-wrapper").empty();
                    
                                let obj = $("<div>");
                                obj[0].dataset.role = "day-event";
                                obj[0].classList.add("list-event-icon", "list-event-icon-animate", "ml-2", "mb-2");
                                obj[0].style.backgroundColor = '#' + v.title_color;
                                obj.appendTo(cell);
                    
                    
                            }, delay + (delayNextDiff * i));
                
                            i++;
                
                
                        })
            
                    })
        
                });
    
            }
            if (undefined !== callback && typeof callback === "function") {
                callback();
            }
            
            
        };
        
        // √
        this.listDayEvents = function (dateText) {
            
            
            let selectedDateContainer = document.getElementById("selected-date-container");
            let selectedDayEventsListContainer = document.getElementById("selected-date-events-list-container");
            let isExistsEl;
            
            let selectedDate = L.datePicker.datepicker('getDate');
            
            // Detail Header Date String
            isExistsEl = $(selectedDateContainer).find(".day-detail-events-header");
            if (isExistsEl.length) {
                // isExistsEl.removeClass("list-top-in").addClass("list-top-out");
                isExistsEl.removeClass("list-top-in");
                isExistsEl.animate({
                    top: 7,
                    opacity: 0
                }, 200, function () {
                    $(this).remove();
                    createHeaderEl(selectedDate);
                });
                /*
                isExistsEl[0].remove();
                setTimeout(function () {
                    setTimeout(function () {
                        // createHeaderEl(selectedDate);
                    },300);
                }, 300);
                */
            } else {
                createHeaderEl(selectedDate);
            }
            
            function createHeaderEl(selectedDate) {
                let eL = $("<span>");
                eL[0].classList.add("day-detail-events-header", "list-top-in");
                eL[0].innerText = L.dateWithFormat(selectedDate);
                selectedDateContainer.appendChild(eL[0]);
            }
            
            
            // Detail Body Items
            isExistsEl = $(selectedDayEventsListContainer).find(".list-group-item");
            if (isExistsEl.length) {
                isExistsEl.removeClass("list-left-in").addClass("list-right-out");
                setTimeout(function () {
                    isExistsEl.remove();
                    createBodyEl(selectedDate);
                }, 300);
            } else {
                createBodyEl(selectedDate);
            }
            
            function createBodyEl(selectedDate) {
                
                
                let d = new Date(selectedDate);
                m = d.getMonth() + 1;
                d = d.getDate();
                m = m < 10 ? "0" + m : m;
                d = d < 10 ? "0" + d : d;
                let eL;
                let i = 0;
                if( L.storeEvents.length ) {
                    
                    let sourceDayEvents = L.storeEvents[m][d];
    
                    $.each(sourceDayEvents, function (k, v) {
                        setTimeout(function () {
                            console.log("Detailiert event", v);
                            eL = L.dayEventDetailRowCreateWithData(v);
                            selectedDayEventsListContainer.appendChild(eL);
                        }, 200 + (i * 300));
                        i++;
                    });
                }
                
                
            }
            
        };
        
        // √
        this.dateWithFormat = function (dateText) {
            
            let selectedDate = new Date(dateText);
            d = selectedDate.getDate();
            m = selectedDate.getMonth();
            Y = selectedDate.getFullYear();
            m++;
            d = d < 10 ? "0" + d : d;
            m = m < 10 ? "0" + m : m;
            return d + "." + m + "." + Y
            
        };
        
        // √
        this.viewMonthYear = function (El) {
            
            let l = new $.tsoftx.loader();
            l.show(function () {
                
                let db = new $.tsoftx.ajax();
                db
                    .setCnt("Calendar")
                    .setNsp("monthview")
                    .setMtd(El.dataset.view)
                    // .setData({})
                    .setProcessWithSession(false)
                    .execute(function () {
                        
                        let data = this;
                        
                        l.dismiss(function () {
                            
                            let ac = new $.tsoftx.alert();
                            ac
                                .setTitle("Bitte Auswählen")
                                .setMessage(data.view)
                                .addBodyClass("nopadding")
                                .show(function () {
                                    
                                    $(this.getContent()).find("a").mousedown(function () {
                                        let currentDate = L.datePicker.datepicker('getDate');
                                        let dd = new Date(currentDate);
                                        let m = dd.getMonth(), Y = dd.getFullYear(), d = dd.getDate();
                                        if (El.dataset.view === "months") {
                                            m = $(this)[0].dataset.valnumeric;
                                        }
                                        m++;
                                        m = m < 10 ? "0" + m : m;
                                        d = d < 10 ? "0" + d : d;
                                        
                                        if (El.dataset.view === "years") {
                                            Y = $(this)[0].dataset.valnumeric;
                                        }
                                        
                                        let dateWithFormat = Y + '-' + m + '-' + d;
                                        
                                        El.innerText = $(this)[0].dataset.valstring;
                                        
                                        ac.dismiss();
                                        
                                        L.datePicker.datepicker('setDate', dateWithFormat);
                                        L.fetchMonth(m, Y);
                                        
                                        
                                    });
                                    
                                });
                            
                            let cancelAction = new $.tsoftx.alertAction();
                            cancelAction
                                .setTitle("Close")
                                .setStyle("danger")
                                .create()
                                .click(function () {
                                    ac.dismiss();
                                })
                                .actionTo(ac.actions())
                            
                        });
                        
                        
                    }, function () {
                    
                    });
                
                
            });
            
            
        };
        
        // √
        this.seekMonth = function (El) {
            
            let getDateFromCalendar = L.datePicker.datepicker('getDate');
            getDateFromCalendar = new Date(getDateFromCalendar);
            
            let m = getDateFromCalendar.getMonth(),
                Y = getDateFromCalendar.getFullYear(),
                d = getDateFromCalendar.getDate();
            
            // alert(El.getAttribute("id") + " " + m);
            
            switch (El.getAttribute("id")) {
                case "prev-month":
                    m--;
                    if (m < 0) {
                        m = 11;
                        Y--;
                    }
                    break;
                case "next-month":
                    m++;
                    if (m > 11) {
                        m = 0;
                        Y++;
                    }
                    break;
            }
            
            let monthEl = document.getElementById("month");
            let yearEl = document.getElementById("year");
            monthEl.innerText = L.monthNames.m_long[m];//  data.m_long[m];
            yearEl.innerText = Y;
            
            // As getDate month number start from 0
            m++;
            // For setDate to datepicker do it with correct month number not from 0
            L.datePicker.datepicker('setDate', Y + '-' + m + '-' + d);
            // Post correct month number to server
            L.fetchMonth(m, Y);
            
            
        };
        
        //√
        this.dayEventDetailRowCreateWithData = function (data) {
            
            let r = '<div class="pos-relative w-100 h-100">' +
                '                        <table class="h-100 box-no-border">' +
                '                            <tbody>' +
                '                            <tr>' +
                '                                <td class="w-2" style="background-color: #' + data.title_color + '"></td>' +
                '                                <td class="pl-10 pt-5 ">' +
                '                                    <div class="pos-relative h-100 w-100">' +
                '                                        <div class="w-100 font-bold" style="color: #' + data.title_color + '">' + data.display_name + '</div>' +
                '                                        <div class="w-100 font-small">' + data.ort + '</div>' +
                '                                    </div>' +
                '                                </td>' +
                '                                <td class="pl-5 pt-5 vertical-align-middle">' +
                '                                    <div class="pos-relative w-100">' +
                '                                        <span class="font-small float-right text-warning font-bold"><i class="icon icon-watch"></i>' + data.meeting_meet + '</span>' +
                '                                        <div class="clearfix"></div>' +
                '                                        <span class="font-small float-right">' +
                '                                               <span class="text-success font-bold"><i class="icon icon-stopwatch"></i>' + data.meeting_start + '</span>' +
                '                                                - ' +
                '                                               <span class="text-danger font-bold"><i class="icon icon-stopwatch text-danger"></i>' + data.meeting_end + '</span>' +
                '                                        </span>' +
                '                                    </div>' +
                '                                </td>' +
                '                                <td class="min-width">' +
                '                                    <span class="badge"><i class="icon icon-arrow-right4"></i></span>' +
                '                                </td>' +
                '                            </tr>' +
                '                            </tbody>' +
                '                        </table>' +
                '                    </div>';
            
            console.log("Incoming Data", data);
            let li = document.createElement('li');
            li.classList.add("list-group-item", "pos-relative", "nopadding", "box-with-border-radius-none");
            li.style.height = "80px";
            
            let a = document.createElement("a");
            // a.dataset.data = JSON.stringify(data);
            a.classList.add("h-100", "w-100", "background-primary", "pos-absolute", "list-left-in");
            a.innerHTML = r;
            a.onclick = function () {
    
                console.log(data);
                let activity = data.activity;
                if (activity === undefined) {
                    activity = ACTIVITY.ACTIVITY_1
                }
                
                location.href = DEVICE + "://" + activity + "?" + JSON.stringify(data);
                
                // let data = this.dataset.data;
                // data = data.replace( /[\\]/g, "" );
                // data = data.replace( /'/g, "\"" );
                
                /*switch (DEVICE){
            
                    case DEVICE_TYPE.ANDROID:
             
                        DFANDROID.startActivity( ACTIVITY.TWO,  data );
                
                        break;
            
                    case DEVICE_TYPE.IOS:
                        
                        // Open List Detail
                        DATA_JSON_FOR_IOS = JSON.stringify(data);
                        location.href = DEVICE_ACTION_SCHEME + "://" + ACTIVITY.TWO + "?" + DATA_JSON_FOR_IOS;
                        
                        break;
            
                    default:
                
                        // data = JSON.parse(data);
                        location.href = data["link"];
            
            
                }*/
                
            }
            
            li.appendChild(a);
            
            
            return li;
            
        };
        
        
        this.setUnwindDataStore = function (k, v) {
            
            unwindDataStore[k] = v;
        };
        this.setUnwindDataFromJSONString = function (data) {
            
            if (typeof data !== "object") {
                unwindDataStore = JSON.parse(data);
            } else {
                unwindDataStore = data
            }
            
            return this;
        };
        this.getUnwindDataStore = function () {
            
            data = JSON.stringify(unwindDataStore);
            return data;
        };
        
        return this;
        
    }, unwindDataStore = {},
    // This action calling from Native Content data Post from Native Content And Need Absolute
    unwindAction = function (data) {
        
        new Layout()
            .setUnwindDataFromJSONString(data);
        
    };

