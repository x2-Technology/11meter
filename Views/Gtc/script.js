/**
 * Created by tSoftX on 12/02/2017.
 */



$(function () {
    
    // let d = new X2FactorViewController();
    // d.open();
    new Layout().init();
});

let Layout = function () {
        
        let L = this;
        
        this.init = function () {
            this.buttons();
            
            return this;
            
        };
        
        
        
        this.buttons = function () {
            
            document.getElementById("gtc_accept").onmousedown = function(){
                
                try{
    
                    L.setUnwindDataStore("accept", true);
                    dismissViewController('{"unwind_get_data_store":"javascript:new Layout().getUnwindDataStore();"}');
                    
                } catch(e){
                    
                    alert(e.message);
                }
                
            }
            
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
        
        // Final Action from Unwind
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
                        let availabilityEl = $("li.cell").filter(function(){
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
    };





