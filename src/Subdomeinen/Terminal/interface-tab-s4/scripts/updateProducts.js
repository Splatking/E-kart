var totalPrice = 0.0

function updateProducts(products) {
    var newProducts = {}
    $.each(products, function(productID, amount) {
        if (amount == null) {
            removeProduct(productID);
        } else if ($(".products").find("#"+productID).length) {
            updateProductAmount(productID, amount)
        } else {
            newProducts[productID] = amount;
        }

    });

    if (!$.isEmptyObject(newProducts)) {
        $.ajax({
            type: "GET",
            url: "php/getProductData.php",
            data: {products: Object.keys(newProducts)},
            success: function (data) {
                var jsonData = JSON.parse(data);
                console.log(jsonData)
                $.each(newProducts, function(productID, amount) {
                    addProduct(productID, jsonData[productID], amount)
                });
            }
        })
    }
    updatePrice();
}

function updatePrice() {
    setTimeout(function() {
        var newTotalPrice = 0.0;
        $(".products > .product").each(function () {
            if (!$(this).hasClass("removed")) {
                var price = parseFloat($(this).find('.product-price').text())
                var amount = parseInt($(this).find('.product-amount').text())
                $(this).find(".product-total-price").text((price * amount).toFixed(2))
                newTotalPrice += price * amount;
            }
        });

        if (newTotalPrice != totalPrice) {
            totalPrice = newTotalPrice;
            var totalPriceTag = $(".price-tag-amount");
            totalPriceTag.addClass("updateAnimation")   
            $(".price-tag-amount").text(totalPrice.toFixed(2));
            setTimeout(function() {
                totalPriceTag.removeClass("updateAnimation")
            }, 750);
        }
    
    }, 100);
}

function removeProduct(productID) {
    $("html, body").animate({ scrollTop: $("."+productID).offset().top - 150 }, 500);
    setTimeout(function() {
        $("."+productID).addClass("removed")
        updatePrice();
        var product = $(".products").find("#"+productID)
        product.css('opacity', "0.0");
        product.css('height', "0");
        product.css('padding', "0");
        product.addClass("removeAnimation")
        $(".products").find("#"+productID).find('.modal').modal('hide');
        setTimeout(function() {
            product.remove()
        }, 1500);
    }, 500);
}

function updateProductAmount(productID, amount) {
    $("html, body").animate({ scrollTop: $("."+productID).offset().top - 150 }, 500);
    setTimeout(function() {
        var amountBadge = $(".products").find("#"+productID).find(".product-amount")
        var productTotalPriceTag = $(".products").find("#"+productID).find(".product-total-price");
        amountBadge.addClass("updateAnimation")
        productTotalPriceTag.addClass("updateAnimation")   
        amountBadge.text(amount+"x");
        setTimeout(function() {
            amountBadge.removeClass("updateAnimation")
            productTotalPriceTag.removeClass("updateAnimation")
        }, 500);
    }, 750);
}

function addProduct(productID, productData, amount) {
    var data = productData;
    $.get("product.html", function(productHTML) {
        var product = $.parseHTML(productHTML)
        $(product).addClass(productID);
        $(product).attr("id", productID);
        $(product).find(".product-image").attr("src","images/products/"+productID+".jpg");
        $(product).find(".product-nutri-score").attr("src","images/nutri-scores/nutri-score-"+data["info"]["nutri-score"]+".svg");
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
            $(product).find(".product-characteristics").append("<li><img src='images/icons/"+icon+".svg' class='characteristics-icon'><p class='characteristics-text'>"+text+"</p></li>");
        });

        $(product).find(".product-nutrition-info").text(data["Voedingswaarden"]["info"]);
        $(product).find(".product-nutrition-unit").text(data["Voedingswaarden"]["eenheid"]);
        $.each(data["Voedingswaarden"]["Voedingswaarden"], function(eenheid, hoeveelheid) {
            $(product).find(".product-nutrition-values").append("<tr><td>"+eenheid+"</td><td>"+hoeveelheid+"</td></tr>");
        });

        $(product).find(".product-ingredients").text(data["Ingrediënten"]["Ingrediënten"]);
        $(product).find(".product-allergies").text(data["Ingrediënten"]["Allergie-informatie"]);
        
        $(".products").append(product);
    });
    $("html, body").animate({ scrollTop: $(document).height() }, 500);

}