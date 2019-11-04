class X2FactorViewController {
    
    DATA    = {};
    ACTIVITY_UNWIND = 0;
    ACTIVITY_LOGGED = 1;
    ACTIVITY_ALERT_VIEW = 2;
    ACTIVITY_IMAGE_VIEW = 3;
    ACTIVITY_REDIRECT = 4;
    ACTIVITY_SHARED = 5;
    ACTIVITY_BOOTSTRAP = 6;
    ACTIVITY_MAIN = 7;
    ACTIVITY_1 = 8;
    ACTIVITY_2 = 9;
    ACTIVITY_3 = 10;
    ACTIVITY_4 = 11;
    _ACTIVITY;
    DEVICE_TYPE = {
        BROWSER : 0,
        IOS     : 1,
        ANDROID : 2
    };
    
    _DEVICE = 0;
    
    get DEVICE() {
        return this._DEVICE;
    }
    
    set DEVICE(value) {
        this._DEVICE = value;
    }

    get ACTIVITY() {
        if( this.DEVICE === this.DEVICE_TYPE.IOS ){
            return this._ACTIVITY;
        }
        return this
    }
    
    set ACTIVITY(value) {
        
        this._ACTIVITY = value;
    }
    
    constructor( device, data ) {
        this._DEVICE = device;
        this.DATA   = data;
    }
    
    
    static getControllerWithIndex(){
    
        return{
            ACTIVITY_UNWIND: (this.DEVICE === this.DEVICE_TYPE.IOS ? 0 : "ACTIVITY_UNWIND"),
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
            ACTIVITY_4: (DEVICE === DEVICE_TYPE.IOS ? 11 : "ACTIVITY_4")
        };
        
    }
    
    
    static go(){
        alert("Open");
        if( typeof this.DATA === "object")
            this.DATA = JSON.stringify(this.DATA);
        location.href = DEVICE + "://" + ACTIVITY + "?" + this.DATA;
    }

}