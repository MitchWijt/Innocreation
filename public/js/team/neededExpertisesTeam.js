$(".addEmptyRequirement").on("click",function () {
    var requirement = "" +
        "<div class='row'><div class='col-sm-9 d-flex js-center m-t-10'><i class='zmdi zmdi-circle c-orange f-12 m-t-8 m-r-20'></i><input type='text' name='requirements[]' class='input'></div></div>";
    $(this).parents(".requirements-list").find(".requirement").append(requirement);
});

$(".deleteCross").on("click",function () {
    if (confirm('Are you sure you want to delete this expertise?')) {
        var postData = "";
        var team_id = $(this).data("team-id");
        var expertise_id = $(this).data("expertise-id");
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/my-team/deleteNeededExpertise",
            data: {'team_id': team_id, 'expertise_id': expertise_id},
            success: function (data) {
                if(data == 1) {
                    $(".neededExpertise").each(function () {
                        if($(this).data("expertise-id") == expertise_id){
                            $(this).fadeOut();
                        }
                    });

                }
            }
        });
    }
});