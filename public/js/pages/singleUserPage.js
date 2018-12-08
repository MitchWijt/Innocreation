$(".openPortfolioModal").on("click",function () {
   $(this).parents(".portfolio").find(".portfolioModal").modal().toggle();
});

$(".read-more").on("click",function () {
   console.log("gfdsa");
    var id = $(this).data("toggle");
    $("#collapse-" + id).collapse('toggle');
});


new floatingCarousel('.carousel-default', {
    autoScroll : true,
    autoScrollDirection : 'right',
    autoScrollSpeed : 70000,
    enableTouchEvents : false,
    touchOverflowHidden : false,
    reverseOnTouch : false

});

$(".contentPortfolio").on("mouseover",function () {
    var id = $(this).data("id");
    $("#portfolioFileCont-" + id).fadeIn();
});
//
// $(".contentPortfolio").on("mouseleave",function () {
//     var id = $(this).data("id");
//     setTimeout(function(){
//     $(".cont-" + id).addClass("hidden");
//     }, 800);
// });
