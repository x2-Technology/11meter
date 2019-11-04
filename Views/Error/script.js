/**
 * Created by tSoftX on 12/02/2017.
 */

$(function () {
    
    $(document).ready(function () {
        
        new X2Tools()
            .TableView(document.getElementsByClassName("x2-list")[0],
                {
                    rows:function(cells, ui){},
                    row:function(cell, cells, ui){}
                })
            .create( function ( TableView, rows, ui ) {});
        
    });
    
    
});
