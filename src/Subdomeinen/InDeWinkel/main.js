//variables
let ConnectedWinkelwagens = sessionStorage.getItem("WinkelwagenNummer");
let Title = document.getElementById("WinkelwagenInfoTitle");
let TextValue = document.getElementById("WinkelwagenInfoText");

//scripts
window.onload = function(){
    CheckLogin();
}

if(ConnectedWinkelwagens != null){
    Title.innerHTML = "Je bent geconnect aan een winkelwagen!";
    TextValue.innerHTML = `Jou winkelwagennummer is: ${ConnectedWinkelwagens}`;
}