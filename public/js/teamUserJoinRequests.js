$(".rejectUser").on("click",function () {
    $(this).closest(".rejectUserFromTeam").submit();
});

$(".acceptUser").on("click",function () {
    $(this).closest(".acceptUserInTeam").submit();
});