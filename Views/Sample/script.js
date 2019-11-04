/**
 * Created by tSoftX on 12/02/2017.
 */

$(function () {
    new Layout().init();
});

let Layout = function () {
        
        let L = this;
        
        
        this.init = function () {
            
            this.setUnwindDataStore("controller", "Sample");
            
            
            return this;
        };
        

        
        // Mode Method On X2UIFactor
        this.setUnwindDataStore = function (k, v) {
            unwindDataStore[k] = v;
        };
        
        // Mode Method On X2UIFactor
        this.setUnwindDataFromJSONString = function (data) {
            
            if (typeof data !== "object") {
                unwindDataStore = JSON.parse(data);
            } else {
                unwindDataStore = data
            }
            return this;
        };
        
        // Mode Method On X2UIFactor
        this.getUnwindDataStore = function () {
            
            data = JSON.stringify(unwindDataStore);
            return data;
        };
        
        // @Overwrite
        // Method Overwrite Here And Fixed
        this.execute = function (data) {
    
            document.write("Unwind Action in Layout" + " " + JSON.stringify(data));
        
            
        };
        
        
        return this;
        
        
    },
    unwindDataStore = {},
    // This action calling from Native Content data Post from Native Content And Need Absolute
    unwindAction = function (data) {
    
        l = Layout();
        l.execute(data);
        // document.write("Unwind Action");
        
    };


