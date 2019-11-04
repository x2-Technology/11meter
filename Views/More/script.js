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

        this.buttons = function () {
            document.querySelectorAll("a[data-role='" + X2SharedApplicationKey + "']").forEach(function (El) {
                El.onmousedown = function(){
                    if (undefined !== El.dataset.data) {
                        let dataURL = JSON.parse(El.dataset.data);
                        L.loadActivityWithData( dataURL );
                    }
                }
            });
            
            
        };
        
        this.loadActivityWithData = function (data) {
            
            let activity = data.activity;
            let dataJSONString = JSON.stringify(data);
            if (activity === undefined) {
                activity = ACTIVITY.ACTIVITY_1
            }
            
            location.href = DEVICE + "://" + activity + "?" + dataJSONString;
            
        };
        
        
        this.setUnwindDataStore = function( k, v ){
            
            unwindDataStore[k] = v;
        };
        this.setUnwindDataFromJSONString = function( data ){
            
            if( typeof data !== "object" ){
                unwindDataStore = JSON.parse(data);
            } else {
                unwindDataStore = data
            }
            return this;
        };
        this.getUnwindDataStore = function(){
            
            data = JSON.stringify(unwindDataStore);
            return data;
        };
        this.updateAvailability = function(){
            
            try{
                var obj = this.getUnwindDataStore();
                
                if( typeof obj !== "object" ){
                    obj = JSON.parse(obj);
                }
                
                // alert(obj["availability"]);
                if( undefined !== obj["availability"]){
                    try{
                        // alert(obj["meeting_id"]);
                        var availabilityEl = $(".meeting-item").filter(function(){
                            return $(this).attr("data-id") === obj["meeting_id"];
                        }).find("span#my-availability i")[0];
                        availabilityEl.removeAttribute("class");
                        availabilityEl.setAttribute("class", "icon " + ANWESENHEIT[parseInt(obj["availability"])] );
                    } catch(e){
                    
                    }
                }
                
            }
            catch(e){
                alert(e.message);
            }
            
            
            
        };
        
        return this;
        
        
    }
    , unwindDataStore = {},
    // This action calling from Native Content data Post from Native Content And Need Absolute
    unwindAction = function (data) {
        
        new Layout()
            .setUnwindDataFromJSONString(data)
            .updateAvailability();
        
    };


