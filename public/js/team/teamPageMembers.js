$(".kickMember").on("click",function () {
    var user_id = $(this).data("user-id");

    $(".kickMemberModal").each(function () {
       if($(this).data("user-id") == user_id){
           $(this).modal().toggle();
       }
    });
});

$(".muteMember").on("click",function () {
    var user_id = $(this).data("user-id");

    $(".muteMemberModal").each(function () {
        if($(this).data("user-id") == user_id){
            $(this).modal().toggle();
        }
    });
});

$(".editMemberPermission").on("click",function () {
    var user_id = $(this).data("user-id");

    $(".editMemberPermissionsModal").each(function () {
        if($(this).data("user-id") == user_id){
            $(this).modal().toggle();
        }
    });
});

$(".generateInviteLink").on("click",function () {
    var team_id = $(this).data("team-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/my-team/generateInviteLink",
        data: {'team_id': team_id},
        success: function (data) {
           $(".inviteLink").val(data);
        }
    });
});
