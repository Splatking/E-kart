<!DOCTYPE html>
<html>
    <head>
        <title>E-kart</title>
        <link rel="icon" href="../../Images/Logo.png">
        <link rel="stylesheet" href="../../MainScripts/MainStyle.css">
        <link rel="stylesheet" href="./style.css">
    </head>
    <body>
        <div class="Menu">
            <input type="image" src="../../Images/Logo.png" onclick="HopToDashboard()">
            <h1 id="titletext">E-kart online</h1>
            <a href="../Dashboard/index.php">Dashboard</a><br>
            <a href="../InDeWinkel/iindex.php">In de winkel</a><br>
            <a href="../LaatsteBonnetjes/index.php">Oude bonnetjes</a><br>
            <a href="../Account/index.php">Mijn Accountgegevens</a><br><br>
            <button type="button" id="Uitloggen" onclick="LogOut()">Uitloggen</button><br><br>
            <p id="SiteInformation">
                Ingelogd als: -<br>
                Versie: DEV
            </p>
        </div>
        <div class="MainScreen">
            <div class="ItemScreen">
                <h1>Jouw accountgegevens</h1>
                <p id="KlantGegevens">
                    <form method="post" id="FormUpload">
                        
                    </form>
                </p>
            </div>
        </div>
    </body>

    <script type="application/javascript" src="../../MainScripts/OnloadFunction.js">CheckLogin();</script>
    <script type="application/javascript" src="./main.js"></script>

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

        if(isset($_POST['Versturen'])){
            $TeWijzigenGegevens = $_POST['UserInputG'];
            $Gegeven = $_COOKIE["TeWijzigenData"];
            $KlantID = $_COOKIE['IDE-kartSite'];
        
            if($Gegeven == "Naam"){
                $sql = "UPDATE klant SET klant_naam ='$TeWijzigenGegevens' WHERE klantID='$KlantID'";
                $result = $conn->query($sql);
                echo '<script type="text/javascript">reload();</script>';
            } else if($Gegeven == "Rekeningnummer") {
                $sql2 = "UPDATE klant SET rekeningnummer ='$TeWijzigenGegevens' WHERE klantID='$KlantID'";
                $result = $conn->query($sql2);
                echo '<script type="text/javascript">reload();</script>';
            } else if($Gegeven == "Wachtwoord") {
                $sql3 = "UPDATE klant SET Wachtwoord ='$TeWijzigenGegevens' WHERE klantID='$KlantID'";
                $result = $conn->query($sql3);
                echo '<script type="text/javascript">reload();</script>';
            } else if($Gegeven == "Email") {
                $sql4 = "UPDATE klant SET email ='$TeWijzigenGegevens' WHERE klantID='$KlantID'";
                $result = $conn->query($sql4);
                echo '<script type="text/javascript">reload();</script>';
            }
        }
    ?>
</html>