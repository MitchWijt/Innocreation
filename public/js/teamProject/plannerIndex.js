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

$(document).on("click", ".textEditor", function () {
    var type = $(this).data("type");
    toggleIconTextEdit($(this));
    var selection = window.getSelection();
    var text = selection.toString();

    if(text.length > 0) {
        if ($(this).hasClass("active-edit")) {
            var newElement = getNewElement(type, text);
            pasteHtmlAtCaret(newElement);
        } else {
            var newObject = document.createElement("span");
            newObject.innerHTML = text;
            getSelectionStart("true").replaceWith(newObject);
        }
    }
});

function getNewElement(type, text){
    if(type == "bold"){
        var element = "<span class='bold'>" + text + "</span>";
    } else if(type == "italic"){
        var element = "<span class='italic'>" + text + "</span>";
    } else if(type == "underlined"){
        var element = "<span class='underlined'>" + text + "</span>";
    }

    return element;
}

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


$(document).on("click", ".taskContentEditor", function () {
    var element = getSelectionStart();
    $(".textEditor").each(function () {
        var type = $(this).data("type");
        if(element.indexOf(type) > 0){
            $(this).addClass("active-edit");
        } else {
            $(this).removeClass("active-edit");
        }
    });
});

//get current html element that carret(cursor) is in. This so it can detect Bold text etc.
function getSelectionStart(object) {
    var node = document.getSelection().anchorNode;

    if(object == "true"){
        return (node.nodeType == 3 ? node.parentNode : node);
    } else {
        return (node.nodeType == 3 ? node.parentNode.outerHTML : node.outerHTML);
    }
}

