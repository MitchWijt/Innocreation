
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
    if($(".userChatId").val() != 0){
        var id = $(".userChatId").val();
    } else if($(".teamId").val() != 0){
        var id = $(".teamId").val();
    } else {
        var id = 0;
    }
   if(id != 0){
       $(".chat-" + id).click();
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
    var teamId = $(this).data('team-id');
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
               data: {'user_chat_id': user_chat_id, 'admin' : admin, 'receiverUserId': receiver_user_id, 'teamId': teamId},
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
               data: {'receiverUserId': receiver_user_id, 'userChatId': user_chat_id, 'teamId': teamId},
               success: function (data) {
                   $(".chatContentHeader").html(data);
               }
           });
       }
       setTimeout(function(){
           getUserChatMessages();
           getUserChatReceiver();
           $(".sendUserMessage").attr("data-chat-id", user_chat_id);
           $(".sendUserMessage").attr("data-team-id", teamId);
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
           setTimeout(function(){
               var objDiv = $(".chatContent");
               if (objDiv.length > 0) {
                   objDiv[0].scrollTop = objDiv[0].scrollHeight;
               }
           }, 1000);
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
    var teamId = $(this).data("team-id");
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
        data: {'user_chat_id': user_chat_id, 'sender_user_id' : sender_user_id, 'message' : message, 'team_id': teamId},
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

var textarea = document.querySelector('textarea');
document.addEventListener('input', function (event) {
    if (event.target.tagName.toLowerCase() !== 'textarea') return;
    autoExpand(event.target);
}, false);
var autoExpand = function (field) {
    // Reset field height
    field.style.height = 'inherit';

    // Get the computed styles for the element
    var computed = window.getComputedStyle(field);

    // Calculate the height
    var height = parseInt(computed.getPropertyValue('border-top-width'), 10)
        + parseInt(computed.getPropertyValue('padding-top'), 10)
        + field.scrollHeight
        + parseInt(computed.getPropertyValue('padding-bottom'), 10)
        + parseInt(computed.getPropertyValue('border-bottom-width'), 10);

    field.style.height = height + 'px';

    if($(".userMessageInput").val().length > 0){
        $(".sendBtn").removeClass("hidden");
    } else {
        $(".sendBtn").addClass("hidden");
    }

};

$(document).on("click", ".emojiGen", function () {
    $(".sendBtn").removeClass("hidden");
});

$(".backToUserChats").on("click", function () {
    $(".slideMessagesMobile").toggleClass("slideMessagesMobileTransistion");
    setTimeout(function () {
        $(".slideMessagesMobile").addClass("hidden");
    }, 1000);
});