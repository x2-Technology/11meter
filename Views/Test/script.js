/**
 * Created by tSoftX on 12/02/2017.
 */

$(function () {
    new Layout();
});

let Layout = function () {
        
        let L = this;
        
        this.init = function () {
            
            if( nsp === "tableView"){
                
                new X2Tools().TableView().create();
            }
    
    
            $("div#player").load("https://hdfilme.net/movie/load-stream/11964/107931?server=2",function (El) {
                alert(JSON.stringify(El));
            })
            
            return this;
        };
        
        this.buttons = function () {
            
            
            return this;
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
        
        
        this.init();
        
        return this;
        
    }
    , unwindDataStore = {},
    // This action calling from Native Content data Post from Native Content And Need Absolute
    unwindAction = function (data) {
        
        /*new Layout()
            .setUnwindDataFromJSONString(data)
            .updateAvailability();
        
        
        alert(nsp);*/
        
    };

