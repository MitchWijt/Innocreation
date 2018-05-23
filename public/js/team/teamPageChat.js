$(".groupMembersSelect").on("change",function () {
    var user_id = $(".groupMembersSelect option:selected").val();
    console.log(user_id);
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/addUsersToGroupChat",
        dataType: "JSON",
        data: {'user_id': user_id},
        success: function (data) {
            var bool = false;
            $(".userName").each(function () {
                if($(this).data("user-id") == data['user_id']){
                    bool = true;
                }
            });
            if(bool == false) {
                $(".groupUsers").append("<li data-user-id='"+data['user_id']+"' class='userName'>" + data['user_name'] + " <i data-user-id='"+data['user_id']+"' class='m-l-10 zmdi zmdi-close c-orange removeGroupUser'></i></li>");
                $(".groupChatForm").append("<input type='hidden' name='groupChatUsersInput[]' class='groupChatUsersInput' value='"+data['user_id']+"'>")
                $(".settingsGroupChatForm").append("<input type='hidden' name='groupChatUsersInput[]' class='groupChatUsersInput' value='"+data['user_id']+"'>")
            }
        }
    });
});

$(".groupMembersSelectSettings").on("change",function () {
    var user_id = $(this).parents(".settingsGroupChatCheck").find(".groupMembersSelectSettings option:selected").val();
    var team_group_chat_id = $(this).data("group-chat-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/addUsersToGroupChat",
        dataType: "JSON",
        data: {'user_id': user_id},
        success: function (data) {
            $(".settingsGroupChatCheck").each(function () {
               if($(this).data("group-chat-id") == team_group_chat_id){
                   var bool = false;
                   $(".userName").each(function () {
                       if($(this).data("user-id") == data['user_id']){
                           bool = true;
                       }
                   });
                   if(bool == false) {
                       $(this).find(".groupUsers").append("<li data-user-id='"+data['user_id']+"' class='userName'>" + data['user_name'] + " <i data-user-id='"+data['user_id']+"' class='m-l-10 zmdi zmdi-close c-orange removeGroupUser'></i></li>");
                       $(this).find(".settingsGroupChatForm").append("<input type='hidden' name='groupChatUsersInput[]' class='groupChatUsersInput' value='"+data['user_id']+"'>");
                   }
               }
            });
        }
    });
});

$(document).on("click", ".removeGroupUser",function () {
    var userId = $(this).data("user-id");
    $(".userName").each(function () {
       if($(this).data("user-id") == userId){
           $(this).fadeOut();
           $(this).remove();
       }
    });
    $(".groupChatUsersInput").each(function () {
       if($(this).val() == userId){
           $(this).remove();
       }
    });
});

$(document).ready(function () {
    var group_chat_id = $(".url_content").val();
    $(".groupChatCollapse").each(function () {
        if($(this).data("group-chat-id") == group_chat_id){
            $(this).addClass("show");
            function getTeamGroupChatMessages() {
                $.ajax({
                    method: "POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');

                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    url: "/message/getTeamGroupChatMessages",
                    data: {'group_chat_id': group_chat_id},
                    success: function (data) {
                        $(".groupChatCollapse").each(function () {
                            if ($(this).data("group-chat-id") == group_chat_id) {
                                $(this).find(".teamGroupChatMessages").html(data);
                            }
                        });
                    }
                });
            }
            getTeamGroupChatMessages();
            setInterval(function () {
                getTeamGroupChatMessages();
            }, 20000);

            $('html, body').animate({
                scrollTop: $(this).offset().top - 120
            }, 1000);
        }
    });
});

$(".groupChatCardToggle").on("click",function () {
    var group_chat_id = $(this).data("group-chat-id");
   $(".groupChatCollapse").each(function () {
        if($(this).data("group-chat-id") == group_chat_id){
            function getTeamGroupChatMessages() {
                $.ajax({
                    method: "POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');

                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    url: "/message/getTeamGroupChatMessages",
                    data: {'group_chat_id': group_chat_id},
                    success: function (data) {
                        $(".groupChatCollapse").each(function () {
                            if ($(this).data("group-chat-id") == group_chat_id) {
                                $(this).find(".teamGroupChatMessages").html(data);
                            }
                        });
                    }
                });
            }
            getTeamGroupChatMessages();
            setInterval(function () {
                getTeamGroupChatMessages();
            }, 20000);

            setTimeout(function(){
                var objDiv = $(".teamGroupChatMessages");
                if (objDiv.length > 0){
                    objDiv[0].scrollTop = objDiv[0].scrollHeight;
                }
            }, 300);
            $(this).collapse('toggle');
        }
   });
});

$(".uploadProfilePic").on("click",function () {
    $(this).parents(".groupChatProfilePicForm").find(".profilePictureGroupChat").click();
});

$(".profilePictureGroupChat").on("change",function () {
   $(this).closest("form").submit();
});

$(".settingsGroupChatBtn").on("click",function () {
    $(this).parents(".groupChat").find(".settingsGroupChat").modal().toggle();
});

$(".removeFromGroupChat").on("click",function () {
    var user_id = $(this).data("user-id");
    var group_chat_id = $(this).data("group-chat-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/removeUserFromGroupChat",
        data: {'user_id': user_id, 'group_chat_id' : group_chat_id},
        success: function (data) {
            console.log(data);
            if(data == 1){
                $(".memberListItem").each(function () {
                    if($(this).data("user-id") == user_id){
                        $(this).fadeOut();
                        $(this).remove();
                    }
                });
            }
        }
    });
});

$(document).ready(function() {
    getTeamChatMessages();
    setInterval(function () {
        getTeamChatMessages();
    }, 2000);
});

function getTeamChatMessages(){
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/message/getTeamChatMessages",
        data: "",
        success: function (data) {
            $(".teamChatMessages").html(data);
        }
    });
}

setTimeout(function(){
    var objDiv = $(".teamChatMessages");
    if (objDiv.length > 0){
        objDiv[0].scrollTop = objDiv[0].scrollHeight;
    }
}, 300);