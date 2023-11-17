<?php
    ini_set('display_errors', 1);
    $WagenID = $_GET['id'];
    $KlantID = $_GET['klantid'];

    $servername = "studmysql01.fhict.local";
    $username = "dbi523553";
    $password = "Fontys123";
    $dbname = "dbi523553";
        
    $conn = new mysqli($servername, $username, $password, $dbname);
        
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE karts SET klantID='$KlantID' WHERE kartID='$WagenID'";
    $result = $conn->query($sql);
?>