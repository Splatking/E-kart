//variables
let JouGegevensText = document.getElementById("GegevensUser");
let LaatsteFactuur = document.getElementById("GegevensLaatsteBonnetje");

//script
function getCookie(name) {
    let x = document.cookie;
    
    if(x != null){
        var cookieArr = x.split(";");
        for(var i = 0; i < cookieArr.length; i++) {
            var cookiePair = cookieArr[i].split("=");
            if(name == cookiePair[0].trim()) {
                return decodeURIComponent(cookiePair[1]);
            }
        }
        return null;
    }
}

window.onload = function(){
    let Rekeningnummer = getCookie("RekeningnummerE-kartSite").toString();
    let RekeningnummerSplit = [];
    let Laatste2Nummers = [];

    for (var i = 0; i < Rekeningnummer.length; i++) {
        RekeningnummerSplit.push(Rekeningnummer.charAt(i));
    }

    for(var i = 0; i < RekeningnummerSplit.length; i++){
        if(RekeningnummerSplit.length-2 == i || RekeningnummerSplit.length-1 == i){
            Laatste2Nummers.push(RekeningnummerSplit[i]);
        }
    }

    sessionStorage.setItem("LaatsteBestelling", getCookie("LaatsteBestellingE-kartSite"));
    sessionStorage.setItem("Username", getCookie("UserNameE-kartSite"));
    sessionStorage.setItem("KlantID", getCookie("IDE-kartSite"));
    sessionStorage.setItem("RekeningnummerLaatste2", `***${Laatste2Nummers[0]}${Laatste2Nummers[1]}`);
    sessionStorage.setItem("Betaalpasnummer", getCookie("betaalpas_nummerE-kartSite"));
    sessionStorage.setItem("Password", getCookie("UserNameE-kartSite"));
    sessionStorage.setItem("Email", getCookie("emailE-kartSite"));

    if(getCookie("WinkelwagenNummerE-kartSite") != "-"){
        sessionStorage.setItem("WinkelwagenNummer", getCookie("WinkelwagenNummerE-kartSite"));
    }

    JouGegevensText.innerHTML = `Ingelogd als:<br>${sessionStorage.getItem("Username")}<br><br>Rekeningnummer:<br>${sessionStorage.getItem("RekeningnummerLaatste2")}<br><br>`;
    LaatsteFactuur.innerHTML = `Jou laatste factuur bedroeg: €${sessionStorage.getItem("LaatsteBestelling")}<br>`;
    ReloadInformation();
}

function HopToDashboard(){
    window.location.replace("./index.html");
}

function ZoekInformatie(ProductNaam){
    
}