$(".editDescriptionBtn").on("click",function () {
    // var _this = $(".expertise-description");
    $(this).hide();
    $(this).parents(".expertiseButtons").find(".saveDescriptionBtn").removeClass("hidden");
    var id = $(this).data("expertise-id");

    $('.editUserExpertiseField').each(function () {
        if($(this).data("id") == id){
            $(this).closest(".formHidden").removeClass("hidden");
        }
    });

    $('.expertise-description').each(function () {
        if($(this).data("id") == id){
            $(this).closest(".expertise-description").hide();
        }
    });
});

$(".saveDescriptionBtn").on("click",function () {
    var id = $(this).data("expertise-id");

    $('.editUserExpertiseField').each(function () {
        if($(this).data("id") == id){
            $(this).closest(".editUserExpertiseField").submit();
        }
    });
});

