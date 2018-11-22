$(".startRegisterProcess").on("click",function () {
    ga('send', {
        hitType: 'event',
        eventCategory: 'RegisterProcess',
        eventAction: 'submit/click'
    });
});
$('.carousel').carousel();

$(".carousel-control-prev").on("click",function () {
    $('.carousel').carousel("prev");
});

$(".carousel-control-next").on("click",function () {
    $('.carousel').carousel("next");
});


$(document).on("click", ".closeModal", function () {
    $(".carouselUserModal").modal("toggle")
});

$(".searchExpertisesHome").on("keyup",function () {
    if($(this).val().length > 0){
        $(".clearCross").removeClass("hidden");
    } else {
        $(".clearCross").addClass("hidden");
    }
});

$(".clearInput").on("click",function () {
   $(".searchExpertisesHome").val("");
   $(".clearCross").addClass("hidden");
});
$(".searchBtnHome").on("click",function () {
    if($(".searchExpertisesHome").val().length > 0){
        var title = $(".searchExpertisesHome").val();
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/home/searchExpertise",
            data: {'title': title},
            success: function (data) {
                window.location.href = data;
            }
        });
    }
});


$(document).on("click", ".ui-menu-item-wrapper", function () {
    var title = $(this).text();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/home/searchExpertise",
        data: {'title': title},
        success: function (data) {
            // window.location.href = data;
        }
    });
});

new floatingCarousel('#carousel-default', {
    autoScroll : true,
    autoScrollDirection : 'right',
    autoScrollSpeed : 50000,
    enableTouchEvents : false,
    touchOverflowHidden : false,
    reverseOnTouch : false

});


new floatingCarousel('#carousel-default2', {
    autoScroll : true,
    autoScrollDirection : 'left',
    autoScrollSpeed : 50000,
    enableTouchEvents : false,
    touchOverflowHidden : false,
    reverseOnTouch : false

});

$(document).on("click", ".searchBtnHomeMobile",function () {
    $(".navMobile").addClass("hidden");
    $(".searchBarBox").removeClass("hidden");

});