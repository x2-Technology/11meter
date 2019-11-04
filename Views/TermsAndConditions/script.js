/*
 * Author          :suleymantopaloglu
 * File            :script.js
 * Product Name    :PhpStorm
 * Time            :14:38
 * Created at      :15.05.2019 14:38
 * Description     :
 */

$(function () {
    new Layout();
});

let Layout = function () {
        
        let L = this;
        
        this.init = function () {
            L.buttons();
            return this;
        };
        
        this.buttons = function () {
            
            document.querySelectorAll("input[data-role='tac-action']").forEach(function (El) {
                
                new X2Tools().Button(El, {
                    touchWith: "end",
                    touch: function (El) {
                        try {
                            L.acceptedTAC( El.dataset.accept );
                        } catch (e) {
                            xAlert(e.message + "\n" + new Error().stack, 2073);
                        }
                    },
                    click: function (El) {}
        
                }).refresh(function (El, ui) {
                });
                
            });
            
            return this;
        };
        
        this.acceptedTAC = function( value ){
            
                
                try{
                    L.setUnwindDataStore("unwindFrom", cnt );
                    L.setUnwindDataStore("tac_accepted", undefined === value ? true : value );
    
                    new X2Tools().dismissViewController(L.getUnwindDataStore());
                } catch (e) {
                    alert(e.message);
                }
            
            
            
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
    
    
    };
