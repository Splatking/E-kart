<?php
    $servername = "studmysql01.fhict.local";
    $username = "dbi523553";
    $password = "Fontys123";
    $database = "dbi523553";
    $conn = new mysqli($servername, $username, $password, $database);

    $kart_id = $_GET['id'];
    $result = $conn->query("SELECT `klantID` FROM `karts` WHERE kartID=$kart_id LIMIT 1");
    $row = $result->fetch_assoc();
    $customerID = $row['klantID'];
    print_r($customerID);