
var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms (5 seconds)

//on keyup, start the countdown
$('.searchChatUsers').keyup(function(){
    clearTimeout(typingTimer);
    if ($('.searchChatUsers').val()) {
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    }
});

//user is "finished typing," do something
function doneTyping () {
    $(".searchChatUsersForm").submit();
}

$(".userCircle").on("click",function () {
    $(this).closest("form").submit();
});


$(".chat-card").on("click",function () {
    var user_id = $(this).data("user-id");
    var user_chat_id = $(this).data("chat-id");
    var admin = 0;
   $(".collapse").each(function () {
       if($(this).data("chat-id") == user_chat_id){
           function getUserChatMessages() {
               $.ajax({
                   method: "POST",
                   beforeSend: function (xhr) {
                       var token = $('meta[name="csrf_token"]').attr('content');

                       if (token) {
                           return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                       }
                   },
                   url: "/message/getUserChatMessages",
                   data: {'user_chat_id': user_chat_id, 'admin' : admin},
                   success: function (data) {
                       $(".collapse").each(function () {
                           if($(this).data("chat-id") == user_chat_id){
                               $(this).find(".userChatMessages").html(data);
                           }
                       });
                   }
               });
           }
           setTimeout(function(){
               getUserChatMessages();
           }, 300);
           setTimeout(function(){
               $(".userChatMessages").each(function () {
                   if($(this).data("chat-id") == user_chat_id) {
                       var objDiv = $(this);
                       if (objDiv.length > 0) {
                           objDiv[0].scrollTop = objDiv[0].scrollHeight;
                       }
                   }
               });
           }, 1000);
           setInterval(function () {
               getUserChatMessages();
           }, 500);
           $(this).collapse('toggle');
       }
   });
});

$(".sendUserMessage").on("click",function () {
    var user_chat_id = $(this).parents(".userChatTextarea").find(".user_chat_id").val();
    var sender_user_id = $(this).parents(".userChatTextarea").find(".sender_user_id").val();
    var message = $(this).parents(".userChatTextarea").find(".messageInput").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/sendMessageUser",
        data: {'user_chat_id': user_chat_id, 'sender_user_id' : sender_user_id, 'message' : message},
        dataType: "JSON",
        success: function (data) {
            var message = $('.sendedMessageAjax').first().clone();
            $(".userChatMessages").each(function () {
                if($(this).data("chat-id") == user_chat_id){
                    var allMessages = $(this);
                    $(message).appendTo(allMessages);
                    message.find(".message").text(data['message']);
                    message.find(".timeSent").text(data['timeSent']);
                    $(this).parents(".userChatTextarea").find(".messageInput").val("");
                }
            });
        }
    });
    setTimeout(function(){
        $(".userChatMessages").each(function () {
            if($(this).data("chat-id") == user_chat_id) {
                var objDiv = $(this);
                if (objDiv.length > 0) {
                    objDiv[0].scrollTop = objDiv[0].scrollHeight;
                }
            }
        });
    }, 500);
});

$(".deleteChat").on("click",function () {
    if(confirm("Are you sure you want to delete this chat?")) {
        var user_chat_id = $(this).data("chat-id");
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/user/deleteUserChat",
            data: {'user_chat_id': user_chat_id},
            success: function (data) {
                $(".userChat").each(function () {
                    if ($(this).data("chat-id") == user_chat_id) {
                        $(this).remove();
                    }
                });
            }
        });
    }
});