<?php
    ini_set('display_errors', 1);

    $servername = "studmysql01.fhict.local";
    $username = "dbi523553";
    $password = "Fontys123";
    $database = "dbi523553";
    $conn = new mysqli($servername, $username, $password, $database);

    $kartId = $_GET['id'];
    $products = json_decode($_GET['products']);

    $conn->query("DELETE FROM kart_product WHERE kart_id = '$kartId';");
    foreach ($products as $product) {
        $conn->query("INSERT INTO kart_product (kart_id, product_id) VALUES ('$kartId', '$product')");
    }

    print_r("succes");
