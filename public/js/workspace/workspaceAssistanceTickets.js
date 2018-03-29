function openReceivedAssistanceModal(){
    var _this = $(this);
    _this.find(".receivedAssistanceModal").modal().toggle();
}
$('.receivedAssistanceModal').on('hidden.bs.modal', function () {
    $(".receivedAssistanceTicket").on("click", openReceivedAssistanceModal);
});

$('.receivedAssistanceModal').on('show.bs.modal', function () {
    $(".receivedAssistanceTicket").off("click", openReceivedAssistanceModal);
});

$(document).ready(function () {
    $(".receivedAssistanceTicket").on("click", openReceivedAssistanceModal);
});

$(".sendMessageReceivedAssistance").on("click",function () {
    var ticket_id = $(this).parents(".receivedAssistanceTicket").find(".ticket_id").val();
    var sender_user_id = $(this).parents(".receivedAssistanceTicket").find(".sender_user_id").val();
    var receiver_user_id = $(this).parents(".receivedAssistanceTicket").find(".receiver_user_id").val();
    var message = $(this).parents(".receivedAssistanceTicket").find(".assistanceTicketMessage").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/sendAssistanceTicketMessage",
        data: {'ticket_id': ticket_id, 'sender_user_id' : sender_user_id, 'receiver_user_id' : receiver_user_id, 'message' : message},
        dataType: "JSON",
        success: function (data) {
            var message = $('.sendedMessageAjax').first().clone();
            $(".receivedAssistanceMessages").each(function () {
               if($(this).data("ticket-id") == ticket_id){
                   var allMessages = $(this);
                   $(message).appendTo(allMessages);
                   message.find(".message").text(data['message']);
                   message.find(".timeSent").text(data['timeSent']);
                   $(this).parents(".receivedAssistanceTicket").find(".assistanceTicketMessage").val("");
               }
            });
        }
    });
});

function openSendedAssistanceModal(){
    var _this = $(this);
    _this.find(".sendedAssistanceModal").modal().toggle();
}
$('.sendedAssistanceModal').on('hidden.bs.modal', function () {
    $(".sendedAssistanceTicket").on("click", openSendedAssistanceModal);
});

$('.sendedAssistanceModal').on('show.bs.modal', function () {
    $(".sendedAssistanceTicket").off("click", openSendedAssistanceModal());
});

$(document).ready(function () {
    $(".sendedAssistanceTicket").on("click", openSendedAssistanceModal);
});

$(".sendMessageSendedAssistance").on("click",function () {
    var ticket_id = $(this).parents(".sendedAssistanceTicket").find(".ticket_id").val();
    var sender_user_id = $(this).parents(".sendedAssistanceTicket").find(".sender_user_id").val();
    var receiver_user_id = $(this).parents(".sendedAssistanceTicket").find(".receiver_user_id").val();
    var message = $(this).parents(".sendedAssistanceTicket").find(".assistanceTicketMessage").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/sendAssistanceTicketMessage",
        data: {'ticket_id': ticket_id, 'sender_user_id' : sender_user_id, 'receiver_user_id' : receiver_user_id, 'message' : message},
        dataType: "JSON",
        success: function (data) {
            var message = $('.sendedMessageAjax').first().clone();
            $(".receivedAssistanceMessages").each(function () {
                if($(this).data("ticket-id") == ticket_id){
                    var allMessages = $(this);
                    $(message).appendTo(allMessages);
                    message.find(".message").text(data['message']);
                    message.find(".timeSent").text(data['timeSent']);
                    $(this).parents(".sendedAssistanceTicket").find(".assistanceTicketMessage").val("");
                }
            });
        }
    });
});