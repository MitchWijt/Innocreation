$(".sendMessageBtn").on("click",function () {
    var sender_user_id = $(this).data("sender-user-id");
    var message = $(".messageInput").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/collaborate/sendMessage",
        data: {'sender_user_id' : sender_user_id, 'message' : message},
        dataType: "JSON",
        success: function (data) {
            var message = $('.messageRowSent').first().clone();
            var allMessages = $(".chatMessages");
            $(message).appendTo(allMessages);
            message.find(".messageSent").find(".message").text(data['message']);
            message.find(".messageSent").find(".timeSent").text(data['timeSent']);
            $(".messageInput").val("");
        }
    });
    setTimeout(function(){
        var objDiv = $(".chatMessages");
        if (objDiv.length > 0) {
            objDiv[0].scrollTop = objDiv[0].scrollHeight;
        }
    }, 500);
});

$(document).ready(function () {
    setTimeout(function(){
        var objDiv = $(".chatMessages");
        if (objDiv.length > 0) {
            objDiv[0].scrollTop = objDiv[0].scrollHeight;
        }
    }, 500);
});

