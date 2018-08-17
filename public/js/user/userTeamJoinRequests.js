$(".rejectInvite").on("click",function () {
    $(this).closest(".rejectTeamInvite").submit();
});

$(".acceptInvite").on("click",function () {
    $(this).closest(".acceptTeamInvite").submit();
});