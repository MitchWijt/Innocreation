$(document).ready(function () {
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/feed/getUserworkPosts",
        data: "",
        success: function (data) {
            $(".userworkData").html(data);
        }
    });
});