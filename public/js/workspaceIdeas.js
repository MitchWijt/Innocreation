$(".workplace_idea_status").on("change",function () {
    var idea_id = $(this).parents(".workplaceIdea").find(".workplace_idea_status option:selected").data("idea-id");
    var status = $(this).parents(".workplaceIdea").find(".workplace_idea_status option:selected").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/changeIdeaStatus",
        data: {'idea_id': idea_id, 'status' : status},
        success: function (data) {
            $(".workplace_idea_status").each(function () {
               if($(this).data("idea-id") == idea_id){
                   $(this).prop("selected", true);
                   if(data == "Passed"){
                       $(this).css("border", "");
                       $(this).attr('style', 'border: 2px solid #19c41f !important');
                   } else if(data == "Rejected"){
                       $(this).css("border", "");
                       $(this).attr('style', 'border: 2px solid #FF0000 !important');
                   } else {
                       $(this).css("border", "");
                       $(this).attr('style', 'border: 2px solid #FF6100 !important');
                   }
               }
            });
        }
    });
});

$(".ideaToggle").on("click",function () {
   $(this).parents(".workplaceIdea").find(".ideaDetailsModal").modal().toggle();
});