<!DOCTYPE html>
<html>
    <head>
        <title>E-kart</title>
        <link rel="stylesheet" href="./style.css">
        <link rel="icon" href="../../Images/Logo.png">
    </head>
    <body>
        <div class="CreatieGUI">
            <h1>Account Creatie!</h1>
            <p id="UserLoginFrame">
                <form method="post">
                    Gebruikersnaam: <input type="text" id="UserLoginValue" name="UserLoginValue"><br>
                    Rekeningnummer: <input type="text" id="RekeningValue" name="RekeningValue"><br>
                    E-mail: <input type="text" id="EmailValue" name="EmailValue"><br>
                    Kaartnummer: <input type="text" id="KaartValue" name="KaartnummerValue"><br>
                    Wachtwoord: <input type="password" id="PassLoginValue" name="PassLoginValue"><br>
                    Herhaal wachtwoord: <input type="password" id="PassLoginValue2" name="PassLoginValue2"><br><br>
                    Heb je al een account?<br> Klik <a href="../../../index.php">hier</a> om in te loggen!<br><br>
                    <input type="submit" value="Creëer!" name="LoginButton">
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
            $UsernameValue = $_POST['UserLoginValue'];
            $RekeningnummerValue = $_POST['RekeningValue'];
            $EmailValue = $_POST['EmailValue'];
            $KaartnummerValue = $_POST['KaartnummerValue'];
            $WachtwoordValue1 = $_POST['PassLoginValue'];
            $WachtwoordValue2 = $_POST['PassLoginValue2'];

            if ($WachtwoordValue1 != $WachtwoordValue2) {
                echo '<script type="text/javascript">window.onload = function () { alert("Het wachtwoord komt niet overeen!"); }</script>';
            } else {
                if($UsernameValue == ""){
                    echo '<script type="text/javascript">window.onload = function () { alert("Je hebt geen gebruikersnaam ingevuld!"); }</script>';
                } else {
                    $Array = str_split($EmailValue);
                    if(!in_array("@", $Array)){
                        echo '<script type="text/javascript">window.onload = function () { alert("Je e-mailadres is geen mail..."); }</script>';
                    } else {
                        if($RekeningnummerValue == "" OR $EmailValue == "" OR $KaartnummerValue == "" OR $WachtwoordValue1 == ""){
                            echo '<script type="text/javascript">window.onload = function () { alert("Je hebt een of meerdere van de values niet ingevuld"); }</script>';
                        } else {
                            if(!is_numeric($RekeningnummerValue) AND !is_numeric($KaartnummerValue)){
                                echo '<script type="text/javascript">window.onload = function () { alert("De ingevulde rekeningnummer en/of kaartnummer is geen nummer!"); }</script>';
                            } else {
                                $EncryptedPassword = password_hash($WachtwoordValue1, PASSWORD_DEFAULT);
                                $sql = "INSERT INTO klant(klantID, ordernummer, rekeningnummer, klant_naam, email, betaalpas_nummer, Wachtwoord) VALUES (NULL, 0, '$RekeningnummerValue', '$UsernameValue', '$EmailValue','$KaartnummerValue', '$EncryptedPassword')";
    
                                if ($conn->query($sql) === TRUE) {
                                    $to = $EmailValue;
                                    $from = utf8_encode("From: 523553@student.fontys.nl");
                                    $headers = "MIME-Version: 1.0" . "\r\n";
                                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                    $headers .= $from . "\r\n";
                                    $subject = utf8_encode("Welkom bij E-Kart - Jouw slimme winkelervaring begint hier!");
                                    $message = "does not need to be encoded";
                                    $mailSuccess = mail($to, $subject, $message, utf8_encode($headers));
    
                                    if ($mailSuccess) {
                                        echo "Email sent successfully";
                                    } else {
                                        echo "Error sending email";
                                    }
    
                                    echo("<script type='text/javascript'>window.location.replace('../../../index.php');</script>");
                                } else {
                                    echo "Error: " . $sql . "<br>" . $conn->error;
                                }
                                $conn->close();
                            }
                        }
                    }
                }
            }
        }
    ?>
</html>