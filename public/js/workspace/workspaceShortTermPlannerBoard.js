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
                  $(this).parents(".shortTermTask").find(".dueDate").removeClass("hidden");
                  $(this).parents(".shortTermTask").find(".dueDate").attr("data-short-planner-task-id", data);
                  $(this).parents(".shortTermTask").find(".date").attr("data-short-planner-task-id", data);
                  $(this).parents(".shortTermTask").find(".dateModal").attr("data-short-planner-task-id", data);
                  $(this).parents(".shortTermTask").find(".assignTaskToMemberToggle").attr("data-short-planner-task-id", data);
                  $(this).parents(".shortTermTask").find(".assignTaskToMember option").attr("data-short-planner-task-id", data);
                  $(this).parents(".shortTermTask").find(".date").removeClass("hidden");
                  $(this).parents(".shortTermTask").find(".deleteShortTermTask").attr("data-short-planner-task-id", data);
                  $(this).parents(".shortTermTask").find(".unassign").attr("data-short-planner-task-id", data);
                  $(this).parents(".shortTermTask").attr("data-short-planner-task-id", data);
                   $(this).parents(".shortTermTask").find(".date").datepicker({
                       format: "yyyy-mm-dd",
                       weekStart: 1,
                       autoclose: true,
                       minDate: "<? echo date('Y-m-d') ?>"
                   });
                  $(this).parents(".shortTermTask").find(".date").addClass("datepicker");
                  $(this).parents(".shortTermTask").find(".assignMember").removeClass("hidden");
                  $(this).parents(".shortTermTask").attr("id", "drag-"+data);
                  $(this).parents(".shortTermTaskModalContainer").find(".modal-title").text(title);
                  $(this).parents(".shortTermTask").find(".card-block-new").attr("class", "card-block");
                  $(this).parents(".shortTermTask").find(".shortTermTaskDescription").attr("data-short-planner-task-id", data);
                  $(this).parents(".shortTermTask").find(".modal-title").text(title);
                  $(this).parents(".shortTermTask").find(".modal-title").append("<i class='zmdi zmdi-chevron-down toggleTaskDelete m-l-10'></i>");
                  $(this).parents(".shortTermTask").find(".dateModal").datepicker({
                       format: "yyyy-mm-dd",
                       weekStart: 1,
                       autoclose: true,
                       minDate: "<? echo date('Y-m-d') ?>"
                   });
                  $(this).remove();
               }
            });
        }
    });
});
$(document).on("click", ".dueDate",function () {
    var modal_check = $(this).parents(".shortTermTaskModalContainer").find(".taskModalCheck").val();
    if(modal_check != 1) {
        $(this).parents(".card-task").find(".datepicker").focus();
    } else {
        $(this).parents(".shortTermTaskModalContainer").find(".datepicker").focus();
        $(this).parents(".shortTermTaskModalContainer").find(".dateModal").focus();
    }
});
$(document).on("mouseover", ".dueDateHover, .removeDueDate",function () {
    var modal_check = $(this).parents(".shortTermTaskModalContainer").find(".taskModalCheck").val();
    if(modal_check != 1) {
        $(this).parents(".card-task").find(".removeDueDate").removeClass("hidden");
    } else {
        $(this).parents(".shortTermTaskModalContainer").find(".removeDueDate").removeClass("hidden");
    }
});
$(document).on("mouseleave", ".dueDateHover, .removeDueDate",function () {
    var modal_check = $(this).parents(".shortTermTaskModalContainer").find(".taskModalCheck").val();
    if(modal_check != 1) {
        $(this).parents(".card-task").find(".removeDueDate").addClass("hidden");
    } else {
        $(this).parents(".shortTermTaskModalContainer").find(".removeDueDate").addClass("hidden");
    }
});

$(document).ready(function () {
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        weekStart: 1,
        autoclose: true,
        minDate: "<? echo date('Y-m-d') ?>"
    });
});

$(document).on("change", ".datepicker, .date, .dateModal", function () {
    var task_id = $(this).data("short-planner-task-id");
    var due_date = $(this).val();
    var modal_check = $(this).parents(".shortTermTaskModalContainer").find(".taskModalCheck").val();
    if(modal_check != 1) {
        var text = $(this).parents(".card-block").find(".dueDate").text();
    } else {
        var text = $(this).parents(".shortTermTaskModalContainer").find(".dueDate").text();
    }
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
$(document).on("click",".removeDueDate",function (event) {
    event.preventDefault();
    var task_id = $(this).data("short-planner-task-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/removeShortTermPlannerTaskDueDate",
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
    var member_user_id = $(this).val();
    console.log(member_user_id);
    var modal_check = $(this).parents(".shortTermTaskModalContainer").find(".taskModalCheck").val();
    if(modal_check != 1) {
        var task_id = $(this).parents(".shortTermTask").find(".assignTaskToMember option:selected").data("short-planner-task-id");
    } else {
        var task_id = $(this).parents(".shortTermTaskModalContainer").find(".assignTaskToMember option:selected").data("short-planner-task-id");
    }
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
                    if(member_user_id != "nobody") {
                        $(this).parents(".assignMember").find(".memberAssignPlaceholder").addClass("hidden");
                        $(this).parents(".assignMember").find(".memberAssignIcon").addClass("hidden");
                        if ($(this).hasClass("placeholderMemberAssign")) {
                            var profilepicture = "<img class='circle circleSmall assignTaskToMemberToggle' src=" + data + " data-short-planner-id=" + task_id + ">";
                            $(this).parents(".assignMember").find("img").remove();
                            $(this).parents(".assignMember").prepend(profilepicture);
                            $(this).addClass("hidden");
                        }
                        $(this).attr("src", data);
                        if (modal_check != 1) {
                            $(this).parents(".shortTermTask").find(".collapse").collapse('toggle');
                        }
                    } else {
                        $(this).parents(".assignMember").find(".memberAssignPlaceholder").removeClass("hidden");
                        $(this).parents(".assignMember").find(".memberAssignIcon").removeClass("hidden");
                        $(this).parents(".assignMember").find(".placeholderMemberAssign").removeClass("hidden");
                        $(this).parents(".assignMember").find(".hasImage").removeClass("hidden");
                        $(this).parents(".assignMember").find("img").addClass("hidden");
                        if (modal_check != 1) {
                            $(this).parents(".shortTermTask").find(".collapse").collapse('toggle');
                        }
                    }
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
                        $(this).parents(".shortTermTask").find(".deleteShortTermTask").attr("data-short-planner-task-id", data);
                        $(this).parents(".shortTermTask").attr("data-short-planner-task-id", data);
                        $(this).parents(".shortTermTask").attr("id", "drag-"+task_id[1]);
                        $(this).parents(".shortTermTask").find(".unassign").attr("data-short-planner-task-id", data);
                        $(this).parents(".shortTermTaskModalContainer").find(".dueDate").removeClass("hidden");
                        $(this).parents(".shortTermTaskModalContainer").find(".dueDate").attr("data-short-planner-task-id", data);
                        $(this).parents(".shortTermTaskModalContainer").find(".datepicker").attr("data-short-planner-task-id", data);
                        $(this).parents(".shortTermTaskModalContainer").find(".assignTaskToMemberToggle").attr("data-short-planner-task-id", data);
                        $(this).parents(".shortTermTaskModalContainer").find(".assignTaskToMember option").attr("data-short-planner-task-id", data);
                        $(this).parents(".shortTermTaskModalContainer").find(".datepicker").removeClass("hidden");
                        $(this).parents(".shortTermTaskModalContainer").find(".assignMember").removeClass("hidden");
                        $(this).parents(".shortTermTask").find(".card-block-new").attr("class", "card-block");
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
$(document).on("click", ".toggleTaskDelete",function () {
    $(".deleteShortTermTask").toggle();
});
$(document).ready(function () {
    $(".taskMenu").removeClass("hidden");
    $(".taskMenu").toggle();
    $(".deleteShortTermTask").removeClass("hidden");
    $(".deleteShortTermTask").toggle();
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
$(document).on("click", ".card-block .dueDate",function (e) {
    e.stopPropagation();
});
$(document).on("click", ".card-block .removeDueDate",function (e) {
    e.stopPropagation();
});
$(document).on("click", ".card-block .assignTaskToMemberToggle",function (e) {
    e.stopPropagation();
});
$(document).on("change", ".card-block .collapse",function (e) {
    e.stopPropagation();
});
$(document).on("click", ".card-block", function (e) {
    $(this).parents(".shortTermTask").find("#shortTermTaskModal").modal().toggle();
});

$('.shortTermTaskModal').on('hidden.bs.modal', function () {
    $(".shortTermTask").attr("draggable", true);
});

$('.shortTermTaskModal').on('show.bs.modal', function () {
    $(".shortTermTask").attr("draggable", false);
});

$(document).on("keyup", ".shortTermTaskDescription",function () {
    var description = $(this).val();
    var task_id = $(this).data("short-planner-task-id");
    setTimeout(function () {
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/workspace/saveShortTermPlannerTaskDescription",
            data: {'description': description, 'task_id': task_id},
            success: function (data) {

            }
        });
    },500);
});

$(document).on("click", ".deleteShortTermTask",function () {
    var task_id = $(this).data("short-planner-task-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/deleteShortTermPlannerTask",
        data: {'task_id': task_id},
        success: function (data) {
            $(".shortTermTask").each(function () {
               if($(this).data("short-planner-task-id") == task_id){
                   $(this).find("#shortTermTaskModal").modal('hide');
                   $(this).fadeOut();
               }
            });
        }
    });
});

