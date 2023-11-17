$(document).ready(function() {
    var searchParams = new URLSearchParams(window.location.search);
    var id = searchParams.get('id');
    var products = searchParams.get('products');

    try {
        if (id && $.isArray($.parseJSON(products))) {
            $.ajax({
                type: "GET",
                url: "php/updateProducts.php",
                data: {id: id, products: products},
                success: function (data) {
                    $("body").append(data);
                }
            })
        }
      }
      catch(err) {
        $("body").append("error");
      }
});