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

$(".deleteMeeting").on("click",function (e) {
   e.stopPropagation();
    if(confirm("Are you sure you want to delete this meeting and all of its content?")) {
        var meeting_id = $(this).parents(".meeting").find(".meetingCardToggle").data("meeting-id");
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/workspace/deleteMeeting",
            data: {'meeting_id': meeting_id},
            success: function (data) {
                $(".meeting").each(function () {
                    if ($(this).find(".meetingCardToggle").data("meeting-id") == meeting_id) {
                        $(this).remove();
                    }
                });
            }
        });
    }
});

$(".editMeeting").on("click",function (e) {
    e.stopPropagation();
    var meeting_id = $(this).parents(".meeting").find(".meetingCardToggle").data("meeting-id");
    var objective = $(this).parents(".meeting").find(".objective").text();
    var description = $(this).parents(".meeting").find(".description").text();
    var date = $(this).parents(".meeting").find(".date").val();
    var time = $(this).parents(".meeting").find(".time").val();
    var maxHours = $(this).parents(".meeting").find(".maxHours").text();
    console.log(maxHours);
    var maxMinutes = $(this).parents(".meeting").find(".maxMinutes").text();

    $("#meeting_id").val(meeting_id);
    $(".modal-title").text("Edit meeting");
    $(".meetingObjective").val(objective);
    $(".descriptionMeeting").val(description);
    $(".dateMeeting").val(date);
    $(".timeMeeting").val(time);
    if(!maxHours && !maxMinutes){
        $(".hours").val(0);
        $(".minutes").val(0);
    } else {
        $(".hours").val(maxHours);
        $(".minutes").val(maxMinutes);
    }
    $(".addedAttendees").html("");
    $(".attendeesInput").each(function () {
       $(this).remove();
    });
    $(this).parents(".meeting").find(".singleAttendee").each(function () {
        var user_id = $(this).data("user-id");
        var user_name = $(this).val();
        $(".addedAttendees").append("<li data-user-id='"+user_id+"' class='userName'>" + user_name + " <i data-user-id='"+user_id+"' class='m-l-10 zmdi zmdi-close c-orange removeAttendee'></i></li>");
        $(".meetingForm").append("<input type='hidden' name='attendeesInput[]' class='attendeesInput' value='"+user_id+"'>")
    });
    $(".meetingForm").attr("action", "/workspace/editMeeting");
    $(".submitMeetingModalBtn").text("Save");

    $(".planNewMeeting").modal().toggle();

});

$.datepicker.setDefaults({
    dateFormat: 'yy-mm-dd'
});

$(".planMeetingModalToggle").on("click",function () {
    $("#meeting_id").val("");
    $(".modal-title").text("Plan new meeting");
    $(".meetingObjective").val("");
    $(".descriptionMeeting").val("");
    $(".dateMeeting").val("");
    $(".timeMeeting").val("");
    $(".hours").val(0);
    $(".minutes").val(0);
    $(".addedAttendees").html("");
    $(".attendeesInput").each(function () {
        $(this).remove();
    });
    $(".submitMeetingModalBtn").text("Plan meeting");
    $(".meetingForm").attr("action", "/workspace/addNewMeeting");
});

$(document).ready(function () {
    $(".dateMeeting").datepicker({
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

$(".meetingCardToggle").on("click",function () {
    var meeting_id = $(this).data("meeting-id");
   $(".collapseMeeting").each(function () {
        if($(this).data("meeting-id") == meeting_id){
            $(this).collapse('toggle');
        }
   });
});

