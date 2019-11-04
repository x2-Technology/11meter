/**
 * Created by tSoftX on 12/02/2017.
 */
let cnt, mtd, nsp, domain = window.location.href;

let domainParser = document.createElement("a");
domainParser.href = domain;
let path = domainParser.pathname;
path = path.split("/");
let query = urlQueryParse(domainParser.search);
function urlQueryParse(query){
   
    // Remove ?
    let _ = query.substr(1, query.length);
    
    // Parse the parameters
    let params = _.split("&");
    let jsonObject = {};
    for( let p in params ){
        let k = params[p].split("=");
        jsonObject[k[0]] = k[1];
    }
    
    return jsonObject;
};

cnt = path[1];
mtd = path[3];
nsp = path[2];

const DATA_FETCH = {
    ASSOC: 0,
    INDEXED: 1
};

const DEVICE_TYPE = {
    IOS: "ios",
    ANDROID: "android"
};

const ANWESENHEIT = [
    "",
    "icon-thumbs-up3 text-success", // YES       = 1;
    "icon-question5 text-warning",  // MAYBE     = 2;
    "icon-thumbs-down3 text-danger" // NO        = 3;
];

const DEVICE_ACTION_SCHEME = "ios";

/**
 * @deprecated
 * @use instead of in X2Tools().dismissViewController()
 * @param data
 */
let dismissViewController = function (data) {
    try {
        if (undefined !== data && null !== data && "" !== data) {
            if (Object.keys(data).length > 0) {
                data = JSON.stringify(data);
            }
            location.href = DEVICE + "://" + ACTIVITY.ACTIVITY_UNWIND + "?" + data;
        } else {
            data = "";
            location.href = DEVICE + "://" + ACTIVITY.ACTIVITY_UNWIND;
        }
        
    } catch (e) {
        alert(e.message);
    }
};

let redirectViewController = function (dataJSONString) {
    try {
        
        let dataParse = dataJSONString === "string" ? JSON.parse(dataJSONString) : dataJSONString;
        let activity = dataParse.activity !== undefined && null !== dataParse ? dataParse.activity : ACTIVITY.ACTIVITY_1;
        dataJSONString = typeof dataJSONString === "object" ? JSON.stringify(dataJSONString) : dataJSONString;
        location.href = DEVICE + "://" + activity + "?" + dataJSONString;
    } catch (e) {
        alert(e.message);
    }
};

/**
 * From native unwind down to here
 * from hre shared to target JS file
 * @param data
 */
let parentUnwindAction = function(data){
    
    // Redirect to unwindAction self customized JS file
    if( typeof data === "string" ){
        data = JSON.parse(data);
    }
    
    unwindAction(data);
    
}



// Activities for IOS from enum object
let ACTIVITY = {
    ACTIVITY_UNWIND: (DEVICE === DEVICE_TYPE.IOS ? 0 : "ACTIVITY_UNWIND"),
    ACTIVITY_LOGGED: (DEVICE === DEVICE_TYPE.IOS ? 1 : "ACTIVITY_LOGGED"),
    ACTIVITY_ALERT_VIEW: (DEVICE === DEVICE_TYPE.IOS ? 2 : "ACTIVITY_ALERT_VIEW"),
    ACTIVITY_IMAGE_VIEW: (DEVICE === DEVICE_TYPE.IOS ? 3 : "ACTIVITY_IMAGE_VIEW"),
    ACTIVITY_REDIRECT: (DEVICE === DEVICE_TYPE.IOS ? 4 : "ACTIVITY_REDIRECT"),
    ACTIVITY_SHARED: (DEVICE === DEVICE_TYPE.IOS ? 5 : "ACTIVITY_SHARED"),
    ACTIVITY_BOOTSTRAP: (DEVICE === DEVICE_TYPE.IOS ? 6 : "ACTIVITY_BOOTSTRAP"),
    ACTIVITY_MAIN: (DEVICE === DEVICE_TYPE.IOS ? 7 : "ACTIVITY_MAIN"),
    ACTIVITY_1: (DEVICE === DEVICE_TYPE.IOS ? 8 : "ACTIVITY_1"),
    ACTIVITY_2: (DEVICE === DEVICE_TYPE.IOS ? 9 : "ACTIVITY_2"),
    ACTIVITY_3: (DEVICE === DEVICE_TYPE.IOS ? 10 : "ACTIVITY_3"),
    ACTIVITY_4: (DEVICE === DEVICE_TYPE.IOS ? 11 : "ACTIVITY_4"),
    ACTIVITY_5: (DEVICE === DEVICE_TYPE.IOS ? 12 : "ACTIVITY_5"),
    ACTIVITY_6: (DEVICE === DEVICE_TYPE.IOS ? 13 : "ACTIVITY_6"),
    ACTIVITY_7: (DEVICE === DEVICE_TYPE.IOS ? 14 : "ACTIVITY_7"),
    ACTIVITY_8: (DEVICE === DEVICE_TYPE.IOS ? 15 : "ACTIVITY_8"),
    
    ACTIVITY_9: (DEVICE === DEVICE_TYPE.IOS ? 16 : "ACTIVITY_9"),
    ACTIVITY_10: (DEVICE === DEVICE_TYPE.IOS ? 17 : "ACTIVITY_10"),
    ACTIVITY_11: (DEVICE === DEVICE_TYPE.IOS ? 18 : "ACTIVITY_11"),
    
    
    ACTIVITY_EXTERNAL: (DEVICE === DEVICE_TYPE.IOS ? 19/*15*/ : "ACTIVITY_EXTERNAL"),
    ACTIVITY_BROWSER: (DEVICE === DEVICE_TYPE.IOS ? 20/*16*/ : "ACTIVITY_BROWSER"),
    ACTIVITY_RESTART: (DEVICE === DEVICE_TYPE.IOS ? 21/*17*/ : "ACTIVITY_RESTART"),
    ACTIVITY_VIBRATE: (DEVICE === DEVICE_TYPE.IOS ? 22/*18*/ : "ACTIVITY_VIBRATE"),
    
    ACTIVITY_HELPER_1: (DEVICE === DEVICE_TYPE.IOS ? 23 : "ACTIVITY_HELPER_1"),
    ACTIVITY_HELPER_2: (DEVICE === DEVICE_TYPE.IOS ? 24 : "ACTIVITY_HELPER_2"),
    ACTIVITY_HELPER_3: (DEVICE === DEVICE_TYPE.IOS ? 25 : "ACTIVITY_HELPER_3"),
    ACTIVITY_HELPER_4: (DEVICE === DEVICE_TYPE.IOS ? 26 : "ACTIVITY_HELPER_4"),
    ACTIVITY_HELPER_5: (DEVICE === DEVICE_TYPE.IOS ? 27 : "ACTIVITY_HELPER_5"),
    
    ACTIVITY_ERROR: (DEVICE === DEVICE_TYPE.IOS ? 28 : "ACTIVITY_ERROR"),
    
};

let ALERT_ACTION_STYLE = {
    UIAlertActionStyleDefault: 0,
    UIAlertActionStyleDestructive: 2
};

const SHARED_APPLICATION = {
    X2SharedApplicationKey: "SHARED_INN_APP",
    X2SharedApplicationAdsKey: "SHARED_ADS",
    X2SharedApplicationFacebookKey: "SHARED_FACEBOOK",
    X2SharedApplicationTwitterKey: "SHARED_TWITTER",
    X2SharedApplicationWhatsAppKey: "SHARED_WHATSAPP"
};

const X2SharedApplicationKey = "SHARED_INN_APP";
const X2SharedApplicationAdsKey = "SHARED_ADS";
const X2SharedApplicationFacebookKey = "SHARED_FACEBOOK";
const X2SharedApplicationTwitterKey = "SHARED_TWITTER";
const X2SharedApplicationWhatsAppKey = "SHARED_WHATSAPP";


/*
var ACTIVITY_BOOTSTRAP  = 0;
var START  = 1;
var ONE  = 1;
*/
$(document).ready(function () {
    
    // Init View Buttons
    
    
    $.autoload.init();
    
    $.autoload.notifications(function () {
        
    
    }, 60);
    
    
    // image preview
    prepareImagePreview();
    
    // let test = {a:"a", b:"b"};
    
    // oActivity.go( ACTIVITY.ACTIVITY_ALERT_VIEW, test )
    

    
});



function xAlert( message, stack ) {
    
    try{
        
        if( typeof message === "object" ){
            // message = JSON.stringify(message);
        }
    
        if( undefined !== stack ){
            // stack = stack.split("@").join("\n");
        }
    
    
        let ac = new X2Tools().AlertController();
        // ac.setMessage( message + ( undefined !== stack ? ( "\n" + stack ) : "" ) );
        ac.setTitle("Message");
        ac.setMessage(message + ( undefined !== stack ? ( "\n\n" + stack ) : "" ));
        ac.addAction({
            title:"Ok",
            style:ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
            action:""
        });
        ac.show();
        
    } catch (e) {
        alert(e.message);
    }
    
    
}

function jsException ( e ) {
    
    try{
        
        let ac = new X2Tools().AlertController();
        ac.setTitle("Message");
        ac.setMessage( e.message +"\n\n" + e.stack );
        ac.addAction({
            title:"Ok",
            style:ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
            action:""
        });
        ac.show();
        
    } catch (e) {
        alert(e.message);
    }
    
    
}

function sAlert( message, stack ) {
    
    alert(message + "\n\n" + new Error().stack );
    
    
}





+function ($) {
    this.prepareImagePreview = function () {
        document.querySelectorAll("[data-role='image-preview']").forEach(function (e) {
            e.onmousedown = function () {
                let d = {}, f = DEVICE;
                try {
                    // document.write(this.dataset["original-src"]);
                    let p = this.getBoundingClientRect();
                    d = {
                        t: p.top,
                        b: p.bottom,
                        l: p.left,
                        r: p.right,
                        w: p.width,
                        h: p.height,
                        error: "error",
                        // url: this.src,
                        url: this.dataset.originalSrc,
                        jump: this.dataset.jump,
                        name: this.dataset.name
                    };
                } catch (e) {
                    console.log("Error with image preview:", e.message);
                }
                
                oActivity.goWithData(ACTIVITY.ACTIVITY_IMAGE_VIEW, d);
                
                
            }
        });
    }
}($);


+function () {
    'use strict';
}(jQuery);


class oActivity {
    
    // noinspection JSAnnotator
    static goWithData(ACTIVITY, data) {
        if (typeof data === "object")
            data = JSON.stringify(data);
        let x = DEVICE + "://" + ACTIVITY + "?" + data;
        location.href = x;
    }
}






/*document.querySelectorAll('div#fixture-league-tables table td.column-club').forEach(function (El) {
    for (var i in El.childNodes){
        alert(El.childNodes[i].nodeName);
    }
})
;*/



