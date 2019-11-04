
$(function () {
    new Layout().init();
});

let GlobalFormData = {};
let GlobalTableViewUI = null;

let Layout = function () {
        
        let L = this;
        
        
        
        this.init = function () {
            
            L.prepareTableView();
            L.initButtons();
    
            // alert(cnt + "_" + nsp + "_" + mtd);
            
            if( "Ad_discussion_index" ===  cnt + "_" +  nsp + "_" + mtd ){
                L.discussion();
            }
            
            else if( "Ad_deal__declined_comment_view" ===  cnt + "_" +  nsp + "_" + mtd ){
                
                setTimeout(function () {
                    document.getElementsByTagName("textarea")[0].focus();
                }, 500);
            }
            
            
           
            
            
            
            return this;
        };
        
        this.initButtons = function(){
            
            try {
    
                // Ad Save Button
                new X2Tools().Button(document.querySelector("#ad_save"), {
        
                    touchWith: "end",
                    touch: function (El) {
                        L.checkAd();
                    }
                }).refresh();
            } catch (e) {
            
            }
    
            try {
                // Ad Delete Button
                new X2Tools().Button(document.querySelector("#ad_delete"), {
            
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
        
            } catch (e) {
            }
            
            try {
                // Ad Delete Button
                new X2Tools().Button(document.querySelector("#interested_to_ad"), {
            
                    touchWith: "end",
                    touch: function (El) {
                        L.setInterestedForAd();
                    }
                }).refresh();
        
            } catch (e) {
            }
        };
        
        
        this.prepareTableView = function(){
    
            // alert(cnt + "_" + nsp + "_" + mtd);
            // alert(nsp + " - " + mtd);
            if( nsp === "testplay" && mtd === "manage" )
            {
                try{
                    
                    
                    // Local Declaration
                    let adInLocal                   = document.querySelector("#ad_in_local");
                    let adInLocalAddress            = document.querySelector("#ad_in_local_address");
                    var $placeCoveringLocalEl       = $("#place_covering_local");
                    var placeCoveringLocalRow       = $placeCoveringLocalEl.closest("li")[0];
    
    
                    // Outwards Declaration
                    let adInOutwards                = document.querySelector("#ad_in_outwards");
                    var $adInOutwardsAreaEl         = $("#ad_in_outwards_area");
                    var adInOutwardsAreaRow         = $adInOutwardsAreaEl.closest("li")[0];
                    var $adInOutwardsKmEl           = $("#ad_in_outwards_km");
                    
                    
                    var $placeCoveringOutwardsEl    = $("#place_covering_outwards");
                    var placeCoveringOutwardsRow    = $placeCoveringOutwardsEl.closest("li")[0];
                    
                    
                    
                    new X2Tools()
                        .TableView(document.getElementsByClassName("x2-list")[0],
                            {
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
                
                            GlobalTableViewUI = ui;
                            
                            /// TODO Switch Local
                            
                            adInLocal.onclick = function () {
    
                                
    
                                if(!this.checked){
    
                                    /**
                                     * Empty Address area
                                     * @type {string}
                                     */
                                    adInLocalAddress.value = "";
    
                                    /**
                                     * Find Place Covering for Local
                                     */
                                    
    
                                    /**
                                     * Update Place Covering Row Sub-title to empty
                                     */
                                    GlobalTableViewUI.updateRowSubTitle(placeCoveringLocalRow,"");
    
                                    /**
                                     * Find And Set Input Element Value to empty
                                     */
                                    $placeCoveringLocalEl[0].value = "";
                                    
                                    
                                    
    
                                }
                                
                                else {
    
                                    let isMyTeamSelected = document.querySelector("select#ad_owner_team").value;
    
                                    // alert(isMyTeamSelected);
                                    if( !parseInt(isMyTeamSelected) && !this.closest("li").hasClass("disabled") ){
        
                                        let ac = new X2Tools().AlertController();
                                        ac
                                            .setMessage("Bitte wähle deine Mannschaft")
                                            .setTitle("Achtung")
                                            .addAction({
                                                title:"Ok",
                                                style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                                action:""
                                            }).show();
        
                                        return false;
        
                                    }
    
                                    adInLocalAddress.value = adInLocalAddress.placeholder;
                                    
                                }
    
                                GlobalTableViewUI.rowProperty("disabled", [adInLocalAddress.parentNode, placeCoveringLocalRow], !this.checked );
                            };
                
                            
                            /// TODO Switch Outwards
                            
                            adInOutwards.onclick = function () {
                                
                                
                                if(!this.checked){
                                    
    
                                    /**
                                     * Find Place in outwards area Element value to empty
                                     * @type {string}
                                     */
                                    $adInOutwardsAreaEl.innerHTML = "<option value='0'></option>";
    
    
                                    /**
                                     * Find Place in outwards km Element value to empty
                                     * @type {string}
                                     */
                                    $adInOutwardsKmEl.value = "";
    
    
                                    /**
                                     * Update Ad in Outwards Area Outwards Row Sub-title to Empty
                                     */
                                    GlobalTableViewUI.updateRowSubTitle(adInOutwardsAreaRow, "");
                                    
                                    /**
                                     * Update Place Covering Outwards Row Sub-title to Empty
                                     */
                                    GlobalTableViewUI.updateRowSubTitle(placeCoveringOutwardsRow, "");
    
    
                                    /**
                                     * Find And Set Place Covering Outwards Input Element Value to empty
                                     */
                                    $placeCoveringOutwardsEl.value = "";
                                    
    
    
                                }

                                else {
    
                                    let isMyTeamSelected = document.querySelector("select#ad_owner_team").value;
                                    
                                    // alert(isMyTeamSelected);
                                    if( !parseInt(isMyTeamSelected) && !this.closest("li").hasClass("disabled") ){
                                        
                                        let ac = new X2Tools().AlertController();
                                        ac
                                            .setMessage("Bitte wähle deine Mannschaft")
                                            .setTitle("Achtung")
                                            .addAction({
                                                title:"Ok",
                                                style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                                action:""
                                            }).show();
                                        
                                        return false;
                                        
                                    }
                                    
                                    
                                    
                                }
    
                                GlobalTableViewUI.rowProperty("disabled", [placeCoveringOutwardsRow, adInOutwardsAreaRow], !this.checked );
                                
                            }
                
                
                            // Check Error
                            try{
                    
                                let errorEl = document.querySelector("[data-role='role-error']");
                                // alert(errorEl.dataset.message);
                                if( undefined !== errorEl && null !== errorEl ){
                        
                                    let ac = new X2Tools().AlertController();
                                    ac
                                        .setTitle("Fehler")
                                        .setMessage(errorEl.dataset.message)
                                        .addAction({
                                            title:"Ok",
                                            style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                            action:"javascript:new X2Tools().dismissViewController();"
                                            // action:"javascript:dismissViewController('{}');"
                                        })
                                        .show();
                                }
                    
                                
                                
                            } catch (e) {
                                alert(e.message + "\n" + e.stack);
                            }
                            
                            
                            
                            try{
                                
                                let myTeamsEl = document.querySelector("#ad_owner_team");
    
                                myTeamsEl.onchange = function(){
                                    L.fetchTownSuggestionAsMyTeams(this.value);
                                }
                                L.fetchTownSuggestionAsMyTeams(myTeamsEl.value);
    
                                
    
                                
                                
                            } catch (e) {
                            
                            }
                            
                            
                
                        });
    
                    
                        GlobalTableViewUI.rowProperty("disabled", [adInLocalAddress.parentNode, placeCoveringLocalRow], !adInLocal.checked );
                        
                        
                        try{
                            GlobalTableViewUI.rowProperty("disabled", [placeCoveringOutwardsRow, adInOutwardsAreaRow], !adInOutwards.checked );
                        } catch (e) {
                        
                        }
                        
                }
                catch (e) {
                    alert(e.message + "\n" + e.stack);
                }
            }

            else if( nsp === "deal" && mtd === "index" ){
                
    
    
                // DEAL BUTTONS
                let acceptButton    = document.querySelector("button#accept");
                let declineButton   = document.querySelector("button#decline");
    
                new X2Tools().Button( acceptButton, {
                    touchWith: "end",
                    touch: function (El) {
                        adDealConfirmation(true);
                    },
                    click:function () {}
                }).refresh();
    
                new X2Tools().Button( declineButton, {
                    touchWith: "end",
                    touch: function (El) {
                        adDealConfirmation(false);
                    },
                    click:function () {}
                }).refresh();
    
                function adDealConfirmation(deal) {
        
                    try{
                        let message = "Möchten Sie diese Vereinbarung mit bestimmte data bestätigen?";
                        let okButtonText = "Annehme";
                        let okAction = "javascript:Layout().confirmedAdDealWithUserChoose(" + deal + ")";
                        if( !deal ){
                            message = "Möchten Sie diese Vereinbarung ablehnen?";
                            okButtonText = "Ablehne";
                            okAction = "javascript:Layout().addAdDeclinedComment()"
                        }
            
            
                        let ac = new X2Tools().AlertController();
                        ac
                            .setTitle("Vereinbarung")
                            .setMessage(message)
                            .addAction({
                                title:"Cancel",
                                style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                action:""
                            })
                            .addAction({
                                title:okButtonText,
                                style:ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                                action: okAction
                            })
                            .show();
                    } catch (e) {
                        alert(e.message);
                    }
        
                }
    
    
    
            }

            /**
             * From which Namespace ????
             */
            else if( mtd === "myAds" ){
            
    
    
                new X2Tools()
                    .TableView(document.getElementsByClassName("x2-list")[0],
                        {
                            rows:function(cells, ui){},
                            row:function(cell, cells, ui){},
                            sort: {
                                render: true,
                                dataSortKey: "id",
                                dataGroupKey: "group"
                            },
                            badge: true,
                            dataBadgeKey: "badge-value"
                
                        })
                    .create( function ( TableView, rows, ui ) {});
                
            }

            /**
             * From which Namespace ????
             */
            else if( mtd === "index"  ){
    
    
                try {
                    new X2Tools()
                        .TableView(document.getElementsByClassName("x2-list")[0],
                            {
                                rows:function(cells, ui){},
                                row:function(cell, cells, ui){}
                            })
                        .create( function ( TableView, rows, ui ) {});
                }catch (e) {
                    alert(e.message);
                }
    
                try {
                    new X2Tools()
                        .TableView(document.getElementsByClassName("x2-list")[1],
                            {
                                rows:function(cells, ui){},
                                row:function(cell, cells, ui){}
                            })
                        .create( function ( TableView, rows, ui ) {});
                }catch (e) {
                    alert(e.message);
                }
    
            }

            else if( nsp === "search" && mtd === "detailsView" ){
    
    
                
                try {
                    new X2Tools()
                        .TableView(document.getElementsByClassName("x2-list")[0],
                            {
                                rows:function(cells, ui){},
                                row:function(cell, cells, ui){}
                            })
                        .create( function ( TableView, rows, ui ) {});
                }catch (e) {
                    alert(e.message);
                }
    
    
    
            }
            
            
            
            
            
            
    
            
            
            
            
            
            
            
        }
        
        /*
            User determined that Interested to Ad
         */
        this.setInterestedForAd = function () {
            
            
            new X2Tools().serializeContent(document.querySelector("ul#team-select"), function(error){
                
                
                if( error ){
                    return false;
                }
                
                // alert(JSON.stringify(this));
                
                //
                let myTeamEl = document.querySelector("select#interested_team");
                
                
                let message = "Haben Sie Interesse an diese Anzeige?";
                let title   = "Interesse";
                let cancelAction = "";
                
                if( parseInt(myTeamEl.value) === 0 ){
                    
                    message = "Bitte wähle deine Mannschaft";
                    title   = "Achtung";
                    // cancelAction = "javascript:document.getElementById(\"interested_team\").focus();"
                }
                
                
                let ac = new X2Tools().AlertController();
                ac
                    .setTitle(title)
                    .setMessage(message);
                ac.addAction({
                    title: "Cancel",
                    style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                    action: cancelAction
                });
                if( parseInt(myTeamEl.value) !== 0 ){
                    
                    ac.addAction({
                        title: "Ok",
                        style: ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                        action:"javascript:Layout().setInterestedAdForUser(" + JSON.stringify(this) + ")"
                    })
                    
                }
                ac.show();
                
                
            });
            
            
            
            
        }
        
        this.setInterestedAdForUser = function (userSelectedTeam) {
    
            let ai = new X2Tools().ActivityIndicator();
            ai.show(function () {
                
                let httpRequest = new X2Tools().HttpRequest();
                httpRequest
                    .setController("Ad")
                    .setNamespace("ads")
                    .setMethod("userInterestedTheAd")
                    .setData(userSelectedTeam)
                    .execute(function () {
                        
                        if( this.resulta ){
                            
                            L.setUnwindDataStore("ad_id", this.ad_id);
                            L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd);
                            L.setUnwindDataStore("set_interested", this.process );
                            new X2Tools().dismissViewController(L.getUnwindDataStore());
                            
                        } else {
                            
                            let ac = new X2Tools().AlertController();
                            ac.setTitle("Fehler " + this.errCode);
                            ac.setMessage(this.errInfo)
                                .addAction({
                                    title:"Schließen",
                                    style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                    action:""
                                })
                                .show();
                            
                            
                        }
                        
                        
                        
                    
                    });
                
                
            })
            
            
        }
        
        /***
         * JS Unwind operation
         * Set Interested Icon Show or Hide
         */
        this.setTargetAdAsInterestedFromUnwind = function (data) {
            
            try{
                // alert( data["ad_id"]);
                let adsTable = document.querySelectorAll("ul.x2-list")[0];
    
                let targetAdCell = adsTable.querySelector("li#ad_" + data["ad_id"]);
                
                let targetAdCellInterestedIcon = targetAdCell.querySelector("span#interested-icon");
                
                if( data.set_interested ){
                    targetAdCellInterestedIcon.classList.remove("d-none");
                } else {
                    targetAdCellInterestedIcon.classList.add("d-none");
                }
            } catch (e) {
                alert(e.stack);
            }
            
        }
        
        
        
        
        this.discussion = function () {
    
            try{
        
                let discussionsEL   = document.getElementById("discussions");
                let adDetails       = document.getElementById("ad-details");
                let adDeal          = document.getElementById("ad-status");
                let chatFooter      = document.getElementById("chat-footer");
        
                if( null !== adDetails && undefined !== adDetails ){
                    let adDetailsH  = adDetails.offsetHeight;
                    let adDealH     = adDeal.offsetHeight;
                    let chatFooterH = chatFooter.offsetHeight;
                    discussionsEL.style.height = "calc(100% - " + ( adDetailsH + chatFooterH + adDealH ) + "px)";
                }
    
                discussionsEL.scrollTop = discussionsEL.scrollHeight;
                /*$(discussionsEL).animate({
                    scrollTop:discussionsEL.scrollHeight
                },1000,  function () {
            
                });*/
        
                let sendButton  = document.querySelector("button#send-message");
                if( undefined !== sendButton && null !== sendButton ){
            
                    new X2Tools().Button(sendButton, {
                
                        touchWith: "end",
                        touch: function (El) {
                    
                    
                    
                            new X2Tools().serializeContent(sendButton.closest("form"),function (error) {
                        
                        
                                if( undefined === this.message ){
                                    return false
                                }
                        
                                if( !this.message.trim().length ){
                                    return false;
                                }
                        
                                indicator(true);
                                let httpRequest = new X2Tools().HttpRequest();
                                let data = this;
                        
                                setTimeout(function () {
                            
                                    httpRequest
                                        .setController("Ad")
                                        .setNamespace("discussion")
                                        .setMethod("sendMessage")
                                        .setData(data)
                                        .execute(function () {
                                    
                                            try{
                                                let virtualDisEl = document.createElement("div");
                                                virtualDisEl.innerHTML = this;
                                        
                                                // alert(virtualDisEl.firstChild.innerHTML);
                                                discussionsEL.insertAdjacentHTML('beforeend', this );
                                        
                                                // discussionsEL.scrollTop = discussionsEL.scrollHeight;
                                        
                                                $(discussionsEL).animate({
                                                    scrollTop:discussionsEL.scrollHeight
                                                },500);
                                        
                                                let messageEl = document.querySelector("#message-field");
                                                messageEl.value = "";
                                        
                                            }catch (e) {
                                                alert(e.stack)
                                            }
                                    
                                            indicator(false);
                                    
                                        });
                            
                            
                                }, 100);
                        
                        
                        
                        
                        
                                /*let ac = new X2Tools().AlertController();
                                ac
                                    .setTitle("Löschen")
                                    .setMessage(JSON.stringify(this))
                                    .addAction({
                                        title: "Cancel",
                                        style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                        action: ""
                                    })
                                    .addAction({
                                        title: "Ok",
                                        style: ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                                        action: ""
                                    })
                                    .show();*/
                        
                            })
                    
                        },
                        click:function () {
                    
                        }
                
                
                    }).refresh();
            
                    function indicator(status) {
                
                
                        if( status ){
                            sendButton.querySelector("i").classList.remove("d-block");
                            sendButton.querySelector("i").classList.add("d-none");
                    
                            sendButton.querySelector("span#chat-indicator").classList.remove("d-none");
                            // sendButton.querySelector("span#chat-indicator").classList.add("d-table");
                    
                        } else {
                            sendButton.querySelector("i").classList.add("d-block");
                            sendButton.querySelector("i").classList.remove("d-none");
                    
                            sendButton.querySelector("span#chat-indicator").classList.add("d-none");
                            // sendButton.querySelector("span#chat-indicator").classList.remove("d-table");
                        }
                
                
                    }
            
            
                }
    
    
    
    
                
                
                
                
                
                
                
                
        
        
        
            } catch (e){
                alert(e.stack);
            }
            
            
        }
        
        
        /**
         * @Javascript Interface
         */
        this.addNewAd = function (data) {
    
            if( "string" === typeof data){
                data = JSON.parse(data);
            }
            
            
            let activity = data.activity;
            let dataJSONString = JSON.stringify(data);
            if (activity === undefined) {
                activity = ACTIVITY.ACTIVITY_1
            }
    
            location.href = DEVICE + "://" + activity + "?" + dataJSONString;
            
            
        }
        
        /**
         * @Javascript Interface
         */
        this.adEdit = function () {
            
            try{
                
                let httpRequest = new X2Tools().HttpRequest();
                httpRequest
                    .setController("Ad")
                    .setNamespace("ads")
                    .setMethod("getAdViewControllerData")
                    // .setData()
                    .setLocalActivityIndicator(true)
                    .execute(function () {
                        
                        let activity = this.activity;
                        let dataJSONString = JSON.stringify(this);
                        if (activity === undefined) {
                            activity = ACTIVITY.ACTIVITY_1
                        }
        
                        location.href = DEVICE + "://" + activity + "?" + dataJSONString;
            
                    })
                
                
            } catch(e){
                
                alert(JSON.stringify(e.message));
                
            }
            
            
            
            
            
            
            
        }
        
        /**
         * @Javascript Interface
         */
        this.collectAdDataAndAddToDatabase = function (data) {
            
            
            new X2Tools().serializeContent(document.querySelector("ul.x2-list"), function (error) {
               
                if( error ){
                    
                    xAlert("Error with Form")
                    
                } else {
                    
                    xAlert(JSON.stringify(this));
                    
                }
                
                
            });
            
            
            
            
        }
        
        
        
        
        
        this.updateRowOpponentTeam = function (data) {
            
            // xAlert(JSON.stringify(data), 1206);
            // return false;
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
                                // alert(opponentTeamEl);
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
        
        this.updateRowTrainerTeams = function (data) {
            
            
            // alert(JSON.stringify(data));
            
            try{
                let teamsContainer = TableViewSelectedRow.querySelector("div#teams");
    
                let teams = JSON.parse(data.team);
    
                // alert(teams.length);
    
                if( teams.length ){
        
                    teamsContainer.innerHTML = "";
                    
                    rowSubTitle = [];
        
                    for( let team in teams ) { // Teams
            
                        // Hidden Element For Selected Team
                        let inputH = document.createElement("input");
                        inputH.name = "team[]";
                        inputH.type = "hidden";
                        inputH.value = teams[team].database;
            
                        // Display or Layout Element For Selected Team
                        rowSubTitle.push(teams[team].display);
                        
                        teamsContainer.appendChild(inputH);
                        
                    }
                    
                    GlobalTableViewUI.updateRowSubTitle(TableViewSelectedRow, rowSubTitle.join("<br/>"))
                    
        
        
                }
            }
            catch (e) {
                jsException(e);
            }
    
            
        };
        
        
        this.updateRowLeague = function (data) {
            
            // alert(JSON.stringify(data));
            // return false;
            try {
    
    
                let selectedLeague              = JSON.parse(data.selected_league);
                let prettySelectedLeagueName    = JSON.parse(data.pretty_selected_league_name);
                
                let teamsLeaguesContainer       = document.querySelector("div#teams_leagues");
                    // leagueEl.value  = JSON.stringify(selectedLeague);
    
                /**
                 * Create and Append League Element Container
                 * @type {null}
                 */
                let leagueEl = null;
                for(let i in selectedLeague ){
    
                    leagueEl = document.createElement("input");
                    leagueEl.type  = "hidden";
                    leagueEl.value  = selectedLeague[i];
                    leagueEl.name   = "opponent_team_league[]";
                    leagueEl.id     = "opponent_team_league_" + selectedLeague[i];
    
                    teamsLeaguesContainer.appendChild(leagueEl);
                
                }
                
                
                    
    
                GlobalTableViewUI.updateRowSubTitle(
                    leagueEl.parentNode.parentNode,
                    prettySelectedLeagueName.join(", ")
                );
    
    
                
                /*let indicator = new X2Tools().ActivityIndicator();
                indicator.show(function () {
                    
                    let httpRequest = new X2Tools().HttpRequest();
                    httpRequest
                        .setController("Ad")
                        .setMethod("selectedLeagues")
                        .setNamespace("testplay")
                        .setData({
                            selected_league    :data.selected_league,
                        })
                        .execute(function () {
                            
                            // alert(JSON.stringify(this));
                            
                            let combinationHTML  = [];
                            let combinationValue = [];
                            for (let league in this){
                                combinationHTML.push(this[league].name);
                                combinationValue.push(this[league].id);
                            }
                            
                            
                            
                            let opponentLeagueEl = document.querySelector("select#opponent_league");
                            if( undefined !== opponentLeagueEl && null !== opponentLeagueEl ){
                                opponentLeagueEl.innerHTML = "<option value='" + combinationValue.join(",") + "'>" + combinationHTML.join(", ") + "</option>";
                            }
                            
                            
                            indicator.dismiss();
                            
                            
                        })
                        .error(function () {
                            
                            alert("Hata");
                        
                        });
                    
                });*/
                
                
                
            } catch (e) {
                
                xAlert(e.message);
                
            }
            
        };
        
        /**
         * Select selected option
         */
        this.fetchTownSuggestionAsMyTeams = function ( clubId ) {
    
            if( undefined !== clubId && null !== clubId && clubId ){
    
                
                clubId = clubId.split(",");
                
                // alert(clubId[0]);
                
                let httpRequest = new X2Tools().HttpRequest();
                httpRequest
                    .setLocalActivityIndicator(true)
                    .setController("Ad")
                    .setNamespace("testplay")
                    .setMethod("fetchLocalClubsWithDataOfClubTown")
                    .setData({
                        club_id:clubId[0]
                    })
                    .execute(function () {
                        
                        try{
                            
                            // let firstObjKey = Object.keys(this.local_clubs)[0];
                            // alert(this.environment_view_controller_data);
                            // Set Default Address
                            
                            // alert(JSON.stringify(this));
                            if( null !== this.club_street && "" === adInLocalAddress.value ){
                                let adInLocalAddress = document.querySelector("#ad_in_local_address");
                                adInLocalAddress.value = this.club_street;
                                adInLocalAddress.placeholder = this.club_street;
                            
                                // Set Default Postcode and Town
                                let environmentViewControllerEl = document.querySelector("a[data-role='environment']");
                                environmentViewControllerEl.dataset.data = this.environment_view_controller_data;
                            }
                            
                            
                        } catch (e) {
                            // alert(e.message);
                        }
                        
                        
                    })
                
            }
            
        
        
        }
        
        
        this.updateRowTimeSuggestion = function (data) {
        
            
            let adSuggestionEl  = document.querySelector("select#ad_suggestion");
            let adTimeEl        = document.querySelector("input#ad_time");
            let ad_time         = parseInt(data.ad_suggestion) === 1 ? data.ad_time : data.pretty_ad_suggestion_name;
            
            adSuggestionEl.innerHTML = "<option value='" + data.ad_suggestion + "'>" + ad_time+ "</option>";
            adTimeEl.value = parseInt(data.ad_suggestion) === 1 ? data.ad_time : "";
            
            
        
        }
        
        this.updateRowEnvironment = function (data) {
            
            let adEnvironmentArea  = document.querySelector("select#ad_in_outwards_area");
            let adEnvironmentMaxKm = document.querySelector("input#ad_in_outwards_km");
    
            let stringEnvironment = data.pretty_environment_area + ", Umgebung max.:" + data.environment_area_km + " km";
    
            adEnvironmentArea.innerHTML = "<option value='" + data.environment_area_id + "'></option>";
            adEnvironmentMaxKm.value = data.environment_area_km;
            
            GlobalTableViewUI.updateRowSubTitle( adEnvironmentArea.parentNode.parentNode, stringEnvironment );

        }
        
        /**
         * Unwind Operation
         * @param data
         * UPDATE PLACE COVERING
         */
        this.updateRowPlaceCovering = function (data) {
    
           
            try{
    
    
                let httpRequest = new X2Tools().HttpRequest();
                httpRequest
                    .setController("Extras")
                    .setNamespace("_place_covering")
                    .setMethod("fetchPlaceCovering")
                    .setLocalActivityIndicator(true)
                    .setData({
                        place_covering:data.place_covering
                    })
                    .execute(function () {
            
                        // Update Selected Place Covering Row this 2 Possibility
    
                        let placeCoveringCell = document.querySelector("li#"+ data.place_covering_for);
                        
                        try{
                            if( this.ids.length ){
                                
                                // Remove already added Place Covering Elements
                                placeCoveringCell.querySelectorAll("input[name='" + data.place_covering_for + "[]" + "']").forEach(function (El) {
                                    El.remove();
                                });
                                
                                
                                // Create Place Covering Elements
                                for(let id in this.ids){
            
                                    let input = document.createElement("input");
                                    input.type = "hidden";
                                    input.name = data.place_covering_for + "[]";
                                    input.value = this.ids[id];
            
                                    placeCoveringCell.querySelector("a").appendChild(input);
                                }
                            }
                        } catch (e) {
                            alert(e.message);
                        }
            
            
                        /*
                        alert(JSON.stringify(this));
                        let placeCoveringEl    = document.querySelector("input#" + data.place_covering_for);
                        // placeCoveringEl.innerHTML  = "<option value='" + JSON.stringify(this.ids) + "'>" + this.pretty_names + "</option>";
                        placeCoveringEl.value = JSON.stringify(this.ids);
                        */
            
                        GlobalTableViewUI.updateRowSubTitle(
                            placeCoveringCell,
                            this.pretty_names.join(", ")
                        );
            
            
                    })
                
                
            } catch (e) {
                alert(e.message);
            }
            
            
            
            
            
            
        }
        
        this.updateRowRequiredTeams = function (data) {
            
            
            try{
                // Connect to Rapository
                let httpRequest  = new X2Tools().HttpRequest();
                httpRequest
                    .setController("TeamsCard")
                    .setNamespace("!")
                    .setMethod("getFinallyCardTeamItemsFromRepository")
                    .setData({
                        card_teams:data.card_teams
                    })
                    .setLocalActivityIndicator(true)
                    .execute(function () {
            
                        /*// Update Teams Row
                        */
            
                        try{
                            // alert(JSON.stringify(this));
                            let finallyTeamsWithPrettyContent = this.finallyPrettyElements;
                            let OpponentTeamsRow = document.querySelector("ul.x2-list li#opponent_team");
                            GlobalTableViewUI.updateRowSubTitle(OpponentTeamsRow, finallyTeamsWithPrettyContent);
                            
                            
                        } catch (e) {
                            
                            alert(e.message);
                        }
            
            
                    });
            }
            catch (e) {
                xAlert(e.stack);
            }
            
            
            
        }
        
        this.checkAd = function () {
            
            
            try{
                new X2Tools().serializeContent(document.getElementsByTagName("form")[0],function(error){
        
                    
                    if(!error){
    
                        // alert("Alles Ok!" + JSON.stringify(this));
                        GlobalFormData = this;
                        L.decisionAd();
                        
                    } else {
                        // alert("Error!");
                    }
        
        
                });
            } catch (e) {
                alert(e.message);
            }
            
            
            
        }
        
        this.decisionAd = function () {
    
            // alert("Alles Ok!" + JSON.stringify(GlobalFormData));
            
            let ac = new X2Tools().AlertController();
            ac
                .setTitle("Was haben Sie tun?")
                .setMessage("Möchten Sie Ilan speichern")
                .addAction({
                    title:"Cancel",
                    style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                    action:""
                })
                .addAction({
                    title:"Ok",
                    style:ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                    action:"javascript:Layout().createAd();"
                })
                
                .show();
            
            
        }
        
        
        this.createAd = function () {
        
            let httpRequest = new X2Tools().HttpRequest();
            let activityIndicator = new X2Tools().ActivityIndicator();
            activityIndicator.show(function () {
    
                httpRequest
                    .setController("Ad")
                    // .setLocalActivityIndicator(true)
                    .setNamespace("testplay")
                    .setMethod("create")
                    .setData(GlobalFormData)
                    .execute(function () {
                        
                        try{
                            
                            activityIndicator.dismiss();
    
                            if( this.resulta ){
                                
                                L.setUnwindDataStore("unwindFrom", cnt + "_" + mtd + "_" + nsp );
                                L.setUnwindDataStore("ad_partners_id", this.ad_partners_id );
    
                                // alert(JSON.stringify(L.getUnwindDataStore()));
                                new X2Tools().dismissViewController(L.getUnwindDataStore())
                                
                                
                            } else {
                                
                                let ac = new X2Tools().AlertController();
                                ac.setMessage(this.message);
                                ac.setTitle("Fehler");
                                ac.addAction({
                                    title:"Ok",
                                    style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                    action:""
                                });
                                ac.show();
                                
                                
                            }
                            
                            
                            
                            
        
                        } catch (e) {
                            alert(e.message);
                        }
                        
                        
            
            
                    })
                    .error(function () {
            
                    })
                    .fail(function () {
            
                    });
                
            });
            
        
        }
        
        
        this.updateAdDetailsWithDiscussionsHeader = function (data) {
            
            // alert(JSON.stringify(data));
            
            let headerCellEl = document.querySelector("ul#ad-details");
            let statusCellEl = document.querySelector("ul#ad-status");

            let httpRequest = new X2Tools().HttpRequest();
            httpRequest
                .setController("Ad")
                .setLocalActivityIndicator(true)
                .setNamespace("discussion")
                .setMethod("getUpdatedHeaderWithPrettyContent")
                .setData(data)
                .execute(function () {
                    
                    // alert(JSON.stringify(this));
                    
                    headerCellEl.innerHTML = this.header;
                    statusCellEl.innerHTML = this.status;
    
                    // Refresh Status Cell
                    try {
                        new X2Tools()
                            .TableView(document.getElementsByClassName("x2-list")[1],
                                {
                                    rows:function(cells, ui){},
                                    row:function(cell, cells, ui){}
                                })
                            .create( function ( TableView, rows, ui ) {});
                    }catch (e) {
                        alert(e.message);
                    }
                    
                    
                    L.setUnwindDataStore("unwindFrom", cnt + '_' + nsp + '_' + mtd );
                    L.setUnwindDataStore("ad_data", this.ad_data);
                    L.setUnwindDataStore("update_target_cell_with_data", this.ad_data);
                    
                    
                })
                .error(function () {
            
                })
                .fail(function () {
            
                });
        }
        
        
        /**
         * Finally
         * After User choosed the Ad Deal
         * Either Accepted or Declined
         * @param confirmation
         * @param comment
         */
        this.confirmedAdDealWithUserChoose = function( confirmation, comment  ) {
            
            
            /// !!!INFO
            /// ad_partners_id ? !!! calling from repository, while ad in repository
            // @@alert(2234);
            let httpRequest = new X2Tools().HttpRequest();
            let ai = new X2Tools().ActivityIndicator();
            ai.show(function () {
                httpRequest
                    .setController("Ad")
                    .setNamespace("deal")
                    .setMethod("adPrivateDealWithConfirmation")
                    .setData({
                        confirmation:confirmation,
                        comment:comment !== undefined && null !== comment ? comment:null
                    })
        
                    .execute(function () {
                        
                        ai.dismiss();
                        
                        L.setUnwindDataFromJSONString(JSON.stringify(this));
                        L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd );
                        
                        new X2Tools().dismissViewController();
            
            
            
                    })
            })
        }
        
        
        /**
         * Before than unwind goto Comment view Controller
         * And take Comment for declined Ad
         */
        this.addAdDeclinedComment = function (data) {
    
            let httpRequest = new X2Tools().HttpRequest();
            let ai = new X2Tools().ActivityIndicator();
            ai.show(function () {
                httpRequest
                    .setController("Ad")
                    .setNamespace("deal")
                    .setMethod("adDeclinedCommentViewControllerData")
                    .execute(function () {
                
                        ai.dismiss();
                        
                        let data = this;
    
                        let activity = data.activity;
                        let dataJSONString = JSON.stringify(data);
                        if (activity === undefined) {
                            activity = ACTIVITY.ACTIVITY_1
                        }
    
                        location.href = DEVICE + "://" + activity + "?" + dataJSONString;
                
                
                
                    })
            })
    
            
            
        }
        
        /**
         * JS unwind function
         * After user added his comment for declined ad than unwind
         * to prevent view controller with data
         */
        this.determinedAdDeclinedCommentAndUnwind = function () {
            
            new X2Tools().serializeContent(document.querySelector("ul"), function(error){
                
                if( !error ){
                    L.setUnwindDataFromJSONString(JSON.stringify(this));
                    L.setUnwindDataStore("unwindFrom", cnt + "_" + nsp + "_" + mtd );
                    new X2Tools().dismissViewController(L.getUnwindDataStore());
                }
                
            })
            
            
            
            
        }
        
        /**
         * JS unwind function
         * After user added his comment for declined ad than unwind
         * to prevent view controller with data
         */
        this.updateTargetPrivateCellAfterStatusChangedWithData = function (data) {
    
            
            try{
    
                let targetCell          = document.querySelector("li#ad_" + data.ad_id );
                let httpRequest         = new X2Tools().HttpRequest();
    
                httpRequest
                    .setController("Ad")
                    .setLocalActivityIndicator(true)
                    .setNamespace("ads")
                    .setMethod("updatedPrivateAdCellViaUser")
                    .setData({
                        ad_data:data
                    })
                    .execute(function () {
            
                        
                        // alert(JSON.stringify(this.ad_data));
                        
                        let virtualCell = document.createElement("div");
                        virtualCell.innerHTML = this.cell;
                        
                        targetCell.innerHTML    = virtualCell.firstChild.innerHTML;
            
                        // Refresh Status Cell
                        try {
                            new X2Tools()
                                .TableView(document.getElementsByClassName("x2-list")[0],
                                    {
                                        rows:function(cells, ui){},
                                        row:function(cell, cells, ui){}
                                    })
                                .create( function ( TableView, rows, ui ) {});
                        }catch (e) {
                            alert(e.message);
                        }
            
            
                    })
                
            } catch (e) {
                alert(e.message + "\n" + e.stack)
            }
            
            
            
            
        }
        
        
        /**
         * Search View Unwind from filtered search data
         */
        this.unwindWithFilteredDataForAdSearch = function () {
            new X2Tools().dismissViewController(L.getUnwindDataStore());
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
    
        switch (data.unwindFrom) {
            
            /*case "assistant_team":
                
                new Layout().updateRowOpponentTeam(data);
                
                break;*/
    
            case "TableView__teams_index":
        
                new Layout().updateRowOpponentTeam(data);
        
                break;
                
                
            case "TableView__trainer_teams_index":
        
                new Layout().updateRowTrainerTeams(data);
        
                break;
    
    
            case "TableView__leagues_index":
        
                new Layout().updateRowLeague(data);
        
                break;
    
            case "TableView__time_suggestion_index":
        
                new Layout().updateRowTimeSuggestion(data);
        
                break;
    
            case "TableView__environment_index":
        
                new Layout().updateRowEnvironment(data);
        
                break;
    
            case "TableView__place_covering_index":
        
                new Layout().updateRowPlaceCovering(data);
        
                break;
    
            case "TeamsCard_!_index":
        
                new Layout().updateRowRequiredTeams(data);
        
                break;
    
    
            /**
             * By New Add unwind to List
             * because of this is error;
             * For Update or Status Change
             */
            case "Ad_manage_testplay":
        
                if( undefined !== data.ad_partners_id && null !== data.ad_partners_id ){
                    new Layout().updateAdDetailsWithDiscussionsHeader(data);
                }
                
                else {
                    
                    // Unwind to List
                    window.location.reload(true);
                    
                }
                
                
        
                break;
    
    
            case "Ad_deal_index":
        
                new Layout().updateAdDetailsWithDiscussionsHeader(data);
        
                break;
                
            case "Ad_deal__declined_comment_view":
                
                new Layout().confirmedAdDealWithUserChoose(false, data.comment);
                
                break;
    
    
            case "Ad_search_detailsView":
        
                new Layout().setTargetAdAsInterestedFromUnwind(data);
        
                break;
    
            case "Ad_discussion_index":
        
                if( undefined !== data.update_target_cell_with_data && data.update_target_cell_with_data ){
                    new Layout().updateTargetPrivateCellAfterStatusChangedWithData(data.ad_data);
                }
    
            
        
                break;
    
            
                
            
        }
    
    };