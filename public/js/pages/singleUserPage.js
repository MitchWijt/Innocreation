$(".openPortfolioModal").on("click",function () {
   $(this).parents(".portfolio").find(".portfolioModal").modal().toggle();
});

$(".read-more").on("click",function () {
    var id = $(this).data("toggle");
    $("#collapse-" + id).collapse('toggle');
});
var vars = {};
$(document).ready(function () {
    $(".carousel").each(function () {
        var counter = $(this).data("counter");
        if ($(window).width() < 400) {
            vars[counter + 'newCarousel'] = new floatingCarousel('#carousel-default-' + counter, {
                autoScroll: true,
                autoScrollDirection: 'right',
                autoScrollSpeed: 10000,
                enableTouchEvents: false,
                touchOverflowHidden: false,
                reverseOnTouch: false

            });
        } else {
            vars[counter + 'newCarousel'] = new floatingCarousel('#carousel-default-' + counter, {
                autoScroll: true,
                autoScrollDirection: 'right',
                autoScrollSpeed: 70000,
                enableTouchEvents: false,
                touchOverflowHidden: false,
                reverseOnTouch: false
            });
        }
    });
});



$(".editBannerImage").on("click",function () {
   $(".bannerImgInput").click();
});

$('.bannerImgInput').on("change", function () {
    $(".bannerImgForm").submit();
});

$('#editProfilePicture').on("click", function () {
    $(".profile_picture").click();
});

$('.profile_picture').on("change", function () {
    $(".profileImageForm").submit();
});

$(document).on("click", ".userPrivacySettings", function () {
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/user/openPrivacySettingsModal",
        data: "",
        success: function (data) {
            $("body").append(data);
            $(".privacySettingsModal").modal("toggle");
        }
    });
});

$(document).on("hidden.bs.modal", ".privacySettingsModal", function () {
    $(".privacySettingsModal").remove();
});
