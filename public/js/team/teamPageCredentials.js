$(".editProfilePicture").on("click",function () {
    $(".uploadFile").click();
});

$(".uploadFile").on("change",function () {
    $(".saveTeamProfilePicture").submit();
});