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
controller = cnt + "_" + nsp + "_" + mtd;

let Layout = function () {
        
        let L = this;
        
        this.init = function () {
            
            this.removeAllLink();
            this.buttons();
            this.prepareTableView();
            return this;
        };
        
        this.prepareTableView = function(){
    
            // xAlert(controller);
            try{
                new X2Tools()
                    .TableView(document.getElementsByClassName("x2-list")[0],
                        {
                            
                            // searchBar:true, Use data attribute data-with="searchbar"
                            rows:function(cells, ui){
                                
                                // TODO All Cells Of Table
                                
                            },
                            row:function(cell, cells, ui){
                                
                                cell.ontouchstart = function () {
                                    TableViewSelectedRow = cell;
                                }
                            },
                            search:function( TableView, rows, ui ){
                                
                                
                                
                                if ( nsp + "_" + mtd === "_clubs_index" ){
                                    
                                    let searchString = this;
    
                                    let httpRequest = new X2Tools().HttpRequest();
                                    let ai          = new X2Tools().ActivityIndicator();
    
    
                                    ai.show(function () {
        
                                        // In Public class 'da global method gelistir butum standartart listelemeler icin
                                        // search olayinda tabloyu yemizle ama eventlerini tut
                                        // Refresh olayini incele
        
                                        httpRequest
                                            .setController("TableView")
                                            .setNamespace("_clubs")
                                            .setMethod("loadClubsWithPrettyCell")
                                            .setProcessWithSession(false)
                                            .setData({
                                                search:searchString
                                            })
                                            .execute(function(){
    
                                                
                                                let addedRows = this;
                                                // document.getElementsByClassName("x2-list")[0].innerHTML = this;
                
                                                alert(JSON.stringify(addedRows));
                                                
                                                ui.removeRow([], function () {
                                                    
                                                    ui.addRow(addedRows);
                                                    setTimeout(function () {
                                                        L.prepareTableView();
                                                        
                                                    }, 100);
                    
                                                    // Dismiss Indicator
                                                    ai.dismiss();
                                                    
                                                });
                
                                            });
                                    });
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                }
    
                                if ( controller === "TableView__postcodes_index" ){
        
                                    // alert("postcodes");
                                    
                                    let searchString = this;
        
                                    let httpRequest = new X2Tools().HttpRequest();
                                    httpRequest
                                        .setController("TableView")
                                        .setNamespace("_postcodes")
                                        .setMethod("loadPostcodesWithPrettyCell")
                                        .setProcessWithSession(false)
                                        .setLocalActivityIndicator(true)
                                        .setData({
                                            search:searchString
                                        })
                                        .execute(function(){
            
            
                                            // alert(this);
                                            try{
                                                let addedRows = this;
                                                // document.getElementsByClassName("x2-list")[0].innerHTML = this;
                                                // alert(JSON.stringify(addedRows));
                
                                                ui.removeRow([], function () {
                        
                                                    ui.addRow(addedRows);
                                                    setTimeout(function () {
                                                        L.prepareTableView();
                            
                                                    }, 100);
                        
                                                    // Dismiss Indicator
                                                    // ai.dismiss();
                        
                                                });
                                            } catch (e) {
                                                alert(e.message)
                                            }
            
                                        });
        
        
        
        
        
        
        
                                }
                                
                                
                            }
                            
                        })
                    
                    .create( function ( TableView, rows, ui ) {
                        
                        try{
                            ui.searchEl.focus();
                        } catch (e) {
                        
                        }
                        
                        GlobalTableViewUI = ui;
                        GlobalTableViewApi = TableView;
                        
                        
                        if( cnt + "_" + nsp + "_" + mtd === "TableView__time_suggestion_index" ){
                            L.timeSuggestion();
                        }
                        
                        
                        /**7
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
            
            
            if( undefined !== postcode_id && null !== postcode_id && typeof postcode_id !== "NaN" ){
                
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
                            
                            let prettyTownName  = this.data.zc_zip + " " + this.data.zc_location_name;
                            let townEl          = document.querySelector("select#environment_area_id");
                            let townHiddenEl    = document.querySelector("input#pretty_environment_area");
                            
                            townEl.value = this.data.zc_id;
                            townEl.querySelector("option:checked").innerText = prettyTownName;
                            
                            townHiddenEl.value = prettyTownName;
                            
                        })
                }, 300);
            }
            
            
        }
        
        this.removeAllLink = function () {
        
        };
        
        /**
         * Javascript Interface
         * Back from Teams
         */
        this.collectSelectedTeamsAndDismissWithData = function () {
            
            
            try{
                
                // let teams = [];
                let team = [];
                let pretty_team_name = [];
                let team_group = [];
                let club = [];
                let league_of_team_group = [];
                let team_dfb_name = [];
                let team_dfb_link = [];
                
                
                /**
                 * This With SubTeam
                 */
                let checkedEls = document.querySelectorAll("ul.x2-list li[data-selected=true]");
                
                
                
                if( checkedEls.length ){
                    
                    checkedEls.forEach(function (El) {
                        
                        let parsedSelectedTeamGroups                = JSON.parse( El.querySelector("input#team_group").value );
                        let parsedSelectedTeamGroupsLeague          = JSON.parse( El.querySelector("input#selected_league").value );
                        
                        for (let p in parsedSelectedTeamGroups) {
                            
                            /*teams.push({
                                team:El.dataset.id,
                                clubId:El.dataset.clubId,
                                subTeam:parsedSelectedTeams[parsedSelectedTeam]
                            });*/
                            
                            // club.push(parseInt(El.dataset.club));
                            team.push(parseInt(El.querySelector("input#team_id").value));
                            team_group.push(parsedSelectedTeamGroups[p]);
                            
                            league_of_team_group.push(parsedSelectedTeamGroupsLeague[p]);
                            
                        }
                    });
                    
                } else {
                    
                    // Without SubTeam
                    checkedEls = document.querySelectorAll("ul.x2-list li input:checked");
                    if(checkedEls.length){
                        checkedEls.forEach(function (El) {
                            // alert(El.value)
                            // El = El.parentNode;
                            team.push(parseInt(El.dataset.id) | parseInt(El.value));
                            pretty_team_name.push(El.dataset.prettyName);
                            /*team.push({
                                pretty_name:El.dataset.prettyName,
                                id:parseInt(El.dataset.id) | parseInt(El.value)
                            });*/
                        });
                    }
                    
                    
                    
                }
                
                
                
                L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd);
                
                // L.setUnwindDataStore("club", JSON.stringify(club));
                
                L.setUnwindDataStore("team", JSON.stringify(team));
                L.setUnwindDataStore("pretty_team_name", JSON.stringify(pretty_team_name));
                
                L.setUnwindDataStore("team_group", JSON.stringify(team_group));
                L.setUnwindDataStore("team_league", JSON.stringify(league_of_team_group));
                
                new X2Tools().dismissViewController(L.getUnwindDataStore());
                
            } catch (e) {
                
                alert(e.stack);
            }
            
            
        };
        
        /**
         * Javascript Interface
         * Back from Teams
         */
        this.collectSelectedTeamGroupsAndDismissWithData = function () {
            
            
            try{
    
                let team_groups     = [];
                let leagues         = [];
                let pretty_league_name = [];
                let pretty_team_group_sub_title_for_team = [];
                
                
                /**
                 * This With SubTeam
                 */
                let checkedEls = document.querySelectorAll("ul.x2-list li[data-selected=true]");
                
                // alert(checkedEls[0].innerHTML);
                
                if( checkedEls.length ){
    
                    try{
                        
                        
                        
                        checkedEls.forEach(function (El) {
                            
                            // alert(El.querySelector("input#selected_league").value);
                            
                            team_groups.push(El.querySelector("input#team_group_id").value);
                            
                            let parsedLeagues = (typeof El.querySelector("input#selected_league").value === "string" ? JSON.parse(El.querySelector("input#selected_league").value) : El.querySelector("input#selected_league").value );
                            
                            leagues.push( parsedLeagues );
                            pretty_league_name.push( El.querySelector("input#pretty_selected_league_name").value );
            
                            /*let str = El.querySelector("input#team_group_id").value;
                            str += ".";
                            str += " ";
                            // noinspection SpellCheckingInspection
                            str += "Mannschaft";
                            str += " ";
                            str += "(" + El.querySelector("input#pretty_selected_league_name").value + ")";
    
                            pretty_team_group_sub_title_for_team.push(str);*/
            
                        });
                        
                        
                    }
                    catch (e) {
                        alert(e.message);
                    }
                    
                } else {
                    
                    // Without SubTeam
                    checkedEls = document.querySelectorAll("ul.x2-list li input:checked");
                    if(checkedEls.length){
                        checkedEls.forEach(function (El) {
                            team_groups.push(parseInt(El.dataset.id) | parseInt(El.value));
                            pretty_team_group_sub_title_for_team.push(El.dataset.prettyName);
                            
                        });
                    }
                    
                    
                    
                }
    
    
                L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd);
                // L.setUnwindDataStore("team_groups",  JSON.stringify(team_groups));
                // L.setUnwindDataStore("leagues",    JSON.stringify(leagues));
    
                L.setUnwindDataStore("team_groups", team_groups);
                L.setUnwindDataStore("leagues", leagues);
                L.setUnwindDataStore("pretty_league_name", pretty_league_name);
    
                // noinspection SpellCheckingInspection
                /**
                 * Bu Cell, sub title icin hazirlanmis array bir sonraki asamasa join ile birlestirilecek
                 */
                // L.setUnwindDataStore( "pretty_team_group_sub_title_for_team",   pretty_team_group_sub_title_for_team );
                new X2Tools().dismissViewController(L.getUnwindDataStore());
    
                
            } catch (e) {
                
                alert(e.stack);
            }
            
            
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
        
        this.collectSelectedTeamsForCardAndDismissWithData = function () {
    
            try{
        
                let finallySelectedCardTeams     = [];
        
        
                /**
                 * This With SubTeam
                 */
                let checkedEls = document.querySelectorAll("ul.x2-list li[data-selected=true]");
                
                if( checkedEls.length ){
            
                    try{
                
                        checkedEls.forEach(function (El) {
                    
                            finallySelectedCardTeams.push({
                                
                                role_id     : El.querySelector("input#role_id").value,
                                club_id     : El.querySelector("input#club_id").value,
                                team_id     : El.querySelector("input#team_id").value,
                                league_id   : El.querySelector("input#league_id").value,
                                trainer_id  : El.querySelector("select#trainer_").value,
                            });
                        });
                        
                        // alert(JSON.stringify(finallySelectedCardTeams));
                        
                    }
                    catch (e) {
                        alert(e.message);
                    }
            
                } else {
            
                    // Without SubTeam
                    checkedEls = document.querySelectorAll("ul.x2-list li input:checked");
                    if(checkedEls.length){
                        checkedEls.forEach(function (El) {
                            team_groups.push(parseInt(El.dataset.id) | parseInt(El.value));
                            pretty_team_group_sub_title_for_team.push(El.dataset.prettyName);
                    
                        });
                    }
            
            
            
                }
        
        
                L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd);
                L.setUnwindDataStore("card_teams", finallySelectedCardTeams);
        
                // noinspection SpellCheckingInspection
                /**
                 * Bu Cell, sub title icin hazirlanmis array bir sonraki asamasa join ile birlestirilecek
                 */
                // L.setUnwindDataStore( "pretty_team_group_sub_title_for_team",   pretty_team_group_sub_title_for_team );
                new X2Tools().dismissViewController(L.getUnwindDataStore());
        
        
            } catch (e) {
        
                alert(e.stack);
            }
        
        
        }
        
        
        /*
        * @Javascript interface */
        this.selectPostCodeAndUnwind = function () {
            
            try{
                
                
                
                
                let checkedPostCodeEl = document.querySelector("input:checked");
                
                
                
                let postcode =checkedPostCodeEl.dataset.postcode;
                // noinspection SpellCheckingInspection
                let areaname = checkedPostCodeEl.dataset.areaName;
                
                let postcodeID = checkedPostCodeEl.value;
                
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
        
        
        /**
         * Javascript Unwind Function
         *
         */
        this.selectedCardClubsAndDismissWithData = function () {
            
            try{
        
        
        
                let checkedEl = GlobalTableViewApi.querySelectorAll("input:checked");
                
                // alert(GlobalTableViewApi);
                // alert(checkedEl );
                if( null === checkedEl ){
                    petiteMessage();
                    return false;
                }
    
                // alert(checkedEl.length);
                if( !checkedEl.length ){
                    petiteMessage();
                    return false;
                }
    
                
    
                let selectedClub            = GlobalTableViewApi.querySelector("input:checked").value;
                
                let selectedClubPrettyName  = GlobalTableViewApi.querySelector("input:checked").dataset.prettyName;
                L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd );
                L.setUnwindDataStore("selected_club", selectedClub );
                L.setUnwindDataStore("pretty_selected_club_name", selectedClubPrettyName );
    
                new X2Tools().dismissViewController(L.getUnwindDataStore());
                
                
                function petiteMessage(){
                    let ac = new X2Tools().AlertController();
                    ac
                        .setTitle("Achtung")
                        .setMessage("noch keine Verein ausgewählt!")
                        .addAction({
                            title:"Ok",
                            style:ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                            action:""
                        })
                        .show()
                }
                
        
        
            } catch (e) {
                alert(e.message + "\n" + e.stack);
            }
            
            
            
        }
        
        /**
         * Javascript Unwind Function
         * Like Top Function
         *
         */
        this.selectClubAndDismissWithData = function () {
            
            
            try{
    
                // GlobalTableViewApi.remove();
                
                let checkedEl = GlobalTableViewApi.querySelectorAll("input:checked");
                
                
                if( checkedEl.length ){
    
                    checkedEl = checkedEl[0];
                    
                    let selectedClub            = checkedEl.value;
                    let selectedClubPrettyName  = checkedEl.dataset.prettyName;
                    L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd );
                    L.setUnwindDataStore("club", selectedClub );
                    L.setUnwindDataStore("pretty_selected_club_name", selectedClubPrettyName );
                    
                    new X2Tools().dismissViewController(L.getUnwindDataStore());
                    
                    
                }
                
                else {
                    
                    let ac = new X2Tools().AlertController();
                    ac
                        .setTitle("Achtung")
                        .setMessage("noch keine Verein ausgewählt!")
                        .addAction({
                            title:"Ok",
                            style:ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                            action:""
                        })
                        .show()
                    
                    
                }
                
                
            } catch (e) {
                alert(e.message + "\n" + e.stack);
            }
            
            
        }
        
        /**
         * Javascript Unwind Function
         *
         */
        this.selectTrainerAndDismissWithData = function () {
            
            
            
            try{
                
                let selectedTrainer            = GlobalTableViewApi.querySelectorAll("input:checked");
                
                if( selectedTrainer.length ){
                    
                    let selectedTrainerPrettyName  = GlobalTableViewApi.querySelector("input:checked").dataset.prettyName;
                    L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd );
                    L.setUnwindDataStore("trainer", selectedTrainer[0].value );
                    L.setUnwindDataStore("pretty_selected_trainer_name", selectedTrainerPrettyName );
                    
                    new X2Tools().dismissViewController(L.getUnwindDataStore());
                }
                
                else {
                    xAlert("Bitte wähle eine Trainer!");
                    
                }
                
            } catch (e) {
                xAlert(e.message , e.stack);
            }
            
            
        }
        
        
        /**
         * Javascript Unwind Function
         *
         */
        this.selectSeasonAndDismissWithData = function () {
            
            try{
                let selectedSeason            = GlobalTableViewApi.querySelector("input:checked").value;
                let selectedSeasonPrettyName  = GlobalTableViewApi.querySelector("input:checked").dataset.prettyName;
                L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd );
                L.setUnwindDataStore("season", selectedSeason );
                L.setUnwindDataStore("pretty_selected_season_name", selectedSeasonPrettyName );
                
                new X2Tools().dismissViewController(L.getUnwindDataStore());
            } catch (e) {
                alert(e.message + "\n" + e.stack);
            }
            
            
        }
        
        this.updateRowSelectedTeam = function (data) {
            
            // alert(JSON.stringify(data));
    
            /*
                teams   :data.teams, // deprecated
                team    :data.team,
                _code   :data._code,
                team_group: data.team_group,
                team_league:data.team_league, // Takim hangi lige ait
                team_dfb_name: data.team_dfb_name,
                team_dfb_link: data.team_dfb_link,
                club: club,
                tableStyle: "default",
                role_locked:data.role_locked
            */
            
            try{
                let teamGroupInputEl        = TableViewSelectedRow.querySelector("input#team_group");
                let leagueInputEl           = TableViewSelectedRow.querySelector("input#selected_league");
                
                let teamGroupPrettyInputEl  = TableViewSelectedRow.querySelector("input#pretty_selected_team_group_name");
                let leaguePrettyInputEl     = TableViewSelectedRow.querySelector("input#pretty_selected_league_name");
                
                let parsedTeamGroups = [];
                let parsedTeamGroupPrettyName = [];
                let parsedLeagues          = [];
                let parsedLeaguesPrettyName = [];
    
                switch (typeof data.team_groups) {
                    case "array":
                    case "object":
    
                        parsedTeamGroups                = data.team_groups;
                        parsedTeamGroupPrettyName       = data.team_groups;
                        
                        teamGroupInputEl.value          = JSON.stringify(parsedTeamGroups);
                        teamGroupPrettyInputEl.value    = JSON.stringify(parsedTeamGroups);
                        break;
        
                    case "string":
            
                        parsedTeamGroups            = JSON.parse(data.team_groups);
                        parsedTeamGroupPrettyName   = JSON.parse(data.team_groups);
                        
                        teamGroupInputEl.value          = data.team_groups;
                        teamGroupPrettyInputEl.value    = data.team_groups;
                }
    
    
                switch (typeof data.leagues) {
                    case "array":
                    case "object":
    
                        parsedLeagues                   = data.leagues;
                        parsedLeaguesPrettyName         = data.pretty_league_name;
                        
                        leagueInputEl.value             = JSON.stringify(parsedLeagues);
                        leaguePrettyInputEl.value       = JSON.stringify(parsedLeaguesPrettyName);
                        break;
        
                    case "string":
            
                        parsedLeagues                   = JSON.parse(data.leagues);
                        parsedLeaguesPrettyName         = JSON.parse(data.pretty_league_name);
                        
                        leagueInputEl.value             = data.leagues;
                        leaguePrettyInputEl.value       = data.pretty_league_name;
                }
    
                let selectedTeamSubTitle = [];
    
                for( let parsedTeamGroup in parsedTeamGroups ){
        
                    selectedTeamSubTitle.push(parsedTeamGroupPrettyName[parsedTeamGroup] + ".Mannschaft (" + parsedLeaguesPrettyName[parsedTeamGroup] + ")" )
        
                }
                
                
                TableViewSelectedRow.dataset.selected = true;
    
                GlobalTableViewUI.updateRowSubTitle(TableViewSelectedRow, selectedTeamSubTitle.join(", ") );
    
    
            } catch(e){
                alert(e.message + "˜\n" + e.stack);
                
            }
            
            
            
    
            
            
            
        };
        
        
        
        this.updateRowFilteredTeamAndAddTrainer = function (data) {
            
 
            try{
    
                TableViewSelectedRow.querySelector("select#trainer_").innerHTML = "<option value='" + data.trainer + "'>" + data.pretty_selected_trainer_name + "</option>";
                
                TableViewSelectedRow.dataset.selected = true;
    
                
    
    
            } catch(e){
                alert(e.message + "˜\n" + e.stack);
                
            }
            
            
            
    
            
            
            
        };
        
        
        /**
         * Javascript Interface
         * @param data
         */
        this.updateRowOpponentTeam = function (data) {
            
            try {
        
                let indicator = new X2Tools().ActivityIndicator();
                indicator.show(function () {
            
                    let httpRequest = new X2Tools().HttpRequest();
                    httpRequest
                        .setController("Ad")
                        .setMethod("selectedTeams")
                        .setNamespace("testplay")
                        .setData({
                            team    :data.team,
                        })
                        .execute(function () {
                    
                    
                            // alert(JSON.stringify(this[0]));
                    
                            let opponentTeamEl = document.querySelector("select#opponent_team");
                            if( undefined !== opponentTeamEl && null !== opponentTeamEl ){
                                opponentTeamEl.innerHTML = "<option value='" + this[0].id + "'>" + this[0].name + "</option>";
                            }
                    
                    
                            // teamsTable.append(this);
                            // let rowsDataAsString = this;
                            /**
                             * Recreate Table
                             */
                            // addRowAndPrepareTable(this);
                    
                            indicator.dismiss();
                    
                    
                        })
                        .error(function () {
                    
                        });
            
                });
        
        
        
            } catch (e) {
        
                xAlert(e.message);
        
            }
    
        };
        
        
        /**
         * Javascript Interface
         * @param data
         */
        this.updateRowOpponentTeam_direct = function (data) {
    
            // alert(1);
            
            data.team = JSON.parse(data.team);
            
            try {
    
                let opponentTeamEl = document.querySelector("select#opponent_team");
                if( undefined !== opponentTeamEl && null !== opponentTeamEl ){
                    opponentTeamEl.innerHTML = "<option value='" + data.team[0].id + "'>" + data.team[0].pretty_name + "</option>";
                }
                
                
                
            } catch (e) {
                
                xAlert(e.message);
                
            }
            
        };
        
        this.updateRowTeamGroup = function (data) {
            
            
            try {
                let leaguesHiddenEl             = TableViewSelectedRow.querySelector("input#selected_league");
                let leaguesHiddenPrettyNameEl   = TableViewSelectedRow.querySelector("#pretty_selected_league_name");
                
                if(undefined !== leaguesHiddenEl && null !== leaguesHiddenEl){
                    
                    switch (typeof data.selected_league) {
                        case "array":
                        case "object":
                            leaguesHiddenEl.value           = JSON.stringify(data.selected_league);
                            leaguesHiddenPrettyNameEl.value = JSON.stringify(data.pretty_selected_league_name);
                            break;
                            
                        case "string":
                            
                            let parsedLeagues = JSON.parse(data.selected_league);
                            parsedLeagues = parsedLeagues.length > 1 ? JSON.stringify(parsedLeagues) : parsedLeagues[0];
    
                            let parsedLeaguesPrettyName = JSON.parse(data.pretty_selected_league_name);
                            parsedLeaguesPrettyName = parsedLeaguesPrettyName.length > 1 ? JSON.stringify(parsedLeaguesPrettyName) : parsedLeaguesPrettyName[0];
                            
                            leaguesHiddenEl.value           = parsedLeagues;
                            leaguesHiddenPrettyNameEl.value = parsedLeaguesPrettyName;
                    }
                    
                }
                
    
                
                
                TableViewSelectedRow.dataset.selected = true;
                
                GlobalTableViewUI.updateRowSubTitle(TableViewSelectedRow, JSON.parse(data.pretty_selected_league_name).join(", ") );
        
        
        
            } catch (e) {
        
                alert(e.message);
        
            }
            
            
            
            
        }
        
        /**
         * Javascript Interface
         * If user Desired club not found
         * His Trigger button bottom fixed on View
         */
        this.clubNotFoundReport = function(){
            
            
            try{
                let ac = new X2Tools().AlertController();
                ac.setMessage("Bitte geben Sie vollständige Link von Verein in fußball.de ein!");
                ac.setWithTextField(true);
                ac.setTitle("Verein Anfordern");
                ac.addAction({
                    title:"Cancel",
                    action:"",
                    style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                });
                ac.addAction({
                    title:"Ok",
                    action:"javascript:new Layout().clubNotFoundAndStartSearchWithURi('|textField|')",
                    style:ALERT_ACTION_STYLE.UIAlertActionStyleDefault
                });
                
                ac.show();
            } catch (e) {
                alert(e.message);
            }
        }
        
        this.clubNotFoundAndStartSearchWithURi = function(url){
            
            function isUrl(s) {
                var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
                return regexp.test(s);
            }
            
            if( isUrl(url) ){
                
                // Call Target Out sourcing File
                // Fetch the DFB Club data with Club ID
                GlobalActivityIndicator = new X2Tools().ActivityIndicator("Verbindung zur fußball.de\nbitte warten!");
                GlobalActivityIndicator.show(function () {
                    
                    let httpRequest = new X2Tools().HttpRequest();
                    httpRequest
                        .setController("TableView")
                        .setMethod("fetchFileForClubSearchFromOutSource")
                        .setNamespace("_clubs")
                        .setData({
                            url:url
                        })
                        .execute(function () {
                            
                            // alert(this.vereinsseite);
                            let data = {};
                            data.externalUrl    = this.vereinsseite;
                            data.runnableScript = this.runnableScript;
                            location.href = DEVICE + "://" + ACTIVITY.ACTIVITY_EXTERNAL + "?" + JSON.stringify(data);
                        });
                });
            }
            
            else {
                
                try{
                    let ac = new X2Tools().AlertController();
                    ac.setTitle("Achtung");
                    ac.setMessage("Bitte geben Sie korrekte Link\n\nLink erfolgreich mit\nhttp oder https Protocol!");
                    ac.addAction({
                        title:"Cancel",
                        action:"",
                        style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                    });
                    ac.show();
                } catch (e) {
                    alert(e.message);
                }
                
                
                
            }
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
        
        this.updateRowEnvironment = function (data) {
            
            let environmentArea         = document.querySelector("select#area");
            let environmentMaxKm        = document.querySelector("input#area_environment_km");
            
            let stringEnvironment       = data.pretty_environment_area + ", Umgebung max.:" + data.environment_area_km + " km";
    
            environmentArea.innerHTML   = "<option value='" + data.environment_area_id + "'></option>";
            environmentMaxKm.value      = data.environment_area_km;
            
            GlobalTableViewUI.updateRowSubTitle( environmentArea.parentNode.parentNode, stringEnvironment );
            
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
    
            if( undefined !== data ){
                
                switch (data.unwindFrom) {
        
                case "TableView__postcodes_index":
            
                    new Layout().updateRowPostCodes(data);
                    break;
        
                case "TableView__teams_index":
                    
                    // Layout().updateRowOpponentTeam(data);
                    Layout().updateRowOpponentTeam_direct(data);
                    break;
                    
                case "TableView__leagues_index":
                    
                    Layout().updateRowTeamGroup(data);
                    break;
    
                case "TableView__environment_index":
        
                    new Layout().updateRowEnvironment(data);
                    break;
    
                case "TableView__team_groups_index":
        
                    new Layout().updateRowSelectedTeam(data);
                    break;
    
                case "TableView__trainers_index":
        
                    new Layout().updateRowFilteredTeamAndAddTrainer(data);
                    break;
        
            }
    
            }
            
            
        } catch (e) {
            alert(e.message + "\n" + e.stack);
        }
        
        
        
        
    };
