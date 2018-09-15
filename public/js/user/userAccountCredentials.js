$(".editProfilePicture").on("click",function () {
    $(".uploadFile").click();
});

$(".uploadFile").on("change",function () {
    $(".loadingGear").removeClass("hidden");
    $(".saveUserProfilePicture").submit();
});