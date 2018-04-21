$(document).ready(function() {
    getTimelineData();
    setInterval(function () {
        getTimelineData();
    }, 15000);
});

function getTimelineData(){
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/forum/getDataForumActivityTimeline",
        data: "",
        success: function (data) {
            $(".timeline").html(data);
        }
    });
}