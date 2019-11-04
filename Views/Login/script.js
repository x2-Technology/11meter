/**
 * Created by tSoftX on 12/02/2017.
 */

$(function () {
    new Layout().init();
});

let Layout = function () {
    
    let L = this;
    
    this.init = function () {
        
        this.buttons();
        
        return this;
    };
    
    this.emptyRequiredInputs = function(){
    
        let emptyCell = 0;
        document.querySelectorAll('input[required]').forEach(function (El) {
            if( El.value === '' ){
                emptyCell++;
            }
        });
        
        return emptyCell;
        
    };
    
    this.checkRequiredInputs = function( addCls ){
    
        document.querySelectorAll('input[required]').forEach(function (El) {
            El.classList.remove("wobbles");
            if( El.value === '' ){
                setTimeout(function () {
                    El.classList.add("wobbles");
                },100);
            }
        });
    };
    
    this.buttons = function () {
        
        
        try{
            document.getElementById("login").ontouchstart = function(){
        
        
                let btn = this;
        
                L.checkRequiredInputs();
                if ( L.emptyRequiredInputs() ){
                    return false;
                }
        
                btn.classList.add("btn-action");
        
                setTimeout(function () {
                    L.checkUserDataFromHost( btn );
                },100);
        
        
            }
        } catch(e){
        
        }
        
        try{
            document.getElementById("signup").ontouchstart = function(){
                location.href = "https://www.lox24.eu/API/httpsms.php" + "?" + "konto=21256&password=adler299&service=12109&text=Hallo%20pacha&to=004915228763036";
            }
        } catch (e) {
        
        }
    
        
        
        
        
        
        
    };
    
    this.checkUserDataFromHost = function( btn ){
    
        let db = new $.tsoftx.ajax();
        db
            .setCnt("User")
            .setNsp("!")
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
                
                    L.loadActivityWithData(data);
                
                }
            
            }, function () {
                btn.classList.remove("btn-action");
            })
        
            .s_expired(function () {
            
            
            });
    
    
    };
    
    this.loadActivityWithData = function (data) {
        
        // alert(ACTIVITY.ACTIVITY_LOGGED);
        let dataJSONString = JSON.stringify(data);
        setTimeout(function () {
            location.href = DEVICE + "://" + ACTIVITY.ACTIVITY_LOGGED + "?" + dataJSONString;
        }, 100);
        
        /*switch (DEVICE) {
            
            case DEVICE_TYPE.ANDROID:
                DFANDROID.loginWithData( dataJSONString );
                setTimeout(function () {
                    location.href = DEVICE + "://" + "ACTIVITY_BOOTSTRAP" + "?" + dataJSONString;
                }, 1000);
                break;
            
            case DEVICE_TYPE.IOS:
                location.href = DEVICE + "://" + ACTIVITY.BOOTSTRAP() + "?" + dataJSONString;
                break;
            
            default:
                console.log("Data Login:", data);
                location.href = "/Meeting/_list/index";
        }*/
        
        
    };
    
    this.userInfo = function (title, message) {
        
    
        let ac;
        if( DEVICE !== null ){
        
            ac = new X2.AlertController();
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
                .setType(message)
                .setMessage()
                .cancelAction("text", lang.close)
                .show(function () {
                
                });
        
        
        }
        
        
    };
    
    return this;
    
    
};



