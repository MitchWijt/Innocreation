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
    var _this = $(this);
    var id = $(this).attr("id");
    console.log(_this);
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
            _this.parents(".singleFolder").append(data);
            var collapseItem =  $("#folderCollapse-" + id);
            collapseItem.collapse("toggle");

            collapseItem.on("shown.bs.collapse",function () {
                _this.find(".zmdi-chevron-right").removeClass("zmdi-chevron-right").addClass("zmdi-chevron-down");
            });

            collapseItem.on("hidden.bs.collapse",function () {
                _this.find(".zmdi-chevron-down").removeClass("zmdi-chevron-down").addClass("zmdi-chevron-right");
                $("#folderCollapse-" + id).remove();
            });
        }
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
            $("#selectedFolder").val(data);
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
    if(key.isPressed(32))
        var element = getSelectionStart();
        if(element) {
            if (element.indexOf("-") > 0) {
                document.execCommand("insertUnorderedList", false, null);
                event.preventDefault();
                var elementObject = getSelectionStart("true");
                saveContent();
                return false;
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
    var team_project_id = $(".teamProjectId").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/addTask",
        data: {"teamProjectId": team_project_id},
        dataType: "JSON",
        success: function (data) {
            var folderId = data['folderId'];
            var collapse = $("#folderCollapse-" + folderId);
            if(collapse.length < 1){
                var parent = $(".singleFolder-" + folderId);
            } else {
                var parent = collapse.parents(".singleFolder");
                collapse.remove();
            }

            console.log(parent);

            parent.append(data['view']);
            $(".collapse-" + folderId).addClass("show");
            var task_id = data['taskId'];
            setRecentTask(task_id);
            setActiveTask(task_id);
            getTaskData(task_id);
        }
    });
});