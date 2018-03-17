$(".toggleBoardRename").on("click",function () {
   $(".boardMenu").toggle();
});

$(document).ready(function () {
   $(".boardMenu").removeClass("hidden");
   $(".boardMenu").toggle();
});

$(document).on("click", ".addShortTermTask",function () {
    var category = $(this).data("short-term-planner-category");
    var task = $('.emptyCard').first().clone();
    $(".shortTermtasksColumn").each(function () {
       if($(this).data("short-term-planner-category") == category){
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
$(document).on("click", ".dueDate",function () {
    $(this).parents(".card-task").find(".datepicker").focus();
});

$(".dueDateHover").on("mouseover",function () {
    $(this).parents(".card-task").find(".removeDueDate").removeClass("hidden");
});
$(".dueDateHover").on("mouseleave",function () {
    $(this).parents(".card-task").find(".removeDueDate").addClass("hidden");
});

$(document).ready(function () {
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        weekStart: 1,
        autoclose: true,
        minDate: "<? echo date('Y-m-d') ?>"
    });
});

$(".datepicker").on("change",function () {
    var task_id = $(this).data("short-planner-task-id");
    var due_date = $(this).val();
    var text = $(this).parents(".card-block").find(".dueDate").text();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/setShortTermPlannerTaskDueDate",
        data: {'task_id': task_id,'due_date' : due_date},
        success: function (data) {
            $(".dueDate").each(function () {
                if($(this).data("short-planner-task-id") == task_id){
                    $(this).text(data);
                    if(text == "Set due date"){
                        var dueDateHover = $(this).parents(".dueDateHover");
                        $("<i class='zmdi zmdi-close hidden removeDueDate m-t-6 m-l-10 c-pointer' data-short-planner-task-id="+task_id+"></i>").appendTo(dueDateHover);
                    }
                }
            });
        }
    });
});

$(document).on("click",".removeDueDate",function () {
    var task_id = $(this).data("short-planner-task-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/setShortTermPlannerTaskDueDate",
        data: {'task_id': task_id},
        success: function (data) {
            $(".dueDate").each(function () {
                if($(this).data("short-planner-task-id") == task_id){
                    $(this).parents(".dueDateHover").find(".removeDueDate").remove();
                    var dueDateHover = $(this).parents(".dueDateHover");
                    $(this).remove();
                    $("<p class='c-orange f-13 m-b-0 m-t-5 dueDate underline c-pointer' data-short-planner-task-id="+task_id+"><i class='zmdi zmdi-plus m-r-5'></i>Set due date</p>").appendTo(dueDateHover);

                }
            });
        }
    });
});
$(document).on("click", ".assignTaskToMemberToggle", function () {
   $(this).parents(".shortTermTask").find(".collapse").collapse('toggle');
});

$(document).on("change",".assignTaskToMember",function () {
    var task_id = $(this).parents(".shortTermTask").find(".assignTaskToMember option:selected").data("short-planner-task-id");
    var member_user_id = $(this).val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/assignTaskToMemberShortTermPlanner",
        data: {'task_id': task_id, 'member_user_id' : member_user_id},
        success: function (data) {
            $(".assignTaskToMemberToggle").each(function () {
                if($(this).data("short-planner-task-id") == task_id){
                    $(this).parents(".assignMember").find(".memberAssignPlaceholder").addClass("hidden");
                    $(this).parents(".assignMember").find(".memberAssignIcon").addClass("hidden");
                    if($(this).hasClass("placeholderMemberAssign")){
                        var profilepicture = "<img class='circle circleSmall assignTaskToMemberToggle' src="+data+" data-short-planner-id="+task_id+">";
                        $(this).parents(".assignMember").find("img").remove();
                        $(this).parents(".assignMember").append(profilepicture);
                        $(this).addClass("hidden");
                    }
                    $(this).attr("src", data);
                    $(this).parents(".shortTermTask").find(".collapse").collapse('toggle');
                }
            });
        }
    });
});

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev, el,category) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    el.appendChild(document.getElementById(data));
    var task_id_text = ev.dataTransfer.getData("text");
    var task_id = task_id_text.split("-");
    if(task_id[2] == "menuTask"){
        var menu_task_category = task_id[4];
        var board_id = task_id[3];
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/workspace/menuTaskToShortTermPlanner",
            data: {'category': category, 'menu_task_id': task_id[1], 'board_id' : board_id, 'menu_task_category' : menu_task_category},
            success: function (data) {
                $(".menuTask").each(function () {
                    if($(this).data("menu-task-id") == task_id[1]){
                        $(this).parents(".shortTermTask").find(".dueDate").removeClass("hidden");
                        $(this).parents(".shortTermTask").find(".dueDate").attr("data-short-planner-task-id", data);
                        $(this).parents(".shortTermTask").find(".datepicker").attr("data-short-planner-task-id", data);
                        $(this).parents(".shortTermTask").find(".assignTaskToMemberToggle").attr("data-short-planner-task-id", data);
                        $(this).parents(".shortTermTask").find(".assignTaskToMember option").attr("data-short-planner-task-id", data);
                        $(this).parents(".shortTermTask").find(".datepicker").removeClass("hidden");
                        $(this).parents(".shortTermTask").find(".assignMember").removeClass("hidden");
                        $(this).parents(".shortTermTask").attr("id", "drag-"+task_id[1]);
                    }
                });
            }
        });
    } else {
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/workspace/changePlaceShortTermPlannerTask",
            data: {'category': category, 'short_term_planner_task_id': task_id[1]},
            success: function (data) {

            }
        });
    }
}

$(".toggleTaskmenu").on("click",function () {
    $(".taskMenu").toggle();
});

$(document).ready(function () {
    $(".taskMenu").removeClass("hidden");
    $(".taskMenu").toggle();
});

$(".toggleBucketlistGoals").on("click",function () {
   $(".passedIdeas").addClass("hidden");
   $(".uncompletedBucketlistGoals").removeClass("hidden");
});

$(".togglePassedIdeas").on("click",function () {
   $(".uncompletedBucketlistGoals").addClass("hidden");
   $(".passedIdeas").removeClass("hidden");
});

$(".renameShortTermPlannerBoard").on("click",function () {
    $(".shortTermPlannerBoardTitle").addClass("hidden");
    $(".toggleBoardRename").addClass("hidden");
    $(".renameShortTermPlannerBoardInput").removeClass("hidden");
    $(".boardMenu").toggle();
});

$(".renameShortTermPlannerBoardInput").on("change",function () {
    var title = $(this).val();
    var board_id = $(this).data("short-term-planner-board-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/changeShortTermPlannerBoardTitle",
        data: {'board_id': board_id, 'title': title},
        success: function (data) {
            $(".shortTermPlannerBoardTitle").text(title);
            $(".shortTermPlannerBoardTitle").removeClass("hidden");
            $(".renameShortTermPlannerBoardInput").addClass("hidden");
        }
    });
});
