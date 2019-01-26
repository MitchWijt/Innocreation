$(".openPortfolioModal").on("click",function () {
   $(this).parents(".portfolio").find(".portfolioModal").modal().toggle();
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

// Get expertise edit modal + append and toggle
$(document).on("click", ".editExpertise", function () {
    var expertiseLinktableId = $(this).data("expertise-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/user/getEditExpertiseModal",
        data: {'expertiseLinktableId': expertiseLinktableId},
        success: function (data) {
            $("body").append(data);
            $(".editExpertiseModal").modal("toggle");
        }
    });
});

$(document).on("hidden.bs.modal", ".editExpertiseModal", function () {
    $(".editExpertiseModal").remove();
});

$(document).on("click", ".removeExpertise", function () {
    if(confirm("Are you sure you want to delete this expertise and its contents?")) {
        var expertiseLinktableId = $(this).data("expertise-id");
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/user/deleteUserExpertise",
            data: {'expertiseLinktableId': expertiseLinktableId},
            success: function (data) {
                $(".expertise-" + expertiseLinktableId).fadeOut();
            }
        });
    }
});


$('.popoverSingleUser').popover({ trigger: "click" , html: true, animation:false, placement: 'bottom'});
$('.popoverUserMenu').popover({ trigger: "click" , html: true, animation:false, placement: 'bottom'});

$(".editImage").on("click",function () {
    var expertise_id = $(this).data("expertise-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/user/getEditUserExpertiseModal",
        data: {'expertise_id': expertise_id},
        success: function (data) {
            $("body").append(data);
            $(".editImageModal").modal('toggle');
        }
    });
});

$(document).on("hidden.bs.modal", ".editImageModal", function () {
    $(".editImageModal").remove();
});

$(document).on("click", ".userExpImg", function () {
    var expertise_id = $(this).data("expertise-id");
    var image = $(this).data("img");
    var photographerLink = $(this).data("pl");
    var photographerName = $(this).data("pn");
    var id = $(this).data("id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/user/editUserExpertiseImage",
        data: {'expertise_id': expertise_id, 'photographerLink' : photographerLink, 'image' : image, 'photographerName' : photographerName, "imgId" : id},
        success: function (data) {
            window.location.reload();
        }
    });
});