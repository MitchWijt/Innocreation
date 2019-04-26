$(document).ready(function () {
    var team_project_id = $(".teamProjectId").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/getFoldersAndTasks",
        data: {'team_project_id': team_project_id},
        success: function (data) {
            $(".foldersAndTasks").html(data);
            openRecentTask();
        }
    });
});

$(document).on("click", ".collapseFolderButton", function () {
    var id = $(this).data("id");
    var _this = $(this);
    $("#folderCollapse-" + id).on("shown.bs.collapse",function () {
        _this.find(".zmdi-chevron-right").removeClass("zmdi-chevron-right").addClass("zmdi-chevron-down");
    });

    $("#folderCollapse-" + id).on("hidden.bs.collapse",function () {
        _this.find(".zmdi-chevron-down").removeClass("zmdi-chevron-down").addClass("zmdi-chevron-right");
    });
});


function getTaskData(task_id){
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/getTaskData",
        data: {'task_id': task_id},
        success: function (data) {
            $(".taskContent").html(data);
        }
    });
}
$(document).on("click", ".plannerTask", function () {
    var task_id = $(this).data("task-id");
    setRecentTask(task_id);
    setActiveTask(task_id);
    getTaskData(task_id);
});

function setRecentTask(task_id){
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/setRecentTask",
        data: {'task_id': task_id},
        success: function (data) {
            console.log(data);
        }
    });
}

function openRecentTask(){
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/openRecentTask",
        dataType: "JSON",
        data: "",
        success: function (data) {
            var task_id = data['task_id'];
            var folder_id = data['folder_id'];
            setTimeout(function () {
                $("#folderCollapse-" + folder_id).collapse("show");
            }, 500);

            setActiveTask(task_id);
            getTaskData(task_id);
        }
    });
}

function setActiveTask(task_id){
    $(".plannerTask").each(function () {
        $(this).attr("style", "");
    });
    $(".task-" + task_id).attr("style", "background: #77787a");
}


//setup before functions
var typingTimerContent;
var typingTimerTitle;


// updates the content of the content of the task every 2 seconds when user stops typing
$(document).on("keyup", ".taskContentEditor", function () {
    var content = $(this).html();
    var task_id = $(this).data("task-id");

    clearTimeout(typingTimerContent);
    if (content) {
        typingTimerContent = setTimeout(function () {
            doneTyping(content, task_id, "content")
        }, 2000);
    }
});


// updates the title of the task every 2 seconds when user stops typing
$(document).on("keyup", ".titleTask", function () {
    var content = $(this).html();
    var task_id = $(this).data("task-id");

    clearTimeout(typingTimerTitle);
    if (content) {
        typingTimerTitle = setTimeout(function () {
            doneTyping(content, task_id, "title")
        }, 2000);
    }
});

//user is "finished typing," do something
function doneTyping (contentHtml, task_id, category) {
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/updateTaskContent",
        data: {'contentHtml' : contentHtml, 'task_id' : task_id, "category": category},
        success: function (data) {
        }
    });
}

function toggleIconTextEdit(element){
    if(element.hasClass("active-edit")){
        element.removeClass("active-edit");
    } else {
        element.addClass("active-edit");
    }
}

$(document).on("click", ".boldText", function () {
    toggleIconTextEdit($(this));
    var selection = window.getSelection();
    var text = selection.toString();

    if($(this).hasClass("active-edit")){
        var newElement = "<span class='bold'>" + text + "</span>";
    } else {
        var newElement = "<span>" + text + "</span>";
    }

    pasteHtmlAtCaret(newElement);

});

function pasteHtmlAtCaret(html) {
    var sel, range;
    if (window.getSelection) {
        // IE9 and non-IE
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();

            // Range.createContextualFragment() would be useful here but is
            // non-standard and not supported in all browsers (IE9, for one)
            var el = document.createElement("div");
            el.innerHTML = html;
            var frag = document.createDocumentFragment(), node, lastNode;
            while ( (node = el.firstChild) ) {
                lastNode = frag.appendChild(node);
            }
            range.insertNode(frag);

            // Preserve the selection
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    } else if (document.selection && document.selection.type != "Control") {
        // IE < 9
        document.selection.createRange().pasteHTML(html);
    }
}

$(document).on("click", ".toggleAssignMemberDropdown", function () {
    $(".assignMemberBox").toggleClass("hidden");
});

$(document).on("click", ".assignUser", function () {
    var user_id = $(this).data("member-id");
    var task_id = $(this).data("task-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/assignUserToTask",
        dataType: "JSON",
        data: {'memberId' : user_id, "taskId": task_id},
        success: function (data) {
            var name = data['name'];
            var profilePicture = data['profilePicture'];

            $(".avatar-assigner-user").attr("style", "background: url('" + profilePicture + "')").removeClass("hidden");
            $(".name-assigned-user").text(name).removeClass("hidden");
            $(".assignMemberPlaceholder").addClass("hidden");
            $(".assignMemberIcon").addClass("hidden");
        }
    });
});


