$(".toggleBoardRename").on("click",function () {
   $(".renameShortTermPlannerBoard").toggle();
});

$(document).ready(function () {
   $(".renameShortTermPlannerBoard").removeClass("hidden");
   $(".renameShortTermPlannerBoard").toggle();
});

$(document).on("click", ".addShortTermTask",function () {
    var category = $(this).data("day-time");
    var task = $('.emptyCard').first().clone();
    $(".shortTermtasksColumn").each(function () {
       if($(this).data("day-time") == category){
           var taskColumn = $(this);
           task.removeClass("hidden");
           $(task).prependTo(taskColumn);
           task.find(".categoryTask").val(category);
           $( ".shortTermTaskTitleInput").focus();
       }
    });
});

$(document).on("change", ".shortTermTaskTitleInput",function () {
    var creator_user_id = $(this).data("creator-user-id");
    var board_id = $(this).data("board-id");
    var task_category = $(this).parents(".emptyCard").find(".categoryTask").val();
    var title = $(this).val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/addShortTermPlannerTask",
        data: {'creator_user_id': creator_user_id, 'task_category' : task_category, 'board_id' : board_id, 'title' : title},
        success: function (data) {
            $(".shortTermTaskTitleInput").each(function () {
               if($(this).val() == title){
                  $(this).parents(".emptyCard").find(".shortTermPlannerTaskTitle").text(title);
                  $(this).remove();
               }
            });
        }
    });
});

$(".dueDate").on("click",function () {
    $(this).parents(".card-task").find(".datepicker").focus();
});

$(document).ready(function () {
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        weekStart: 1,
        autoclose: true,
        minDate: "<? echo date('Y-m-d') ?>",
    });
});

$(".datepicker").on("change",function () {
    var task_id = $(this).data("short-planner-task-id");
    var due_date = $(this).val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/editShortTermPlannerTaskDueDate",
        data: {'task_id': task_id,'due_date' : due_date},
        success: function (data) {
            $(".dueDate").each(function () {
                if($(this).data("short-planner-task-id") == task_id){
                    $(this).text(data);
                }
            });
        }
    });
});


