/**
 * Created by tSoftX on 12/02/2017.
 */

$(function() {
    new Layout().init();
});

let Layout = function () {
        
        let L = this;
        
        this.init = function () {
            
            try{
                this.buttons();
                
            }catch(e){
                alert(e.message);
            }
            
            return this;
        };
        
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
            
        };
        
        this.loadActivityWithData = function( data ){
            
            let activity        = data.activity;
            let dataJSONString  = JSON.stringify(data);
            if (activity === undefined) {
                activity = ACTIVITY.ACTIVITY_1;
            }

            location.href = DEVICE + "://" + activity + "?" + dataJSONString;
            
            
        }
     
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
 
        };
        
        return this;
        
        
    }
    , unwindDataStore = {},
    // This action calling from Native Content data Post from Native Content And Need Absolute
    unwindAction = function (data) {
        
        /*new Layout()
            .setUnwindDataFromJSONString(data)
            .updateAvailability();*/
        
    };
