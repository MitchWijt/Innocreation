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

$(".triggerLike").on("click",function () {
    var postData = "";
    var team_id = $(this).data("team-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/favoriteTeam",
        data: {'team_id': team_id},
        success: function (data) {
            if(data == 1) {
                var _this = $(".favoriteIconLiked");
                _this.unbind('mouseleave');
                _this.removeClass("hidden");
                $(".favoriteIcon").addClass("hidden");
            } else if(data == 2){
                $(".favAfterLike").addClass("hidden");
                $(".favoriteIcon").removeClass("hidden");
            }
        }
    });
});



$(".star").on('mouseover', function () {
   $(this).addClass("hover");
   $(".star").each(function () {
       if (!$(this).hasClass("hover")) {
           $(this).addClass("zmdi-star");
           $(this).removeClass("zmdi-star-outline");
       }
   });
});

// $(".star").on('mouseleave', function () {
//     $(this).removeClass("zmdi-star");
//     $(this).addClass("zmdi-star-outline");
// });
