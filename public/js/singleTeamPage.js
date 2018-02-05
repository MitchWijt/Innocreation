$(".favoriteIcon").on("mouseover",function () {
    $(this).addClass("hidden");
   $(".favoriteIconLiked").removeClass("hidden");
});

$(".favoriteIconLiked").on("mouseleave",function () {
   $(this).addClass("hidden");
   $(".favoriteIcon").removeClass("hidden");

});

$(".openApplyModal").on("click",function () {
    var expertise_id = $(this).data("expertise-id");

    $(".applyForExpertise").each(function () {
       if($(this).data("expertise-id") == expertise_id){
           $(this).modal().toggle();
       }
    });
});