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

$('.bannerImgInput').on("change", function () {
    $(".bannerImgForm").submit();
});

// Opens popup to kick member from team.
$('.popoverMember').popover({ trigger: "click" , html: true, animation:false, placement: 'bottom'})
    .on("click", function () {
    });
$(".popoverMember").on("click", function (e) {
    e.preventDefault();
});

$(document).on("click", ".popoverMember, .memberName", function (e) {
    e.preventDefault();
});

$(document).on("click", ".teamPrivacySettings", function () {
    var teamId = $(this).data("id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/my-team/getPrivacySettingsModal",
        data: {'team_id': teamId},
        success: function (data) {
            $("body").append(data);
            $(".privacySettingsModalTeam").modal("toggle");
        }
    });
});

$(document).on("hidden.bs.modal", ".privacySettingsModalTeam", function () {
    $(".privacySettingsModalTeam").remove();
});



