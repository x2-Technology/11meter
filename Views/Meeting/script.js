/**
 * Created by tSoftX on 12/02/2017.
 */

$(function () {
    new Layout().init();
});

let Layout = function () {
        
        let L = this;
        
        
        this.init = function () {
    
            
            // alert(location.href);
            
            this.buttons();
            
            this.showListDirection();
            
            if( nsp === "_feedback" ){
                    this.feedbackBonusAvailable();
            }
            
            
            
            return this;
        };
        
        // @Device Interface
        this.feedbackMeetingSave = function(){
            
            try{

                function serializeFeedback(callback){
    
                    let cells   = document.querySelectorAll("li.cell").length;
                    let i       = 0;
                    let fb      = [];
                    
                   
                    document.querySelectorAll("li.cell").forEach(function (El) {
        
                        let
                            // bonus   = $(El).find("input[type=checkbox]").is(":checked"),
                            option  = $(El).find("select").val(),
                            player  = El.dataset.playerid;
                        
                        if( player !== undefined )
                        {
                            let itm     = {};
                            itm.option  = option;
                            itm.player  = player;
                            /*if( undefined !== bonus ){
                                itm.bonus   = bonus;
                            }*/
                            fb.push(itm);
    
                            console.log("Feedback for " + i + ":", fb);
                        }
                        
                        i++;
                        
                        if( i === cells ){
                            if( typeof callback === "function" && undefined !== callback ){
                                callback(fb);
                            }
                        }
        
                    });
                    
                    
                    
                    
                }
    
                serializeFeedback(function (fb) {
                    
                    
                    
                    let l = new $.tsoftx.loader();
                    l.show(function () {
                        let ajx = new $.tsoftx.ajax();
                        ajx
                            .setCnt(cnt)
                            .setNsp(nsp)
                            .setProcessWithSession(false)
                            .setMtd("save")
                            .setData({
                                fb:fb
                            })
                            .execute(function () {
    
                                
                                let data = this;
                                console.log("dataX",data.sql);
                                
                                l.dismiss(function () {
                                    // Process with multiple Query
                                    // Because of result from mysql not functionally
                                    // Result only for one Query successful
                                    // location.reload(true);
                                    
                                    
                                    if( DEVICE !== "" ){
                                        
                                        let d = {};
                                        d.title = data.title;
                                        d.message = data.message;
                                        d.actions = [
                                            {
                                                "title":"Ok",
                                                "action":"javascript:dismissViewController({})",
                                                "style":ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                                            }
                                        ];
                                        data = JSON.stringify(d);
                                        location.href = DEVICE + "://" + ACTIVITY.ACTIVITY_ALERT_VIEW + "?" + data;
                                    }
                                    else
                                    {
                                        alert(data.message);
                                        
                                    }
                                    
                                    
                                    
                                    
                                    /*$("form").processResultaWithView(data.message, data.color);
                                    setTimeout(function () {
                                        dismissViewController(data);
                                    }, 1000);*/
                    
                                });
                
                            });
                    });
                    
                });
                
                
                
            } catch( e ){
    
                alert(e.message);
                
            }
            
            
                
                
            
            
            
            
        };
        
        this.dismissViewController = function(){
            dismissViewController({});
        };
        
        this.feedbackBonusAvailable = function (){
            
            document.querySelectorAll("select#feedback_option").forEach(function (El) {
                El.onchange = function(){
                    switch (this.value){
                        case 3:
                        case 4:
                        case 0:
                            document.querySelector("input#" + this.dataset.checkbox).addAttribute("disabled");
                            break;
                        default:
                            document.querySelector("input#" + this.dataset.checkbox).removeAttribute("disabled");
                            
                            
                    }
                    
                    if( $(this).val() == 3 || $(this).val() == 4 || $(this).val() == 0 ){
                        $(this).closest("li").find("input#bonus").prop("disabled", true).prop("checked", false).checkboxradio("refresh");
        
                    } else
                    {
                        $(this).closest("li").find("input#bonus").removeAttr("disabled").checkboxradio("refresh");
                    }
                    
                }
            });
            
            $("select#options").on("change", function(){
                
                if( $(this).val() == 3 || $(this).val() == 4 || $(this).val() == 0 ){
                    $(this).closest("li").find("input#bonus").prop("disabled", true).prop("checked", false).checkboxradio("refresh");
                    
                } else
                {
                    $(this).closest("li").find("input#bonus").removeAttr("disabled").checkboxradio("refresh");
                }
                
                
            });
            
        }
        
        
        
        this.showListDirection = function () {
            
            console.log("document.querySelector-->", document.querySelector(".meeting-list"));
            
            if(document.querySelector(".meeting-list") !== null){
                setTimeout(function () {
                    $.tsoftx.processResultaWithView( document.querySelector(".meeting-list"), document.getElementById("listing-label").value, "info")
                }, 800);
                
            }
            
        };
        
        // @Native Interface
        this.toggleList = function(){
    
            let params = new URLSearchParams(window.location.search);
            let direction;
            switch (params.get("direction")){
                case null:
                    direction = "prev";
                    break;
                    
                case "next":
                    direction = "prev";
                    break;
                    
                case "prev":
                    direction = "next";
                    break;
                
                
            }
            
            let url;
            url = location.protocol + "//" + location.hostname + location.pathname + "?direction=" + direction;
            location.href = url;
            
        }
        
        this.buttons = function () {
            
            if( DEVICE !== "" ){
                // document.querySelectorAll(".meeting-item, .meeting-details-item").forEach(function (El) {
                document.querySelectorAll("li.cell > a.action").forEach(function (El) {
                    
                    El.onmousedown = function(){
                        
                        let data    = this.dataset.data;
                        data        = JSON.parse(data.replace(/[\\]/g, ""));
                        L.loadActivityWithData(data);
                    }
                });
            }
    
            // INPUT REASON BETWEEN
            
            switch (nsp){
                
                case "_availability":
                    this.actionForNSAvailability();
                    break;
    
                case "_list":
                    break;
    
                case "_feedback":
                    break;
                
            }
            
            
    
    
    
            
            
            // Deprecated
            document.querySelectorAll("[data-role=tab]").forEach(function (El) {
                
                El.ontouchstart = function(){
                    event(this)
                }
    
                El.onclick = function(){
                    event(this);
                }
                
                function event(El){
                    let content = document.getElementsByClassName("page-viewer-content")[0];
                    console.log("Node",El.parentNode);
                    El.parentNode.parentNode.childNodes.forEach(function(node){
                        if( node.nodeName === "LI" ){
                                console.log("Node",node);
                                node.classList.remove("active");
                        }
                    });
                    El.parentNode.classList.add("active");
                    // El.parentNode.style.borderBottom = "2px solid blue";
                    
                    if( El.dataset.page === "to-one" ){
                        content.classList.remove("show-page-two");
                        content.classList.add("show-page-one");
                    } else {
                        content.classList.remove("show-page-one");
                        content.classList.add("show-page-two");
                        
                    }
                }
            });
    
            function removeClassByPrefix(el, prefix) {
                let regx = new RegExp('\\b' + prefix + '.*?\\b', 'g');
                el.className = el.className.replace(regx, '');
                return el;
            }
            
            
            
            
        };
        
        this.actionForNSAvailability = function(){
    
            let reason_to   = null;
            let reason_from = null;
            let today       = new Date();
            let today_str   = null;
            let diff        = null;
            
            document.querySelectorAll(".my-availability").forEach(function (El) {
            // document.querySelectorAll("li.action").forEach(function (El) {
                El.ontouchstart = function(){
            
            
                    document.querySelectorAll(".my-availability").forEach(function (El) {
                        El.classList.remove("availability-active");
                        El.classList.add("availability-inactive");
                    });
            
                    this.classList.add("availability-active");
            
                    document.getElementById('selected_availability').value = this.dataset.avalilability;
            
                    // Change subview
                    L.availabilitySubview(this.dataset.avalilability);
            
                }
            })
    
            
            document.querySelectorAll(".reason-between").forEach(function (El) {
                
                // El.value = El.getAttribute("value");
                // El.removeAttribute("value");
                
                El.onchange = function(){
    
                    reason_to   = document.getElementById("reason_to");
                    reason_from = document.getElementById("reason_from");
                    
                    console.log("ID", this.getAttribute("id"));
                    try{
                        switch( this.getAttribute("id") ){
        
                            case "reason_from":
            
                                today_str = today.getFullYear() + '-' + (today.getMonth()+1) + '-' + today.getDate();
                                
                                diff = Math.floor((new Date(this.value) - new Date(today_str)))/(3600*1000*24);
                                if( diff < 0 ){
                                    this.value = today_str;
                                }
            
                                // document.getElementById("diff").innerText = diff;
            
                                // Stop Value
                                if( '' !== reason_to.value ){
                                    let end_date = null;
                                    diff = Math.floor((new Date(this.value) - new Date(reason_to.value)))/(3600*1000*24);
                                    
                                    if( diff >= 0 ){
                                        
                                        end_date = new Date(this.value);
                                        end_date.setDate(end_date.getDate()+1);
                                        reason_to.value = end_date.getFullYear() + '-' + (end_date.getMonth()+1) + '-' + end_date.getDate()
                                        // reason_to.setAttribute("value",end_date.getDate() + '.' + (end_date.getMonth()+1) + '.' + end_date.getFullYear() );
                                    }
                                }
            
                                break;
        
                            case "reason_to":
                                
                                console.log(today);
                                today.setDate(today.getDate()+1);
                                today_str = today.getFullYear() + '-' + (today.getMonth()+1) + '-' + today.getDate();
                                // console.log("Today", today_str);
                                
                                
            
                                if( '' !== reason_from.value ){
                                    let from_date = null;
                                    diff = Math.floor((new Date(this.value) - new Date(reason_from.value)))/(3600*1000*24);
                                    if(  diff <= 0 ){
                                        from_date = new Date(reason_from.value);
                                        from_date.setDate(from_date.getDate()+1);
                                        this.value = from_date.getFullYear() + '-' + (from_date.getMonth()+1) + '-' + from_date.getDate();
                                    }
                
                                } else {
                                    diff = Math.floor((new Date(this.value) - new Date(today_str)))/(3600*1000*24);
                                    if( diff < 0 ){
                                        this.value = today_str;
                                    }
                                }
            
            
                                break;
        
        
        
                        }
    
                    } catch(e){
                        alert(JSON.stringify(e));
                    }
            
            
                }
            });
            
            
        }
        
        
        this.availabilitySubview = function(availability){
    
            try{
        
                let l = new $.tsoftx.loader();
                l.show(function () {
                    let ajx = new $.tsoftx.ajax();
                    ajx
                        .setCnt("Meeting")
                        .setNsp("_availability")
                        .setMtd("dispatchSubview")
                        .setProcessWithSession(false)
                        .setData({
                            availability:availability
                        })
                        .execute(function () {
                            let data = this;
                            l.dismiss(function () {
                                
                                document.querySelector("#subview").innerHTML = data;
                                
                                
                                
                            });
                    
                        });
                });
        
        
            } catch(e){
                alert(e.message);
            }
            
            
        }

        
        this.loadActivityWithData = function (data) {
            
            let activity = data.activity;
            let dataJSONString = JSON.stringify(data);
            if (activity === undefined) {
                activity = ACTIVITY.ACTIVITY_1;
            }
    
            location.href = DEVICE + "://" + activity + "?" + dataJSONString;
            
            /*switch (DEVICE) {
                
                case DEVICE_TYPE.ANDROID:
                    // DFANDROID.startActivity(activity, dataJSONString);
                    location.href = DEVICE + "://" + "ACTIVITY_2" + "?" + dataJSONString;
                    break;
                
                case DEVICE_TYPE.IOS:
                    location.href = DEVICE_ACTION_SCHEME + "://" + activity + "?" + dataJSONString;
                    break;
                
                default:
                    console.log("Data Meeting:", data);
                    location.href = data["link"];
            }*/
            
            
        }
        
        // @Interface
        this.shareWithWhatsApp = function(){
    
            try{
    
                let l = new $.tsoftx.loader();
                l.show(function () {
                    let ajx = new $.tsoftx.ajax();
                    ajx
                        .setCnt("Meeting")
                        .setNsp("_details")
                        .setMtd("shareWithWhatsapp")
                        .setProcessWithSession(false)
                        .execute(function () {
                            let data = this;
                            l.dismiss(function () {
                                oActivity.goWithData(ACTIVITY.ACTIVITY_SHARED, data);
                            });
            
                        });
                });
                
                
            } catch(e){
                alert(e.message);
            }
            
        }
        
        this.save = function (name_space) {
            
            let l = new $.tsoftx.loader();
            l.show(function () {
                $("form").serializeContent(function () {
                    let ajx = new $.tsoftx.ajax();
                    ajx
                        .setCnt("Meeting")
                        .setNsp(name_space)
                        .setProcessWithSession(false)
                        .setMtd("save")
                        .setData(this)
                        .execute(function () {
                            
                            let data = this;
                            l.dismiss(function () {
                                $("form").processResultaWithView(data.message, data.color);
                                if (data.resulta && data.process) {
                                    // alert(JSON.stringify(data));
                                    L.setUnwindDataStore("updated_meetings", data.updated_meetings); // using instead of data.meeting_id
                                    L.setUnwindDataStore("meeting_id", data.meeting_id); // Needless
                                    L.setUnwindDataStore("availability", data.availability);
                                    
                                    setTimeout(function () {
                                        dismissViewController(data);
                                    }, 500);
                                    
                                }
                                
                            });
                            
                        });
                });
            });
        };
        
        // Mode Method On X2UIFactor
        this.setUnwindDataStore = function (k, v) {
            
            unwindDataStore[k] = v;
        };
        
        // Mode Method On X2UIFactor
        this.setUnwindDataFromJSONString = function (data) {
            
            if (typeof data !== "object") {
                unwindDataStore = JSON.parse(data);
            } else {
                unwindDataStore = data
            }
            return this;
        };
        
        // Mode Method On X2UIFactor
        this.getUnwindDataStore = function () {
            
            data = JSON.stringify(unwindDataStore);
            return data;
        };
        
        // @Overwrite
        // Method Overwrite Here And Fixed
        this.updateAvailability = function () {
            
            try {
                let obj = this.getUnwindDataStore();
                // alert(JSON.stringify(obj));
                
                if (typeof obj !== "object") {
                    obj = JSON.parse(obj);
                }
                
                if (undefined !== obj["availability"]) {
                    
                    if( Object.keys(obj["updated_meetings"]).length ){
    
                        for(let i in obj["updated_meetings"]){
                            // From single item to multiple items update possible
                            let meeting_id = obj["updated_meetings"][i];
                            
                            try {
                                // let availabilityEl = $(".meeting-details-item, .meeting-item").filter(function () {
                                let availabilityEl = $("li.cell").filter(function () {
                                    // return $(this).attr("data-id") === obj["meeting_id"];
                                    return parseInt($(this).attr("data-id")) === parseInt(meeting_id);
                                })
                                    .find("span#my-availability i")[0];
                                if( undefined !== availabilityEl ){
                                    availabilityEl.removeAttribute("class");
                                    availabilityEl.setAttribute("class", "icon " + ANWESENHEIT[parseInt(obj["availability"])]);
                                }
                            } catch (e) {
                                // alert(e.message);
                            }
        
                        }
                        
                        
                    }
                    
                    
                    
                    /*try {
                        let availabilityEl = $(".meeting-details-item, .meeting-item").filter(function () {
                            return $(this).attr("data-id") === obj["meeting_id"];
                        })
                            .find("span#my-availability i")[0];
                        availabilityEl.removeAttribute("class");
                        availabilityEl.setAttribute("class", "icon " + ANWESENHEIT[parseInt(obj["availability"])]);
                    } catch (e) {
                    
                    }*/
                    
                }
                
            }
            catch (e) {
                alert(e.message);
            }
            
        };
        
        
        return this;
        
        
    },
    unwindDataStore = {},
    // This action calling from Native Content data Post from Native Content And Need Absolute
    unwindAction = function (data) {
        
        new Layout()
            .setUnwindDataFromJSONString(data)
            .updateAvailability();
        
    };


