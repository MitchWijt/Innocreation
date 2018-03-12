$(".toggleBoardRename").on("click",function () {
   $(".renameShortTermPlannerBoard").toggle();
});

$(document).ready(function () {
   $(".renameShortTermPlannerBoard").removeClass("hidden");
   $(".renameShortTermPlannerBoard").toggle();
});