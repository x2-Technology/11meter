/**
 * Created by tSoftX on 12/02/2017.
 */

$(function () {
    new Layout()
        .init();
});

let
    GlobalTableViewUI,
    GlobalActivityIndicator,
    GlobalClubCollectData,
    TableViewSelectedRow,
    ClubCanBeSaveAccess = false, // Club Send To Database Button Inactive, can be only one time active
    ContextTableView,
    /**
     * Loaded Table after user Role Select
     * inline have a Status Switch
     * @type {null}
     */
    RoleSelectorTableRows = null;
    
    Layout = function () {
        
        let L = this;
        
        
        this.init = function () {
            
            if (DEVICE !== "") {
            
            }
            
            
            // alert(cnt + " " + nsp + " " + mtd);
            
            if (mtd === "fetchUserUsedRolesWithTable") {
                
                // new X2Tools().TableView().create();
            }
            
            // new X2Tools().TableView().create();
            // return false;
            
            if (nsp === "manage") {
                
                // New Role
                try {
                    document.querySelector("select#role").onchange = function (e) {
                        L.prepareRole(this.value, e);
                    }
                    
                } catch (e) {
                
                }
                
                // TODO Test
                // L.removeUserRoleFromUserRolesTableView(86);
                
                
                
                
                // Prepare Table Status etc.
                // Do individually for Table View
                
                try{
    
                    new X2Tools()
                        .TableView(document.querySelectorAll("ul.x2-list")[0],
                            {
                                // searchBar:true, Use data attribute data-with="searchbar"
                                rows: function (cells, ui) {
                                    // TODO All Cells Of Table
                                },
                                row: function (cell, cells, ui) {
                                    // TODO All Cells Of Table
                    
                                },
                                search: function (TableView, rows, ui) {
                                    // TODO All Cells Of Table
                                }
                
                            })
                        .create(function (TableView, rows, ui) {
            
                            // TODO All Cells Of Table
            
                            GlobalTableViewUI = ui;
            
            
                            
                            // Role can be edit
                            L.roleEdit();
                        });
                    
                } catch (e) {
                    alert(e.message);
                }
                
                
                try{
                    // Prepare Table Already Added Clubs
                    new X2Tools()
                        .TableView(document.getElementById("role_club"),
                            {
                                // searchBar:true, Use data attribute data-with="searchbar"
                                rows: function (cells, ui) {
                                    // TODO All Cells Of Table
                                },
                                row: function (cell, cells, ui) {
                                    // TODO All Cells Of Table
                                },
                                search: function (TableView, rows, ui) {
                                    // TODO All Cells Of Table
                                }
                
                            })
                        .create(function (TableView, rows, ui) {
                            // TODO All Cells Of Table
                        });
    
    
                    // Delete Role Button
                    new X2Tools().Button(document.querySelector("input[type=button][data-role='role-delete']"), {
        
                        touchWith: "end",
                        touch: function (El) {
            
                            let ac = new X2Tools().AlertController();
                            ac
                                .setTitle("Löschen")
                                .setMessage("Möchten Sie Rolle löschen?")
                                .addAction({
                                    title: "Cancel",
                                    style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                    action: ""
                                })
                                .addAction({
                                    title: "Ok",
                                    style: ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                                    action: "javascript:Layout().deleteUserRoleAfterConfirmation(" + El.dataset.userUsedRoleId + ")"
                                })
                                .show();
            
                        }
        
        
                    }).refresh();
                }
                catch (e) {
                    alert(e.message);
                }
                
                
                try{
                    // Prepare Table Already Added Clubs
                    new X2Tools()
                        .TableView(document.getElementById("user_used_roles"),
                            {
                                // searchBar:true, Use data attribute data-with="searchbar"
                                rows: function (cells, ui) {
                                    // TODO All Cells Of Table
                                },
                                row: function (cell, cells, ui) {
                                    // TODO All Cells Of Table
                                },
                                search: function (TableView, rows, ui) {
                                    // TODO All Cells Of Table
                                },
                                sort: {
                                    render: true,
                                    dataSortKey: "id",
                                    dataGroupKey: "group"
                                },
                                badge: true,
                                dataBadgeKey: "badge-value"
                
                            })
                        .create(function (TableView, rows, ui) {
                            // TODO All Cells Of Table
                        });
                } catch (e) {
                    alert(e.message);
                }
                
                
                
                
                try{
                    let user_used_role_id = document.querySelector("input#user_used_role_id");
                    if( null !== user_used_role_id ){
        
                        // alert(2);
                        // Load User Role
                        let httpRequest = new X2Tools().HttpRequest();
                        httpRequest.setLocalActivityIndicator(true);
                        httpRequest.setController("Role");
                        httpRequest.setMethod("fetchRole");
                        httpRequest.setNamespace("manage");
                        httpRequest.setData({
                            user_used_role_id:user_used_role_id.value
                        });
                        httpRequest.execute(function () {
                            // alert(JSON.stringify(this));
                            let data = this;
                            setTimeout(function () {
                                L.addClubDataToRoleWithBE(data);
                            },500)
                        })
        
        
                    }
                }
                catch (e) {
                    alert(e.message);
                }
                
                
                
            }
            
            // xAlert(nsp + " " + mtd);
            
            if (nsp === "assistant")
            {
                
               
                
                switch (mtd) {
                    
                    case "index":
                    case "season":
                        
                        /**
                         * Other Base Table View
                         * Little Big Table Difference
                         */
                        
                        new X2Tools()
                            .TableView(document.getElementsByClassName("x2-list")[0],
                                {
                                    
                                    // searchBar:true, Use data attribute data-with="searchbar"
                                    rows: function (cells, ui) {
                                        
                                        // TODO All Cells Of Table
                                        
                                    },
                                    row: function (cell, cells, ui) {
                                        
                                        
                                        if (mtd === "season") {
                                            
                                            let checkEl = cell.querySelector("input");
                                            
                                            if (checkEl !== null) {
                                                
                                                checkEl.onclick = function () {
                                                    
                                                    
                                                    if (checkEl.checked) {
                                                        
                                                        L.setUnwindDataStore("unwindFrom", nsp + "_" + mtd);
                                                        L.setUnwindDataStore("season", checkEl.value);
                                                        
                                                        new X2Tools().dismissViewController(L.getUnwindDataStore());
                                                        
                                                    }
                                                    
                                                }
                                            }
                                            
                                        }
                                        
                                    },
                                    search: function (TableView, rows, ui) {
                                    
                                    }
                                    
                                })
                            .create(function (TableView, rows, ui) {
    
                               
                                GlobalTableViewUI = ui;
                                L.lockedCellsForStatus( "disabled", rows, ui, true );
                                
                                try{
                                    
                                    let user_used_role_id = document.querySelector("input#user_used_role_id");
                                    
                                    // xAlert(user_used_role_id.value, 265);
                                    if( null !== user_used_role_id){
                                        L.loadUserRequestedRole(user_used_role_id.value);
                                    }
    
                                    
                                } catch (e) {
                                    alert(new Error(e.message))
                                }
                                
                                
                                
                            });
                        
                        
                        break;
                    
                    case "club":
                        
                        /**
                         * Table View For Clubs Select
                         */
                        new X2Tools()
                            .TableView(document.getElementById("clubs"),
                                {
                                    
                                    // searchBar:true, Use data attribute data-with="searchbar"
                                    rows: function (cells, ui) {
                                        
                                        // TODO All Cells Of Table
                                        
                                    },
                                    row: function (cell, cells, ui) {
                                    
                                    },
                                    search: function (TableView, rows, ui) {
                                        
                                        for (let row in rows) {
                                            rows[row].remove();
                                        }
                                        
                                        let indicator = new X2Tools().ActivityIndicator();
                                        indicator.show(function () {
                                            
                                            let httpRequest = X2Tools().HttpRequest();
                                            httpRequest
                                                .setController("Role")
                                                .setNamespace("assistant")
                                                .setMethod("club")
                                                .setData({
                                                    search: this
                                                })
                                                .execute(function () {
                                                
                                                
                                                })
                                            
                                            
                                        })
                                        
                                        
                                    },
                                    sort: {
                                        render: true,
                                        dataSortKey: "sort",
                                        dataGroupKey: "group"
                                    },
                                    badge: true,
                                    dataBadgeKey: "badge-value"
                                    
                                })
                            .create(function (TableView, rows, ui) {
                                // alert(TableView.id)
                                GlobalTableViewUI = ui;
                                
                            });
                        
                        break;
                    
                    case "team":
                    case "sub_teams":
                        
                        
                        /**
                         * Table View For Teams Select
                         */
                        TableView = new X2Tools()
                            .TableView(document.querySelector("ul.x2-list")[0],
                                {
                                    
                                    // searchBar:true, Use data attribute data-with="searchbar"
                                    rows: function (cells, ui) {
                                        
                                        // TODO All Cells Of Table
                                        
                                    },
                                    row: function (cell, cells, ui) {
    
                                        cell.ontouchend = function () {
                                            TableViewSelectedRow = cell;
                                        }
                                        
                                        /**
                                         * This is a check option
                                         * Function call only by checked row
                                         */
                                        /*cell.isChecked = function(){
    
                                            let ac = new X2Tools().AlertController();
                                            ac.setMessage("Möchten Sie verbinden [" + cell.innerText + "] mit DFB");
                                            ac.setTitle("DFB verbindung!");
                                            ac.addAction({
                                                title:"Cancel",
                                                style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                                action:"",
                                            });
                                            ac.addAction({
                                                title:"Ok",
                                                style:ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                                                action:"javascript:new Layout().embedUrl(" + cell.dataset.dfbEmbedUrl + ")",
                                            });
    
                                            ac.show()
                                            
                                        }*/
                                        
                                        
                                        
    
                                        
                                    },
                                    search: function (TableView, rows, ui) {
                                    
                                    }
                                    
                                })
                            .create(function (TableView, rows, ui) {
                                
                                GlobalTableViewUI = ui;
                                
                            });
                        
                        break;
                    case "dfbConnect":
                        
                        // alert(123);
                        
                        // Fake Loader
                        // alert(document.location.href);
                        // alert(1);
                        // alert(JSON.stringify(query));
                        // alert(query.scollId);
                        GlobalActivityIndicator = new X2Tools().ActivityIndicator("Connecting to Dfb, Please waits!");
                        GlobalActivityIndicator.show( function () {
    
                            // Fetch the DFB Club data with Club ID
                            let httpRequest = new X2Tools().HttpRequest();
                            httpRequest
                                .setController("Role")
                                .setMethod("fetchDFBClubData")
                                .setNamespace("assistant")
                                .setData(query)
                                .execute(function () {
            
                                    // alert(JSON.stringify(this));
            
                                    
                                    let data = {};
                                    data.externalUrl    = this.vereinsseite;
                                    data.runnableScript = this.runnableScript;
            
                                    // alert(JSON.stringify(data));
            
                                    
                                    location.href = DEVICE + "://" + ACTIVITY.ACTIVITY_EXTERNAL + "?" + JSON.stringify(data);
                                    
            
                                    
                                    //while ( !document.body.querySelector("div.view-wrapper ul#dfbClubTeams").children.length ){
                                    
                                    //};
    
                                    // GlobalActivityIndicator.dismiss();
            
                                });
                            
                            
                        });
                        
                        
                        
                        
                        
                        
                        break;
                    
                }
                
                
            }
            
            
            return this;
        };
        
        this.buttons = function () {
            return this;
        };
    
    
        /**
         * Load Assistant index
         * With User Using role data
         * @param userRoleData
         * @deprecated
         */
        this.loadUserRequestedRole_ = function ( userRoleData ) {
            // userRoleData.xxl = "super";
            // xAlert(userRoleData, new Error().stack);
            
            let parsedUserRoleData = JSON.parse( userRoleData );
            
            // Set input value Activity from
            let activityFromEl    = document.querySelector("input#activity_from");
            activityFromEl.value  = parsedUserRoleData.activity_from;
            
            // Set input value Activity to
            let activityToEl      = document.querySelector("input#activity_to");
            activityToEl.value    = parsedUserRoleData.activity_to;
            
            /**
             * Set Season Value
             * season_id included
             */
            if( parsedUserRoleData.season !== ""){
                L.updateRowSeason( parsedUserRoleData );
            }
    
    
            
            parsedUserRoleData.clubId   = parsedUserRoleData.club_id;
            parsedUserRoleData.clubName = parsedUserRoleData.pretty_club_name;
            L.updateRowClub( parsedUserRoleData );
            
            // return false;

            
            // Set Club Teams with Http Request
            // L.updateCellRoleTeam();
            // Set Club Data with Http Request
            if( null !== parsedUserRoleData.club_with_teams && undefined !== parsedUserRoleData.club_with_teams ){
                // alert(parsedUserRoleData.club_with_teams);
                L.updateCellRoleTeam({
                    teams:JSON.parse(parsedUserRoleData.club_with_teams)
                });
            }
    
            
            // Rewrite Teams while here the teams data into array seperated object
            // Should be
            // teams:[]
            
            if( null !== parsedUserRoleData.teams && undefined !== parsedUserRoleData.teams ){
                L.updateCellRoleTeam({
                    teams:parsedUserRoleData.teams
                });
            }
            
        
        
        }
    
    
        this.loadUserRequestedRole = function ( user_used_role_id ) {
            // userRoleData.xxl = "super";
            // xAlert(user_used_role_id, 578);
            
            
            
            try{
                let httpRequest = new X2Tools().HttpRequest();
                httpRequest.setLocalActivityIndicator(true);
                httpRequest.setController("Role");
                httpRequest.setNamespace("assistant");
                httpRequest.setMethod("fetchCurrentlyUserRoleFromRepository");
                httpRequest.setData({
                    user_used_role_id:user_used_role_id
                });
                httpRequest.execute(function () {
                    
                    
                    
                    
                    // alert("K:\n" + JSON.stringify(this));
                    // return false;
                    // // Set input value Activity from
                    // let activityFromEl    = document.querySelector("input#activity_from");
                    // activityFromEl.value  = this.activity_from;
                    //
                    // // Set input value Activity to
                    // let activityToEl      = document.querySelector("input#activity_to");
                    // activityToEl.value    = this.activity_to;
                    //
                    /**
                     * Set Season Value
                     * season_id included
                     */
                    if( undefined !== this.season && null !== this.season ){
                        L.updateRowSeason( this );
                    }
                    //
                    //
                    //
                    // parsedUserRoleData.clubId   = parsedUserRoleData.club;
                    // // parsedUserRoleData.clubName = parsedUserRoleData.pretty_club_name;
                    //
                    // // Load Club
                    if( undefined !== this.club && null !== this.club ){
                        L.updateRowClub( this );
                    }
    
                    /**
                     * Load club Teams
                     */
                    L.updateCellRoleTeam(this);
                    
                    
                });
            } catch (e) {
                // xAlert(e.message);
            }

        
        }
    
        
    
    
        /**
         * @Javascript AlertController Interface
         * Will User Edited Role Delete
         */
        this.deleteUserRoleAfterConfirmation = function (roleId) {
            
            
            let indicator = new X2Tools().ActivityIndicator();
            
            indicator.show(function () {
                
                let httpRequest = new X2Tools().HttpRequest();
                httpRequest
                    /*.setController("Member")
                    .setNamespace("role")*/
                    .setController("Role")
                    .setNamespace("manage")
                    .setMethod("delete")
                    .setData({
                        id: roleId
                    })
                    .execute(function () {
                        
                        indicator.dismiss();
                        
                        if (this.resulta) {
                            
                            // TODO Goto BackView
                            L.setUnwindDataStore("unwindFrom", nsp + "_" + mtd);
                            // L.setUnwindDataStore("unwindFrom", nsp);
                            L.setUnwindDataStore("action","user_used_role_remove");
                            L.setUnwindDataStore("roles_table_should_reload", this.roles_table_should_reload);
                            // L.setUnwindDataStore("user_removed_role_id", this.user_removed_role_id);
                            //// L.setUnwindDataStore("user_removed_role_id",    this.role_id);
                            //// L.setUnwindDataStore("user_have_same_role",     this.user_have_same_role);
                            
                            new X2Tools().dismissViewController(L.getUnwindDataStore());
                            
                        } else {
                            
                            // TODO Show Alert Message
                            let ac = new X2Tools().AlertController();
                            ac
                                .setTitle(this.messageTitle)
                                .setMessage(this.messageBody)
                                .addAction({
                                    title: "Ok",
                                    style: ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                                    action: "javascript "
                                })
                                .show();
                            
                            
                        }
                        
                        
                    });
                
                
            })
            
            
        }
        
        
        /**
         * @Javascript Interface
         */
        this.clubSelect = function () {
            
            let club = document.querySelector("ul.x2-list input:checked");
            
            if (club !== null) {
                
                let label = document.querySelector("ul.x2-list label[for=" + club.id + "]");
                
                L.setUnwindDataStore("unwindFrom", nsp + "_" + mtd);
                
                L.setUnwindDataStore("pretty_club_name", label.innerHTML);
                L.setUnwindDataStore("club", club.value);
                
                new X2Tools().dismissViewController(L.getUnwindDataStore())
                
            } else {
                
                let ac = new X2Tools().AlertController();
                
                ac
                    .setMessage("Wähle eine Verein!")
                    .setTitle("Achtung")
                    .addAction({
                        title: "Ok",
                        style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                        action: ""
                    })
                    .show();
            }
        };
        
        
        /**
         * @Javascript Interface
         */
        this.teamSelect = function () {
            
                
                let club = document.querySelector("ul.x2-list input:checked");
                
                if(club !== null ){
                    
                    let label = document.querySelector("ul.x2-list label[for=" + club.id + "]");
                    
                    L.setUnwindDataStore("unwindFrom", "club");
                    
                    L.setUnwindDataStore("clubName", label.innerHTML);
                    L.setUnwindDataStore("club", club.value);
                    
                    new X2Tools().dismissViewController(L.getUnwindDataStore())
                    
                } else {
                    
                    let ac = new X2Tools().AlertController();
                    
                    ac
                        .setMessage("Wähle eine Verein!")
                        .setTitle("Achtung")
                        .addAction({
                            title:"Ok",
                            style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                            action:""
                        })
                        .show();
                }
        };
    
        /**
         * Javascript Interface
         * Back from Teams
         */
        this.collectSelectedTeamsAndDismissWithData = function () {
            
            
            try{
    
                // let teams = [];
                let team = [];
                let team_group = [];
                let club = [];
                let league_of_team_group = [];
                let team_dfb_name = [];
                let team_dfb_link = [];
    
    
                /**
                 * This With SubTeam
                 */
                let checkedEls = document.querySelectorAll("ul.x2-list li[data-selected=true]");
                
                // alert(checkedEls.length);
                if( checkedEls.length ){
    
                    checkedEls.forEach(function (El) {
    
                        let parsedSelectedSubTeams          = JSON.parse(El.dataset.subTeams);
                        let parsedSelectedSubTeamsLeagues   = JSON.parse(El.dataset.leagues);
                        
                        for (let p in parsedSelectedSubTeams) {
        
                            /*teams.push({
                                team:El.dataset.id,
                                clubId:El.dataset.clubId,
                                subTeam:parsedSelectedTeams[parsedSelectedTeam]
                            });*/
        
                            club.push(parseInt(El.dataset.club));
                            team.push(parseInt(El.dataset.id));
                            team_group.push(parsedSelectedSubTeams[p]);
                            
                            league_of_team_group.push(parsedSelectedSubTeamsLeagues[p]);
        
                        }
                    });
               
                } else {
                    
                    // Without SubTeam
                    checkedEls = document.querySelectorAll("ul.x2-list li input:checked");
                    if(checkedEls.length){
                        checkedEls.forEach(function (El) {
                            El = El.parentNode;
                            team.push(parseInt(El.dataset.id));
                        });
                    }
                    
                    
                    
                }
                
    
    
                L.setUnwindDataStore("unwindFrom", nsp + "_" + mtd);
                // L.setUnwindDataStore("teams", JSON.stringify(teams));
                L.setUnwindDataStore("club", JSON.stringify(club));
                L.setUnwindDataStore("team", JSON.stringify(team));
                L.setUnwindDataStore("team_group", JSON.stringify(team_group));
                L.setUnwindDataStore("team_league", JSON.stringify(league_of_team_group));
    
                new X2Tools().dismissViewController(L.getUnwindDataStore());
                
            } catch (e) {
                
                alert(e.stack);
            }
            
            
        };
    
        /**
         * Javascript Interface
         * Back from Teams > Sub teams
         */
        this.collectSelectedTeamGroupsAndDismissWithData = function () {
    
    
            /*let sub_teams = [];
            document.querySelectorAll("ul.x2-list input:checked").forEach(function (El) {
                sub_teams.push(El.value);
            });*/
    
            try{
                let sub_teams   = [];
                let leagues     = [];
                let pretty_sub_title_for_team = [];
                document.querySelectorAll("ul.x2-list li[data-selected=true]").forEach(function (El) {
                    sub_teams.push(El.querySelector("input[type=hidden]#sub_team").value);
                    leagues.push(El.querySelector("input[type=hidden]#league_id").value);
    
                    let str = El.querySelector("input[type=hidden]#sub_team").value;
                        str += ".";
                        str += " ";
                        // noinspection SpellCheckingInspection
                    str += "Mannschaft";
                        str += " ";
                        str += "(" + El.querySelector("input[type=hidden]#pretty_league_name").value + ")";
                    
                    pretty_sub_title_for_team.push(str);
                    
                });
    
                
                L.setUnwindDataStore("unwindFrom",                  nsp + "_" + mtd);
                L.setUnwindDataStore("sub_teams",                   JSON.stringify(sub_teams));
                L.setUnwindDataStore("leagues",                     JSON.stringify(leagues));
    
                // noinspection SpellCheckingInspection
                /**
                 * Bu Cell, sub title icin hazirlanmis array bir sonraki asamasa join ile birlestirilecek
                 */
                L.setUnwindDataStore("pretty_sub_title_for_team",   pretty_sub_title_for_team);
                new X2Tools().dismissViewController(L.getUnwindDataStore());
                
            }
            catch (e) {
                alert(e.message);
            }
        
        
        };
    
    

    
    
    
        /**
         * @Javascript Unwind Action
         * @User All Roles listed Table View
         */
        this.removeUserRoleFromUserRolesTableView = function (removedUserRoleId) {
            
            
            // console.log("GlobalTableViewUI", GlobalTableViewUI);
            try {
                let userRoleRowOnUserRolesTable = document.querySelector('ul.x2-list li[data-id="' + removedUserRoleId + '"]');
                
                userRoleRowOnUserRolesTable.remove();
                
                // TODO Check Others Roles if exists than stay on view else again dismissViewController with removed Role
                if (!document.querySelectorAll('ul.x2-list li.cell').length) {
                    
                    // TODO Remove Table Section and Dismiss View Controller
                    document.querySelector('ul.x2-list li.section:first-child').remove();
                    
                    setTimeout(function () {
                        try {
                            
                            L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp);
                            L.setUnwindDataStore("action", "user_used_role_remove");
                            L.setUnwindDataStore("user_removed_role_id", removedUserRoleId);
                            
                            new X2Tools().dismissViewController(L.getUnwindDataStore());
                        } catch (e) {
                            alert(e.message)
                        }
                        
                    }, 0);
                    
                    
                }
                
                
            } catch (e) {
                
                alert(e.message);
                
            }
            
        };
        
        
        // View Role
        /*
        * // namespace:_User_Role
        * User Role Add Or Edit with Drop Down Option
        * */
        this.prepareRole = function (role, e) {
            
            
            if (parseInt(role) === 0) {
                e.preventDefault();
                return false;
            }
            
            // Prepare Indicator
            let indicator = new $.tsoftx.loader();
            
            // Prepare Profile Content
            let profile = document.getElementById("profile");
            profile.innerHTML = "";
            
            
            // Process
            indicator.show(function () {
                try {
                    
                    let httpRequest = new X2Tools().HttpRequest();
                    
                    httpRequest
                        .setController("Role")
                        .setMethod("index")
                        .setNamespace("load")
                        .setProcessWithSession(true)
                        .setData({
                            role: role
                        })
                        .setProcessWithSession(true)
                        .error(function () {
                        })
                        .setCompletedCallback(function () {
                            indicator.dismiss();
                        })
                        .execute(function (dt) {
                            
                            
                            profile.innerHTML = this.content;
                            
                            new X2Tools()
                                .TableView(document.getElementById("profile"),
                                    {
                                        searchBar: false,
                                        row: function ( row, rows, ui ) {},
                                        rows: function (cells, ui) {
                                            // TODO All Cells Of Table
                                        }
                                    })
                                .create( function (TableView, rows, ui) {
                                    
                                    GlobalTableViewUI       = ui;
                                    ContextTableView        = TableView;
                                    RoleSelectorTableRows   = rows;
                                    
                                    L.lockedCellsForStatus( "disabled", rows, ui, true );
                                    
                                    
                                    prepareImagePreview();
                                    
    
                                    
                                });
                            
                            
                                // BOOT AUTO LOADER
                                // L.addClubForRoleWithBoot();
                            
                            
                        }, function (message, message2, message3) {
                            alert(message + " " + message2 + " " + message3)
                        });
                    
                } catch (e) {
                    alert(e.message);
                }
            });
            
            
            // namespace:_User_Role
            
            
        }
    
    
        /**
         * After Added Club
         * required element position switch
         * @param status // Enabled | disabled
         * @param value status value
         * @param cells
         * @param TableViewUI
         */
        this.lockedCellsForStatus = function ( status /*enabled|disabled*/, cells, TableViewUI, value ) {
            
            let targetCells = [];
            cells.forEach(function (El) {
                if (El.classList.contains(status)) {
                    
                    targetCells.push(El);
                }
            });
            
            TableViewUI.rowProperty( status, targetCells, value );
        }
        
        this.addClubForRoleWithBoot = function () {
            
            // Test
            setTimeout(function () {
                L.addClubDataToRoleWithBE({
                    season: 3,
                    club: 8,
                    teams: ["6", "12"]
                });
            }, 1000);
            
            /*setTimeout(function () {
                L.addClubDataToRoleWithBE({
                    season: 3,
                    club: 5,
                    teams: ["2", "4"]
                });
            }, 2000);*/
            
        }
        
        this.updateRowSeason = function (data) {
            
            try {
                let seasonEl = document.querySelector("ul.x2-list select#season");
                if ( seasonEl.length && data.season ) {
                    seasonEl.innerHTML = "<option value='" + data.season + "'>" + data.pretty_selected_season_name + "</option>";
                }
            } catch (e) {
                // xAlert(e.message);
            }
        };
    
        /**
         * Assistant Update Club Select Element
         * @param data
         */
        this.updateRowClub = function (data) {
            
            try {
    
                // alert("J:\n" + JSON.stringify(data));
                
                let clubEl = document.querySelector("ul.x2-list select#club");
                // if ( null !== clubEl && Object.keys(data).length && data.club ) {
                if ( null !== clubEl && clubEl.length && data.club ) {
    
                    if( !data.user_used_role_id ){
                    
                        /// Load club with httpRequest
                        let httpRequest = new X2Tools().HttpRequest();
                        let indicator   = new X2Tools().ActivityIndicator();
                        indicator.show(function () {
                            
                            httpRequest
                                .setController("_Public")
                                .setMethod("getDFBClubs")
                                .setNamespace("!")
                                .setData({
                                    id:data.club
                                })
                                .execute(function () {
                
                                    // alert("S:\n" + JSON.stringify(this));
                
                                    /**
                                     * Teams for Club select button
                                     * ViewController Data Prepare from cloud
                                     * And append to data to TeamSelect button
                                     */
                                    httpRequest
                                        .setController("Role")
                                        .setNamespace("assistant")
                                        .setMethod("teamsViewControllerData")
                                        .setData({
                                            club:this.id,
                                            clubName:this.teamName2, // <- Club Name
    
                                            /**
                                             * User Role prams need for
                                             * If user replaced the Club for currently Role
                                             * than with user_used_role_id or key
                                             * find the role from repository and remove club's teams
                                             */
                                            // user_used_role_id:data.user_used_role_id
                                        })
                                        .execute(function () {
                        
                        
                                            indicator.dismiss();
                        
                                            // xAlert(JSON.stringify(this), 1107);
                                            buttonAddTeamToClubForRole(this);
                        
                                        });
                
                                    createAndSelectSelectOptionForRoleClub(this);
                
                
                
                                })
        
                        });
                        
                    }

                    else {

                        // alert("H:\n" + JSON.stringify(data));
                        
                        createAndSelectSelectOptionForRoleClub(data);
                        buttonAddTeamToClubForRole(data.buttonDataForTeamAdd);

                    }
    
    
                    /**
                     * Crating and Selecting Option for Club Select Element
                     * @param data
                     */
                    function createAndSelectSelectOptionForRoleClub(data){
    
                        try{
    
    
                            // alert("BBS\n:" + JSON.stringify(data));
    
                            // Creat Option element for Club and select it
                            let option = document.createElement("option");
    
                            /*let club_combination = data.club ? data.club : data.id;
                            option.value = data.association_id + "," + club_combination;*/
    
                            option.value            = data.club ? data.club : data.id;
                            
                            // option.innerText    = data.pretty_association_name + ", " + (data.pretty_club_name !== undefined ? data.pretty_club_name : data.teamName2);
                            option.innerText    = data.pretty_club_name !== undefined ? data.pretty_club_name : data.teamName2;
                            // option.setAttribute("selected", "selected");
                            option.dataset.embedUrl = data.vereinsseite;
    
                            
                            clubEl.innerHTML = "";
                            clubEl.appendChild(option);
    
                            /**
                             * Pretty Club Name with input hidden Element
                             *
                             */
                            let prettyClubNameEl = document.querySelector("input#pretty_club_name");
                            if( undefined !== prettyClubNameEl || null !== prettyClubNameEl ){
                                prettyClubNameEl.value = data.pretty_club_name !== undefined ? data.pretty_club_name : data.teamName2;
                            }
    
                            // Independent the Team Button
                            let teamButton = document.querySelector("input#add_team");
    
                            if (null !== teamButton) {
                                // alert(223);
                                GlobalTableViewUI.rowProperty("disabled", [teamButton.parentNode], false );
                            }
                            
                            //
                            // for other Disabled Elements//
                            try{
                                let nodes = [];
                                document.querySelectorAll('ul.x2-list li.cell').forEach(function (El) {
                                    if( (El.classList.contains("disabled") || El.hasAttribute("disabled")) && !El.hasAttribute("readonly") ){
                                        nodes.push(El);
                                    }
                                });
                                // GlobalTableViewUI.rowProperty("disabled", nodes, false );
                                
                                L.lockedCellsForStatus("disabled", nodes, GlobalTableViewUI, false )
                                
                            } catch (e) {
                                alert(e.message);
                            }
                            
                            
    
                            /**
                             * Empty Club Teams Box
                             * While new Club need his teams
                             *
                             */
                            document.querySelector("ul.x2-list#teams").innerHTML = "";
    
    
                            // Ready For Club Add with Desired Data
                            // Click is Ready For Collect Data
                            L.prepareClubDataForRole();
                            
                            
                        } catch (e) {
                            xAlert(e.message, 1221);
                        }
    
    
    
                    }
    
                    /**
                     * Team for Club Button Add operation
                     * @param data
                     */
                    function buttonAddTeamToClubForRole(data) {
    
                        // alert(JSON.stringify(data));
                        
                        try{
                            // Teams Add Button
                            let btnAddTeam = document.querySelector("input#add_team");
                                btnAddTeam.dataset.data = JSON.stringify(data);
                            
                                // btnAddTeam.parentNode.querySelector("textarea").value = JSON.stringify(data);
                            
                                
                        } catch (e) {
                            alert(e.message);
        
                        }
                        
                    }
                    
                    
                }
                
                
                
                
                
            } catch (e) {
                
                alert(e.message);
                
            }
            
        };
        
        this.updateCellRoleTeam = function (data) {
    
            
            // xAlert(JSON.stringify(data), 1206);
            // return false;
            try {
                
                if( undefined !== data && null !== data ){
                    
                    let indicator = data.indicator;
    
                    try{
                        if( undefined === indicator && null === indicator ){
        
                            indicator = new X2Tools().ActivityIndicator();
                            indicator.show(function () {
                                // doIt(indicator);
                            });
        
                        } else {
                            
                            indicator = data.indicator;
                            doIt(indicator);
        
                        }
                    } catch (e) {
                        xAlert(e.message);
                    }
                    
                }
                
                function doIt(indicator){
    
                    // alert(JSON.stringify(data));
                    
                    /*let club = null;
                    try {
                        club = JSON.parse(data.club);
                    } catch (e) {
                    
                    }*/
                    
                    
                    
                    /*if( typeof club !== "object" ){
                        // Club object is single integer variable ,
                        // Need this Integer as array object
                        // While every team item need for self club id for DFB operation
                        // Now convert club object to array object
                        // Append items in club object, up to team items
                        club = [];
                        for(let i in data.team){
                            club.push(data.club | document.querySelector("select#club option:checked").value);
                        }
                    }*/
    
                    if( undefined === data.club ){
                        data.club = document.querySelector("select#club").value
                    }
                    
                    // alert(data.club);
                    
                    let httpRequest = new X2Tools().HttpRequest();
                    // noinspection SpellCheckingInspection
                    httpRequest
                        .setController("Role")
                        .setMethod("selectedTeams")
                        .setNamespace("assistant")
                        .setData({
                            // teams   :data.teams, // deprecated
                            team    :data.team,
                            _code   :data._code,
                            team_group: data.team_group,
                            team_league:data.team_league, // Takim hangi lige ait
                            team_dfb_name: data.team_dfb_name,
                            team_dfb_link: data.team_dfb_link,
                            club: data.club,
                            tableStyle: "default",
                            role_locked:data.role_locked
                        })
                        .execute(function () {
            
            
                            // alert(this);
                            
                            // teamsTable.append(this);
                            // let rowsDataAsString = this;
                            /**
                             * Recreate Table
                             */
                            addRowAndPrepareTable(this);
            
                            if( undefined !== indicator ){
                                indicator.dismiss();
                            }
            
                        })
                        .error(function () {
                            
                        });
    
                    /**
                     * Table will creating
                     * @param rowDataString
                     */
                    function addRowAndPrepareTable(rowDataString) {
        
                        let teamsTable = document.querySelector("ul.x2-list#teams");
        
                        try{
    
    
                            new X2Tools()
                                .TableView(teamsTable,
                                    {
                                        searchBar: false,
                                        row: function (cell, cells, ui) {
                                            // TODO All Cells Of Table
                                            cell.ontouchend = function () {
                                                TableViewSelectedRow = cell;
                                            }
                    
                                        },
                                        rows: function (cells, ui) {
                                            // TODO All Cells Of Table
                                        }
                                    })
                                .create(function (TableView, rows, ui) {
            
                                    if (undefined !== rowDataString) {
                
                                        ui.addRow(rowDataString, function () {
                                            addRowAndPrepareTable();
                                        })
                                    }
            
                                });
                            
                        } catch (e) {
                            alert(e.message);
                        }
        
        
                    }
                    
                    
                }
                
                
                
                
            } catch (e) {
                
                xAlert(e.message);
                
            }
            
        };
    
        this.updateCellTeamForSelectedSubTeams = function ( row, data ) {
        
            // alert(JSON.stringify(data) + "212");
            
            try{
    
                data.sub_teams  = JSON.parse(data.sub_teams);
                
                // noinspection SpellCheckingInspection
                /**
                 * Her takim alt takimi ile barabe bir lige ait
                 */
                data.leagues    = JSON.parse(data.leagues);
    
                // noinspection SpellCheckingInspection
                /**
                 * Alt takimlar yani takimin 1.2.3. takimi gibi
                 */
                let subTeams                = [];
                // noinspection SpellCheckingInspection
                /**
                 * Alt takimlar yani takimin 1.2.3. takimi gibi dataset icin
                 */
                let subTeamsForDataset      = [];
    
                // noinspection SpellCheckingInspection
                /**
                 * Takima ait league takim hangi ligde oynuyor Ornedin B.München 1. takimi hangi ligde
                 */
                let teamLeagueForDataset    = [];
    
                for(let subTeam in data.sub_teams ){
                    // subTeams.push(  parseInt(data.sub_teams[subTeam])  + ". Mannschaft");
                    // alert(subTeam);
                    
                    subTeams
                        .push(  data.pretty_sub_title_for_team[subTeam] );  // ./
                    
                    subTeamsForDataset
                        .push( parseInt(data.sub_teams[subTeam]) );
    
                    teamLeagueForDataset
                        .push( parseInt(data.leagues[subTeam]) )
                }
    
                // alert(subTeams.join(", "));
                row.dataset.selected    = true;
                row.dataset.subTeams    = JSON.stringify(subTeamsForDataset);
                row.dataset.leagues     = JSON.stringify(teamLeagueForDataset);
                
                row.querySelector("span[data-role=sub-title]").innerText = subTeams.join(", ");
                
                
                
                
            }
            catch (e) {
                
                alert(e.message);
            
            }
            
            
        
        };
        
        
        this.prepareClubDataForRole = function () {
            
            let addButton = document.querySelector("input[type=button]#approve_edited_club_for_role");
            new X2Tools().Button(addButton, {
                touchWith: "end",
                touch: function ( El ) {
                    
                    try {
                        
                        new X2Tools().serializeContent(document.getElementsByTagName("form")[0], function () {
                            
                            // alert(JSON.stringify(this));
                          
                            let club = this.club;
                            
                            // Add additional item for unwind
                            this.unwindFrom = nsp + "_" + mtd;
                            
                            GlobalClubCollectData = this;
                            
                            // Is New Or Old
                            GlobalClubCollectData.is_new = null === document.querySelector("input#user_used_role_data");
    
    
                            /**
                             * Add Club Pretty Name
                             * Extras
                             */
                            // GlobalClubCollectData.club_pretty_name = document.querySelector("select#club").innerText;


                            L.postBackClubDataToRequestRole()
                            
    
                            /*try {
                                
                                if (!parseInt(club)) {
                                    
                                    let ac = new X2Tools().AlertController();
                                    ac.setTitle("Achtung");
                                    ac.setMessage("Bitte wähle Mannschaft!");
                                    ac.addAction({
                                        title: "Ok",
                                        style: ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                                        action: ""
                                    });
                                    ac.show();
                                    
                                } else {
                                    
                                    
                                    let ac = new X2Tools().AlertController();
                                    ac.setTitle("Einfügen");
                                    ac.setMessage("Möchten Sie diese Verein einfügen?");
                                    // ac.setMessage(JSON.stringify(this));
                                    ac.addAction({
                                        title: "Abbrechen",
                                        style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                        action: ""
                                    });
                                    ac.addAction({
                                        title: "Ok",
                                        style: ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                                        action: "javascript:Layout().postBackClubDataToRequestRole()"
                                    });
                                    ac.show();
                                    
                                }
                                
                            } catch (e) {
                                alert(e.message);
                                
                            }*/
                            
                            
                        });
                        
                        
                    } catch (e) {
                        
                        alert(e.message);
                        
                    }
                    
                    
                },
                click: function (El) {
                    
                    new X2Tools().serializeContent(document.getElementsByTagName("form")[0], function () {
                        
                        console.log(this);
                        
                        // alert(JSON.stringify(this));
                        
                    });
                    
                }
                
            }).refresh(function (El, ui) {
                ui.property("disabled", false);
            });
            
            
        }
        
        
        // noinspection SpellCheckingInspection
        /**
         * @Javascript Interface
         * Übernehmen Completed Role
         * */
        this.postBackClubDataToRequestRole = function () {
            
            try{
                // xAlert(JSON.stringify(GlobalClubCollectData), new Error().stack);
                
                L.setUnwindDataFromJSONString(JSON.stringify(GlobalClubCollectData));
                new X2Tools().dismissViewController(L.getUnwindDataStore());
            } catch (e) {
                xAlert(e.message);
            }
        };
    
    
        /**
         * Return here After Club team selected optional team connected with DFB team
         * And Role ready for temporarily store for Save
         * After Übernehmen
         * @param returnedData
         */
        this.addClubDataToRoleWithBE = function (returnedData, parentAI ) {
            
            
            // alert(JSON.stringify(returnedData));
            try{
    
                if( undefined === parentAI ){
    
                    let indicator = new X2Tools().ActivityIndicator();
    
                    indicator.show(function () {
                        render(indicator);
                    });
                    
                } else {
                    
                    render( parentAI );
                    
                }
                
                // function render(ai){
                let render = function(ai){
    
                    try {
                        let httpRequest = new X2Tools().HttpRequest();
        
                        // alert(JSON.stringify(returnedData));
                        
                        httpRequest
                            .setController("Role")
                            .setMethod("preparePrettyClubRowForRole")
                            .setNamespace("assistant")
                            .setData(returnedData)
                            .execute(function () {
                
                                // alert(this.RowClubForRole);
                                ai.dismiss();
                                L.addPreparedPrettyClubForRole( this.RowClubForRole, returnedData );
                                // window.location.reload(true);
                
                
                            })
                    } catch (e) {
                        xAlert(e.message);
                    }
                    
                }
                
                
                
            } catch (e) {
                alert(e.message);
            }
            
        }
        
        
        /**
         * Final Add Club For Role And Ready For Database
         * @param rowsString
         * @param returnedData
         */
        this.addPreparedPrettyClubForRole = function ( rowsString, returnedData ) {
            
            // alert(JSON.stringify(returnedData));
            // return false;
            
            // alert(rowsString);
            
            try{
    
                let table = document.querySelector("ul#role_club");
                
                let userRoleRowEl = null;
                if( returnedData !== null && undefined !== returnedData ){
                    if( null !== returnedData.user_used_role_id && null !== table ){
    
                        userRoleRowEl = table.querySelector("li[data-user-used-role-id='" + returnedData.user_used_role_id + "']");
                        
                        if( null !== userRoleRowEl ){
                            userRoleRowEl.remove();
                        }
                    }
                }
    
    
                new X2Tools()
                    .TableView(table,
                        {
                            // searchBar:true, Use data attribute data-with="searchbar"
                            rows: function (cells, ui) {
                    
                                // TODO All Cells Of Table
                    
                            },
                            row: function (cell, cells, ui) {
    
    
                                cell.ontouchstart = function () {
        
                                    
                                    // alert(JSON.stringify(this.querySelector("a").dataset));
        
        
                                }
                                /*if (cell.dataset !== undefined && null !== cell.dataset.role && cell.dataset.role === "role-clubs") {
                                    
                                    let a = cell.querySelector("a[data-role=role-club-remove]");
                                    if (undefined !== a) {
                                        
                                        
                                        cell.ontouchstart = function () {
                                            
                                            TableViewSelectedRow = cell;
                                            
                                            let ac = new X2Tools().AlertController();
                                            ac
                                                .setMessage("Möchten Sie Verein löschen?")
                                                .setTitle("Löschen")
                                                .addAction({
                                                    title: "Ok",
                                                    style: ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                                                    action: "javascript:new Layout().removeSelectedClubFromTable()"
                                                })
                                                .addAction({
                                                    title: "Cancel",
                                                    style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                                    action: ""
                                                })
                                                .show();
                                            
                                            
                                        }
                                        
                                        
                                    }
                                    
                                    
                                }*/
                    
                    
                            },
                            search: function (TableView, rows, ui) {
                    
                            },
                            /*addRow:function( TableView ){
        
                                TableView.append( rowsString )
                                
                            }*/
                
                        })
                    .create(function (TableView, rows, ui) {
            
            
                            // alert(rowsString);
                        ContextTableView = TableView;
                        
            
                        if ( undefined !== rowsString ) {
                            
                            
                            ui.addRow( rowsString, function () {
                                ui.refresh();
                            });
                            
                            
                            /**
                             * Do Status Check Element to Enabled
                             */
                
                            // alert(RoleSelectorTableRows.length);
                            /**
                             * Need Previous Table
                             * Element for Status Switch
                             */
                            if( null !== RoleSelectorTableRows ){
                                L.lockedCellsForStatus( "disabled", RoleSelectorTableRows, ui, false );
                            }
                
                            
                
                            if (!TableView.querySelectorAll("li.cell").length) {
                                TableView.innerHTML = "";
                            }
                
                            
                
                
                            // TODO For Multiple added Clubs, Button Create and do Active only for 1 time ( For Click Events )
                            if (!ClubCanBeSaveAccess) {
                    
                    
                                // Ready Add Button
                                ClubCanBeSaveAccess = true;
                    
                                L.roleAdd(true);
                                
                    
                    
                            }
                
                
                        }
            
                    });
                
            } catch (e) {
                // alert(e.message, "\n\n" + new Error().stack);
                alert(e.message);
            }
            
            
        };
        
        this.roleAdd = function( buttonActive ){
            
            try{
                let roleSaveButton = document.querySelector("input[type=button]#role_add");
                return new X2Tools().Button( roleSaveButton, {
                    touchWith: "end",
                    touch: function (El) {
            
                        try {
                            withRepository();
                            function live() {
                                new X2Tools().serializeContent(document.getElementsByTagName("form")[0], function ()
                                {
                        
                        
                                    // Individually Clubs Rows Serialize
                                    let serializedParent = this;
                        
                                    // Remove last Added Club And his Teams from Object
                                    delete (serializedParent.club);
                                    delete (serializedParent.team);
                                    delete (serializedParent.season);
                        
                                    // Create Empty Object
                                    serializedParent.clubs = [];
                        
                        
                                    ContextTableView.querySelectorAll("li[data-role='role-clubs']").forEach(function (El) {
                            
                                        new X2Tools().serializeContent(El.querySelector("a > div#role-data"), function () {
                                
                                            serializedParent.clubs.push(this);
                                
                                        });
                            
                            
                                    });
                        
                                    // alert(JSON.stringify(serializedParent.clubs.length));
                        
                                    /**
                                     * Default Message Parameters
                                     * @type {boolean}
                                     */
                                    let err     = !serializedParent.clubs.length;
                                    let title   = "Rolle einfügen?";
                                    let message = "Möchten Sie diese Rolle einfügen?";
                                    let actionCancelTitle = "Abbrechen";
                        
                                    /**
                                     * with Error
                                     * Changed Message Parameters
                                     * @type {boolean}
                                     */
                                    if (err) {
                                        title = "Achtung";
                                        message = "Rolle ohne Verein nicht möglich!";
                                        actionCancelTitle = "Ok";
                                    }
                        
                                    // alert(JSON.stringify(serializedParent));
                        
                                    try {
                            
                                        let ac = new X2Tools().AlertController();
                                        ac.setTitle(title);
                                        ac.setMessage(message);
                                        ac.addAction({
                                            title: actionCancelTitle,
                                            style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                            action: ""
                                        });
                                        if (!err) {
                                            ac.addAction({
                                                title: "Ok",
                                                style: ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                                                action: "javascript:Layout().postBackCompletedRoleForUser(" + JSON.stringify(serializedParent) + ")"
                                            });
                                        }
                                        ac.show();
                            
                                    } catch (e) {
                            
                                        alert(e.message);
                            
                                    }
                        
                        
                                });
                            }
                            function withRepository() {
                                new X2Tools().serializeContent(document.getElementsByTagName("form")[0], function ( error )
                                {
                        
                                    // alert(completed);
                                    /*if( !Object.keys(this).length ){
                                        return false;
                                    }*/
                                    // return false;
                                    // Individually Clubs Rows Serialize
                                    let serializedParent = this;
                        
                                    // alert(JSON.stringify(serializedParent));
                                    // return false;
                                    // Remove last Added Club And his Teams from Object
                                    // delete (serializedParent.club);
                                    // delete (serializedParent.team);
                                    // delete (serializedParent.season);
                        
                                    // Create Empty Object
                                    serializedParent.clubs = [];
                        
                        
                                    ContextTableView.querySelectorAll("li[data-role='role-clubs']").forEach(function (El) {
                                        serializedParent.clubs.push(El.dataset.userUsedRoleId);
                                    });
                        
                        
                                    serializedParent.roles_table_should_reload = true;
                        
                                    /**
                                     * Default Message Parameters
                                     * @type {boolean}
                                     */
                                        // alert(document.querySelector("select#club").value);
                                    let err     = !serializedParent.clubs.length && parseInt(document.querySelector("select#club").value) === 0 ;
                                    let title   = "Rolle einfügen?";
                                    let message = "Möchten Sie diese Rolle einfügen?";
                                    let actionCancelTitle = "Abbrechen";
                        
                                    let formCompleted = true;
                        
                                    /**
                                     * with Error
                                     * Changed Message Parameters
                                     * @type {boolean}
                                     */
                                    if (err) {
                                        title = "Achtung";
                                        message = "Rolle ohne Verein nicht möglich!";
                                        actionCancelTitle = "Ok";
                                    }
                        
                                    else {
                            
                                        // alert(JSON.stringify(Object.keys(this)));
                                        formCompleted = !error;
                                    }
                        
                        
                        
                        
                                    try {
                            
                                        if( formCompleted ){
                                
                                            // Live Data Check
                                
                                            // alert( JSON.stringify(serializedParent));
                                
                                            let ac = new X2Tools().AlertController();
                                            ac.setTitle(title);
                                            ac.setMessage(message);
                                            ac.addAction({
                                                title: actionCancelTitle,
                                                style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                                action: ""
                                            });
                                            if (!err) {
                                                ac.addAction({
                                                    title: "Ok",
                                                    style: ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                                                    action: "javascript:Layout().postBackCompletedRoleForUser(" + JSON.stringify(serializedParent) + ")"
                                        
                                                });
                                            }
                                            ac.show();
                                
                                        }
                            
                            
                                    } catch (e) {
                            
                                        alert(e.message);
                            
                                    }
                        
                        
                                });
                    
                            }
                        } catch (e) {
                            xAlert(e.message, 1912);
                        }
            
            
                    },
                    click: function (El) {
            
                        alert(1);
                        new X2Tools().serializeContent(document.getElementsByTagName("form")[0], function () {
                
                            console.log(this);
                
                            alert(JSON.stringify(this));
                
                        });
            
                    },
                    active:buttonActive
                }).refresh(function (El, ui) {
                    ui.property("enabled", undefined !== buttonActive ? buttonActive : true );
                    // ui.property("enabled", true );
                });
            } catch (e) {
            
            }
        };
        
        this.roleEdit = function () {
    
            let addButton = document.querySelector("input[type=button]#role_edit");
            
            if( null !== addButton ){
    
                new X2Tools().Button(addButton, {
                    touchWith: "end",
                    touch: function (El) {
            
                        // alert("Will edit");
                        // console.log("Element Node Name", document.getElementsByTagName("form")[0].nodeName);
                        // document.write(toString(document.getElementsByTagName("form")[0].outerHTML))
                        try {
                
                            new X2Tools().serializeContent(document.getElementsByTagName("form")[0], function () {
                    
                    
                               // alert(1);
                                // Individually Clubs Rows Serialize
                                let serializedParent = this;
                    
                                // Remove last Added Club And his Teams from Object
                                // delete (serializedParent.club);
                                delete (serializedParent.team);
                                delete (serializedParent.season);
                    
                                // Create Empty Object
                                serializedParent.clubs = [];
    
    
                                
                                try{
                                    
                                    ContextTableView.querySelectorAll("li[data-role='role-clubs']").forEach(function (El) {
        
                                        new X2Tools().serializeContent(El.querySelector("a > div#role-data"), function () {
            
                                            // alert(JSON.stringify(this));
                                            
                                            serializedParent.clubs.push(this);
            
                                        });
        
        
                                    });
                                } catch (e) {
                                
                                }
    
                                
                    
                                // alert(JSON.stringify(serializedParent));
    
                                // return false;
                                Layout().postBackCompletedRoleForUser( serializedParent );
                                
                    
                    
                            });
                
                
                        } catch (e) {
                
                            xAlert(e.message + "\n" + new Error().stack, 2073);
                
                        }
            
            
                    },
                    click: function (El) {
            
                        new X2Tools().serializeContent(document.getElementsByTagName("form")[0], function () {
                
                            console.log(this);
                
                            // alert(JSON.stringify(this));
                
                        });
            
                    }
        
                }).refresh(function (El, ui) {
                    ui.property("disabled", false);
                });
                
                
            }
        
        }
        
        /**
         * @Javascript With AlertController Interface
         * @deprecated
         * @instead of Row Action embedded
         */
        this.removeSelectedClubFromTable = function () {
            
            TableViewSelectedRow.remove();
            
        }
    
    
        /**
         * User Role ready for database
         * Now Add To Database
         */
        this.saveAndAddCompletedRoleForUser = function (data) {
    
            // alert(JSON.stringify(data));
    
            // TODO To Database
    
            let indicator = new X2Tools().ActivityIndicator();
            indicator.show(function () {
        
                let httpRequest = new X2Tools().HttpRequest();
                httpRequest
                    .setController("Role")
                    .setNamespace("manage")
                    .setMethod("add")
                    // .setMethod("prepareClubsDataForRole")
                    .setData(data)
                    // .setActivityIndicator(indicator)
                    .execute(function () {
                
                        // alert(JSON.stringify(this.fetchUserUsedRolesRows));
    
                        indicator.dismiss();
    
                        /**
                         * New Added Role Row
                         */

                        // document.write(this.clubAddQuery);
                        
                        if( !this.showAlert ) {
    
                            L.reloadUserUsedRolesTableView( this );
    
                            L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd);
                            L.setUnwindDataStore("roles_table_should_reload", true);
                            
                        }
                        
                        else {
                            
                            // alert(this.messageBody);
                            let ac = new X2Tools().AlertController();
                            ac
                                .setMessage(this.messageBody)
                                .setTitle(this.messageTitle)
                                .addAction({
                                    title:"Ok",
                                    style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                    action:""
                                })
                                .show();
                        }
                        
                    });
        
        
            });
        }
    
        // {"role=29&register_role=29&status=false&pretty_club_name=FV Dudenhofen&club=2&founding_year=&street=&post_code=&town=&homepage=&email=&facebook=&instagram=&twitter=&youtube=&username=&password=&tac=true&roles_table_should_reload=true&unwindFrom=manage_index&output=json"}
        
    
        /**
         * User Role already removed from Previous View
         * Now fetch User Role from Database
         * And Reload table View
         */
        this.removeUserRoleFromUser = function (data) {
            
            // TODO To Database
        
            if( data.roles_table_should_reload ){
    
                // alert(JSON.stringify(data));
                let indicator = new X2Tools().ActivityIndicator();
                indicator.show(function () {
        
                    let httpRequest = new X2Tools().HttpRequest();
                    httpRequest
                        .setController("Role")
                        .setNamespace("manage")
                        .setMethod("fetchUserPrettyRolesRowsForTableViewReload")
                        .setData(data)
                        .execute(function () {
                
                            indicator.dismiss();
                
                            L.reloadUserUsedRolesTableView( this );
    
                            L.setUnwindDataStore( "unwindFrom", cnt + "_" + nsp + "_" + mtd );
                            L.setUnwindDataStore( "roles_table_should_reload", data.roles_table_should_reload );
                        });
                });
            }
        }
    
        /**
         * User Table view reloading with fresh Data
         * @param data
         */
        this.reloadUserUsedRolesTableView = function(data){
    
            
            // alert(JSON.stringify(data));
    
            try{
    
    
                let fetchUserUsedRolesRows = data.fetchUserUsedRolesRows;
                let elUserUsedRolesTableView = document.getElementById("user_used_roles");
    
                if( !data.total_role ){
    
                    fetchUserUsedRolesRows = ' <div class="container-fluid full-height" >\n' +
                        '            <div class="d-table full-width mt-50" >\n' +
                        '                <div class="d-table-cell text-center font-bold font-italic text-disabled" >\n' +
                        '                    Keine Rolle gefunden!\n' +
                        '                </div>\n' +
                        '            </div>\n' +
                        '        </div>';
                }
    
                // alert(fetchUserUsedRolesRows);
                elUserUsedRolesTableView.innerHTML = fetchUserUsedRolesRows;
    
                new X2Tools()
                    .TableView(elUserUsedRolesTableView,
                        {
                            // searchBar:true, Use data attribute data-with="searchbar"
                            rows: function (cells, ui) {
                                // TODO All Cells Of Table
                            },
                            row: function (cell, cells, ui) {
                                // TODO All Cells Of Table
                            },
                            search: function (TableView, rows, ui) {
                                // TODO All Cells Of Table
                            },
                            sort: {
                                render: true,
                                dataSortKey: "id",
                                dataGroupKey: "group"
                            },
                            badge: true,
                            dataBadgeKey: "badge-value"
                
                        })
                    .create(function (TableView, rows, ui) {
                        // TODO All Cells Of Table
                    });
                
            } catch (e) {
                alert(e.message);
            }
            
            
            
            
        }
        
        
        /**
         * @Javascript Interface
         * @param data
         * @deprecated
         * @use self class not more Settings Class
         */
        this.postBackCompletedRoleForUser = function (data) {
            
            // xAlert("postBackCompletedRoleForUser\n" + JSON.stringify(data));
            
            // TODO -->
            //  To Database On BackView
            //  This On Mange View
            // alert(nsp + "_" + mtd  + "\n \n " + JSON.stringify(data) + "\n \n " + data.user_used_role_id );
            
            if( undefined === data.user_used_role_id){
    
                /**
                 * New Added
                 * Back to Settings General
                 * @type {string}
                 */
                data.unwindFrom = "role";
                
            }
            else {
    
                /**
                 * Edited
                 * Back to Manage Roles Table View
                 * @type {string}
                 */
                data.unwindFrom = nsp + "_" + mtd;
                
            }
            
            // Upper ones crushed
            data.unwindFrom = nsp + "_" + mtd;
            
            
            L.setUnwindDataFromJSONString(JSON.stringify(data));
            new X2Tools().dismissViewController(L.getUnwindDataStore());
            
            
        }
    
    
        /**
         * @JavascriptInterface
         * @deprecated
         * @description After selected DFB teams from DFB Official Page return selected teams with Data
         */
        this.connectMyTeamWithDfbTeamAndGoBack = function() {
    
            try{
                
                let checkedEl = document.querySelectorAll("ul.x2-list input:checked");
                
                // alert(checkedEl.length);
                let link = checkedEl[0].dataset.link;
                let name = checkedEl[0].value;
    
                this.setUnwindDataStore("unwindFrom", nsp +  "_" + mtd);
                this.setUnwindDataStore("name", name);
                this.setUnwindDataStore("link", link);
                new X2Tools().dismissViewController(this.getUnwindDataStore());
            } catch (e) {
                alert(e.message);
            }
            
        
        
        }
    
        /**
         * Completed --
         * Club team ready is selected
         * Club selected team with DFB connection decided
         * Completed --
         * Returned Data from fussball.de like:Team Name on fussball.de and team link on fußball.de
         * Add This data into Cell to ready input hidden elements
         * team_dfb_names[] => for Returned Team name from DFB
         * team_dfb_link[] => for Returned Team link from DFB
         * @param data Returned Data from fussball.de
         */
        this.updateSelectedClubTeamWithDfbConnect = function (data) {
            
            try{
                
                TableViewSelectedRow.querySelector("input[type=hidden][name='team_dfb_name[]']").value = data.name;
                TableViewSelectedRow.querySelector("input[type=hidden][name='team_dfb_link[]']").value = data.link;
                setTimeout(function () {
                    
                    let iconEl = TableViewSelectedRow.querySelector("span#dfb_connect > i");
                    iconEl.classList.remove("text-danger");
                    iconEl.classList.add("text-success");
                    
                    iconEl.classList.remove("icon-unlink3");
                    iconEl.classList.add("icon-link3");
                    
                },1000);
                
            } catch (e) {
                // alert(e.message);
            }
        }
    
    
        /**
         * Update Team group After League selected this unwind operation
         */
        this.updateSelectedTeamGroupCell = function (data) {
            
            try{
                /**
                 * Add Selected League ID to Element
                 */
                TableViewSelectedRow.querySelector("a input#league_id").value = JSON.parse(data.selected_league)[0];
                TableViewSelectedRow.querySelector("a input#pretty_league_name").value = JSON.parse(data.pretty_selected_league_name)[0];
                TableViewSelectedRow.dataset.selected = true;
    
                /**
                 * Update Row Sub Title
                 */
                GlobalTableViewUI.updateRowSubTitle(TableViewSelectedRow, JSON.parse(data.pretty_selected_league_name)[0] );
                
    
                
                
            } catch (e) {
                
                alert(e.message);
                
            }
            
            
            
            
        }
    
    
        /**
         * @deprecated use saveAndAddCompletedRoleForUser
         * @param data
         */
        this.updateUserRolesTableFinally = function (data) {
        
            // alert(JSON.stringify(data));
            
            // Fetch Currently User role from Repository
    
            try {
                let indicator = new X2Tools().ActivityIndicator();
                indicator.show(function () {
            
                    let httpRequest = new X2Tools().HttpRequest();
                    httpRequest
                        .setController("Role")
                        .setMethod("fetchRole")
                        .setNamespace("manage")
                        .setData(data)
                        .execute(function () {
                    
                            
                            indicator.dismiss();
                    
                        
                            let data = this;
                            // alert(JSON.stringify(data));
                            document.querySelectorAll("ul.x2-list li").forEach(function (El) {
                                
                                if( El.dataset.id === data.user_used_role_id){
                                    
                                    El.querySelector("a span#season").innerText = "(" + data.pretty_season + ")";
                                    El.dataset.subTitle = data.pretty_club_name; // Teams no need!
                                    El.querySelector("span[data-role='sub-title']").innerText = data.pretty_club_name;
                                    
                                }
                                
                            });
                            
                            
                    
                        });
            
            
            
                })
            } catch (e) {
                alert(new Error(e.message));
            }
            
            
        
        };
        
        
        this.loadActivityWithData = function (data) {
            
            let activity = data.activity;
            // alert(activity);
            let dataJSONString = JSON.stringify(data);
            if (activity === undefined) {
                activity = ACTIVITY.ACTIVITY_1
            }
            // alert(DEVICE + "://" + activity + "?" + dataJSONString);
            location.href = DEVICE + "://" + activity + "?" + dataJSONString;
            
        };
    
    
        
    
    
        /**
         * Back from Settings Controller
         * Here Moved the data
         * Fetch Added Role data From Database And Reload Page
         */
        this.addClubFromCode = function(data){
            
            try{
    
                let ai = new X2Tools().ActivityIndicator();
                ai.show(function () {
        
                    let httpRequest = new X2Tools().HttpRequest();
                    httpRequest
                        .setController("Role")
                        .setMethod("fetchUserPrettyRolesRowsForTableViewReload")
                        .setNamespace("manage")
                        .setContentType("json")
                        .setData({
                            // user_used_role_id:data.finallyProcessedUserUsingRoleId
                        })
                        .execute(function () {
                
                            ai.dismiss();
    
                            // L.addClubDataToRoleWithBE(this, ai );
                            // Send the data and fetch pretty Row for completed Club!!!
                            // window.location.href = this.redirect ;
                            // alert(this.fetchUserUsedRolesRows);
    
                            
                            L.reloadUserUsedRolesTableView( this );
    
                            L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd);
                            L.setUnwindDataStore("roles_table_should_reload", true);
                            
                            
                            
                        })
    
                    /*let httpRequest = new X2Tools().HttpRequest();
                    httpRequest
                        .setController("Role")
                        .setMethod("index")
                        .setNamespace("manage")
                        .setContentType("json")
                        .setData({
                            user_used_role_id:data.finallyProcessedUserUsingRoleId
                        })
                        .execute(function () {
            
                            ai.dismiss();
                            // alert(this);
                            
                            // document.outerHTML = this;
            
                            // L.addClubDataToRoleWithBE(this, ai );
                            // Send the data and fetch pretty Row for completed Club!!!
                            window.location.href = this.redirect ;
            
                        })*/
        
        
        
                });
                
            } catch (e) {
                alert(e.message);
            }
            
            
            
        }
    
    
        /**
         * Javascript interface
         */
        this.addRoleWithAlertConfirmation = function () {
            
            let x2Tools = new X2Tools();
            
            let ac = new X2Tools().AlertController();
            let ai = x2Tools.ActivityIndicator();
            ai.show(function () {
    
                try{
                    let httpRequest = x2Tools.HttpRequest();
                    httpRequest
                        .setController("Role")
                        .setNamespace("manage")
                        .setMethod("addRoleWithAlertController")
                        .execute(function () {
            
                            
                            ai.dismiss();
            
                            // alert(JSON.stringify(this));
                            ac
                                .setMessage(this.message)
                                .setTitle(this.title)
                                .addAction({
                                    title:this.with_manually.title,
                                    style:ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                                    action:this.with_manually.action
                                })
                                .addAction({
                                    title:this.with_licence.title,
                                    style:ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                                    action:this.with_licence.action
                                })
                                .addAction({
                                    title:"Abbrechen",
                                    style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                    action:""
                                })
                                .show();
            
                        })
                } catch (e) {
                    alert(e.message);
                }
                
            });
        }
    
        /**
         * Javascript interface assigned method addRoleWithAlertConfirmation;
         */
        this.goViewControllerWithRoleAlertController = function (data){
    
            
            let activity = data.activity;
            let dataJSONString = JSON.stringify(data);
            if (activity === undefined) {
                activity = ACTIVITY.ACTIVITY_1
            }
    
            location.href = DEVICE + "://" + activity + "?" + dataJSONString;
            
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
    
        // alert(JSON.stringify(data));
        
        // Role Club Admin Edit Calismiyor
        
        
        /**
         * Android icin String oluyo
         * obje olmasi lazim
         */
        if( typeof data === "string" ){
            data = JSON.parse(data);
        }
        
        
        
        
        /**
         * @description
         * Storing and Moving the data
         * from RightViewController
         * for LeftViewController
         */
        Layout().setUnwindDataFromJSONString(data);
        
        switch (data.unwindFrom) {
            
            /**
             * @description
             * After user Season select
             * Moving data from season View
             * to Current View
             */
            
            
            
            // case "assistant_season":
            case "TableView__season_index":
                try {
                    Layout().updateRowSeason(data);
                } catch (e) {
                    alert(e.message);
                }
                break;
                
            // case "assistant_club":
            case "TableView__clubs_index":
                
                Layout().updateRowClub(data);
                
                break;
            
            // case "assistant_team":
            case "TableView__teams_index":
                
                // xAlert(JSON.stringify(data), 1990);
                
                Layout().updateCellRoleTeam(data);
                
                
                /**
                 * -- ALERT --
                 * Remove all data object elements Previous (assistant_index) view
                 * @description
                 * with this block the data returned from assistant_team select with full need data
                 * On Assistant Index, View Requesting without Save option returning previous view controller
                 * The Original data moved from Role/assistant_team's view to Role/manage_index view with assistant_team's returned data
                 * therefore data must absolutely doing empty for manage_index
                 * [ This option only,  When User will dismiss View Controller Without data saving ]
                 * */
                
                data = {};
                
                Layout().setUnwindDataFromJSONString(data);
                
                break;
    
            case "assistant_sub_teams":
    
    
                // alert(JSON.stringify(data));
                
                Layout().updateCellTeamForSelectedSubTeams( TableView.selectedRow, data );
        
        
                /**
                 * -- ALERT --
                 * Remove all data object elements Previous (assistant_index) view
                 * @description
                 * with this block the data returned from assistant_team select with full need data
                 * On Assistant Index, View Requesting without Save option returning previous view controller
                 * The Original data moved from Role/assistant_team's view to Role/manage_index view with assistant_team's returned data
                 * therefore data must absolutely doing empty for manage_index
                 * [ This option only,  When User will dismiss View Controller Without data saving ]
                 * */
        
                data = {};
        
                Layout().setUnwindDataFromJSONString(data);
        
                break;
            
            case "assistant_index":
                
                Layout().addClubDataToRoleWithBE(data);
                
                
                break;
    
            case "assistant_dfbConnect":
                // alert(JSON.stringify(data));
                Layout().updateSelectedClubTeamWithDfbConnect(data);
        
                break;
    
            /**
             * Return hre after role edit
             * from manage to roles table
             */
            case "manage_index": // Update eUser Tables
        
                // alert(JSON.stringify(data));
                // @deprecated Method
                // Layout().updateUserRolesTableFinally(data);
                
                if( data.action === "user_used_role_remove" ){
                    Layout().removeUserRoleFromUser(data);
                } else {
                    Layout().saveAndAddCompletedRoleForUser(data);
                }
                
                
        
                break;
                
            case "manage":
                
                // TODO User Role Removed and Goto Followed Action
                if (data.action === "user_used_role_remove") {
                    Layout().removeUserRoleFromUserRolesTableView(data.user_removed_role_id);
                }
                break;
                
            case "Settings__code_index":
                
                Layout().addClubFromCode(data);
                break;
                
                
            case "TermsAndConditions":
            
                let val = (data.tac_accepted === 'true');
                try{
    
                    document.querySelector("input[name='tac']").value = val;
                    let saveBut = Layout().roleAdd( val );
                    // saveBut.property("disabled", !val );
    
                    if( val ){
                        document.querySelector("i.tac").classList.remove("icon-circle");
                        document.querySelector("i.tac").classList.add("icon-checkmark-circle");
                    } else {
                        document.querySelector("i.tac").classList.add("icon-circle");
                        document.querySelector("i.tac").classList.remove("icon-checkmark-circle");
                    }
                }
                catch (e) {
                    alert(e.message);
                }
                
                break;
                
            case "Extras__leagues_index":
    
                try{
                    Layout().updateSelectedTeamGroupCell(data);
                    
                } catch (e) {
                    alert(e.message);
                }
                
                
                break;
            
            
        }
        
        
    };

