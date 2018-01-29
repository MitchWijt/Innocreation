$(document).ready(function () {
    if($(".searched").text() == 1) {
        $('html, body').animate({
            scrollTop: $(".input-fat").offset().top
        }, 1000);
    }
});