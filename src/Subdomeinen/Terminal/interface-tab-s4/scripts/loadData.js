var products = {}

$(document).ready(function() {
    getProducts();
    setInterval(getProducts,1000);
});

function getProducts() {
    updatePrice();
    $.ajax({
        type: "GET",
        url: "php/getKartData.php",
        data: {id: 1},
        success: function (data) {
            var jsonData = JSON.parse(data);
            console.log(jsonData)
            var newProducts = jsonData["products"];
            var customerID = jsonData["customerID"];
            if (customerID == 0) {
                window.location = './start.html';
            }
            var customerName = jsonData["customerName"];
            var customerBank = jsonData["customerBank"];
            var formattedProducts =  formatChangedProducts(newProducts)
            var changedProducts = findChangedProducts(products, formattedProducts);
            if (!$.isEmptyObject(changedProducts)) {
                updateProducts(changedProducts);
            }
            var formattedCustomerBank = customerBank.substr(customerBank.length - 4);
            $(".customer-data").text(customerName+" ***"+formattedCustomerBank);
            products = formattedProducts;
        } 
    })
}

function findChangedProducts(products, newProducts) {
    var changedProducts = {};
    var changedProducts = {};

    for (var key in products) {
        if (newProducts.hasOwnProperty(key)) {
            if (products[key] !== newProducts[key]) {
                changedProducts[key] = newProducts[key];
            }
        } else {
            changedProducts[key] = null;
        }
    }

    for (var key in newProducts) {
        if (!products.hasOwnProperty(key)) {
            changedProducts[key] = newProducts[key];
        }
    }
    return changedProducts;
}

function formatChangedProducts(changedProducts) {
    var formattedProducts = {};
    $.each(changedProducts, function(index, product) {
        formattedProducts[product] = (formattedProducts[product] || 0) + 1;
    });

    for (var key in formattedProducts) {
        if (formattedProducts[key] <= 0 || formattedProducts[key] === undefined) {
            delete formattedProducts[key];
        }
    }
    return formattedProducts
}