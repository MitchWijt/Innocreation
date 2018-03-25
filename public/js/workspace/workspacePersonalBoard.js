$(".openCompletedTaskModal").on("click",function () {
   $(this).parents(".completedTask").find("#personalBoardTaskModal").modal().toggle();
});