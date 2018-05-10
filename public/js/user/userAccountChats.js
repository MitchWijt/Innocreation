
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
               var objDiv = $(".userChatMessages");
               if (objDiv.length > 0){
                   objDiv[0].scrollTop = objDiv[0].scrollHeight;
               }
           }, 500);
           setInterval(function () {
               getUserChatMessages();
           }, 20000);
           $(this).collapse('toggle');
       }
   });
});

$(document).ready(function () {
    var user_id = $(".url_content").val();
    var user_chat_id = $(".url_content_chat").val();
    $(".collapse").each(function () {
        if($(this).data("user-id") == user_id){
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
                    data: {'user_chat_id': user_chat_id},
                    success: function (data) {
                        $(".collapse").each(function () {
                            if($(this).data("user-id") == user_id){
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
                var objDiv = $(".userChatMessages");
                if (objDiv.length > 0){
                    objDiv[0].scrollTop = objDiv[0].scrollHeight;
                }
            }, 500);
            setInterval(function () {
                getUserChatMessages();
            }, 20000);
            $(this).addClass("show");
        }
    });
});