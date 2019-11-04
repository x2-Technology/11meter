function runnableAction(data){
    try{
        let httpRequest = new X2Tools().HttpRequest();
        httpRequest
            .setController("Role")
            .setNamespace("assistant")
            .setMethod("preparePrettyTableRowsFromSelectedTeamsForClubFromDFB")
            .setData({data:data})
            .execute(function () {
                let returnedRows = this;
                /** * Separate Loaded with* Role/assistant/dfbConnect*/
                GlobalActivityIndicator.dismiss();
                let tableView = document.body.querySelector("div.view-wrapper ul#dfbClubTeams");
                tableView.innerHTML = returnedRows;
                new X2Tools()
                    .TableView(tableView,
                        {
                            searchBar: false,
                            row: function ( row, rows, ui ) {
                                row.ontouchend = function(){
                                    TableViewSelectedRow = this;
                                    try{
                                        let ac = new X2Tools().AlertController();
                                        ac.setMessage("Dein team vorubegehend ausgewahlt?");
                                        ac.setTitle("Was hast zu tun");
                                        ac.addAction({
                                            title:"Bestätigen",
                                            style:ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                                            action:"javascript:new Layout().connectMyTeamWithDfbTeamAndGoBack()"
                                        });
                                        ac.addAction({
                                            title:"Shaue in fussball.de",
                                            style:ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                                            action:"javascript:visitDFBTeam()"
                                        });
                                        ac.addAction({
                                            title:"Schließen",
                                            style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive,
                                            action:""
                                        });
                                        ac.show();
                                    } catch (e) {
                                        alert(e.message);
                                    }
                                }
                            },
                            rows: function (cells, ui) {}
                        })
                    .create( function (_TableView, rows, ui) {
                    });
            });
    } catch (e) {
        alert(e.message);
    }
}

function visitDFBTeam() {
    let data = {};
    data.link = TableViewSelectedRow.querySelector("input").dataset.link;
    data.display_name= "Nothing";
    data["SHARED_INN_APP"] = "SHARED_ADS";
    data.activity= ACTIVITY.ACTIVITY_SHARED;
    let activity = ACTIVITY.ACTIVITY_SHARED;
    let dataJSONString = JSON.stringify(data);
    if (activity === undefined) {activity = ACTIVITY.ACTIVITY_1}
    location.href = DEVICE + "://" + activity + "?" + dataJSONString;
}