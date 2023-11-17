<?php
    $servername = "studmysql01.fhict.local";
    $username = "dbi523553";
    $password = "Fontys123";
    $database = "dbi523553";
    $conn = new mysqli($servername, $username, $password, $database);

    $products = $_GET['products'];

    $productNutritionalNameCorrections =  array(
        "vet_verzadigd" => 'Waarvan verzadigd',
        "vet_onverzadigd" => 'Waarvan onverzadigd',
        "suikers" => 'Waarvan suikers',
        "vit_b2" => 'Vitamine B2 / Riboflavine',
        "vit_b3" => 'Vitamine B3 / Niacine',
        "vit_b5" => 'Vitamine B5 / Pantotheenzuur',
        "vit_b6" => 'Vitamine B6 / Pyridoxine',
        "vit_b12" => 'Vitamine B12 / Cyano-Cobalamine'
    );

    $data  = array();
    foreach ($products as $product) {
        $result = $conn->query("SELECT * FROM `product` WHERE productID='$product' LIMIT 1");
        $productTable = $result->fetch_assoc();


        // $characteristics = json_decode($productTable['kenmerken']);
        // $productCharacteristics = array();
        // foreach ($characteristics as $characteristic) {
        //     $result = $conn->query("SELECT * FROM `kenmerken` WHERE kenmerk_id='$characteristic' LIMIT 1");
        //     $characteristicTable = $result->fetch_assoc();
        //     $productCharacteristics[$characteristicTable["afkorting"]] = $characteristicTable["naam"];
        // }

        $result = $conn->query("SELECT `kenmerk_id` FROM `product_kenmerk` WHERE product_id='$product'");
        $row = $result->fetch_assoc();
        $productCharacteristics = array();
        if ($row) {
            do {
                $characteristic = $row['kenmerk_id'];
                $result2 = $conn->query("SELECT * FROM `kenmerken` WHERE kenmerk_id='$characteristic' LIMIT 1");
                $characteristicTable = $result2->fetch_assoc();
                $productCharacteristics[$characteristicTable["afkorting"]] = $characteristicTable["naam"];
            } while ($row = $result->fetch_assoc());
        }

        $nutritionalValueId = $productTable['voedingswaarden_id'];
        $result = $conn->query("SELECT * FROM `voedingswaarden` WHERE voedingswaarden_id='$nutritionalValueId' LIMIT 1");
        $nutritionalValueTable = $result->fetch_assoc();
        $productNutritionalValue = array();
        foreach ($nutritionalValueTable as $nutritionalValueName => $nutritionalValue) {
            if ($nutritionalValueName == 'info') {
                $productNutritionalValueInfo = $nutritionalValue;
            } elseif ($nutritionalValueName == 'eenheid') {
                $productNutritionalValueUnit = $nutritionalValue;
            } elseif (!empty($nutritionalValue)) { 
                foreach ($productNutritionalNameCorrections as $nutritionalValueNameError => $nutritionalValueNameCorrection) {
                    $nutritionalValueName = str_replace($nutritionalValueNameError, $nutritionalValueNameCorrection, $nutritionalValueName);
                }
                $nutritionalValueName = ucwords($nutritionalValueName);
                $productNutritionalValue[$nutritionalValueName] = $nutritionalValue;
            } 
        }
        array_shift($productNutritionalValue);
        $data[$product] = array(
            "info" => [
                "naam" => $productTable['productNaam'], 
                "eenheid" => $productTable['eenheid'], 
                "prijs" => $productTable['prijs'], 
                "nutri-score" => $productTable['nutri'], 
                "melding-positief" => $productTable['meld_pos'], 
                "melding-negatief" => $productTable['meld_neg']
            ], 
            "Omschrijving" => [
                "Omschrijving" => explode("\n", $productTable['productbeschrijving']), 
                "Kenmerken" => $productCharacteristics
            ], 
            "Ingrediënten" => [
                "Ingrediënten" =>  $productTable['ingrediënten'], 
                "Allergie-informatie" => $productTable['allergie-informatie'] 
            ], 
            "Voedingswaarden" => [
                "info" => $productNutritionalValueInfo, 
                "eenheid" => $productNutritionalValueUnit,
                "Voedingswaarden" => $productNutritionalValue
            ] 
        );
    }

    print_r(json_encode($data));