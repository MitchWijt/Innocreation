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
    getTaskData(task_id);
    setRecentTask(task_id);
    setActiveTask(task_id);
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