$(document).ready(function() {
    checkKartStatus();
    setInterval(checkKartStatus,1000);
});

function checkKartStatus() {
    $.ajax({
        type: "GET",
        url: "php/getKartStatus.php",
        data: {id: 1},
        success: function (data) {
            customerID = data;
            if (customerID != 0) {
                $(".qr-code").attr("src","images/succes.svg");
                $(".qr-code").addClass("succes");
                setTimeout(function() {
                    window.location = './index.html';
                }, 2000);
            }
        }
    })
}