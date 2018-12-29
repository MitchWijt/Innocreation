$(".openPortfolioModal").on("click",function () {
   $(this).parents(".portfolio").find(".portfolioModal").modal().toggle();
});

$(".read-more").on("click",function () {
    var id = $(this).data("toggle");
    $("#collapse-" + id).collapse('toggle');
});
var vars = {};
$(document).ready(function () {
    $(".carousel").each(function () {
        var counter = $(this).data("counter");
        if ($(window).width() < 400) {
            vars[counter + 'newCarousel'] = new floatingCarousel('#carousel-default-' + counter, {
                autoScroll: true,
                autoScrollDirection: 'right',
                autoScrollSpeed: 10000,
                enableTouchEvents: false,
                touchOverflowHidden: false,
                reverseOnTouch: false

            });
        } else {
            vars[counter + 'newCarousel'] = new floatingCarousel('#carousel-default-' + counter, {
                autoScroll: true,
                autoScrollDirection: 'right',
                autoScrollSpeed: 70000,
                enableTouchEvents: false,
                touchOverflowHidden: false,
                reverseOnTouch: false
            });
        }
    });
});



$(".editBannerImage").on("click",function () {
   $(".bannerImgInput").click();
});

$('.bannerImgInput').on("change", function () {
    $(".bannerImgForm").submit();
});






