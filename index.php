<!DOCTYPE html>
<html>
    <head>
        <title>E-kart</title>
        <link rel="stylesheet" href="./style.css">
        <link rel="icon" href="./src/Images/Logo.png">
    </head>
    <body>
        <div class="LoginGUI">
            <h1>Login!</h1>
            <p id="UserLoginFrame">
                <form method="post">
                    Gebruikersnaam/Email: <input type="text" id="UserLoginValue" name="UserLoginValue"><br>
                    Wachtwoord: <input type="password" id="PassLoginValue" name="PassLoginValue"><br><br>
                    Nog geen account?<br> Klik <a href="./src/Subdomeinen/CreateAccount/index.php">hier</a> om een account aan te maken!<br><br>
                    <input type="submit" value="Login!" name="LoginButton">
                </form>
            </p>
        </div>
    </body>
    
    <?php
        ini_set('display_errors', 1);

        $servername = "studmysql01.fhict.local";
        $username = "dbi523553";
        $password = "Fontys123";
        $dbname = "dbi523553";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        if (isset($_POST['LoginButton'])) {
            $UsernameInput = $_POST['UserLoginValue'];
            $PasswordInput = $_POST['PassLoginValue'];
            $EmailInput = false;
            $sql;

            $Array = str_split($UsernameInput);
            if(in_array("@", $Array)){
                $EmailInput = true;
            }

            if($EmailInput == false){
                $sql = "SELECT `klantID`, `rekeningnummer`, `klant_naam`, `email`,`betaalpas_nummer`, `Wachtwoord` FROM `klant` WHERE `klant_naam`='$UsernameInput'";
            } else {
                $sql = "SELECT `klantID`, `rekeningnummer`, `klant_naam`, `email`,`betaalpas_nummer`, `Wachtwoord` FROM `klant` WHERE `email`='$UsernameInput'";
            }

            $GivenID;
            $GivenUsername;
            $GivenRekeningnummer;
            $GivenPassNummer;
            $GivenPassword;
            $GivenEmail;
            $result = $conn->query($sql);
        
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $GivenID = $row["klantID"];
                    $GivenRekeningnummer = $row["rekeningnummer"];
                    $GivenUsername = $row["klant_naam"];
                    $GivenEmail = $row["email"];
                    $GivenPassNummer = $row["betaalpas_nummer"];
                    $GivenPassword = $row["Wachtwoord"];
                }
            }

            $PasswordCheck = password_verify($PasswordInput, $GivenPassword);

            if($result){
                if ($GivenUsername == $UsernameInput and $PasswordCheck == TRUE OR $GivenEmail == $UsernameInput AND $PasswordCheck == TRUE) {
                    $sql2 = "SELECT `Totaal_Prijs` FROM `bon` WHERE klantID='$GivenID' LIMIT 1";
                    $sql3 = "SELECT `kartID` FROM `karts` WHERE klantID='$GivenID'";
                    $result2 = $conn->query($sql2);
                    $result3 = $conn->query($sql3);
                    $TotalePrijsLaatsteFactuur = null;
                    $KartID = null;

                    if ($result2->num_rows > 0) {
                        while ($row = $result2->fetch_assoc()) {
                            $TotalePrijsLaatsteFactuur = $row["Totaal_Prijs"];
                        }
                    }

                    if ($result3->num_rows > 0) {
                        while ($row = $result3->fetch_assoc()) {
                            $KartIDN = $row["kartID"];
                        }
                    }

                    if(is_null($TotalePrijsLaatsteFactuur)){
                        setcookie("LaatsteBestellingE-kartSite", "-", time() + 86400, "/");
                    } else {
                        setcookie("LaatsteBestellingE-kartSite", $TotalePrijsLaatsteFactuur, time() + 86400, "/");
                    }

                    if(is_null($KartIDN)){
                        setcookie("WinkelwagenNummerE-kartSite", "-", time() + 86400, "/");
                    } else {
                        setcookie("WinkelwagenNummerE-kartSite", $KartIDN, time() + 86400, "/");
                    }

                    setcookie("UserNameE-kartSite", $GivenUsername, time() + 86400, "/");
                    setcookie("RekeningnummerE-kartSite", $GivenRekeningnummer, time() + 86400, "/");
                    setcookie("betaalpas_nummerE-kartSite", $GivenPassNummer, time() + 86400, "/");
                    setcookie("PasswordE-kartSite", $GivenPassword, time() + 86400, "/");
                    setcookie("IDE-kartSite", $GivenID, time() + 86400, "/");
                    setcookie("emailE-kartSite", $GivenEmail, time() + 86400, "/");
                    echo("<script type='text/javascript'>window.location.replace('./src/Subdomeinen/Dashboard/index.php');</script>");
                } else {
                    echo '<script type="text/javascript">window.onload = function () { alert("Your username and/or password are not found in the database!"); }</script>';
                }
            } else {
                echo '<script type="text/javascript">window.onload = function () { alert("Your account has not been found in the database!"); } </script>';
            }
        }
    ?>

    <script type="application/javascript" src="./main.js"></script>
</html>