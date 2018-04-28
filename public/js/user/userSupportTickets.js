$(".supportTicketCard").on("click",function () {
    var ticket_id = $(this).data("ticket-id");
    function getSupportTicketMessages() {
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/message/getSupportTicketMessages",
            data: {'ticket_id': ticket_id},
            success: function (data) {
                $(".supportTicketModal").each(function () {
                    if($(this).data("ticket-id") == ticket_id){
                        $(this).find(".supportTicketMessages").html(data);
                    }
                });
            }
        });
    }
    setTimeout(function(){
        getSupportTicketMessages();
    }, 300);
    setTimeout(function(){
        var objDiv = $(".supportTicketMessages");
        if (objDiv.length > 0){
            objDiv[0].scrollTop = objDiv[0].scrollHeight;
        }
    }, 500);
    setInterval(function () {
        getSupportTicketMessages();
    }, 20000);
    $(this).parents(".supportTicket").find(".supportTicketModal").modal().toggle();
});

$(".sendSupportTicketMessage").on("click",function () {
    var ticket_id = $(this).parents(".supportTicket").find(".ticket_id").val();
    var sender_user_id = $(this).parents(".supportTicket").find(".sender_user_id").val();
    var message = $(this).parents(".supportTicket").find(".supportTicketMessage").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/user/sendSupportTicketMessage",
        data: {'ticket_id': ticket_id, 'sender_user_id' : sender_user_id, 'message' : message},
        dataType: "JSON",
        success: function (data) {
            var message = $('.sendedMessageAjax').first().clone();
            $(".supportTicketMessages").each(function () {
                if($(this).data("ticket-id") == ticket_id){
                    var allMessages = $(this);
                    $(message).appendTo(allMessages);
                    message.find(".message").text(data['message']);
                    message.find(".timeSent").text(data['timeSent']);
                    $(this).parents(".supportTicket").find(".supportTicketMessage").val("");
                    setTimeout(function(){
                        var objDiv = $(".supportTicketMessages");
                        if (objDiv.length > 0){
                            objDiv[0].scrollTop = objDiv[0].scrollHeight;
                        }
                    }, 1);
                }
            });
        }
    });
});

$(".filterSupportTicketsMenuToggle").on("click",function () {
    $(".filterSupportTicketsMenu").toggle();
});

$(document).ready(function () {
    $(".filterSupportTicketsMenu").removeClass("hidden");
    $(".filterSupportTicketsMenu").toggle();
});

$(".filterSupportTickets").on("click",function () {
   if($(this).data("filter") == "Open"){
       $(".singleSupportTicket").each(function () {
           if($(this).find(".ticketStatus").val() != 1){
                $(this).hide();
           } else {
               $(this).show();
           }
       });
   } else if($(this).data("filter") == "OnHold"){
       $(".singleSupportTicket").each(function () {
           if($(this).find(".ticketStatus").val() != 2){
               $(this).hide();
           } else {
               $(this).show();
           }
       });
   } else if($(this).data("filter") == "Closed"){
       $(".singleSupportTicket").each(function () {
           if($(this).find(".ticketStatus").val() != 3){
               $(this).hide();
           } else {
               $(this).show();
           }
       });
   } else {
       $(".singleSupportTicket").each(function () {
           $(this).show();
       });
   }
});