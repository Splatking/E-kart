//variables
let SiteInformation = document.getElementById("SiteInformation");

//scripts
window.onload = function(){
    SiteInformation.innerHTML = `Ingelogd als: [${sessionStorage.getItem("KlantID")}] ${sessionStorage.getItem("Username")}<br>Versie: DEV`;
}

function ReloadInformation(){
    SiteInformation.innerHTML = `Ingelogd als: [${sessionStorage.getItem("KlantID")}] ${sessionStorage.getItem("Username")}<br>Versie: DEV`;
}

function LogOut(){
    sessionStorage.clear();
    window.location.replace("../../../index.php");
}

function CheckLogin(){
    if(sessionStorage.getItem("Username") == null){
        window.location.replace("../../../index.php");
    } else {
        ReloadInformation();
    }
}