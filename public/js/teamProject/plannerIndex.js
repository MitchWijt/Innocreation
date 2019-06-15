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
            // checks if values activeTaskId and activeFolderId are set in the input fields in the view that come from the controller.
            // if so it will Collapse the recent folder and select the recentTask.
            $(".foldersAndTasks").html(data);
            if (typeof $("#activeTaskId").val() !== "undefined" && typeof $("#activeFolderId").val().length !== "undefined") {
                openRecentTask($("#activeTaskId").val(), $("#activeFolderId").val());
            } else if(typeof $("#activeFolderId").val().length !== "undefined"){
                openRecentFolder($("#activeFolderId").val());
            }
            setContextmenuEvent();
        }
    });
});

//gets task of clicked folder and appends a collapse with tasks as a shared view to the folder + collapses the collapse with tasks.
$(document).on("click", ".collapseFolderButton", function () {
    var _this = $(this);
    var id = $(this).attr("id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/getTasksOfFolder",
        data: {'folder_id': id},
        success: function (data) {
            if($("#folderCollapse-" + id).length < 1) {
                _this.parents(".singleFolder").append(data);
            }
            var collapseItem =  $("#folderCollapse-" + id);
            collapseItem.collapse("toggle");

            collapseItem.on("shown.bs.collapse",function () {
                setRecentFolder(id);
                _this.find(".zmdi-chevron-right").removeClass("zmdi-chevron-right").addClass("zmdi-chevron-down");
            });

            collapseItem.on("hidden.bs.collapse",function () {
                $("#folderCollapse-" + id).remove();
                removeRecentFolderSession();
                _this.find(".zmdi-chevron-down").removeClass("zmdi-chevron-down").addClass("zmdi-chevron-right");

            });
            setContextmenuEvent();
        }
    });


});


function getTaskData(task_id){
    var team_project_id = $(".teamProjectId").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/getTaskData",
        data: {'task_id': task_id, "team_project_id" : team_project_id},
        success: function (data) {
            $(".taskContent").html(data);
        }
    });
}
$(document).on("click", ".plannerTask", function () {
    $(".contentEditFunctions").addClass("hidden");
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
        dataType: "JSON",
        success: function (data) {
            window.history.pushState(null, null, '/my-team/project/' + data['teamProjectSlug'] + "?th=" + data['taskHash'] + "&fh=" + data['folderHash']);
        }
    });
}

function setRecentFolder(folder_id){
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/setRecentFolder",
        data: {'folder_id': folder_id},
        dataType: "JSON",
        success: function (data) {
            $("#activeFolderId").val(folder_id);
            window.history.pushState(null, null, '/my-team/project/' + data['teamProjectSlug'] + "?fh=" + data['folderHash']);
        }
    });
}

function removeRecentFolderSession(){
    if(typeof $("#activeFolderId").val() !== "undefined"){
        var folderId = $("#activeFolderId").val();
        var postData = {"folderId" : folderId};
    } else {
        postData = null;
    }
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/removeRecentFolderSession",
        data: postData,
        dataType: "JSON",
        success: function (data) {
            window.history.pushState(null, null, '/my-team/project/' + data['teamProjectSlug']);
        }
    });
}

function openRecentTask(task_id, folder_id){
    setTimeout(function () {
        $(".folder-" + folder_id).click();
    }, 500);

    setTimeout(function () {
        setRecentTask(task_id);
        setActiveTask(task_id);
    }, 1000);
    getTaskData(task_id);
}

function openRecentFolder(folder_id){
    setTimeout(function () {
        $(".folder-" + folder_id).click();
    }, 500);
}

function setActiveTask(task_id){
    $(".plannerTask").each(function () {
        $(this).attr("style", "");
    });
    $(".task-" + task_id).attr("style", "background: #B4B7BA");
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

    if(key.isPressed("enter")){
        $(".taskContentEditor").focus();

        //deleted the white enter placed in title and focusses on the editable content of the task.
        var titleVal =  $(this).text();
        $(".titleTask").html(titleVal);
    }

    if(!key.isPressed("enter")) {
        clearTimeout(typingTimerTitle);
        if (content) {
            typingTimerTitle = setTimeout(function () {
                doneTyping(content, task_id, "title")
            }, 1000);
        }
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
        dataType: "JSON",
        success: function (data) {
            var folderId = data['folderId'];
            var view = data['view'];
            getTasksAndCollapseForFolder(folderId, view);
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
    var task_id = $(this).data("task-id");
    var type = $(this).data("type");


    if(document.execCommand(type, false, null)){
        toggleIconTextEdit($(this));
    }

    doneTyping($(".taskContentEditor").html(), task_id, 'content');
});


//return new element to replace the old one with the existing styles array and new style in parameter.
function getNewElement(temp, text, css, id){
    var typeString = "";
    //loops through the existing style classes in array from selected element.
    $.each(temp, function(index, value ) {
        //adds the current style text (bold, italic etc...) to a string next to each other
        typeString = typeString + " " + value;
    });
    // creates new element with class name and css based upon the created string above.
    if(css){
        var element = "<span style='" + css + "' class='" + typeString + "'>" + text + "</span>";
    } else if(id){
        var element = "<span id='" + id +"' class='" + typeString + "'>" + text + "</span>";
    } else {
        var element = "<span class='" + typeString + "'>" + text + "</span>";
    }

    return element;
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
    //gets current element that is clicked on.
    var element = getSelectionStart();
    var object = getSelectionStart("true");

    //show edit functions
    $(".contentEditFunctions").removeClass("hidden");

    //loops through all the text editor function (bold, italic, underlined)
    $(".textEditor").each(function () {
        var _this = $(this);
        //grabs the type (bold, italic, etc...) from the textEditor element data type
        var type = $(this).data("type");

        //checks if styleType is applied on current selected element and makes corresponding textEditor icon active if applied to element.
        if(document.queryCommandState(type)){
            _this.addClass("active-edit");
        } else {
            _this.removeClass("active-edit");
        }
    });


    if(element.indexOf("font-family")){
        var fontFamily = object.style.fontFamily;

        if(fontFamily.length > 0){
            $(".font").find(".select-selected").text(fontFamily);
        } else {
            $(".font").find(".select-selected").text("Corbert-Regular");
        }
    }

    if(element.indexOf("font-size")){
        var size = object.style.fontSize;
        if(size.length > 0){
            var numberSize = size.replace("px", "");
            $(".fontSize").find(".select-selected").text(numberSize);
        } else {
            $(".fontSize").find(".select-selected").text("14");
        }

        if(size.indexOf("rem") > 0){
            $(".fontSize").find(".select-selected").text("14");
        }
    }

    if(element.indexOf("color")){
        var color = object.getAttribute("color");
        updateColor(color);
    }
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

function uniqueId(){
    function Generator() {}

    Generator.prototype.rand =  Math.floor(Math.random() * 26) + Date.now();

    Generator.prototype.getId = function() {
        return this.rand++;
    };
    var idGen =new Generator();
    var newId = idGen.getId();

    return newId;
}

// ==================== font size + font style =====================

$(document).on("click", ".custom-select", function () {
    var selection = window.getSelection();
    var text = selection.toString();

    var selectedOption = $(this).find(".select-selected").text();
    var selectType = $(this).data("type");

    if(selectType == "fontSize"){
        var css = 'font-size:' + selectedOption + 'px';
    } else {
        var css = 'font-family:' + selectedOption;
    }

    var newElement = getNewElement(null, text, css);
    document.execCommand("insertHTML", false, newElement);

    var task_id = $(this).data("task-id");
    doneTyping($(".taskContentEditor").html(), task_id, 'content');
});

//color picker
$(document).on("click", ".font-color-icon", function () {
    $(".colorpicker").toggleClass("hidden");
});

$(document).on("click", ".codeToggleIcon", function () {
    toggleIconTextEdit($(this));
    if($(this).hasClass("active-edit")){
        document.execCommand('formatBlock', false, "<blockquote>");
    } else {
        document.execCommand('formatBlock', false, "<div>");
    }
});

function saveContent(){
    var task_id = $("#taskId").val();
    var content = $(".taskContentEditor").html();
    doneTyping(content, task_id, "content");
}

//keyboard keys defined
key('⌘+b, ctrl+b', function(event){
    document.execCommand("bold", false, null);
    event.preventDefault();
    saveContent();
    return false;
});

key('⌘+i, ctrl+i', function(event){
    document.execCommand("italic", false, null);
    event.preventDefault();
    saveContent();
    return false;
});

key('⌘+u, ctrl+u', function(event){
    document.execCommand("underline", false, null);
    event.preventDefault();
    saveContent();
    return false;
});

$(document).on("keyup", ".taskContentEditor", function () {
    if(key.isPressed(32)) {
        var element = getSelectionStart("true").innerHTML;
        if (element) {
            if (element.indexOf("-") > 0) {
                document.execCommand("insertUnorderedList", false, null);
                event.preventDefault();
                saveContent();
                return false;
            }
        }
    }
});


//Checkbox list

//Adds a class to the LI and the UL
//This class modifies that specific UL and changes the li bullet to a checkbox icon
//When click on this icon the icon changes to a checked icon also by a custom toggled class
$(document).on("click", "#checkboxListToggle", function () {
    document.execCommand("insertUnorderedList", false, null);
    var liElement = getSelectionStart("true").parentNode;
    var ulElement = liElement.parentNode;
    ulElement.classList.add("checkboxlist");

    var items = $('.checkboxlist>li');
    $.each(items,function(){
        $(this).addClass("liCheck");
    });
    saveContent();
});


$(document).on("click", ".liCheck", function (e) {
    if (e.offsetX < e.target.offsetLeft) {
        $(this).toggleClass("checkedCheckbox");
    }
    saveContent();
});

$(document).ready(function () {
    setTimeout(function () {
        var tokenfieldInput = document.getElementById("tokenfieldLabels-tokenfield");
        tokenfieldInput.classList.add("no-focus");
        var parent = tokenfieldInput.parentNode;
        parent.classList.add("input-transparant");
        parent.classList.add("no-focus");
    }, 400);
});

//on click of button to add a new folder. Affs a folder input type to give the folder a name.
$(document).on("click", ".addNewFolder", function () {
    var folder = $(".singleFolder").first().clone();
    folder.find(".collapse").remove();
    folder.find(".zmdi-chevron-right").remove();
    folder.find(".zmdi-chevron-down").remove();
    var folderId = folder.find(".collapseFolderButton").data('id');
    folder.find(".collapseFolderButton").removeClass("folder-" + folderId);
    folder.find(".collapseFolderButton").attr("data-id", null);
    $(".foldersAndTasks").append(folder);

    var inputBox = document.createElement("INPUT");
    inputBox.setAttribute("type", "text");
    inputBox.classList.add("input");
    inputBox.classList.add("newFolderInput");
    inputBox.classList.add("col-sm-12");
    inputBox.classList.add("p-l-5");
    inputBox.classList.add("input-transparant");
    inputBox.classList.add("c-black");
    folder.find(".collapseFolderButton").addClass("d-flex");
    folder.find(".collapseFolderButton").find(".folderTitle").text("");
    folder.find(".collapseFolderButton").find(".folderTitle").append(inputBox);
    $(".newFolderInput").focus();
});

// On change of input box new folder.
$(document).on("change", ".newFolderInput", function () {
    var _this = $(this);
    var folderName = $(this).val();
    var team_project_id = $(".teamProjectId").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/addFolderToProject",
        data: {"folderName": folderName, "teamProjectId": team_project_id},
        success: function (data) {
            var folderId = data;
            var folderTitle = _this.parents(".folderTitle");
            var collapseButton = folderTitle.parents(".collapseFolderButton");
            var chevron = document.createElement("i");
            chevron.classList.add("zmdi");
            chevron.classList.add("zmdi-chevron-right");
            chevron.classList.add("f-20");
            chevron.classList.add("c-black");
            chevron.classList.add("m-r-5");
            collapseButton.prepend(chevron);
            collapseButton.attr("id", folderId);
            collapseButton.addClass("folder-" + data);
            _this.parents(".folderTitle").text(folderName);
        }
    });
});


//Adds a new task to a folder.
$(document).on("click", ".addTask", function () {
    var type = $(this).data("task-category");
    addNewTask(type);
});

function addNewTask(type){
    var team_project_id = $(".teamProjectId").val();
    var folderId = $("#activeFolderId").val();
    if(typeof folderId === "undefined"){
        folderId = null;
    }
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/addTask",
        data: {"teamProjectId": team_project_id, "type" : type, "folderId" : folderId},
        dataType: "JSON",
        success: function (data) {
            getTasksAndCollapseForFolder(data['folderId'], data['view']);

            var task_id = data['taskId'];
            setRecentTask(task_id);
            setActiveTask(task_id);
            getTaskData(task_id);
            setContextmenuEvent();
        }
    });
}

function getTasksAndCollapseForFolder(folderId, tasksSharedView){
    var collapse = $("#folderCollapse-" + folderId);
    if(collapse.length < 1){
        var parent = $(".singleFolder-" + folderId);
    } else {
        var parent = collapse.parents(".singleFolder");
        collapse.remove();
    }

    parent.append(tasksSharedView);
    $(".collapse-" + folderId).addClass("show");
    setContextmenuEvent();
}

$(document).on("click", ".changeFolderBtn", function () {
   $(".folderList").toggleClass("hidden");
});

$(document).on("click", ".assignNewFolder", function () {
    var currentFolderId = $("#folderId").val();
    var newFolderId = $(this).data("new-folder-id");
    var taskId = $(this).data("task-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/changeFolderOfTask",
        data: {"currentFolder": currentFolderId, "newFolder" : newFolderId, "taskId" : taskId},
        dataType: "JSON",
        success: function (data) {
            var newFolderId = data['newFolderId'];
            var newView = data['newView'];
            getTasksAndCollapseForFolder(newFolderId, newView);
            setRecentTask(taskId);
            setActiveTask(taskId);

            var oldFolderId = data['oldFolderId'];
            var oldView = data['oldView'];
            getTasksAndCollapseForFolder(oldFolderId, oldView);

            $("#folderTitle").text(data['newFolderName']);
        }
    });
});

var hoverTimer;
$(document).on("mouseenter", ".addTaskMenuToggle", function () {
    hoverTimer = setTimeout(function () {
        $(".createTasksBox").fadeIn();
    }, 1000);

});
$(document).on("mouseleave", ".addTaskMenuToggle", function () {
    $(".createTasksBox").fadeOut();
    clearTimeout(hoverTimer);
});

// custom right click menu


function setContextmenuEvent() {
    if (document.addEventListener) { // IE >= 9; other browsers
        setTimeout(function () {
            var tasks = $(".plannerTask");
            tasks.each(function () {
                var id = $(this).attr("id");
                var newContextmenu = document.getElementById(id);
                newContextmenu.addEventListener("contextmenu", function (e) {
                    var task_id = $(this).data("task-id");
                    $.ajax({
                        method: "POST",
                        beforeSend: function (xhr) {
                            var token = $('meta[name="csrf_token"]').attr('content');

                            if (token) {
                                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                            }
                        },
                        url: "/teamProject/getTaskContextMenu",
                        data: {"taskId": task_id},
                        success: function (data) {
                            $("body").append(data);
                            var x = e.clientX;
                            var y = e.clientY;
                            $(".task-click-menu").css("top", y);
                            $(".task-click-menu").css("left", x);
                            $(".task-click-menu").removeClass("hidden");
                        }
                    });
                    e.preventDefault();
                });
            });
        }, 1000);
    } else { // IE < 9
        $(".plannerTask").attachEvent('oncontextmenu', function () {
            alert("You've tried to open context menu");
            window.event.returnValue = false;
        });
    }
}

$(document).on("click", "body", function () {
   $(".task-click-menu").remove();
});

$(document).on("click", ".contextMenuAction", function () {
    var formUrl = $(this).data("form-url");
    var taskId = $(this).data("task-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: formUrl,
        data: {"taskId": taskId},
        dataType: "JSON",
        success: function (data) {
            var folderId = data['folderId'];
            var view = data['view'];
            getTasksAndCollapseForFolder(folderId, view);
        }
    });
});

$(document).on("click", ".copyLink", function () {
    var link = $(this).data("link");
    var input = document.createElement("input");
    input.setAttribute("type", "text");
    input.setAttribute("id", "taskLink");
    input.classList.add("input-transparant");
    input.classList.add("no-focus");
    input.setAttribute("style", "color: transparant !important; border: none");
    input.value = link;
    $("body").append(input);

    var copyLink = document.getElementById("taskLink");
    copyLink.select();
    document.execCommand("copy");
    $("#taskLink").remove();

});

$(document).on("click", ".validateTask", function () {
    var taskId = $("#taskId").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/addTaskToValidationProcess",
        data: {"taskId": taskId},
        dataType: "JSON",
        success: function (data) {
            var folderId = data['folderId'];
            var view = data['view'];
            var oldView = data['oldFolderView'];
            var oldFolderId = data['oldFolderId'];
            getTasksAndCollapseForFolder(folderId, view);
            getTasksAndCollapseForFolder(oldFolderId, oldView);
        }
    });
});