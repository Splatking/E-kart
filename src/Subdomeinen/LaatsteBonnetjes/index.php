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
            <a href="../InDeWinkel/index.php">In de winkel</a><br>
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
                <h1>Bonnetjes</h1>
                <?php
                    ini_set('display_errors', 1);

                    $servername = "studmysql01.fhict.local";
                    $username = "dbi523553";
                    $password = "Fontys123";
                    $dbname = "dbi523553";
                    $KlantID = $_COOKIE['IDE-kartSite'];
                                    
                    $conn = new mysqli($servername, $username, $password, $dbname);
                                    
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
            
                    $sql = "SELECT kartID, betaaldatum, Totaal_Prijs FROM bon WHERE klantID='$KlantID'";
                    $result = $conn->query($sql);
                        
                    while($row = $result->fetch_assoc()){
                        echo "<div class='Item'>
                            <h1>" . $row['betaaldatum'] . "</h1>
                            <p class='ItemsOnList'>Totale prijs: " . $row['Totaal_Prijs'] . "<br> WinkelwagenID: " . $row['kartID'] . "</p>
                            <button type='button'>Inkijken</button>
                        </div><br><br>";
                    }
                ?>
            </div>
        </div>

        <script type="application/javascript" src="../../MainScripts/OnloadFunction.js">CheckLogin();</script>
        <script type="application/javascript" src="./main.js"></script>
    </body>
</html>