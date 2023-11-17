//variables
let KlantInformatie = document.getElementById("FormUpload");

let Klantnaam = sessionStorage.getItem("Username");
let Email = sessionStorage.getItem("Email");
let Rekeningnummer = sessionStorage.getItem("RekeningnummerLaatste2");
let KlantID = sessionStorage.getItem("KlantID");

//scripts
window.onload = function(){
    if(KlantID == null){
        window.location.replace("../../../index.php");
    } else {
        CheckLogin();
        KlantInformatie.innerHTML = `<form method="post">Naam: ${Klantnaam} <button type="button" onclick="GegevensVerranderen('Naam')">verranderen</button><br>Email: ${Email} <button type="button" onclick="GegevensVerranderen('Email')">verranderen</button><br>Rekeningnummer: ***${Rekeningnummer} <button type="button" onclick="GegevensVerranderen('Rekeningnummer')">verranderen</button><br><br>AccountID: ${KlantID}<br>Wachtwoord: *** <button type="button" onclick="GegevensVerranderen('Wachtwoord')">verranderen</button><br><br><input type="submit" value="verstuur" name="Versturen"></form>`;
    }
}

function GegevensVerranderen(GegevenType){
    if(GegevenType == "Naam"){
        document.cookie = "TeWijzigenData=Naam";
        sessionStorage.setItem("GewijzigdGegeven", "Naam");
        KlantInformatie.innerHTML = `<form method="post">Naam: <input type="text" id="GebruikersnaamValue" name="UserInputG"><br>Email: ${Email} <button type="button" onclick="GegevensVerranderen('Email')">verranderen</button><br>Rekeningnummer: ***${Rekeningnummer} <button type="button" onclick="GegevensVerranderen('Rekeningnummer')">verranderen</button><br><br>AccountID: ${KlantID}<br>Wachtwoord: *** <button type="button" onclick="GegevensVerranderen('Wachtwoord')">verranderen</button><br><br><input type="submit" value="verstuur" name="Versturen"></form>`
    } else if(GegevenType == "Rekeningnummer"){
        document.cookie = "TeWijzigenData=Rekeningnummer";
        sessionStorage.setItem("GewijzigdGegeven", "Rekeningnummer");
        KlantInformatie.innerHTML = `<form method="post">Naam: ${Klantnaam} <button type="button" onclick="GegevensVerranderen('Naam')">verranderen</button><br>Email: ${Email} <button type="button" onclick="GegevensVerranderen('Email')">verranderen</button><br>Rekeningnummer: <input type="text" id="RekeningnummerValue" name="UserInputG"><br><br>AccountID: ${KlantID}<br>Wachtwoord: *** <button type="button" onclick="GegevensVerranderen('Wachtwoord')">verranderen</button><br><br><input type="submit" value="verstuur" name="Versturen"></form>`
    } else if(GegevenType == "Wachtwoord"){
        document.cookie = "TeWijzigenData=Wachtwoord";
        sessionStorage.setItem("GewijzigdGegeven", "Wachtwoord");
        KlantInformatie.innerHTML = `<form method="post">Naam: ${Klantnaam} <button type="button" onclick="GegevensVerranderen('Naam')">verranderen</button><br>Email: ${Email} <button type="button" onclick="GegevensVerranderen('Email')">verranderen</button><br>Rekeningnummer: ***${Rekeningnummer} <button type="button" onclick="GegevensVerranderen('Rekeningnummer')">verranderen</button><br><br>AccountID: ${KlantID}<br>Wachtwoord: <input type="password" id="PasswordValue" name="UserInputG"><br><br><input type="submit" value="verstuur" name="Versturen"></form>`
    } else if(GegevenType == "Email"){
        document.cookie = "TeWijzigenData=Email";
        sessionStorage.setItem("GewijzigdGegeven", "Email");
        KlantInformatie.innerHTML = `<form method="post">Naam: ${Klantnaam} <button type="button" onclick="GegevensVerranderen('Naam')">verranderen</button><br>Email: <input type="text" id="EmailValue" name="UserInputG"><br>Rekeningnummer: ***${Rekeningnummer} <button type="button" onclick="GegevensVerranderen('Rekeningnummer')">verranderen</button><br><br>AccountID: ${KlantID}<br>Wachtwoord: *** <button type="button" onclick="GegevensVerranderen('Wachtwoord')">verranderen</button><br><br><input type="submit" value="verstuur" name="Versturen"></form>`
    }
}

function reload(){
    if(sessionStorage.getItem("GewijzigdGegeven") == "Naam"){
        sessionStorage.setItem("Username", document.getElementById("GebruikersnaamValue").value);
        document.cookie = `UserNameE-kartSite=${document.getElementById("GebruikersnaamValue").value}`;
        window.location.reload();
    } else if(sessionStorage.getItem("GewijzigdGegeven") == "Rekeningnummer"){
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
        document.cookie = `RekeningnummerE-kartSite=***${Laatste2Nummers[0]}${Laatste2Nummers[1]}`;
        sessionStorage.setItem("RekeningnummerLaatste2", `***${Laatste2Nummers[0]}${Laatste2Nummers[1]}`);
        window.location.reload();
    } else if(sessionStorage.getItem("GewijzigdGegeven") == "wachtwoord"){
        sessionStorage.setItem("Password", document.getElementById("PasswordValue").value);
        document.cookie = `PasswordE-kartSite=${document.getElementById("PasswordValue").value}`;
        window.location.reload();
    } else if(sessionStorage.getItem("GewijzigdGegeven") == "Email"){
        sessionStorage.setItem("Email", document.getElementById("EmailValue").value);
        document.cookie = `emailE-kartSite=${document.getElementById("PasswordValue").value}`;
        window.location.reload();
    }
}