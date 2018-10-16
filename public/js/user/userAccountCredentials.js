$(".editProfilePicture").on("click",function () {
    $(".uploadFile").click();
});

$(".uploadFile").on("change",function () {
    $(".loadingGear").removeClass("hidden");
    $(".saveUserProfilePicture").submit();
});

$(".toConnections").on("click",function () {
   $(this).addClass("activeItem");
   $(".toConnectionRequests").addClass("c-dark-grey");
   $(".toConnectionRequests").removeClass("activeItem");

   $(".connections").removeClass("hidden");
   $(".connections-received").addClass("hidden");
});

$(".toConnectionRequests").on("click",function () {
    $(this).addClass("activeItem");
    $(".toConnections").addClass("c-dark-grey");
    $(".toConnections").removeClass("activeItem");

    $(".connections").addClass("hidden");
    $(".connections-received").removeClass("hidden");
});

$(document).on("click", ".switch__toggle", function () {
    $(".acceptConnection").submit();
});