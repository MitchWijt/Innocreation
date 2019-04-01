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
   $(this).addClass("zmdi-star");
   $(this).prevAll().addClass("zmdi-star");
});

$(".star").on('mouseleave', function () {
    $(this).removeClass("zmdi-star");
});

$(".star").on("click",function () {
    var value = $(this).data("star-value");
    $(".star_value").val(value);
    $(this).addClass("zmdi-star");
    $(this).unbind("mouseleave");
    $(this).prevAll().unbind("mouseleave");
});

$(".collapseExpertise").on("click",function () {
    var id = $(this).data("user-id");
    var _this = $(this);
    $("#collapseExpertise-" + id).on("shown.bs.collapse",function () {
        var icon = "<i class=\"zmdi zmdi-chevron-down m-t-5 m-l-10 c-orange\"></i>";
        if ($(window).width() <= 545){
            _this.parents(".moreLink").find(".collapseExpertise").html("Expertises" + icon);
        } else {
            _this.parents(".moreLink").find(".collapseExpertise").html("Hide expertises" + icon);
        }
    });

    $("#collapseExpertise-" + id).on("hidden.bs.collapse",function () {
        var icon = "<i class=\"zmdi zmdi-chevron-left m-t-5 m-l-10 c-orange\"></i>";
        if ($(window).width() <= 545){
            _this.parents(".moreLink").find(".collapseExpertise").html("Expertises" + icon);
        } else {
            _this.parents(".moreLink").find(".collapseExpertise").html("Show expertises" + icon);
        }
    });
});

$(".editBannerImage").on("click",function () {
    $(".bannerImgInput").click();
});
$("#editProfilePicture").on("click",function () {
    $(".profile_picture").click();
});

$('.bannerImgInput').on("change", function () {
    $(".bannerImgForm").submit();
});

$('.profile_picture').on("change", function () {
    $(".profileImageForm").submit();
});