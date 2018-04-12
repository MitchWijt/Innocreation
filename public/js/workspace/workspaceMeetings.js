$(".attendeeSelect").on("change",function () {
    var user_id = $(".attendeeSelect option:selected").val();
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
                $(".addedAttendees").append("<li data-user-id='"+data['user_id']+"' class='userName'>" + data['user_name'] + " <i data-user-id='"+data['user_id']+"' class='m-l-10 zmdi zmdi-close c-orange removeAttendee'></i></li>");
                $(".meetingForm").append("<input type='hidden' name='attendeesInput[]' class='attendeesInput' value='"+data['user_id']+"'>")
            }
        }
    });
});

$(document).on("click", ".removeAttendee",function () {
    var userId = $(this).data("user-id");
    $(".userName").each(function () {
        if($(this).data("user-id") == userId){
            $(this).fadeOut();
            $(this).remove();
        }
    });
    $(".attendeesInput").each(function () {
        if($(this).val() == userId){
            $(this).remove();
        }
    });
});

$(document).ready(function () {
    $(".dateMeeting").datepicker({
        format: "y-m-d",
        weekStart: 1,
        autoclose: true,
        minDate: "<? echo date('Y-m-d') ?>"
    });

    $('.timeMeeting').timepicker({
        timeFormat: "g:i a",
        showOn: ['focus'],
        step: 15
    });
});