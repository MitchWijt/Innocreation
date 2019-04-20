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
        }
    });
});