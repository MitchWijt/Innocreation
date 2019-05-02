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
    var task_id = $(this).data("task-id");
    var type = $(this).data("type");
    toggleIconTextEdit($(this));
    var selection = window.getSelection();
    var text = selection.toString();
    // var temp = getExistingStylesOnElement(type);

    if(text.length > 0) {
        var element = getSelectionStart("true");
        execCommandOnElement(element, type);
        doneTyping($(".taskContentEditor").html(), task_id, 'content');
    } else {
        document.execCommand(type, false, null);
        doneTyping($(".taskContentEditor").html(), task_id, 'content');
    }

    //
    // if(text.length > 0) {
    //     if ($(this).hasClass("active-edit")) {
    //         var newElement = getNewElement(temp, text);
    //         pasteHtmlAtCaret(newElement);
    //     } else {
    //
    //         if(type == "underlined") {
    //             var selectedElement = getSelectionStart("true");
    //             selectedElement.classList.remove("underlined");
    //         }
    //         var stylesTemp = getExistingStylesOnElement();
    //         stylesTemp.splice($.inArray(type, stylesTemp),1);
    //
    //         var newElement = getNewElement(stylesTemp, text);
    //         pasteHtmlAtCaret(newElement);
    //
    //     }
    //     var task_id = $(this).data("task-id");
    //     doneTyping($(".taskContentEditor").html(), task_id, 'content');
    // } else {
    //     var uniqueId = createUniqueId();
    //     var newElement = getNewElement(temp, text, false, uniqueId);
    //     pasteHtmlAtCaret(newElement);
    //     var currentElement = document.getElementById(uniqueId);
    //     currentElement.tabIndex = 0;
    //     setTimeout(function () {
    //         document.getElementById(uniqueId).focus();
    //     }, 1000);
    //
    //
    //     // var p = document.getElementById(uniqueId),
    //     //     s = window.getSelection(),
    //     //     r = document.createRange();
    //     // r.setStart(p, 0);
    //     // r.setEnd(p, 0);
    //     // s.removeAllRanges();
    //     // s.addRange(r);
    //
    // }
});

function execCommandOnElement(el, commandName, value) {
    if (typeof value == "undefined") {
        value = null;
    }

    if (typeof window.getSelection != "undefined") {
        // Non-IE case
        var sel = window.getSelection();

        // Save the current selection
        var savedRanges = [];
        for (var i = 0, len = sel.rangeCount; i < len; ++i) {
            savedRanges[i] = sel.getRangeAt(i).cloneRange();
        }

        // Temporarily enable designMode so that
        // document.execCommand() will work
        document.designMode = "on";

        // Select the element's content
        sel = window.getSelection();
        var range = document.createRange();
        range.selectNodeContents(el);
        sel.removeAllRanges();
        sel.addRange(range);

        // Execute the command
        document.execCommand(commandName, false, value);

        // Disable designMode
        document.designMode = "off";

        // Restore the previous selection
        sel = window.getSelection();
        sel.removeAllRanges();
        for (var i = 0, len = savedRanges.length; i < len; ++i) {
            sel.addRange(savedRanges[i]);
        }
    } else if (typeof document.body.createTextRange != "undefined") {
        // IE case
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.execCommand(commandName, false, value);
    }
}

function createUniqueId(){
    function Generator() {}

    Generator.prototype.rand =  Math.floor(Math.random() * 26) + Date.now();

    Generator.prototype.getId = function() {
        return this.rand++;
    };
    var idGen =new Generator();
    var newId = idGen.getId();

    return newId;
}

//Gets existing styles on selected element and returns them in a array based upon the selection and types of .textEditor
function getExistingStylesOnElement(type){
    var temp = [];
    var element = getSelectionStart();
    $(".textEditor").each(function () {
        var existingType = $(this).data("type");
        if(element.indexOf(existingType) > 0){
            temp.push(existingType);
            if(type) {
                temp.push(type);
            }
        } else {
            if(type) {
                temp.push(type);
            }
        }
    });
    return temp;
}

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
    //gets current element that is clicked on.
    var element = getSelectionStart();
    var object = getSelectionStart("true");

    //loops through all the text editor function (bold, italic, underlined)
    $(".textEditor").each(function () {
        //grabs the type (bold, italic, etc...) from the textEditor element data type
        var type = $(this).data("type");

        //checks if styleType is applied on current selected element and makes corresponding textEditor icon active if applied to element.
        if(element.indexOf(type) > 0){
            $(this).addClass("active-edit");
        } else {
            $(this).removeClass("active-edit");
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


// ==================== font size + font style =====================

$(document).on("click", ".custom-select", function () {
    var selection = window.getSelection();
    var text = selection.toString();

    var element = getSelectionStart("true");

    var selectedOption = $(this).find(".select-selected").text();
    var selectType = $(this).data("type");

    if(selectType == "fontSize"){
        var css = 'font-size:' + selectedOption + 'px';
    } else {
        var css = 'font-family:' + selectedOption;
    }

    var newElement = getNewElement(null, text, css);
    execCommandOnElement(element, "insertHTML", newElement);

    var task_id = $(this).data("task-id");
    doneTyping($(".taskContentEditor").html(), task_id, 'content');
});
