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
            this.userPerformance();
            
            this.redirect();
            
            
            return this;
        };
        
        this.redirect = function(callback){
            
            try{
                let redirectEl = document.getElementsByTagName("redirect");
                let redirectVal = redirectEl[0].dataset.value;
    
                if( redirectVal !== "" ){
        
        
                    // Parse JSON String
                    let redirectDataParse = JSON.parse(redirectVal);
        
                    document.body.onload = function () {
                        setTimeout(function () {
                            L.helperController(redirectDataParse);
                        },0);
                    }
        
        
        
                }
            } catch (e) {
                document.write(e);
            }
            
        };
        
        this.helperController = function ( dataJSONString ) {
            let dataParse   = dataJSONString === "string" ? JSON.parse(dataJSONString) : dataJSONString;
            let activity    = dataParse.activity !== undefined && null !== dataParse ? dataParse.activity : ACTIVITY.ACTIVITY_1;
            dataJSONString  = typeof dataJSONString === "object" ? JSON.stringify(dataJSONString) : dataJSONString;
            // document.write(dataJSONString);
            location.href = DEVICE + "://" + activity + "?" + dataJSONString;
        };
        
        this.userPerformance = function () {
            
            $('.second.circle').circleProgress({
                value: .9,
                size: 125,
                // sizeAfterLoad:"100%",
                startAngle: 10,
                fill: {gradient: ['#ff1e41', '#ff5f43']},
                thickness: 20,
                startAfterDelay: 1500
            }).on('circle-animation-progress', function (event, progress) {
                
                // console.log("progress", Math.floor(progress*100));
                // console.log("progress", event.getValue());
                if (progress <= 0.9) {
                    $(this).find('.progress-numerical').html(Math.round(100 * progress) + '<i>%</i>');
                }
                
                
            }).on("");
            
        };
        
        this.buttons = function () {
            
            let div = $("div");
            
            if( DEVICE !== "" ){
                document.querySelectorAll("li.cell > .action").forEach(function (El) {
                    El.ontouchend = function(){
                        let data    = this.dataset.data;
                        data        = JSON.parse(data.replace(/[\\]/g, ""));
                        L.loadActivityWithData(data);
                    }
                });
            }
            
            /*div.filter(function () {
                return $(this).data("meeting-item") || $(this).hasClass("meeting-details-item")
            }).find("a").each(function () {
                $(this).unbind("mousedown").mousedown(function () {
            
                    let data    = this.dataset.data;
                    data        = JSON.parse(data.replace(/[\\]/g, ""));
                    L.loadActivityWithData(data);
                });
            });*/
    
            document.querySelectorAll("div[data-role='advertisement']").forEach(function (El) {
                El.ontouchend = function(){
                    if (undefined !== El.dataset.data) {
                        let dataURL = JSON.parse(El.dataset.data);
                        L.loadActivityWithData( dataURL );
                    }
                }
            });
            
            
        };
        
        this.loadActivityWithData = function (data) {
            
            alert(JSON.stringify(data));
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
            .updateAvailability();
        
    };





