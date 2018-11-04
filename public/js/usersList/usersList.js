$(".collapseExpertise").on("click",function () {
    var id = $(this).data("user-id");
    var _this = $(this);
    $("#collapseExpertise-" + id).on("shown.bs.collapse",function () {
        _this.parents(".moreLink").find(".zmdi-chevron-left").addClass("zmdi-chevron-down").removeClass("zmdi-chevron-left");
        _this.parents(".moreLink").find(".collapseExpertise").text("Show less expertises");
    });

    $("#collapseExpertise-" + id).on("hidden.bs.collapse",function () {
        _this.parents(".moreLink").find(".zmdi-chevron-down").addClass("zmdi-chevron-left").removeClass("zmdi-chevron-down");
        _this.parents(".moreLink").find(".collapseExpertise").text("Show more expertises");
    });
});