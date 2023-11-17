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

    $result = $conn->query("SELECT `product_id` FROM `kart_product` WHERE kart_id=$kart_id");
    $row = $result->fetch_assoc();
    $products = array();
    if ($row) {
        do {
            $products[] = $row['product_id'];
        } while ($row = $result->fetch_assoc());
    }


    $result = $conn->query("SELECT `klant_naam`, `rekeningnummer` FROM `klant` WHERE klantID=$customerID LIMIT 1");
    $row = $result->fetch_assoc();
    $customerName = $row['klant_naam'];
    $customerBank = $row['rekeningnummer'];

    $data = array(
        "products" => $products,
        "customerID" => $customerID,
        "customerName" => $customerName,
        "customerBank" => $customerBank
    );

    print_r(json_encode($data));