$(".favoriteIcon").on("mouseover",function () {
    $(this).addClass("hidden");
   $(".favoriteIconLiked").removeClass("hidden");
});

$(".favoriteIconLiked").on("mouseleave",function () {
   $(this).addClass("hidden");
   $(".favoriteIcon").removeClass("hidden");

});