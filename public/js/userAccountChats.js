
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
   $(".collapse").each(function () {
       if($(this).data("user-id") == user_id){
           $(this).collapse('toggle');
       }
   });
});