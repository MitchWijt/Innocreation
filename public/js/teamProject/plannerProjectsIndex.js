//Add new project to teams project
$(document).on("click", ".addNewProject", function () {
    var newProject = $(".singleProject:first").clone();
    newProject.find("a").attr("href", null);
    newProject.find(".completedTasks").remove();
    var input = document.createElement("input");
    input.setAttribute("type", "text");
    input.classList.add("newProjectInput");
    input.classList.add("input-transparant");
    input.classList.add("c-black");
    newProject.find(".projectTitle").replaceWith(input);
    $(".allProjects").append(newProject);
    $(".newProjectInput").focus();
});


$(document).on("change", ".newProjectInput", function () {
    var projectTitle = $(this).val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/addProject",
        data: {"projectTitle" : projectTitle},
        success: function (data) {
            $(".allProjects").html(data);
        }
    });
});

$(document).ready(function () {
    getProjectsView();
});

function getProjectsView(){
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/teamProject/getProjects",
        data: "",
        success: function (data) {
            $(".allProjects").html(data);
        }
    });
}