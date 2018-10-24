$(".editProfilePicture").on("click",function () {
    $(".uploadFile").click();
});

$(".uploadFile").on("change",function () {
    $(".saveTeamProfilePicture").submit();
});

$(document).on("click", ".editTeamName",function () {
    $(".newTeamNameInput").removeClass("hidden");
    $(".TeamName").addClass("hidden");
    $(".closeEditName").removeClass("hidden");
    $(".editTeamName").addClass("hidden");
});

$(".closeEditName").on("click",function () {
    $(".TeamName").removeClass("hidden");
    $(".newTeamNameInput").addClass("hidden");
    $(".closeEditName").addClass("hidden");
    $(".editTeamName").removeClass("hidden");
});

$(".newTeamNameInput").on("blur" ,function () {
    var newName = $(this).val();
    var id = $(".teamId").val();

    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/my-team/saveNewName",
        dataType: "JSON",
        data: {'newTeamName': newName, 'teamId': id},
        success: function (data) {
            console.log(data);
            if(data == 1){
                $(".error").text("This name is not available");
                return false;
            }

            $(".error").text("");
            $(".TeamName").html(newName + '<i class="zmdi zmdi-edit f-18 p-absolute c-pointer editTeamName" style="right: -20px;"></i>');
            $(".TeamName").removeClass("hidden");
            $(".newTeamNameInput").addClass("hidden");
            $(".closeEditName").addClass("hidden");
            $(".editTeamName").removeClass("hidden");

        }
    });
});
