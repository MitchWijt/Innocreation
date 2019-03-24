$(".toggleBoardRename").on("click",function () {
   $(".boardMenu").toggle();
});

$(document).ready(function () {
   $(".boardMenu").removeClass("hidden");
   $(".boardMenu").toggle();

    $(".taskMenu").removeClass("hidden");
    $(".taskMenu").toggle();
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
var inputCounter = 0;
// $(document).on("keyup", ".shortTermTaskTitleInput",function () {
//     inputCounter++;
// });
// $("body").on("click",function () {
//     $(".emptyCard").each(function () {
//         if (!$(this).hasClass("hidden") && inputCounter < 1) {
//             $(this).remove();
//         }
//     });
// });

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
                  $(this).parents(".shortTermTask").find(".dueDate").attr("data-short-planner-task-id", data["task_id"]);
                  $(this).parents(".shortTermTask").find(".date").attr("data-short-planner-task-id", data["task_id"]);
                  $(this).parents(".shortTermTask").find(".dateModal").attr("data-short-planner-task-id", data["task_id"]);
                  $(this).parents(".shortTermTask").find(".assignTaskToMemberToggle").attr("data-short-planner-task-id", data["task_id"]);
                  $(this).parents(".shortTermTask").find(".assignTaskToMember option").attr("data-short-planner-task-id", data["task_id"]);
                  $(this).parents(".shortTermTask").find(".date").removeClass("hidden");
                  $(this).parents(".shortTermTask").find(".deleteShortTermTask").attr("data-short-planner-task-id", data["task_id"]);
                  $(this).parents(".shortTermTask").find(".completeShortTermTaskCard").attr("data-short-planner-task-id", data["task_id"]);
                  $(this).parents(".shortTermTask").find(".unassign").attr("data-short-planner-task-id", data["task_id"]);
                  $(this).parents(".shortTermTask").find(".card-block").attr("data-short-planner-task-id", data["task_id"]);
                  $(this).parents(".shortTermTask").find(".priorityTask").attr("data-short-planner-task-id", data["task_id"]);
                  $(this).parents(".shortTermTask").find(".short-planner-task-id").val(data["task_id"]);
                  $(this).parents(".shortTermTask").attr("data-short-planner-task-id", data["task_id"]);
                   $(this).parents(".shortTermTask").find(".date").datepicker({
                       format: "yyyy-mm-dd",
                       weekStart: 1,
                       autoclose: true,
                       minDate: "<? echo date('Y-m-d') ?>"
                   });
                  $(this).parents(".shortTermTask").find(".date").addClass("datepicker");
                  $(this).parents(".shortTermTask").find(".assignMember").removeClass("hidden");
                  $(this).parents(".shortTermTask").attr("id", "drag-"+data["task_id"]);
                  $(this).parents(".shortTermTaskModalContainer").find(".modal-title").text(title);
                  $(this).parents(".shortTermTask").find(".card-block-new").attr("class", "card-block");
                  $(this).parents(".shortTermTask").find(".card-task").attr("data-category", data["category"]);
                  $(this).parents(".shortTermTask").find(".card-task").attr("data-short-planner-task-id", data["task_id"]);
                  $(this).parents(".shortTermTask").find(".shortTermTaskDescription").attr("data-short-planner-task-id", data["task_id"]);
                  $(this).parents(".shortTermTask").find(".modal-title").text(title);
                  $(this).parents(".shortTermTask").find(".modal-title").append("<i class='zmdi zmdi-chevron-down toggleTaskDelete m-l-10'></i>");
                  $(this).parents(".shortTermTask").find(".modal-title").prepend("<i class='zmdi zmdi-check circle circleSmall border-inno-black f-18 text-center completeShortTermTask' data-short-planner-task-id="+data["task_id"]+"></i>");
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
    $(".shortTermTaskModalShared").find(".datepicker").datepicker({
        format: "yyyy-mm-dd",
        weekStart: 1,
        autoclose: true,
        minDate: "<? echo date('Y-m-d') ?>"
    });
    $(this).parents(".card-task").find(".datepicker").focus();
    $(".shortTermTaskModalShared").find(".datepicker").focus();
    $(".shortTermTaskModalShared").find(".dateModal").focus();
});
$(document).on("mouseover", ".dueDateHover, .removeDueDate",function () {
    $(this).parents(".card-task").find(".removeDueDate").removeClass("hidden");
    $(".shortTermTaskModalShared").find(".removeDueDate").removeClass("hidden");
});
$(document).on("mouseleave", ".dueDateHover, .removeDueDate",function () {
    $(this).parents(".card-task").find(".removeDueDate").addClass("hidden");
    $(".shortTermTaskModalShared").find(".removeDueDate").addClass("hidden");
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
                            var profilepicture = "<div class='avatar-sm assignTaskToMemberToggle img' data-short-planner-task-id=" + task_id + " style=background:url('" + data + "')" + "></div>";
                            $(this).parents(".assignMember").find(".img").remove();
                            $(this).parents(".assignMember").prepend(profilepicture);
                            $(this).addClass("hidden");
                        }
                        // $(this).attr("src", data);
                        if (modal_check != 1) {
                            $(this).parents(".shortTermTask").find(".collapse").collapse('toggle');
                        }
                    } else {
                        $(this).parents(".assignMember").find(".memberAssignPlaceholder").removeClass("hidden");
                        $(this).parents(".assignMember").find(".memberAssignIcon").removeClass("hidden");
                        $(this).parents(".assignMember").find(".placeholderMemberAssign").removeClass("hidden");
                        $(this).parents(".assignMember").find(".hasImage").removeClass("hidden");
                        $(this).parents(".assignMember").find(".img").addClass("hidden");
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

var yellow = $('.board');
var offset = yellow.offset();
var offsetWidth = offset.left + yellow.width();
var offsetHeight = offset.top + yellow.height();



var intRightHandler = null;
var intLeftHandler = null;
var intTopHandler= null;
var intBottomHandler= null;
var distance = 70;
var timer = 5;
var step = 7;




function clearInetervals()
{
    clearInterval(intRightHandler);
    clearInterval(intLeftHandler);
    clearInterval(intTopHandler);
    clearInterval(intBottomHandler);
}
function drag(e) {
    $('.board').css({
        overflow: 'hidden'
    });
    $('html, body').css({
        overflow: 'hidden'

    });
    e.dataTransfer.setData("text", e.target.id);
}

function dragging(e){
    var isMoving = false;
    //Left
    if((e.pageX - offset.left) <= distance)
    {
        isMoving = true;
        clearInetervals();
        intLeftHandler= setInterval(function(){
            yellow.scrollLeft(yellow.scrollLeft() - step)
        },timer);
    }

    //Right
    if(e.pageX >= (offsetWidth - distance))
    {
        isMoving = true;
        clearInetervals();
        intRightHandler = setInterval(function(){
            yellow.scrollLeft(yellow.scrollLeft() + step)
        },timer);
    }

    //Top
    if((e.pageY - offset.top) <= distance)
    {
        isMoving = true;
        clearInetervals();
        intTopHandler= setInterval(function(){
            yellow.scrollTop(yellow.scrollTop() - step)
        },timer);
    }

    //Bottom
    if(e.pageY >= (offsetHeight - distance))
    {
        isMoving = true;
        clearInetervals();
        intBottomHandler= setInterval(function(){
            yellow.scrollTop(yellow.scrollTop() + step)
        },timer);
    }

    //No events
    if(!isMoving) {
        clearInetervals();
    }
}

function drop(ev, el,category) {
    $('html, body').css({
        overflow: 'auto',
        height: 'auto'
    });
    $('.board').css({
        overflow: 'auto',
        height: 'auto'
    });
    clearInetervals();
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
                        $(this).parents(".shortTermTask").find(".dueDate").attr("data-short-planner-task-id", data["task_id"]);
                        $(this).parents(".shortTermTask").find(".datepicker").attr("data-short-planner-task-id", data["task_id"]);
                        $(this).parents(".shortTermTask").find(".assignTaskToMemberToggle").attr("data-short-planner-task-id", data["task_id"]);
                        $(this).parents(".shortTermTask").find(".assignTaskToMember option").attr("data-short-planner-task-id", data["task_id"]);
                        $(this).parents(".shortTermTask").find(".datepicker").removeClass("hidden");
                        $(this).parents(".shortTermTask").find(".assignMember").removeClass("hidden");
                        $(this).parents(".shortTermTask").find(".deleteShortTermTask").attr("data-short-planner-task-id", data["task_id"]);
                        $(this).parents(".shortTermTask").find(".completeShortTermTaskCard").attr("data-short-planner-task-id", data["task_id"]);
                        $(this).parents(".shortTermTask").find(".completeShortTermTask").attr("data-short-planner-task-id", data["task_id"]);
                        $(this).parents(".shortTermTask").find(".priorityTask").attr("data-short-planner-task-id", data["task_id"]);
                        $(this).parents(".shortTermTask").find(".short-planner-task-id").val(data["task_id"]);
                        $(this).parents(".shortTermTask").attr("data-short-planner-task-id", data["task_id"]);
                        $(this).parents(".shortTermTask").attr("id", "drag-"+task_id[1]);
                        $(this).parents(".shortTermTask").find(".unassign").attr("data-short-planner-task-id", data["task_id"]);
                        $(this).parents(".shortTermTask").find(".card-block").attr("data-short-planner-task-id", data["task_id"]);
                        $(this).parents(".shortTermTask").find(".card-block-new").attr("class", "card-block");
                        $(this).parents(".shortTermTask").find(".card-task").attr("data-category", data["category"]);
                        $(this).parents(".shortTermTask").find(".card-task").attr("data-short-planner-task-id", data["task_id"]);
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
    var task_id = $(this).data("short-planner-task-id");
    var team_id = $(this).data("team-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/getDataShortTermTaskModal",
        data: {'task_id': task_id, 'team_id': team_id},
        success: function (data) {
            $(".taskModalData").html(data);
            $(".shortTermTaskModalShared").modal().toggle();
            $(".deleteShortTermTask").removeClass("hidden");
            $(".deleteShortTermTask").toggle();
        }
    });
});

$(document).on("click", ".customTextarea", function () {
    if($(".clicked").text() != "1") {
        var editor;
        editor = ContentTools.EditorApp.get();
        editor.init('*[data-editable]', 'data-name');
        $(".ct-ignition__button--edit").trigger("click");
        $(".ct-inspector").remove();
        $(".ce-element--type-text").addClass("ce-element--focused");
        $(".shortTermPlannertextarea").focus();

        setInterval(function () {

        }, 2000);
    }
    $(".clicked").text("1");
});

$('.shortTermTaskModal').on('hidden.bs.modal', function () {
    $(".shortTermTask").attr("draggable", true);
    $(".ct-widget").hide();
    $(".clicked").text("");
    $(".customTextarea").unbind("click");
});

$('.shortTermTaskModal').on('show.bs.modal', function () {
    $(".shortTermTask").attr("draggable", false);
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
                   $(".shortTermTaskModalShared").modal('hide');
                   $(this).fadeOut();
               }
            });
        }
    });
});

$(document).on("click",".completeShortTermTask",function () {
    var task_id = $(this).data("short-planner-task-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/completeShortTermPlannerTask",
        data: {'task_id': task_id},
        success: function (data) {
           if(data == 1){
               $(".completeShortTermTask").each(function () {
                  if($(this).data("short-planner-task-id") == task_id){
                      $(this).addClass("bcg-orange");
                      if($(this).data("card") == 1){
                          $(this).removeClass("hidden");
                      }
                  }
               });
               $(".completeShortTermTaskCard").each(function () {
                   if($(this).data("short-planner-task-id") == task_id){
                       $(this).removeClass("hidden");
                   }
               });
           } else if(data == 2){
               $(".completeShortTermTask").each(function () {
                   if($(this).data("short-planner-task-id") == task_id){
                       $(this).removeClass("bcg-orange");
                       if($(this).data("card") == 1){
                           $(this).addClass("hidden");
                       }
                   }
               });
               $(".completeShortTermTaskCard").each(function () {
                   if($(this).data("short-planner-task-id") == task_id){
                       $(this).addClass("hidden");
                   }
               });
           }
        }
    });
});

$(document).on("change", ".setShortTermTaskPriority", function () {
    var task_id = $(this).parents(".shortTermTaskModalContainer").find(".short-planner-task-id").val();
    var priority = $(this).parents(".shortTermTaskModalContainer").find(".setShortTermTaskPriority option:selected").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/setPriorityShortTermPlannerTask",
        data: {'task_id': task_id, 'priority' : priority},
        success: function (data) {
            $(".priorityTask").each(function () {
                if($(this).data("short-planner-task-id") == task_id) {
                    if (data == "High") {
                        $(this).text(data);
                        $(this).removeClass("c-black");
                        $(this).removeClass("c-orange");
                        $(this).removeClass("c-green");
                        $(this).removeClass("c-black");
                        $(this).addClass("c-red");
                    } else if(data == "Medium"){
                        $(this).text(data);
                        $(this).removeClass("c-black");
                        $(this).removeClass("c-red");
                        $(this).removeClass("c-green");
                        $(this).addClass("c-orange");
                    } else if(data == 'Low'){
                        $(this).text(data);
                        $(this).removeClass("c-black");
                        $(this).removeClass("c-orange");
                        $(this).removeClass("c-red");
                        $(this).addClass("c-green");
                    }
                }
            });
        }
    });
});

$(document).ready(function () {
   if($(".urlParameter").val()){
        $(".card-block").each(function () {
            if($(this).data("short-planner-task-id") == $(".urlParameter").val()){
                var task_id = $(this).data("short-planner-task-id");
                var team_id = $(this).data("team-id");
                $.ajax({
                    method: "POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');

                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    url: "/workspace/getDataShortTermTaskModal",
                    data: {'task_id': task_id, 'team_id': team_id},
                    success: function (data) {
                        $(".taskModalData").html(data);
                        $(".shortTermTaskModalShared").modal().toggle();
                        $(".deleteShortTermTask").removeClass("hidden");
                        $(".deleteShortTermTask").toggle();
                    }
                });
            }
        });
   }

   $(".menuShortTermPlanner").removeClass("hidden");
   $(".menuShortTermPlanner").toggle();
});

$(".toggleMenu").on("click",function () {
    $(this).parents(".category").find(".menuShortTermPlanner").toggle();
});

$(".completeAllTasks").on("click",function () {
    var category = $(this).data("category");
        $(".card-task").each(function () {
            if ($(this).data("category") == category && $(this).data("completed") != "1") {
                $(this).attr("data-completed", "1");
                var task_id = $(this).data("short-planner-task-id");
                $.ajax({
                    method: "POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');

                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    url: "/workspace/completeShortTermPlannerTask",
                    data: {'task_id': task_id},
                    success: function (data) {
                        $(".completeShortTermTask").each(function () {
                            if ($(this).data("short-planner-task-id") == task_id) {
                                $(this).addClass("bcg-orange");
                                if ($(this).data("card") == 1) {
                                    $(this).removeClass("hidden");
                                }
                            }
                        });
                        $(".completeShortTermTaskCard").each(function () {
                            if ($(this).data("short-planner-task-id") == task_id) {
                                $(this).removeClass("hidden");
                            }
                        });
                    }
                });
            }
        });
});

// var curYPos = 0,
//     curXPos = 0,
//     curDown = false;
//
// window.addEventListener('mousemove', function(e){
//     if(curDown === true){
//         window.scrollTo(document.body.scrollLeft + (curXPos - e.pageX), document.body.scrollTop + (curYPos - e.pageY));
//     }
// });
//
// window.addEventListener('mousedown', function(e){ curDown = true; curYPos = e.pageY; curXPos = e.pageX; });
// window.addEventListener('mouseup', function(e){ curDown = false; });



// red.draggable({
//     start : function(){},
//     stop: function(){ },
//     drag : function(e){
//
//     }
// });





