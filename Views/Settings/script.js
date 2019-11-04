/**
 * Created by tSoftX on 12/02/2017.
 */

$(function() {
    new Layout().init();
});


/**
 * GlobalUserCode:
 * User Will add the code which him that have
 * By Checking code will memorize with this GlobalUserCode,
 * By Click Einfügen (Add) Moving data GlobalUserCode from Native AlertController by clicking event to JS method codeAdd
 * Using this variable 'GlobalUserCode'
 * @type {string}
 */
let GlobalUserCode = "";





let Layout = function () {
        
        let L = this;
        
        this.init = function () {
    
            
            
            
            try{
                
                this.buttons();

                
                // alert(query.externalUrl);
    
                new X2Tools().TableView(document.getElementById("manage"),{
                    row:function () {
                    
                    },
                    rows:function () {
                    
                    },
                    search:function () {
                    
                    },
                    action:["Sil",function ( Button, row, ui) {
                        ui.remove(row);
                    }]
                }).create();
                
                
                // Prepare Table View
                // new X2Tools().TableView().create();
                
                switch (nsp) {
                    case "_notification":
                        
                        if( DEVICE  ){
                            this.planPicker();
                        }
                        
                        if (mtd === "index") {
                            document.querySelectorAll("input[data-role='plan-picker']").forEach(function (El) {
                                if (undefined !== El.value) {
                                    let val = JSON.parse(El.value);
                                    El.parentNode.childNodes.forEach(function (El) {
                                        if( El.nodeName === "LABEL" ){
                                            El.innerText = L.preparePlanString(val[0], val[1], val[2]);
                                        }
                                        console.log(El.nodeName);
                                    });
                        
                                }
                            });
                
                        }
            
                        // Set Plan plan for unwind element set Day Hour Minute
                        if (mtd === "plan_picker") {
                            
                            this.setUnwindDataStore("plan-picker", $("input").filter(function () {
                                return $(this).data("role") === "plan-picker";
                            }).val());
                        }
            
                        //
                        break;
    
    
                    case "_general":
    
                        // Prepare Table View
                        new X2Tools().TableView(document.querySelector("ul.x2-list"))
                            .children(function(li){
            
                                for(let x = 0; x < li.children.length; x++){
                
                                    let el = li.children[x];
                                    console.log("Button", el);
                
                                    if( el.nodeName === "BUTTON" ){
                                        el.onclick = function(){
                                            if( undefined !== el.dataset && (null !== el.dataset.data && undefined !== el.dataset.data) ){
                                                new X2Tools().presentViewControllerWithData(el.dataset.data);
                                            }
                                        }
                                    }
                                }
            
                                console.log("Li Element", li);
                            })
                            .create();
                        
                        
                        // TODO Test Role
    
                        // L.bootAutoRollAdder();
                        
                        break;
                        
                        
                    case "_code":
                        
                        let $codeEl = $("input#_code");
                        
                        $codeEl.inputmask("***-***-***-***");
                        
                        new X2Tools().Button(document.getElementById("check_code"),{
                            touchWith:"end",
                            touch:function (El) {
                                
                                let indicator = new X2Tools().ActivityIndicator();
                                indicator.show(function () {
    
                                    try{
                                        let httpRequest = new X2Tools().HttpRequest();
                                        httpRequest.setController("Settings");
                                        httpRequest.setMethod("check");
                                        httpRequest.setNamespace("_code");
                                        httpRequest.setData({
                                            code:$codeEl[0].value
                                        });
                                        httpRequest.execute(function () {
    
                                            GlobalUserCode = this.prettyCode;
                                            
                                            indicator.dismiss();
                                            let ac = new X2Tools().AlertController();
                                            ac.setTitle(this.title);
                                            ac.setMessage(this.message);
                                            
                                            let cancelActionTitle = "Schließen";
                                            if(!this.resulta){
                                                cancelActionTitle = "Ok";
                                            }
                                            ac.addAction({
                                                title:cancelActionTitle,
                                                style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                                action:""
                                            });
    
                                            if(this.resulta){
                                                ac.addAction({
                                                    title:"Einfügen",
                                                    style: ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                                                    action:"javascript:Layout().codeAdd()"
                                                });
                                            }
                                            
                                            ac.show();
            
                                        });
                                    } catch (e) {
                                        alert(e.message);
                                    }
                                    
                                });
                            }
                            
                        })
                        
                        break;
                        
                }
                
                
            }catch(e){
                alert("Error:" + e.message);
                
            }
    
    
            
            
            
            return this;
        };
        
        /**
         * Add user have the code to database
         */
        this.codeAdd =  function(){
    
            /*L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd );
            L.setUnwindDataStore("code", GlobalUserCode );
            new X2Tools().dismissViewController(L.getUnwindDataStore())*/
            
            let httpRequest = new X2Tools().HttpRequest();
            let activityIndicator = new X2Tools().ActivityIndicator()
            
            activityIndicator.show(function () {
                
                httpRequest
                    .setController("Settings")
                    .setNamespace("_code")
                    .setMethod("bindCodeToUser")
                    .setData({
                        code:GlobalUserCode
                    })
                    .execute(function () {
                        
                        activityIndicator.dismiss();
                        
                        // alert(JSON.stringify(this));
                        
                        
                        L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd );
                        L.setUnwindDataStore("code", GlobalUserCode );
                        L.setUnwindDataStore("finallyProcessedUserUsingRoleId", this.finallyProcessedUserUsingRoleId );
                        L.setUnwindDataStore("roles_table_should_reload", true);
                        new X2Tools().dismissViewController(L.getUnwindDataStore())
                        
                    })
                
                
                
            })
            
            
            
        
        }
        
        
        
        this.bootAutoRoleAdder = function () {
    
            let clubs = [];
            let club1 =
                {
                    season: 3,
                    club: 5,
                    activity_from: "2019-03-01",
                    activity_to: "2020-03-01",
                    team: [2, 4]
                };
    
            let club2 =
                {
                    season: 4,
                    club: 8,
                    team: [1, 12]
                };
    
            clubs.push(club1);
            clubs.push(club2);
    
            let data = {
                role: 15,
                register_role: 15,
                status: false,
                visibility: false,
                session: 3,
                club: 5,
                team: [2, 4]
            };
    
            delete (data.season);
            delete (data.club);
            delete (data.team);
    
            data.clubs = clubs;
    
    
    
            L.saveAndAddCompletedRoleForUser(data);
            
            
        }
        
        this.buttons = function () {
            
            $("li").filter(function () {
                return $(this).hasClass("action")
            }).find("a")
                .each(function () {

                    $(this).unbind("mousedown").mousedown(function () {
                        let data    = this.dataset.data;
                        data        = JSON.parse(data.replace(/[\\]/g, ""));
                        L.loadActivityWithData(data);
                    });
                });
            
            
            
            if( nsp === "_password" ){
                
                document.getElementsByTagName('input')[0].focus();
                
            }
            
            try{
                document.querySelectorAll("input.password").forEach(function (El) {
    
                    /*let im = new Inputmask("******");
                    im.mask(El);*/
                    
                });
            }catch (e) {
            
            }
    
    
            
            if( nsp === "_general" ){
            
        
            }
            
            
            
            
            
            
        };
        
        
        /**
         * @Javascript Interface
         * @Post to Database Completed Club Data for User
         * @param data
         * @deprecated instead of in Role Class
         */
        /*this.saveAndAddCompletedRoleForUser = function (data) {
            
            // xAlert(JSON.stringify(data));
            
            // TODO To Database
            
            let indicator = new X2Tools().ActivityIndicator();
            indicator.show(function () {
               
               let httpRequest = new X2Tools().HttpRequest();
               httpRequest
                   .setController("Role")
                   .setNamespace("manage")
                   .setMethod("add")
                   // .setMethod("prepareClubsDataForRole")
                   .setData(data)
                   .execute(function () {
                       
                       try{

                           let userRolesEl = document.querySelector("a[data-role=user-roles]");
                           userRolesEl.parentElement.classList.remove("disabled");
                           userRolesEl.parentElement.removeAttribute("disabled");
                           userRolesEl.innerHTML = this;
                           indicator.dismiss();


                       } catch(e){
                           alert(e.message);
                       }
    
    
                   });
               
                
                
                
            });
            
            
            
            
        }*/
        
        this.reloadUserRolesIconRowView = function(data){
    
            // xAlert(JSON.stringify(data), 122);
            
            // L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd);
            // L.setUnwindDataStore("roles_table_should_reload", this.roles_table_should_reload);
    
            // TODO If Role Removed
            try{
    
    
                let userRoleNewEl     = document.querySelector("li.cell a[data-role=role-management] span[data-content=new]");
                let userRolesMangeEl  = document.querySelector("li.cell a[data-role=role-management] span[data-content=manage]");
    
                if( userRolesMangeEl !== undefined && null !== userRolesMangeEl ){
    
                    if( data.roles_table_should_reload ){
        
                        // TODO Recall all Roles From Database
                        let httpRequest = new X2Tools().HttpRequest();
                        httpRequest
                            .setController("Role")
                            .setMethod("fetchUserUsedRolesWithIcon")
                            .setNamespace("manage")
                            .execute(function () {
                
                                // alert(JSON.stringify(this));
                
                
                
                
                                userRolesMangeEl.innerHTML = this.content;
                
                                if( this.total_role ){
                                    userRolesMangeEl.classList.remove("d-none");
                                    userRolesMangeEl.classList.add("d-block");
                                    userRoleNewEl.classList.remove("d-block");
                                    userRoleNewEl.classList.add("d-none");
                                }
                                else
                                {
                                    userRolesMangeEl.classList.add("d-none");
                                    userRolesMangeEl.classList.remove("d-block");
                                    userRoleNewEl.classList.add("d-block");
                                    userRoleNewEl.classList.remove("d-none");
                                }
                            });
        
                    }
                    
                }
           
            } catch( e ){
                
                xAlert(e.message);
                
            }
    
    
    
        }
        
        
        
        this.helperController = function ( dataJSONString ) {
            
            let dataParse   = typeof dataJSONString === "string" ? JSON.parse(dataJSONString) : dataJSONString;
            let activity    = dataParse.activity !== undefined && null !== dataParse ? dataParse.activity : ACTIVITY.ACTIVITY_1;
            // dataJSONString  = typeof dataJSONString === "object" ? JSON.stringify(dataJSONString) : dataJSONString;
            // document.write(dataJSONString);
            location.href = DEVICE + "://" + activity + "?" + dataJSONString;
        };
        
        this.loadActivityWithData = function( data ){
    
            // alert(data);
            let activity        = data.activity;
            let dataJSONString  = JSON.stringify(data);
            // data        = JSON.parse(data.replace(/[\\]/g, ""));
            if (activity === undefined) {
                activity = ACTIVITY.ACTIVITY_1;
            }
            
    
            
            switch (nsp) {
                case "_notification":
                    if (mtd === "index") {
                        try{
                            
                            let targetEl = document.querySelector("input[data-role='plan-picker'][name='" + data.key + "']");
                            let setting_plan = targetEl.value;
                            setting_plan = JSON.parse(setting_plan);
                    
                            if ( setting_plan === undefined) {
                                setting_plan = [0,0,0];
                            }
                            data["link"] += "&d=" + setting_plan[0]; // 2&hour=25&minute=2";
                            data["link"] += "&h=" + setting_plan[1]; // 2&hour=25&minute=2";
                            data["link"] += "&m=" + setting_plan[2]; // 2&hour=25&minute=2";
    
                            // Overwrite dataJSONString
                            dataJSONString  = JSON.stringify(data);
                            
                        } catch(e){
                            // alert(e.message);
                        }
                    }
                    break;
                    
                default:
                    
                    
                    break;
            }
    
            location.href = DEVICE + "://" + activity + "?" + dataJSONString;
            /*switch (DEVICE) {
        
                case DEVICE_TYPE.ANDROID:
                    DFANDROID.startActivity( activity, dataJSONString );
                    break;
        
                case DEVICE_TYPE.IOS:
                    location.href = DEVICE_ACTION_SCHEME + "://" + activity + "?" + dataJSONString;
                    break;
        
                default:
                    console.log( "Data Settings:", data );
                    location.href = data["link"];
            }*/
            
            
        }
        
        this.planPicker = function () {
            
            let d, h, m;
            
            document.querySelectorAll("select[data-role='plan-picker']").forEach(function (El) {
                
                El.onchange = function(){
                    updatePickerVals();
                }
            });
    
            updatePickerVals();
            
            function updatePickerVals(){
    
                let d, h, m;
                
                document.querySelectorAll("select[data-role='plan-picker']").forEach(function (El) {
    
                    switch( El.dataset.picker ){
                        case "d": d = El.value;
                            break;
                        case "h": h = El.value;
                            break;
                        case "m": m = El.value;
                            break;
                    }
                    L.setUnwindDataStore(El.dataset.picker, El.value);
                });
                L.setUnwindDataStore("plan", L.preparePlanString( d, h, m ));
                
                if( DEVICE_TYPE.ANDROID ){
                    try{
                        DFANDROID.sotoreData(L.getUnwindDataStore());
                    } catch(e){
                        console.log("Only Android")
                    }
                }
            }
        };
        
        this.preparePlanString = function (d, h, m) {
            return d + " Tag(e), " + h + " Stunde(n), " + m + " minute(n)";
        };
        
        this.save = function (method_name) {
    
            
            let ai                  = new X2Tools().ActivityIndicator();
            let httpRequest         = new X2Tools().HttpRequest();
            let alertController     = new X2Tools().AlertController();
            
            try{
                
                ai.show(function () {
    
                    new X2Tools().serializeContent(document.getElementsByTagName("form")[0], function(){
        
                        
                        console.log("Serialize ", this );
                        console.log("Serialize Length :", Array().keys(this));
                        
                        // alert(Object.keys(this).length);
                        if( !Object.keys(this).length ){
                            ai.dismiss();
                            return false;
                        }
                        
                        
                        
                        httpRequest
                            .setController("Settings")
                            .setNamespace(method_name)
                            .setProcessWithSession(false)
                            .setMethod("save")
                            .setData(this)
                            .execute(function () {
                
                                let data = this;
                
                                console.log("Data", data);
                
                                // alert(new X2Tools().fromDevice());
                                
                
                                ai.dismiss(function(){
                    
                                    if( undefined !== data.messageWithAlert){
                        
                                        
                                        if( new X2Tools().fromDevice() ){
                            
                                            alertController
                                                .setTitle( data.title )
                                                .setMessage( data.message )
                                                .addAction({
                                                    title: "Ok",
                                                    action: data.action !== null ? data.action : "",
                                                    style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                                                })
                                                .show();
                            
                                        }
                        
                                        else {
                            
                                            try{
                                
                                                ac = new $.tsoftx.alert(1000);
                                                ac
                                                    .setTitle(data.title)
                                                    .setMessage(data.messsage)
                                                    .cancelAction("text", "Close")
                                                    .show(function () {
                                        
                                                    });
                                
                                
                                            } catch( e ){
                                                alert(e.message);
                                            }
                            
                                        }
                        
                                    } else
                                    {
                                        $("form").processResultaWithView( data.message, data.color);
                                    }
                    
                                });
                
                
                            });
        
                    });
                
                });
                
            } catch (e){
                
                alert(e.message);
                
            }
            
            
            
            
            
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
        this.updateAvailability = function () {
            
            
            try {
                let obj = this.getUnwindDataStore();
                
                if (typeof obj !== "object") {
                    obj = JSON.parse(obj);
                }
                
                
                if (nsp === "_notification") {
                    
                    
                    try {
                        
                        let pickerEl = document.querySelector("input[data-role='plan-picker'][name='" + obj["plan-picker"] + "']");
                        
                        let lastPlanValue = [];
                        lastPlanValue.push(parseInt(obj["d"]));
                        lastPlanValue.push(parseInt(obj["h"]));
                        lastPlanValue.push(parseInt(obj["m"]));
                        pickerEl.value = JSON.stringify(lastPlanValue);
                        // alert(JSON.stringify(lastPlanValue));
                        // pickerEl.parentNode.innerText = obj["plan"];
                        pickerEl.parentNode.childNodes.forEach(function (El) {
                            if( El.nodeName === "LABEL" ){
                                El.innerText = obj["plan"];
                            }
                            console.log(El.nodeName);
                        })
                        
                    } catch (e) {
                        alert("232" + e.message + " " + mtd );
                        
                    }
                }
                
                
            }
            catch (e) {
                // alert(e.message);
            }
            
            
        };
        
        
        
        return this;
        
        
    }
    , unwindDataStore = {},
    
    // This action calling from Native Content data Post from Native Content And Need Absolute
    unwindAction = function (data) {
        
        
        if( typeof data === "string" ){
            data = JSON.parse(data);
        }
        
        // alert(JSON.stringify(data));
        
        switch (data.unwindFrom) {
            
            case "role":
                Layout().saveAndAddCompletedRoleForUser(data);
                break;
            case "manage":      // TODO If User Returned Manually
            case "Role_manage": // TODO Returned From Application Automatically Role/manage
        
                
                break;
                
            case "Role_manage_fetchUserUsedRolesWithTable":
                
                Layout().reloadUserRolesIconRowView(data);
                
                break;
            
            
        }
        
        
        
    };



