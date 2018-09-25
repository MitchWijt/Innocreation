$(".startRegisterProcess").on("click",function () {
    ga('send', {
        hitType: 'event',
        eventCategory: 'RegisterProcess',
        eventAction: 'submit/click'
    });
    $(".startRegisterForm").submit();
});
$('.carousel').carousel();

$(".openCarouselModal").on("click",function () {
    var user_id = $(this).data("user-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/home/getModalCarouselUser",
        data: {'userId': user_id},
        success: function (data) {
            $(".carouselUserModalData").html(data);
            $(".carouselUserModal").modal().toggle();
        }
    });
});

$(".openCarouselModalLink").on("click",function (e) {
    var user_id = $(this).data("user-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/home/getModalCarouselUser",
        data: {'userId': user_id},
        success: function (data) {
            $(".carouselUserModalData").html(data);
            $(".carouselUserModal").modal().toggle();
        }
    });
    e.preventDefault();
    e.stopPropagation();
});