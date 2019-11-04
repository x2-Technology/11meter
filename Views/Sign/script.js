/**
 * Created by tSoftX on 12/02/2017.
 */

$(function () {
    new Layout();
});

let Layout = function () {
        
        let L = this;
        
        this.init = function () {
    
            
            this.buttons();
    
            
            return this;
        };
        
        this.buttons = function () {
            
            try {
    
                // document.getElementById("login").ontouchstart = function(El){
                document.getElementById("login").onclick = function (El) {
                    
                    let btn = this;
                    
                    L.checkRequiredInputs();
                    if (L.emptyRequiredInputs()) {
                        return false;
                    }
                    
                    btn.classList.add("btn-action");
                    
                    setTimeout(function () {
                        L.signInData(btn);
                    }, 100);
                };
                
            } catch (e) {
            
            }
            
            try {
                document.getElementById("signup_save").onclick = function () {
                    // location.href = "https://www.lox24.eu/API/httpsms.php" + "?" + "konto=21256&password=adler299&service=12109&text=Hallo%20pacha&to=004915228763036";
                    
                    let btn = this;
                    
                    L.checkRequiredInputs();
                    if (L.emptyRequiredInputs()) {
                        return false;
                    }
                    
                    btn.classList.add("btn-action");
                    
                    setTimeout(function () {
                        L.signUpData(btn);
                    }, 100);
                    
                }
            }
            catch (e) {
            
            }
            
            
            
            // To SignupView
            try{
                if( DEVICE !== "" ){
                    // document.querySelectorAll(".meeting-item, .meeting-details-item").forEach(function (El) {
                    document.querySelectorAll("a#signup_view").forEach(function (El) {
            
                        El.onmousedown = function(){
                            let data    = this.dataset.data;
                            // alert(data);
                            data        = JSON.parse(data.replace(/[\\]/g, ""));
                            // Goto Signup view
                            L.helperController(JSON.stringify(data));
                        }
                    });
    
    
                    
                    document.getElementById("terms_view").onmousedown = function(){
                        
                            let data    = this.dataset.data;
                            L.gotoGTCWithData(data);
                        
                    };
                    
                    
                }
            } catch(e){
            
            }
            
            // Back to Sign In
            try {
                document.getElementById("backtologin").onclick = function (El) {
                    L.backToSignIn();
                };
            }catch(e){
            
            }
            
            // Sign Confirmation
            try {
    
                
                if( document.getElementById("mobil_confirmation") !== undefined ){
                    document.getElementById("mobil_confirmation").focus();
                    let im = new Inputmask("9  9  9  9  9");
                    im.mask(document.getElementById("mobil_confirmation"));
                }
                
                document.getElementById("confirmation").onclick = function () {
                    
                    let btn = this;
                    
                    L.checkRequiredInputs();
                    if (L.emptyRequiredInputs()) {
                        return false;
                    }
                    
                    btn.classList.add("btn-action");
                    
                    setTimeout(function () {
                        L.signConfirm(btn);
                    }, 100);
                    
                }
            }
            catch (e) {
            
            }
    
            // Request Forgot password
            try {
                document.getElementById("request_password").onmousedown = function () {
                    
                    /*let data    = this.dataset.data;
                    data        = JSON.parse(data.replace(/[\\]/g, ""));
                    data.mobil_number = document.getElementById("mobil_number").value;
                    
                    // Goto Signup view
                    // alert(JSON.stringify(data));
                    // L.helperController(JSON.stringify(data));*/
                    L.requestForgotPassword();
            
                }
            }
            catch (e) {
        
            }
    
            // Response Forgot password
            try {
                document.getElementById("save_password_number").onmousedown = function () {
    
                    let btn = this;
    
                    L.checkRequiredInputs();
                    if (L.emptyRequiredInputs()) {
                        return false;
                    }
    
                    btn.classList.add("btn-action");
    
                    setTimeout(function () {
                        L.processNewPassword(btn);
                    }, 100);
            
                }
            }
            catch (e) {
        
            }
    

  
            try {
    
    
                /*function teamDetails(){
                    var El = document.querySelectorAll('div.factfile-data .row')[2].children[0].children[0].children[0];
                    var ret = Array();
                    ret.teamWebURL = El.href;
                    ret.teamWebName = El.innerText;
                    ret.teamName = document.querySelectorAll('div.stage-profile-content h2')[0].innerText;
                    ret.vereinsseite = document.querySelectorAll('div.stage-profile-content .subline')[1].children[0].href;
                    return JSON.stringify(ret);
                }
                teamDetails();*/
    
                /*function teamDetails() {
                    try {
                        var El = document.querySelectorAll('div.factfile-data .row')[2].children[0].children[0].children[0];
                        var ret = Object();
                        ret.teamWebURL = El.href;
                        ret.teamWebName = El.innerText;
                        clubKey = document.querySelectorAll('div#teamProfile div.factfile-data div.factfile-headline h3')[0].innerText;
                        ret.teamName = document.querySelectorAll('div.stage-profile-content h2')[0].innerText;
                        ret.vereinsseite = document.querySelectorAll('div.stage-profile-content .subline')[1].children[0].href;
                        return JSON.stringify(ret);
                        
                    } catch (e) {
                        alert(e.message);
                    }
                };
                teamDetails();
                console.log(document.body.innerHTML);
                
                
                alert(URL.createObjectURL("https://hdfilme.net/godzilla-the-planet-eater-2019-10981-stream"));*/
                
                
                
            }
            catch (e) {
                alert(e.message);
            }
            
            
            
            
            
    
            // password
            try{
                // if( DEVICE !== "" ){
    
    
                /*let phoneMask = new IMask(document.getElementById('password'), {
                    mask: '+{7}(000)000-00-00'
                    // mask: '0-0-0-0'
                }).on('accept', function() {
                    document.getElementById('phone-complete').style.display = '';
                    document.getElementById('phone-unmasked').innerHTML = phoneMask.unmaskedValue;
                }).on('complete', function() {
                    document.getElementById('phone-complete').style.display = 'inline-block';
                });*/
    
                // alert( document.getElementById("mobil_number").value.length );
                
                let elMobilNumber = document.getElementById("mobil_number");
                
                if( elMobilNumber !== undefined )
                {
                    let trimmed_number = elMobilNumber.value.trim();
    
                    elMobilNumber.value = trimmed_number;
                    
                    if( !elMobilNumber.value.length ){
    
                        elMobilNumber.focus();
    
                        return false;
                        
                    }
                    
                    // let im = new Inputmask("9  9  9  9");
                    // im.mask(document.getElementById("password"));
                }
    
    
                let elPassword = document.getElementById("password");
                
                if( elPassword !== undefined ){
    
                    let trimmed_password = elPassword.value.trim();
    
                    elPassword.value = trimmed_password;
    
                    if( !elPassword.value.length ){
    
                        elPassword.focus();
        
                        return false;
        
                    }
                    
                    
                    // let im = new Inputmask("9  9  9  9");
                    // im.mask(document.getElementById("password"));
                }
                // $("#password").inputmask({"mask": "9 9 9 9"});
                
        
        
                // }
            } catch(e){
        
        
            }
            
            
        };
        
        this.gotoGTCWithData = function(data){
    
            
            data        = JSON.parse(data.replace(/[\\]/g, ""));
            // Go to view
            L.helperController(JSON.stringify(data));
            
        }
        
        
        this.emptyRequiredInputs = function () {
            
            let emptyCell = 0;
            document.querySelectorAll('input[required]').forEach(function (El) {
                if (El.value === '') {
                    emptyCell++;
                }
            });
            
            return emptyCell;
            
        };
        
        this.checkRequiredInputs = function (addCls) {
            
            document.querySelectorAll('input[required]').forEach(function (El) {
                El.classList.remove("wobbles");
                if (El.value === '') {
                    setTimeout(function () {
                        El.classList.add("wobbles");
                    }, 100);
                }
            });
        };
        
        
        this.signInData_dep = function (btn) {
            
            
            let db = new $.tsoftx.ajax();
            db
                .setCnt("Sign")
                .setNsp("in")
                .setMtd("fetch")
                .setData({
                    username: $("#username")[0].value,
                    password: $("#password")[0].value,
                })
                .setProcessWithSession(false)
                .execute(function () {
                    
                    let data = this;
                    
                    if (data.user === null) {
                        // Stop Animation
                        btn.classList.remove("btn-action");
                        L.userInfo("Fehler aufgetreten", "Keine benutzer");
                    }
                    
                    else {
                        
                        if (!data.user.status) {
                            
                            // Stop Animation
                            btn.classList.remove("btn-action");
                            L.userInfo(data.user.status_title, data.user.status_message);
                            
                            return false;
                        }
                        // alert(JSON.stringify(data));
                        L.loadActivityWithData(data);
                        
                    }
                    
                }, function () {
                    btn.classList.remove("btn-action");
                })
                
                .s_expired(function () {
                
                
                });
            
            
        };
        
        this.signInData = function (btn) {
    
            
            
            let db = new $.tsoftx.ajax();
            db
                .setCnt("Sign")
                .setNsp("in")
                .setMtd("fetch")
                .setData({
                    mobil_number: $("#mobil_number")[0].value,
                    password    : $("#password")[0].value,
                })
                .setProcessWithSession(false)
                .execute(function () {
                    
                    
                    let data = this;
                    btn.classList.remove("btn-action");
    
                    let dataForViewController = data.data;
                    
                    if ( !Object.keys(data.user).length ) {
                        
                        // No User found!!
                        L.userInfo(data.title, data.message);
                        
                        return false;
                    } else {
                        
                        // Goto Confirmation
                        L.loadActivityWithData(data);
                        
                        
                    }
                    
                    
                }, function () {
                    btn.classList.remove("btn-action");
                })
                
                .s_expired(function () {
                
                
                });
            
            
        };
        
        /*
        * Confirmation View
        * SignUp View
        * */
        
        this.helperController = function ( dataJSONString ) {
            
            let dataParse   = typeof dataJSONString === "string" ? JSON.parse(dataJSONString) : dataJSONString;
            let activity    = dataParse.activity !== undefined && null !== dataParse ? dataParse.activity : ACTIVITY.ACTIVITY_1;
            // dataJSONString  = typeof dataJSONString === "object" ? JSON.stringify(dataJSONString) : dataJSONString;
            // document.write(dataJSONString);
            location.href = DEVICE + "://" + activity + "?" + dataJSONString;
        };
        
        
        this.signUpData = function (btn) {
            
            let gtc = document.getElementById("terms_and_conditions");
            
            if( !gtc.checked  ){
    
                let alert = new $.tsoftx.deviceAlert();
                alert.setTitle("Information")
                    .setMessage("Bitte lesen und akzeptieren Sie unsere Allgemeine Geschäftsbedingungen bevor Sie mit der Registrierung fortfahren")
                    .addAction({
                        title:"Ok",
                        action:"",
                        style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                    })
                    .addAction({
                        title:"AGB",
                        action:"new Layout().gotoGTCWithData(document.getElementById('terms_view').dataset.data);"
                    }).show();
    
                    btn.classList.remove("btn-action");
                    return false;
            
            }
        
            
            
            $("form").serializeContent(function () {
    
                // alert(JSON.stringify(this));
                
                let db = new $.tsoftx.ajax();
                db
                    .setCnt("Sign")
                    .setNsp("up")
                    .setMtd("save")
                    .setData(this)
                    .setProcessWithSession(false)
                    .execute(function () {
            
                        let data = this;
            
                        if (!data.process) {
                
                
                            // Stop Animation
                            btn.classList.remove("btn-action");
                            L.userInfo(data.title, data.message);
                
                            return false;
                        } else {
                
                            // Goto Confirmation
                            let dataJSONString = JSON.stringify(data.data);
                
                            // alert(dataJSONString);
                            location.href = DEVICE + "://" + ACTIVITY.ACTIVITY_2 + "?" + dataJSONString;
                
                        }
            
            
                    }, function () {
                        btn.classList.remove("btn-action");
                    })
        
                    .s_expired(function () {
            
            
                    });
                
            })
            
            
            
            
        };
        
        
        // Process requesting new password, before SMS activation
        this.requestForgotPassword = function () {
            
            if( $("#mobil_number")[0].value === "" ){
    
                let alert = new $.tsoftx.deviceAlert();
                alert.setTitle("Achtung!")
                    .setMessage("geben Sie bitte Ihre Handynummer")
                    .addAction({
                        title: "Ok",
                        action: "",
                        style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                    })
                    .show();
                
                return false;
            }
            
            let loader = $.tsoftx.loader();
            loader.show(function () {
    
                let db = new $.tsoftx.ajax();
                db
                    .setCnt("Sign")
                    .setNsp("newPassword")
                    .setMtd("request")
                    .setData({
                        mobil_number: $("#mobil_number")[0].value,
                    })
                    .setProcessWithSession(false)
                    .execute(function () {
            
                        loader.dismiss();
                        
                        let data = this;
    
                        // document.write(JSON.stringify(data));
                        
                        /*
                        let alert = new $.tsoftx.deviceAlert();
                        alert.setTitle(data.title)
                            .setMessage(data.message);
    
                        if (!data.process) {
    
                            alert.addAction(
                                {
                                    title: "Ok",
                                    action: "",
                                    style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
            
                                });
                            
                        }
                        
                        else {
    
                            alert
                                .addAction({
                                    // title: "Nutze deine letzte erhaltene Code",
                                    title: data.action_title,
                                    action: "javascript:new Layout().helperController(" + JSON.stringify(data.data) + ")",
                                    style: ALERT_ACTION_STYLE.UIAlertActionStyleDefault
                                });
                            
                            
                        }
                        */
                        
                        let ac = new X2Tools().AlertController();
                        ac
                            .setMessage(data.title)
                            .setTitle(data.message);
    
                        if (!data.process) {
        
                            ac.addAction(
                                {
                                    title: "Ok",
                                    action: "",
                                    style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                
                                });
        
                        }
    
                        else {
        
                            // alert( JSON.stringify(data.data));
                            
                            ac.addAction({
                                    // title: "Nutze deine letzte erhaltene Code",
                                    title: data.action_title,
                                    action: "javascript:new X2Tools().presentViewControllerWithData(" + JSON.stringify(data.data) + ")",
                                    style: ALERT_ACTION_STYLE.UIAlertActionStyleDefault
                                });
        
        
                        }
                        
                        
                        ac.show();
                        
                        
                        
                        
                        
                        
                        return false;
                        
                        
            
            
                    }, function () {
                    
                    })
        
                    .s_expired(function () {
            
            
                    });
                
                
                
            });
            
            
            
            
            
        };
        
        this.processNewPassword = function(btn){
    
            
            let passwordEl       = document.getElementById("password");
            let passwordElVal    = passwordEl.value;
            
            let db = new $.tsoftx.ajax();
            db
                .setCnt("Sign")
                .setNsp("newPassword")
                .setMtd("save")
                .setData({
                    mobil_number: $("#mobil_number")[0].value,
                    password: passwordElVal.replace(/\s/g, '')//password.join(""),
                })
                .setProcessWithSession(false)
                .execute(function () {
            
                    let data = this;
            
                    btn.classList.remove("btn-action");
            
                    let alertAction = "";
                    
                    if ( data.process ) {
                        
                        alertAction = "javascript:location.href = '" + DEVICE + "://" + ACTIVITY.ACTIVITY_BOOTSTRAP + "?{}';";
                        
                        
                    }
    
                    
                    let alert = new $.tsoftx.deviceAlert();
                    alert.setTitle(data.title)
                        .setMessage(data.message)
                        .addAction({
                            title: "Ok",
                            action: alertAction,
                            style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                        })
                        .show();
    
                    return false;
            
            
                }, function () {
                    btn.classList.remove("btn-action");
                })
        
                .s_expired(function () {
            
            
                });
    
    
        };
        
        
        
        this.signConfirm = function (btn) {
            
            let confirmationCode = $("#mobil_confirmation")[0].value;
            
            let db = new $.tsoftx.ajax();
            db
                .setCnt("Sign")
                .setNsp("confirmation")
                // .setMtd("save")
                .setMtd("check")
                .setData({
                    mobil_confirmation: confirmationCode.replace(/\s/g, ''),
                    mobil_number: $("#mobil_number")[0].value,
                })
                .setProcessWithSession(false)
                .execute(function () {
                    
                    let data = this;
    
                    btn.classList.remove("btn-action");
                    
                    // alert(JSON.stringify(data));
                    
                    /*if ( data.user === null || undefined  === data.user ) {
                        
                        
                        // Stop Animation
                        
                        L.userInfo(data.title, data.message);
                        
                        return false;
                    } else {
                        
                        
                        
                        if( data.redirect !== null && undefined !== data.redirect ){
                            L.helperController(data.redirect);
                            return false;
                        }
                        
                        // Unwind
                        L.setUnwindDataFromJSONString(JSON.stringify(data)); // using instead of data.meeting_id
                        setTimeout(function () {
                            dismissViewController(data);
                        }, 500);
                        
                        
                    }*/
    
                    if ( !Object.keys(data.user).length ) {
        
                        let alert = new $.tsoftx.deviceAlert();
                        alert.setTitle(data.title)
                            .setMessage(data.message)
                            .addAction(
                                {
                                    title: "Ok",
                                    action: "",
                                    style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                                })
                            /*.addAction({
                                title: "Ich habe passwordnummer",
                                action: "javascript:new Layout().helperController(" + JSON.stringify(dataForViewController) + ")",
                                style: ALERT_ACTION_STYLE.UIAlertActionStyleDefault
                            })*/
                            .show();
        
        
                        // No User found!!
                        L.userInfo(data.title, data.message);
        
                        return false;
                    } else {
        
                        // Goto Confirmation
                        L.loadActivityWithData(data);
        
        
                    }
                    
                    
                }, function () {
                    btn.classList.remove("btn-action");
                })
                
                .s_expired(function () {
                
                
                });
            
            
        };
        
        this.backToSignIn = function(){
            dismissViewController('{}');
        };
        
        /***
         * Load Activity
         * @param data
         */
        this.loadActivityWithData = function (data) {
            
            try{
                data.activity = ACTIVITY.ACTIVITY_LOGGED;
                new X2Tools().presentViewControllerWithData(data);
            } catch (e) {
                alert(e.message);
            }
            
            
            
        };
        
        this.userInfo = function (title, message) {
    
            
            
            let ac;
            if( new X2Tools().fromDevice() ){
        
                ac = new X2Tools().AlertController();
                ac.setMessage(message);
                ac.setTitle(title);
                ac.addAction({
                    title: "Ok",
                    action: "", // Reload App
                    style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                });
                ac.show();
        
            } else {
        
                // Browser Alert
                let ac = new $.tsoftx.alert(1000);
                ac
                    .setTitle(title)
                    .setType("")
                    .setMessage(message)
                    .cancelAction("text", "Close")
                    .show(function () {
                
                    });
        
        
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
        this.fetchUser = function () {
    
            try {
                let obj = this.getUnwindDataStore();
                
                if (typeof obj !== "object") {
                    obj = JSON.parse(obj);
                }
                
                // document.write(JSON.stringify(obj));
                
                // Goto Main View
                L.loadActivityWithData(obj);
                
                
            }
            catch (e) {
                document.write(e.message);
            }
            
            
        };
        
        
        
        this.init();
        
        return this;
        
    }
    , unwindDataStore = {},
    // This action calling from Native Content data Post from Native Content And Need Absolute
    unwindAction = function (data) {
    
        if(  nsp === "up" ){
        
            if( data.accept !== undefined && data.accept ){
                let el = document.getElementById("terms_and_conditions");
                if( !el.checked ){
                    el.click();
                }
            }
            
            
        
        } else {
            
            new Layout()
                .setUnwindDataFromJSONString(data)
                .fetchUser();
            
        }
        
    };

