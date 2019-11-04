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
            
            $("div").filter(function () {
                return $(this).hasClass("message-item");
            }).find("a").mousedown(function () {
    
                    let data    = this.dataset.data;
                    data        = JSON.parse(data.replace(/[\\]/g, ""));
                    L.loadActivityWithData(data);
                    
                    
                });
            
            
        };
        
        
        this.loadActivityWithData = function( data ){
            // alert(data.activity);
            // data.activity = undefined;
            oActivity.goWithData( (data.activity | ACTIVITY.ACTIVITY_2) ,data)
        };
        
        this.delete = function (name_space) {
            
            
            let l = new $.tsoftx.loader();
            l.show(function () {
                
                
                let ajx = new $.tsoftx.ajax();
                ajx
                    .setCnt("Message")
                    .setNsp(name_space)
                    .setProcessWithSession(false)
                    .setMtd("delete")
                    // .setData(this)
                    .execute(function () {
                        let data = this;
                        // alert(JSON.stringify(data));
                        l.dismiss(function () {
                            L.setUnwindDataStore("new_id", data.new_id);
                            L.setUnwindDataStore("remove_it", true);
                            setTimeout(function () {
                                dismissViewController(data);
                            }, 100);
                        });
                        
                    });
            });
            
            
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
        
        this.rowTo = function () {
            
            try {
                let obj = this.getUnwindDataStore();
                if ( typeof obj !== "object" ) {
                    obj = JSON.parse(obj);
                }
                
                let el = document.querySelector("[data-id='" + obj["new_id"] + "']");
                if( null !== el && undefined !== el){
                    el.classList.remove("message-active");
                    el.classList.add("message-inactive");
                    if( undefined !== obj["remove_it"] && obj["remove_it"] ){
                        el.remove();
                    }
                }
            }
            catch (e) {
                alert(e.message);
            }
            
        };
        
        return this;
        
        
    }, unwindDataStore = {},
    // This action calling from Native Content data Post from Native Content And Need Absolute
    unwindAction = function (data) {
        
        new Layout()
            .setUnwindDataFromJSONString(data)
            .rowTo(); // Disable or Delete
            
        
    };

