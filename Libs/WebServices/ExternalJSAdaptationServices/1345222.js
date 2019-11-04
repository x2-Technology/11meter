var newAddedClubData = {};
function runnableAction(data){
    try{
        
        GlobalActivityIndicator.dismiss();
        if( typeof data === "string" ){
            data = JSON.parse(data);
        }
        /**
         * This Variable movement work only by ios
         * Android wont not
         * Android work only with movement data with cookie
         * newAddedClubData = data;
         * Finally for 2 device successfully data transfer with cookie
         * @type {X2Tools|X2Tools|X2Tools}
         */
        let x2 = new X2Tools();
        x2.setCookie("newAddedClubData", JSON.stringify(data));
        
        let title = "Gefundene Verein";
        let message = "Ich habe folgende verein gefunden\n" + data.teamName  + "\n möchten Sie diese Verein auswählen?";
        let cancelActionTitle = "Abbrechen";
        if( null === data.teamName ){
            title = "Möglicherweise";
            message = "* Link stimmt nicht!\n * Verbindung mit fußball.de untergebrochen!\n\nBitte versuchen mit richtige Vereinsseite link!";
            cancelActionTitle = "Schließen";
        }
    
        let ac = new X2Tools().AlertController();
        ac.setTitle(title);
        ac.setMessage(message);
        ac.addAction({
            title:cancelActionTitle,
            action:"",
            style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
        });
    
        if( null !== data.teamName ){
            ac.addAction({
                title:"Einfügen",
                style:ALERT_ACTION_STYLE.UIAlertActionStyleDefault,
                action:"javascript:addNewClubWithUser();"
            });
        }
        ac.show();
        
        
    } catch (e) {
        
        let ac = new X2Tools().AlertController();
        ac.setTitle("Fehler aufgetreten");
        ac.setMessage("Fehler mit daten!\nMöglicherweise diese ist keine richtige Vereinsseite link\nBitte versuchen mit richtige Vereinsseite link!\n" + e.message);
        ac.addAction({
            title:"Schließen",
            action:"",
            style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
        });
        ac.show();
    }
}

function addNewClubWithUser() {
    
    try{
        
        /*alert(new X2Tools().getCookie("newAddedClubData"));*/
        let ai = new X2Tools().ActivityIndicator();
        ai.show(function () {
    
            let httpRequest = new X2Tools().HttpRequest();
            httpRequest
                .setController("TableView")
                .setNamespace("_clubs")
                .setMethod("addFoundClubToDatabase")
                .setData(new X2Tools().getCookie("newAddedClubData"))
                .execute(function () {
                    
                    ai.dismiss();
                    
                    if( this.resulta !== undefined && !this.resulta  ){
                
                        let ac = new X2Tools().AlertController();
                        ac.setTitle(this.title);
                        ac.setMessage(this.message);
                        ac.addAction({
                            title:"Schließen",
                            action:"",
                            style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                        });
                        ac.show();
                        return false;
                    }
            
                    let L = new Layout();
                    L.setUnwindDataStore("unwindFrom", nsp + "_" + mtd);
                    L.setUnwindDataStore("club", this);
            
                    new X2Tools().dismissViewController(L.getUnwindDataStore());
            
                });
            
        })
    } catch (e) {
        let ac = new X2Tools().AlertController();
        ac.setTitle("Fehler aufgetreten");
        ac.setMessage(e.message);
        ac.addAction({
            title:"Schließen",
            action:"",
            style:ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
        });
        ac.show();
    }
}