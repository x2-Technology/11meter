/*
 * Author          :suleymantopaloglu
 * File            :script.js
 * Product Name    :PhpStorm
 * Time            :15:53
 * Created at      :11.06.2019 15:53
 * Description     :
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
            
            this.prepareTableView();
            this.buttons();
            return this;
        };
        
        this.prepareTableView = function(){
            
            // alert(cnt + "_" + nsp + "_" + mtd) ;
            
            
            L.checkCardTeamsItemsFromRepository(
                
                function ( cardTeamsItems ) {
                    
                    
                            // 1. Step Add To Card Box the cardTeamsItems
                    
                            // 2. Step Create TableView
                            
                    
                            try{
    
                                // Load already added Teams Clubs Items
                                L.loadCardItemsCellsFromBackend();
                                setTimeout(function () {
                                }, 1000);
                                
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
                                    
                                            }
                                
                                        })
                        
                                    .create( function ( TableView, rows, ui ) {
                            
                                        try{
                                            ui.searchEl.focus();
                                        } catch (e) {
                                
                                        }
                            
                            
                                        GlobalTableViewUI   = ui;
                                        GlobalTableViewApi  = TableView;
                            
                            
                                        if( cnt + "_" + nsp + "_" + mtd === "TableView__time_suggestion_index" ){
                                            L.timeSuggestion();
                                        }
                            
                            
                                        /**
                                         * Load Environment full data for user select
                                         */
                                        try{
                                
                                            if( "" !== document.querySelector("select#environment_area_id").value )
                                            {
                                                L.loadEnvironmentFullData(parseInt(document.querySelector("select#environment_area_id").value));
                                            }
                                
                                        } catch (e) {
                                            // alert(e.message);
                                        }
                            
                            
                                    });
                    
                            }
                
                            catch (e) {
                                alert(e.message + "\n" + e.stack);
                            }
                })
            
        };
        
        
        this.checkCardTeamsItemsFromRepository = function( callback ){
            
            
            let repositoryCardTeamsItems = "";
            
            if( undefined !== callback && "function" === typeof callback){
                callback( repositoryCardTeamsItems );
            }
          
        };
        
        
        this.buttons = function(){
            
            document.querySelectorAll("li.action").forEach(function (El) {
                El.onmousedown = function(){
                    let data    = $(this).find("a")[0].dataset.data;
                    data        = JSON.parse(data.replace(/[\\]/g, ""));
                    
                    // alert(JSON.stringify(data));
                    L.loadActivityWithData(data);
                }
            });
            
            try{
                document.querySelector("input#suggestions").ontouchend = function (El) {
                    
                    let opponentTeamEl      = document.querySelector("select#opponent_team");
                    let opponentLeagueEl    = document.querySelector("input#opponent_league");
                    let requiredRows        = [];
                    let requiredRowsErr     = false;
                    
                    
                    if( !parseInt(opponentTeamEl.value) ){
    
                        requiredRows.push("Gegner Mannschft");
                        requiredRowsErr     = true;
                        
                    }
    
                    // alert(requiredRowsErr);
                    if( opponentLeagueEl.value === "" ){
        
                        requiredRows.push("Gegner Spielklasse");
                        requiredRowsErr     = true;
        
                    }
                    
                    
                    if( requiredRowsErr ){
    
    
                        
                        let ac = new X2Tools().AlertController();
                        ac
                            .setMessage(requiredRows.join("\n"))
                            .setTitle("Wähle")
                            .addAction({
                                title:"Ok",
                                style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                action:""
                            })
                            .show();
                        
                        
                    } else {
                        
                        // alert(this.dataset.viewController);
                        new X2Tools().presentViewControllerWithData(this.dataset.viewController);
                        
                        
                    }
                    
                    
                    
        
        
                }
            } catch (e) {
                alert(e.message);
            }
            
            
            try{
                document.querySelector("input#card-teams-items-reset").ontouchend = function (El) {
                    L.resetCardTeamsItemsFiltered();
                }
            } catch (e) {
                alert(e.message);
            }
            
            
            
            return this;
        }
        
        
        this.resetCardTeamsItemsFiltered = function () {
            
            try{
                let clubSelectEl            = document.getElementById("club_name");
                let opponentTeamSelectEl    = document.getElementById("opponent_team");
                let opponentLeagueEl        = document.getElementById("opponent_league");
                let areaSelectEl            = document.getElementById("area");
                let areaEnvironmentEl       = document.getElementById("area_environment_km");
    
                // Club
                clubSelectEl.innerHTML          = '<option value="0">Optional</option>';
                // Team
                opponentTeamSelectEl.innerHTML  = '<option value="0"></option>';
    
    
                // Opponent League
                opponentLeagueEl.value = "";
                GlobalTableViewUI.updateRowSubTitle( opponentLeagueEl.closest("li"), "" );
    
                // Area
                areaSelectEl.innerHTML  = '<option value="0">Optional</option>';
                // Area Distance
                areaEnvironmentEl.value = "";
                GlobalTableViewUI.updateRowSubTitle( areaSelectEl.closest("li"), "" );
                
                // Box Empty
                let cardItemsBox = document.getElementById("team-card");
                cardItemsBox.innerHTML = "";
    
                let httpRequest = new X2Tools().HttpRequest();
                httpRequest
                    .setController("TeamsCard")
                    .setNamespace("!")
                    .setMethod("removeAllCardItemsFromRepository")
                    .setLocalActivityIndicator(true)
                    .execute(function () {
                    })
                
            }catch (e) {
                xAlert(e.message);
            }
            
        }
        
        
        /**
         * Javascript Interface
         * @param data
         */
        this.updateRowOpponentTeam = function (data) {
            
            
            try {
    
                data.team               = JSON.parse(data.team);
                data.pretty_team_name   = JSON.parse(data.pretty_team_name);
                
                let opponentTeamEl = document.querySelector("select#opponent_team");
                if( undefined !== opponentTeamEl && null !== opponentTeamEl ){
                    opponentTeamEl.innerHTML = "<option value='" + data.team[0] + "'>" + data.pretty_team_name[0] + "</option>";
                }
                
                
                
            } catch (e) {
                
                xAlert(e.message);
                
            }
            
        };
        
        this.updateRowOpponentLeagues = function (data) {
    
    
            try {
    
                let leaguesHiddenEl = document.querySelector("#opponent_league");
                if(undefined !== leaguesHiddenEl && null !== leaguesHiddenEl){
                    leaguesHiddenEl.value = data.selected_league;
                }
    
                GlobalTableViewUI.updateRowSubTitle(TableViewSelectedRow, JSON.parse(data.pretty_selected_league_name).join(", ") );
        
        
        
            } catch (e) {
        
                alert(e.message);
        
            }
            
            
            
            
        }
    
        this.updateRowEnvironment = function (data) {
            
            let environmentArea         = document.querySelector("select#area");
            let environmentMaxKm        = document.querySelector("input#area_environment_km");
            
            let stringEnvironment       = data.pretty_environment_area + ", Umgebung max.:" + data.environment_area_km + " km";
    
            environmentArea.innerHTML   = "<option value='" + data.environment_area_id + "'></option>";
            environmentMaxKm.value      = data.environment_area_km;
            
            GlobalTableViewUI.updateRowSubTitle( environmentArea.parentNode.parentNode, stringEnvironment );
            
        }
        
        this.updateRowClub = function (data) {
            
            let clubSelectEl            = GlobalTableViewApi.querySelector("select#club_name");
    
            clubSelectEl.innerHTML   = "<option value='" + data.selected_club + "'>" + data.pretty_selected_club_name + "</option>";
    
    
            /**
             * Lock Environment Row
             */
            L.resetEnvironmentRowByClubSelected(function (row) {
    
                GlobalTableViewUI.rowProperty("disabled", [row], true);
                GlobalTableViewUI.updateRowSubTitle( row, "");
                
            })
            
         
            
        }
        
        this.resetEnvironmentRowByClubSelected = function (callback) {
    
            
            try{
    
                let environmentEl  = GlobalTableViewApi.querySelector("select#area");
                let environmentRow = environmentEl.closest("li.cell");
                environmentEl.innerHTML = "<option value='0'></option>";
    
                if( undefined !== callback && "function" === typeof callback ){
        
                    callback(environmentRow);
        
                }
                
            } catch (e) {
                alert(e.message + "\n" + e.stack);
            }
            
            
            
        }
        
        this.updateFilterData = function (data) {
    
            try {
        
                let indicator = new X2Tools().ActivityIndicator();
                indicator.show(function () {
            
                    let httpRequest = new X2Tools().HttpRequest();
                    httpRequest
                        .setController("TeamsCard")
                        .setMethod("collectFilterData")
                        .setNamespace("!")
                        .setData({
                            filters:data
                        })
                        .execute(function () {
                            
                            // alert(JSON.stringify(this));
                            
                            indicator.dismiss();
                        })
                        .error(function () {
                    
                        });
            
                });
        
            } catch (e) {
        
                xAlert(e.message);
        
            }
            
        }
        
        this.resultForFilter = function () {
        
        
        
        }
        
        this.updateFilteredTeamsCard = function (data) {
    
            /**
             * Club_Team_TeamGroup_League_Trainer
             */

            let httpRequest = new X2Tools().HttpRequest();
            httpRequest
                .setController("TeamsCard")
                .setNamespace("!")
                .setMethod("addSelectedTeamsCardTeamsToRepositoryAndReturnWithPrettyCells")
                .setData({
                    card_teams:data.card_teams
                })
                .setLocalActivityIndicator(true)
                .execute(function () {
    
    
                    // alert(JSON.stringify(this));
                    try{
        
                        L.appendLoadedCardTeamsItemsToTableWithCellData(this);
        
                    } catch (e) {
                        alert(e.message + "\n" + e.stack);
        
                    }
                   
                    
                })
            
            
        
        
        
        }
        
        this.loadCardItemsCellsFromBackend = function () {
            
            
            try{
                let httpRequest = new X2Tools().HttpRequest();
                httpRequest
                    .setController("TeamsCard")
                    .setNamespace("!")
                    .setMethod("loadCardTeamsItems")
                    .setLocalActivityIndicator(true)
                    .execute(function () {
            
            
                        // Ayni anda ikinci bi takim koymak istenirse ilkini overwrite ediyo oysaki altina eklemeli
            
                        try{
                
                           L.appendLoadedCardTeamsItemsToTableWithCellData(this);
                
                        } catch (e) {
                            alert(e.message + "\n" + e.stack);
                
                        }
            
            
                    })
            } catch(e){
                alert(e.message);
            }
            
        }
        
        /**
         * Local function
         * Add pretty cell with Data
         * @param cells
         */
        this.appendLoadedCardTeamsItemsToTableWithCellData = function(cells){
    
            let teamCardTableView    = document.getElementById("team-card");
    
            // alert(JSON.stringify(cells));
            
            if( cells.length ){
        
                for(let cell in cells ){
            
                    let c = cells[cell].cell;
                    let k = cells[cell].cell_key;
            
            
            
                    let cellExists = false;
                    teamCardTableView.querySelectorAll("li").forEach(function (El) {
                        if( El.dataset.teamKey === k ){
                            cellExists = true;
                        }
                    });
            
            
                    if( !cellExists ){
                        var content          = document.createElement("div");
                        content.innerHTML    = c.trim();
                        teamCardTableView.appendChild(content.firstChild);
                    }
            
                    new X2Tools()
                        .TableView(teamCardTableView,
                            {
                                rows:function(cells, ui){
                            
                                    // TODO All Cells Of Table
                            
                                },
                                row:function(cell, cells, ui){
                                    cell.ontouchend = function () {
                                        TableViewSelectedRow = cell;
                                    }
                                }
                            })
                
                        .create( function ( TableView, rows, ui ) {
                    
                            TableView.querySelectorAll("button#remove-card-item").forEach(function (El) {
                                El.ontouchend = function(){
                                    this.closest("li").remove();
                                }
                            });
                    
                    
                        });
                }
            }
            
            
        }
        
        
        this.collectSelectedTeamsForCardAndDismissWithData = function(){
            
            
            let teamsCardTableView = document.querySelector("ul#team-card");
    
            let items = teamsCardTableView.querySelectorAll("li[data-role='team-card-item']");
            
            if( items.length ){
    
    
                try{
                    
                    let requiredTeamItems = [];
    
                    items.forEach(function (El) {
                        requiredTeamItems.push(El.dataset.teamKey);
                    });
                    
                    
                    L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd );
                    L.setUnwindDataStore("card_teams", requiredTeamItems );
                    
                    new X2Tools().dismissViewController(L.getUnwindDataStore());
        
                } catch (e) {
                    alert(e.message + "\n" + e.stack);
                }
            
            
            } else {
                
                let ac = new X2Tools().AlertController();
                ac
                    .setTitle("Achtung")
                    .setMessage("noch keine Mannschaft vorberetiet")
                    .addAction({
                        title:"Ok",
                        style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                        action:""
                    })
                    .show();
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
        
        
        try{
    
            // alert(JSON.stringify(data));
    
            switch (data.unwindFrom) {
                
                case "TableView__teams_index":
                    
                    Layout().updateRowOpponentTeam(data);
                    Layout().updateFilterData(data);
                    
                    break;
                case "TableView__leagues_index":
                    Layout().updateRowOpponentLeagues(data);
                    Layout().updateFilterData(data);
                    
                    break;
    
                case "TableView__environment_index":
        
                    Layout().updateRowEnvironment(data);
                    Layout().updateFilterData(data);
        
                    break;
    
                case "TableView__clubs_index":
        
                    Layout().updateRowClub(data);
                    Layout().updateFilterData(data);
        
                    break;
    
                case "TableView__filtered_teams_card_index":
        
                    Layout().updateFilteredTeamsCard(data);
                    break;
        
            }
            
            
            
        } catch (e) {
            alert(e.message + "\n" + e.stack);
        }
        
        
        
        
    };
