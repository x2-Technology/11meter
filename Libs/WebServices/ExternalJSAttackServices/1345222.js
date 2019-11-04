function action(){
    
    let response = JSON.stringify({
        teamName:null,
        vereinsseite:null,
        resulta:false
    });
    
    if( document.querySelector(".stage-content h2") !== null ){
        
        response = JSON.stringify({
            teamName:document.querySelector(".stage-content h2").innerText,
            vereinsseite:location.href,
            resulta:true
        });
    }
    
    /** * @Interface for Android */
    try{
        X2AndroidInterface.runnableScriptResult( response, "1345222.js");
    } catch (e) {}
    
    return response;
    
}
action();