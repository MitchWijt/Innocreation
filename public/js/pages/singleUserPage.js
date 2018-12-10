$(".openPortfolioModal").on("click",function () {
   $(this).parents(".portfolio").find(".portfolioModal").modal().toggle();
});

$(".read-more").on("click",function () {
    var id = $(this).data("toggle");
    $("#collapse-" + id).collapse('toggle');
});


if ($(window).width() < 400) {
    new floatingCarousel('.carousel-default', {
        autoScroll: true,
        autoScrollDirection: 'right',
        autoScrollSpeed: 10000,
        enableTouchEvents: false,
        touchOverflowHidden: false,
        reverseOnTouch: false

    });
} else {
    new floatingCarousel('.carousel-default', {
        autoScroll : true,
        autoScrollDirection : 'right',
        autoScrollSpeed : 70000,
        enableTouchEvents : false,
        touchOverflowHidden : false,
        reverseOnTouch : false
    });
}


$(".editBannerImage").on("click",function () {
   $(".bannerImgInput").click();
});

$('.bannerImgInput').on("change", function () {
    $(".bannerImgForm").submit();
});