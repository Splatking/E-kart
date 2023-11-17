$(document).ready(function() {
    var styles = ".erdemAnimate {-webkit-animation: erdem 7s;}@-webkit-keyframes erdem {from, to { bottom: -187px; }25% { bottom: -100px; }50% { bottom: -10px; }75% { bottom: -187px; }}";

var styleElement = $('<style>', { type: 'text/css' });
styleElement.text(styles);
$('head').append(styleElement);


    var erdem = $('<img>', {
        class: 'erdem',
        src: 'images/erdem.png'
    });

    erdem.css({
        'position': 'absolute',
        'bottom': '-187px',
        'left': '10%',
        'width': '200px'
    });

    $('.price-tag-container').append(erdem);


    var clickCount = 0;
    var clickTimeout;
    var timeWindow = 300;
    var targetElement = $('.price-tag-label');
    targetElement.on('click touchstart tap', function() {
    clickCount++;
    clearTimeout(clickTimeout);
    clickTimeout = setTimeout(function() {
        clickCount = 0;
    }, timeWindow);
    if (clickCount === 3) {
        $(".erdem").addClass("erdemAnimate");
        setTimeout(function() {
            $(".erdem").removeClass("erdemAnimate");
        }, 8000);
        clickCount = 0;
    }
    });
  });