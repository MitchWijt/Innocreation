$(".kickMember").on("click",function () {
    var user_id = $(this).data("user-id");

    $(".kickMemberModal").each(function () {
       if($(this).data("user-id") == user_id){
           $(this).modal().toggle();
       }
    });
});

