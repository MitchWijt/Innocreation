
var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms (5 seconds)

//on keyup, start the countdown
$('.searchChatUsers').keyup(function(){
    clearTimeout(typingTimer);
    if ($('.searchChatUsers').val()) {
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    }
});

$(document).ready(function () {
   var userChatId = $(".userChatId").val();
   if(userChatId != 0){
       $(".chat-" + userChatId).click();
   }
});
//user is "finished typing," do something
function doneTyping () {
    $(".searchChatUsersForm").submit();
}

$(".userCircle").on("click",function () {
    $(this).closest("form").submit();
});



$(".chatItem").on("click",function () {
    $(".chatItem").removeClass("activeChat");
    $(this).addClass("activeChat");
    var user_id = $(this).data("user-id");
    var streamToken = $(".streamToken").val();
    var userId = $(".userId").val();
    var user_chat_id = $(this).data("chat-id");
    var receiver_user_id = $(this).data("receiver-user-id");
    var admin = 0;
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
               data: {'user_chat_id': user_chat_id, 'admin' : admin, 'receiverUserId': receiver_user_id},
               success: function (data) {
                   $(".chatContent").html(data);
                   $(".userMessageInput").removeClass("hidden");
                   // $(this).parents(".chat").find(".unreadNotification").remove();
               }
           });
       }

       function getUserChatReceiver(){
           $.ajax({
               method: "POST",
               beforeSend: function (xhr) {
                   var token = $('meta[name="csrf_token"]').attr('content');

                   if (token) {
                       return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                   }
               },
               url: "/message/getUserChatReceiver",
               data: {'receiverUserId': receiver_user_id, 'userChatId': user_chat_id},
               success: function (data) {
                   $(".chatContentHeader").html(data);
               }
           });
       }
       setTimeout(function(){
           getUserChatMessages();
           getUserChatReceiver();
           $(".sendUserMessage").attr("data-chat-id", user_chat_id);
           $(".unseen-" + user_chat_id).addClass("hidden");
           $(".actions").removeClass("hidden");
           if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
               $(".slideMessagesMobile").removeClass("hidden");
               $(".slideMessagesMobile").toggleClass("slideMessagesMobileTransistion");
           }
       }, 500);
       setTimeout(function(){
           var objDiv = $(".chatContent");
           if (objDiv.length > 0) {
               objDiv[0].scrollTop = objDiv[0].scrollHeight;
           }
       }, 1000);

       var client = stream.connect('ujpcaxtcmvav', null, '40873');
       var user1 = client.feed('user', userId, streamToken);

       function callback(data) {
           var message = $('.messageReceivedAjax').first().clone();
           var allMessages = $(".chatContent");
           $(message).appendTo(allMessages);
           message.find(".messageReceived").find(".message").text(data["new"][0]["message"]);
           message.find(".messageReceived").find(".timeSent").text(data["new"][0]["timeSent"]);
       }

       function successCallback() {
       }

       function failCallback(data) {
           alert('something went wrong, check the console logs');
       }
       user1.subscribe(callback).then(successCallback, failCallback);

});

$(".sendUserMessage").on("click",function () {
    var user_chat_id = $(this).data("chat-id");
    var sender_user_id = $(".sender_user_id").val();
    var message = $(".userMessageInput").val();
    $(".userMessageInput").val("");
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
            var message = $('.newChatMessage').first().clone();
            function Generator() {}

            Generator.prototype.rand =  Math.floor(Math.random() * 26) + Date.now();

            Generator.prototype.getId = function() {
                return this.rand++;
            };
            var idGen =new Generator();
            var newId = idGen.getId();
            message.attr("id", newId);
            var allMessages = $(".chatContent");
            $(message).appendTo(allMessages);
            message.find(".message").text(data['message']);
            message.find(".timeSent").text(data['timeSent']);
            $("#" + newId).removeClass("hidden");
            if (allMessages.length > 0) {
                allMessages[0].scrollTop = allMessages[0].scrollHeight;
            }
        }
    });
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

var textarea = document.querySelector('textarea');

textarea.addEventListener('keyup', autosize);
textarea.addEventListener('change', autosize);
textarea.addEventListener('paste', autosize);

function autosize() {
    var el = this;
    setTimeout(function () {
        el.style.cssText = 'height:auto;';
        el.style.cssText = 'color: #000 !important; height:' + el.scrollHeight +'px !important';
    }, 200);


    if($(".userMessageInput").val().length > 0){
        $(".sendBtn").removeClass("hidden");
    } else {
        $(".sendBtn").addClass("hidden");
    }
}

$(document).on("click", ".emojiGen", function () {
    $(".sendBtn").removeClass("hidden");
});

$(".backToUserChats").on("click", function () {
    $(".slideMessagesMobile").toggleClass("slideMessagesMobileTransistion");
    setTimeout(function () {
        $(".slideMessagesMobile").addClass("hidden");
    }, 1000);
});