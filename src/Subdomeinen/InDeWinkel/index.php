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
            <div class="Boodschappenlijstje">
                <h1>Boodschappenlijstje</h1>
                <div class="ItemHolders" id="ItemHolders">
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

                        $Kart_ID;

                        $sql = "SELECT kartID FROM karts WHERE klantID='$KlantID'";
                        $result = $conn->query($sql);
                        while($row = $result->fetch_assoc()){
                            $Kart_ID = $row['kartID'];
                        }
            
                        $sql2 = "SELECT product_id FROM kart_product WHERE kart_id='$Kart_ID'";
                        $result2 = $conn->query($sql2);
                        $Array = array();
                        
                        while($row = $result2->fetch_assoc()){
                            $PID = $row['product_id'];
                            if(!in_array($PID, $Array)){
                                array_push($Array, $PID);
                                $sql3 = "SELECT product_id, COUNT(*) AS Dublicates FROM kart_product WHERE product_id='$PID'";
                                $result3 = $conn->query($sql3);
                                $Aantal;

                                while($row = $result3->fetch_assoc()){
                                    $Aantal = $row['Dublicates'];
                                }

                                $sql4 = "SELECT productNaam, prijs, `allergie-informatie` FROM product WHERE productID='$PID'";
                                $result4 = $conn->query($sql4);

                                while($row2 = $result4->fetch_assoc()){
                                    echo "<div class='Item' id=" . $PID . ">
                                        <div class='Leftside'>
                                            <img src='../../Images/" . $PID  .".png'>
                                        </div>
                                        <div class='Middleside'>
                                            <h1 class='ItemNaam'>" . $row2['productNaam'] . "</h1>
                                            <p class='ItemInformatie' >" . $row2['allergie-informatie'] . "</p>
                                        </div>
                                        <div class='Rightside'>
                                            <p id='prijsinformatiePerL'>" . $row2['prijs'] . "</p>
                                            <p id='Aantal'>" . $Aantal . "</p>
                                            <p id='TotaalPrijs'>" . $row2['prijs']*$Aantal . "</p>
                                        </div>
                                    </div>";
                                }
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="ConnectGUI">
                <h1 id="WinkelwagenInfoTitle">Je bent op dit moment nog niet geconnect met een winkelwagen!</h1>
                <p id="WinkelwagenInfoText">
                    Klik <a href="../QrCode/index.html">hier</a> om een verbinding te maken met een winkelwagen.
                </p>
            </div>
        </div>
        <script type="application/javascript" src="./main.js"></script>
        <script type="application/javascript" src="../../MainScripts/OnloadFunction.js">CheckLogin();</script>
    </body>
</html>