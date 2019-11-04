/**
 * Created by tSoftX on 12/02/2017.
 */

$(function () {
    
    // let d = new X2FactorViewController();
    // d.open();
    new Layout().init();
});
GlobalTableViewApi = null;
GlobalTableViewUI = null;
TableViewSelectedRow = null;

let Layout = function () {
        
        let L = this;
        
        this.init = function () {
           
            this.removeAllLink();
            this.buttons();
            this.prepareTableView();
            return this;
        };
        
        this.prepareTableView = function(){
    
            
            try{
                new X2Tools()
                    .TableView(document.getElementsByClassName("x2-list")[0],
                        {
                
                            // searchBar:true, Use data attribute data-with="searchbar"
                            rows:function(cells, ui){
                    
                                // TODO All Cells Of Table
                    
                            },
                            row:function(cell, cells, ui){
                    
                                cell.ontouchend = function () {
                                    TableViewSelectedRow = cell;
                                }
                            },
                            search:function( TableView, rows, ui ){
                    
                                let searchString = this;
                    
                                console.log("Rows After Search", rows);
                    
                                let httpRequest = new X2Tools().HttpRequest();
                                let ai          = new X2Tools().ActivityIndicator();
                    
                    
                                ai.show(function () {
                        
                                    // In Public class 'da global method gelistir butum standartart listelemeler icin
                                    // search olayinda tabloyu yemizle ama eventlerini tut
                                    // Refresh olayini incele
                        
                                    httpRequest
                                        .setController("Extras")
                                        .setNamespace("_dfb_clubs")
                                        .setMethod("loadClubs")
                                        .setProcessWithSession(false)
                                        .setData({
                                            search:searchString
                                        })
                                        .execute(function(){
                                
                                
                                            // Add new Rows
                                            ui.addRow(this, function(ui){
                                                // ui.load();
                                    
                                                L.prepareTableView();
                                    
                                    
                                            });
                                
                                
                                
                                            // Dismiss Indicator
                                            ai.dismiss();
                                        });
                                });
                            }
                
                        })
                    .create( function ( TableView, rows, ui ) {
                        
                        try{
                            ui.searchEl.focus();
                        } catch (e) {
                        
                        }
            
                        GlobalTableViewUI = ui;
                        GlobalTableViewApi = TableView;
                        
            
                        if( cnt + "_" + nsp + "_" + mtd === "Extras__time_suggestion_index" ){
                            L.timeSuggestion();
                        }
    
    
                        /**7
                         * Load Environment full data for user select
                         */
                        try{
                            L.loadEnvironmentFullData(parseInt(document.querySelector("select#environment_area_id").value));
                        } catch (e) {
                            // alert(e.message);
                        }
                        
            
                    });
            } catch (e) {
                alert(e.message);
            }
            
            
        }
        
        this.timeSuggestion = function () {
    
            // Exact time element
            try{
        
                let timeSuggestionsEl   = document.querySelector("select#ad_suggestion");
        
                if( undefined !== timeSuggestionsEl && null !== timeSuggestionsEl ){
                    statusPlaytimeEl(timeSuggestionsEl.value);
                    timeSuggestionsEl.onchange = function () {
                        statusPlaytimeEl(timeSuggestionsEl.value );
                    }
                }
        
                function statusPlaytimeEl(val){
                    let playtimeEl = document.querySelector("input#ad_time");
                    GlobalTableViewUI.rowProperty("disabled", [playtimeEl.parentNode], parseInt(val)!==1 );
                    
                    if(parseInt(val)!==1){
                        playtimeEl.value = "";
                    }
                    
                }
        
            } catch (e) {
                alert(e.message);
            }
            
        }
        
        this.setTimeSuggestionAndUnwind = function () {
            
            try{
                new X2Tools().serializeContent(document.querySelector("ul.x2-list"), function (error) {
        
                    if( !error ){
                        // alert(document.querySelector("select#ad_suggestion option:checked").innerText);
                        
                        L.setUnwindDataFromJSONString(JSON.stringify(this));
                        L.setUnwindDataStore("pretty_ad_suggestion_name", document.querySelector("select#ad_suggestion option:checked").innerText);
                        L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd );
                        new X2Tools().dismissViewController(L.getUnwindDataStore());
                        
                        
                    } else {
                        // alert("Hata");
                    }
        
                });
            } catch (e) {
                alert(e.message);
            }
        
        }
        
        
        this.buttons = function(){
    
            document.querySelectorAll("li.action").forEach(function (El) {
                El.onmousedown = function(){
                    let data    = $(this).find("a")[0].dataset.data;
                    data        = JSON.parse(data.replace(/[\\]/g, ""));
                   
                    // alert(JSON.stringify(data));
                    L.loadActivityWithData(data);
                }
            });
    
    
            
            
            
            return this;
        }
    
        this.loadActivityWithData = function (data) {
            
            let activity = data.activity;
            let dataJSONString = JSON.stringify(data);
            if (activity === undefined) {
                activity = ACTIVITY.ACTIVITY_1;
            }
            
            location.href = DEVICE + "://" + activity + "?" + dataJSONString;
            
            
            
        }
        
        this.loadEnvironmentFullData = function (postcode_id) {
            
                if( undefined !== postcode_id && null !== postcode_id ){
                    
                    setTimeout(function () {
                        let httpRequest = new X2Tools().HttpRequest();
                        httpRequest
                            .setController("Extras")
                            .setMethod("fetchEnvironmentData")
                            .setNamespace("_environment")
                            .setLocalActivityIndicator(true)
                            .setData({
                                postcode_id:postcode_id
                            })
                            .execute(function () {
            
                                let prettyTownName  = this.data.postcode + " " + this.data.town;
                                let townEl          = document.querySelector("select#environment_area_id");
                                let townHiddenEl    = document.querySelector("input#pretty_environment_area");
                                
                                townEl.value = this.data.id;
                                townEl.querySelector("option:checked").innerText = prettyTownName;
                                
                                townHiddenEl.value = prettyTownName;
            
                            })
                    }, 300);
                }
            
            
        }
        
        this.removeAllLink = function () {
        
        };
        
        
        /**
         * @Javascript interface
         */
        this.collectSelectedLeagueAndDismissWithData = function () {
            
            
            
            try{
    
                let finallySelectedLeagues  = [];
                let finallyPrettySelectedLeaguesName  = [];
    
                document.querySelectorAll("ul.x2-list input:checked").forEach(function (El) {
                    finallySelectedLeagues.push(El.value);
                    finallyPrettySelectedLeaguesName.push(El.dataset.prettyLeagueName);
                });
    
                
                if( finallySelectedLeagues ){
        
                    L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd );
                    L.setUnwindDataStore("selected_league", JSON.stringify(finallySelectedLeagues));
                    L.setUnwindDataStore("pretty_selected_league_name", JSON.stringify(finallyPrettySelectedLeaguesName));
        
                    new X2Tools().dismissViewController(L.getUnwindDataStore());
        
                }
                
            } catch (e) {
                alert(e.message);
            }
            
            
            
        }
        
        /*
        * @Javascript interface */
        this.selectPostCodeAndUnwind = function () {
            
            try{
    
                let postcode = TableViewSelectedRow.querySelector("input").dataset.postcode;
                // noinspection SpellCheckingInspection
                let areaname = TableViewSelectedRow.querySelector("input").dataset.areaName;
    
                let postcodeID = TableViewSelectedRow.querySelector("input").value;
                
                L.setUnwindDataStore("postcode_id", postcodeID );
                L.setUnwindDataStore("postcode", postcode );
                // noinspection SpellCheckingInspection
                L.setUnwindDataStore("areaname", areaname );
                L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd );
    
                new X2Tools().dismissViewController(L.getUnwindDataStore());
                
            } catch (e) {
                alert(e.message);
            }
            
        }
        
        /*
        * @Javascript interface */
        this.selectEnvironmentAndUnwind = function () {
            // alert(122);
            try{
                
                new X2Tools().serializeContent(document.querySelector("ul.x2-list"), function (error) {
                    
                    if( !error ){
                        
                        L.setUnwindDataFromJSONString(JSON.stringify(this));
                        L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd );
                        new X2Tools().dismissViewController(L.getUnwindDataStore());
                        
                    }
                    
                    
                })
                
            } catch (e) {
                alert(e.message);
            }
            
        }
        
        this.selectPlaceCoveringAndUnwind = function () {
    
    
            try{
        
                new X2Tools().serializeContent(document.querySelector("ul.x2-list"), function (error) {
            
                    if( !error ){
                
                        // alert(TableViewSelectedRow.querySelector("input").dataset.prettyName);
                        // L.setUnwindDataStore("place_covering_id", TableViewSelectedRow.querySelector("input").value);
                        // L.setUnwindDataStore("place_covering_pretty_name", TableViewSelectedRow.querySelector("input").dataset.prettyName );
                        
                        // alert(JSON.stringify(this));
                        
                        L.setUnwindDataFromJSONString(JSON.stringify(this));
                        L.setUnwindDataStore("place_covering_for", document.querySelector("#place_covering_for").value );
                        L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd );
                        new X2Tools().dismissViewController(L.getUnwindDataStore());
                
                    }
            
            
                })
        
            } catch (e) {
                alert(e.message);
            }
            
        }
        
        
        /**
         * @Javascript interface
         * @Select League for team group and Dismiss
         */
        this.selectLeagueAndDismissWithData = function () {
    
            let selectedLeague              = TableViewSelectedRow.querySelector("input").value;
            let selectedLeaguePrettyName    = TableViewSelectedRow.querySelector("input").dataset.prettyName;
            L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd );
            L.setUnwindDataStore("selected_league", selectedLeague );
            L.setUnwindDataStore("pretty_selected_league_name", selectedLeaguePrettyName );
    
            new X2Tools().dismissViewController(L.getUnwindDataStore());
            
            
        }
        
        
        
        this.updateRowPostCodes = function (data) {
            
            try {
                
                
                let adInOutwardsAreaEl = document.querySelector("select#environment_area_id");
                
                if( undefined !== adInOutwardsAreaEl && null !== adInOutwardsAreaEl ){
                    adInOutwardsAreaEl.innerHTML = "<option value='" + data.postcode_id + "'>" + data.postcode + " - " + data.areaname + "</option>";
    
                    document.querySelector("input#pretty_environment_area").value = data.postcode + " - " + data.areaname
                }
                
            } catch (e) {
                xAlert(e.message);
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
        
        
        return this;
}
    , unwindDataStore = {},
    // This action calling from Native Content data Post from Native Content And Need Absolute
    unwindAction = function (data) {
    
    
        // alert(JSON.stringify(data));
    
        switch (data.unwindFrom) {
    
            case "Extras__postcodes_index":
        
                new Layout().updateRowPostCodes(data);
        
                break;
            
            
        }

    
        
    
    };
