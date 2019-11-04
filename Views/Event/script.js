$(function () {
    new Layout().init();
});

let Layout = function () {
        
        let L = this;
        
        this.init = function () {
            L.prepareTableView();
            return this;
        };
        
        this.prepareTableView = function(){
            
            
            for(let i=0; i<3; i++){
    
                new X2Tools()
                    .TableView(document.getElementsByClassName("x2-list")[i],
                        {
                
                            // searchBar:true, Use data attribute data-with="searchbar"
                            rows:function(cells, ui){
                    
                                // TODO All Cells Of Table
                    
                            },
                            row:function(cell, cells, ui){
                    
                    
                            },
                            search:function( TableView, rows, ui ){
                            }
                
                        })
                    .create( function ( TableView, ui ) {
                    
                    });
                
            }
            
            
            
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
        
        
        return this;
    }
    , unwindDataStore = {},
    // This action calling from Native Content data Post from Native Content And Need Absolute
    unwindAction = function (data) {
    
    
    
    };