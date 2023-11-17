<?php
    $servername = "studmysql01.fhict.local";
    $username = "dbi523553";
    $password = "Fontys123";
    $database = "dbi523553";
    $conn = new mysqli($servername, $username, $password, $database);

    $kart_id = $_GET['id'];
    $conn->query("UPDATE `karts` SET `klantID` = '$kart_id' WHERE `kartID`=1;");