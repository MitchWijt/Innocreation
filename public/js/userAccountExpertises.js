$(".editDescriptionBtn").on("click",function () {
    // var _this = $(".expertise-description");
    // $(this).hide();
    // $(this).parents("#expertiseButtons").find(".saveDescriptionBtn").removeClass("hidden");
    var id = $(this).data("expertise-id");
    console.log(id);
    // if($(this).data("expertise-id") == $(this).parents(".container").find(".editUserExpertiseField").data("id")){
    //     $(this).parents(".container").closest(".editUserExpertiseField").show();
    // }
    $('.editUserExpertiseField').each(function () {
        if($(this).data("id") == id){
            $(this).closest(".formHidden").removeClass("hidden");
            console.log($(this).data("id"));
        }
    });


    // _this.closest(".expertise-description").find(".desc").hide();
});