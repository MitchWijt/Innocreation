$(".openCompletedTaskModal").on("click",function () {
    var task_id = $(this).data("task-id");
    $(".personalBoardTaskModal").each(function () {
        if($(this).data("task-id") == task_id){
            $(this).modal().toggle();
        }
    });
});

$(document).on("click", ".completeTaskPersonalBoard" ,function () {
    var task_id = $(this).data("task-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/completeTaskPersonalBoard",
        data: {'task_id': task_id},
        success: function (data) {
            $(".toDoTask").each(function () {
               if($(this).data("task-id") == task_id){
                  $(this).find(".toDoTitle").addClass("completedTaskTitle").removeClass("toDoTitle");
                  $(this).find(".toDoDescription").addClass("completedTaskDescription").removeClass("toDoDescription");
                  $(this).find(".toDoCompleteCheck").addClass("completedTaskCheck").removeClass("toDoCompleteCheck");

                  $(this).addClass("completedTask");
                  $(this).removeClass("toDoTask");
                  $(this).find(".switchStatusTask").addClass("bcg-orange");
                  $(this).find(".switchStatusTask").addClass("c-black");
                  $(this).find(".switchStatusTask").removeClass("c-gray");
                  $(this).find(".completeTaskPersonalBoard").addClass("uncompleteTaskPersonalBoard");
                  $(this).find(".completeTaskPersonalBoard").removeClass("completeTaskPersonalBoard");

                  $(this).appendTo(".completedTasksList");
               }
            });
        }
    });
});

$(document).on("click",".uncompleteTaskPersonalBoard",function () {
    var task_id = $(this).data("task-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/uncompleteTaskPersonalBoard",
        data: {'task_id': task_id},
        success: function (data) {
            $(".completedTask").each(function () {
               if($(this).data("task-id") == task_id){
                   $(this).find(".completedTaskTitle").addClass("toDoTitle").removeClass("completedTaskTitle");
                   $(this).find(".completedTaskDescription").addClass("toDoDescription").removeClass("completedTaskDescription");
                   $(this).find(".completedTaskCheck").addClass("toDoCompleteCheck").removeClass("completedTaskCheck");
                   $(this).find(".switchStatusTask").removeClass("c-black").addClass("c-gray");
                   $(this).find(".switchStatusTask").removeClass("bcg-orange").addClass("bcg-black");
                   $(this).addClass("toDoTask");
                   $(this).removeClass("completedTask");
                   $(this).find(".uncompleteTaskPersonalBoard").addClass("completeTaskPersonalBoard");
                   $(this).find(".uncompleteTaskPersonalBoard").removeClass("uncompleteTaskPersonalBoard");
                   $(this).appendTo(".toDoTasksList");
               }
            });
        }
    });
});

$(".toggleAssistanceForm").on("click",function () {
    $(".assistanceForm").removeClass("hidden");
    $(".assistanceToggleLink").addClass("hidden");
    $(".closeAssistanceForm").removeClass("hidden");
});

$(".closeAssistanceForm").on("click",function () {
    $(".assistanceForm").addClass("hidden");
    $(".assistanceToggleLink").removeClass("hidden");
    $(".closeAssistanceForm").addClass("hidden");
});

