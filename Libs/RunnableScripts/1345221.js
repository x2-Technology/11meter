function action(){
    let items = [];
    document.querySelectorAll('#clubTeams div.items > div.item').forEach(function(El){
        
        let a = El.querySelector('h4 > a');
        a.querySelectorAll("*").forEach(function (El) {
            if(El.nodeName !== undefined && El.nodeName !== null ){
                El.remove();
            }
        });
        
        let name = a.innerHTML;
        name = name.trim();
        let link = a.href;
        
        items.push({
            name:name,
            link:link
        });
    });
    /** * @Interface for Android */
    try{
        X2AndroidInterface.runnableScriptResult(JSON.stringify(items), "1345221.js");
    } catch (e) {}
    return JSON.stringify(items);
}
action();