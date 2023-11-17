$(document).ready(function() {
    time();
    setInterval(time,60000);
});

function time() {
    var currentTime = new Date($.now());
    var hours = currentTime.getHours()
    var minutes = currentTime.getMinutes()
    var formattedHours = (hours < 10) ? '0' + hours : hours;
    var formattedMinutes = (minutes < 10) ? '0' + minutes : minutes;
    $(".time-tag").text(formattedHours+":"+formattedMinutes);
}