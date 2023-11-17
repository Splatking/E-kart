$(document).ready(function() {
    var products = {
        "wi195643": "2",
        "wi382538": "3",
        "wi386099": "69",
        "wi130084": "5",
        "wi448504": "14"
    }

    var totalPrice = 0.0

    $.getJSON('../dataset/sample.json', function(data){ 
        database = data
        // 
        $.each(products, function(productID, amount) {
            var data = database[productID];
            $.get("product.html", function(productHTML) {
                var product = $.parseHTML(productHTML)
                $(product).addClass(productID);
                $(product).find(".product-image").attr("src","../dataset/images/"+productID+".jpg");
                $(product).find(".product-nutri-score").attr("src","images/nutri-score-"+data["info"]["nutri-score"]+".svg");
                $(product).find(".product-name").text(data["info"]["naam"]);
                $(product).find(".product-unit").text(data["info"]["eenheid"]);
                $(product).find(".product-price").text(data["info"]["prijs"]);
                $(product).find(".product-amount").text(amount+"x");

                if (data["info"]["melding-positief"] != "") {
                    $(product).find(".product-mention").text(data["info"]["melding-positief"]).addClass("positive-mention");
                }
                if (data["info"]["melding-negatief"] != "") {
                    $(product).find(".product-mention").text(data["info"]["melding-negatief"]).addClass("negative-mention");
                }

                $(product).attr("data-target","#modal"+productID);
                $(product).find(".product-info-modal").attr("id","modal"+productID);
                
                $.each(data["Omschrijving"]["Omschrijving"], function(index, line) {
                    $(product).find(".product-description").append("<p>"+line+"</p>");
                });

                $.each(data["Omschrijving"]["Kenmerken"], function(icon, text) {
                    $(product).find(".product-characteristics-preview").append("<img src='images/icons/"+icon+".svg' class='characteristics-icon-preview'>");
                });

                $.each(data["Omschrijving"]["Kenmerken"], function(icon, text) {
                    $(product).find(".product-characteristics").append("<li><img src='images/icons/"+icon+".svg' class='characteristics-icon'>"+text+"</li>");
                });

                $(product).find(".product-nutrition-info").text(data["Voedingswaarden"]["info"]);
                $(product).find(".product-nutrition-unit").text(data["Voedingswaarden"]["eenheid"]);
                $.each(data["Voedingswaarden"]["Voedingswaarden"], function(eenheid, hoeveelheid) {
                    $(product).find(".product-nutrition-values").append("<tr><td>"+eenheid+"</td><td>"+hoeveelheid+"</td></tr>");
                });

                $(product).find(".product-ingredients").text(data["Ingrediënten"]["Ingrediënten"]);
                $(product).find(".product-allergies").text(data["Ingrediënten"]["Allergie-informatie"]);
                
                $(".products").append(product);
                totalPrice += (parseFloat(data["info"]["prijs"]) * parseInt(amount))
                $(".price-tag-amount").text(totalPrice.toFixed(2));
            });
        });
        //
    });
});