$(document).ready(function() {
    $('span').click(function() {
        var product = $(this).attr("class").slice(3);
        var value = parseInt($("."+product).text());
        if(!$(this).is('[class*="min"]')) {
            value += 1;
        } else if(!$(this).is('[class*="plu"]')) {
            if (value != 0) {
                value -= 1;
            }
        }
        $("."+product).text(value);

        productsData = {
            "wi386099": parseInt($(".wi386099").text()), 
            "wi195643": parseInt($(".wi195643").text()), 
            "wi382538": parseInt($(".wi382538").text()), 
            "wi448504": parseInt($(".wi448504").text()), 
            "wi130084": parseInt($(".wi130084").text()), 
        }

        var products = Object.keys(productsData).map(function(key) {
            return Array(productsData[key]).fill(key);
        }).flat();

        $.ajax({
            type: "GET",
            url: "php/updateProducts.php",
            data: {products: JSON.stringify(products)},
        })
    });

    $(".connect").click(function() {
        var id = parseInt($(".id").val());

        productsData = {
            "wi386099": parseInt($(".wi386099").text()), 
            "wi195643": parseInt($(".wi195643").text()), 
            "wi382538": parseInt($(".wi382538").text()), 
            "wi448504": parseInt($(".wi448504").text()), 
            "wi130084": parseInt($(".wi130084").text()), 
        }

        var products = Object.keys(productsData).map(function(key) {
            return Array(productsData[key]).fill(key);
        }).flat();
        $.ajax({
            type: "GET",
            url: "php/updateProducts.php",
            data: {products: JSON.stringify(products)},
        })
        $.ajax({
            type: "GET",
            url: "php/connect.php",
            data: {id: id},
        })
    });

    $(".disconnect").click(function() {
        $.ajax({
            type: "GET",
            url: "php/connect.php",
            data: {id: "0"},
        })
    });
});