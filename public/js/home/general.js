$(".toggleNavMenu").off("click").on("click", function() {
    $(".main-navMenu-mobile").fadeToggle("slow");
});


$(document).ready(function () {
    $(".main-navMenu-mobile").removeClass("hidden");
    $(".main-navMenu-mobile").hide();
});

// $(".toggleSidebar").off("click").on("click", function() {
//    $(".sidebarModal").modal().toggle();
// });

$(document).on("click touchstart", ".closePopover", function () {
    var _this = $('[data-toggle="popover"]');
    $(_this).popover("hide");
});

//sidebar

$('.userAccountPopover').popover({ trigger: "click" , html: true, animation:false, placement: 'bottom'})
    .on("click", function () {
        var _this = $('.popover');
        _this.addClass("popover-userAccSidebar");
    });


$(".toggleSidebar").click(function() {
    var selector = $("#mobileMenu");
    $(selector).toggleClass('in');
    $(".sidebarIcon").toggle();
    $("#mobileMenu").toggle();
});

$(document).ready(function () {
    $("#mobileMenu").removeClass("hidden");
    $("#mobileMenu").toggle();
});

$(".menuBackArrow").on("click",function () {
    $("#mobileMenu").toggle();
    $(".sidebarIcon").toggle();
});

$('.popoverEmojis').popover({ trigger: "click" , html: true, animation:false, placement: 'auto'});

$(document).on("click touchstart", "body",function (e) {
    $('[data-toggle=popover]').each(function () {
        // hide any open popovers when the anywhere else in the body is clicked
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});

$(document).on("click", ".emojiGen", function () {
   var emoji = $(this).data('code');

   var textarea = $("#emojiArea");
   var val = textarea.val();
   textarea.val(val + emoji);
});

$('.popoverHeader').popover({ trigger: "click" , html: true, animation:false, placement: 'bottom'})
    .on("click", function () {
        var _this = $('.popover');
        _this.addClass("popover-black");
    });

//NOTIFICATIONSBOX
$('.popoverNotifications').popover({ trigger: "click" , html: true, animation:false, placement: 'bottom'})
    .on("click", function () {
        var _this = $('.popover');
        _this.addClass("popover-notification");
        _this.find(".popover-body").addClass("p-0");
    });

$('.popoverNotifications').on('hide.bs.popover', function () {
    var _this = $('.popover');
    _this.addClass("popover-black");
});

$('.popoverNotificationsMob').popover({ trigger: "click" , html: true, animation:false, placement: 'bottom'})
    .on("click", function () {
        var _this = $('.popover');
        _this.addClass("popover-notification-mob");
        _this.find(".popover-body").addClass("p-0");
    });

$('.popoverNotificationsMob').on('hide.bs.popover', function () {
    var _this = $('.popover');
    _this.addClass("popover-black");
});

$(document).on("click", ".popoverNotifications", function () {
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/notification/getNotifications",
        data: "",
        success: function (data) {
            $(".notificationsContent").html(data);
        }
    });
});

$(document).on("click", ".popoverNotificationsMob", function () {
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/notification/getNotifications",
        data: "",
        success: function (data) {
            $(".notificationsContent").html(data);
        }
    });
});

// MESSAGESBOX
$('.popoverMessages').popover({ trigger: "click" , html: true, animation:false, placement: 'bottom'})
    .on("click", function () {
        var _this = $('.popover');
        _this.addClass("popover-notification");
        _this.find(".popover-body").addClass("p-0");
    });

$('.popoverMessages').on('hide.bs.popover', function () {
    var _this = $('.popover');
    _this.addClass("popover-black");
});

$(document).on("click", ".popoverMessages", function () {
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/notification/getMessageNotifications",
        data: "",
        success: function (data) {
            $(".messagesBoxContent").html(data);
        }
    });
});

$('.popoverMessagesMob').popover({ trigger: "click" , html: true, animation:false, placement: 'bottom'})
    .on("click", function () {
        var _this = $('.popover');
        _this.addClass("popover-notification-mob");
        _this.find(".popover-body").addClass("p-0");
    });

$('.popoverMessagesMob').on('hide.bs.popover', function () {
    var _this = $('.popover');
    _this.addClass("popover-black");
});

$(document).on("click", ".popoverMessagesMob", function () {
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/notification/getMessageNotifications",
        data: "",
        success: function (data) {
            $(".messagesBoxContent").html(data);
        }
    });
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
            window.location.href = data;
        }
    });
});


$(document).on("click touchstart", ".searchBtnHomeMobile",function () {
    $(".navMobile").addClass("hidden");
    $(".searchBarBox").removeClass("hidden");

});

$(document).on("click touchstart", ".closeSearchBar", function (e) {
    $(".navMobile").removeClass("hidden");
    $(".searchBarBox").addClass("hidden");
    e.stopPropagation();
    e.preventDefault();
});

$(document).on("click", ".input-file", function () {
   $("#fileBox").click();
});

$("#tagsHeader").on("keyup", function () {
    $(".ui-menu-item-wrapper").addClass("autocomplete-black");
});

$(document).on("click", ".acceptConnectionNotification", function () {
    var id = $(this).data("id");
    $(".acceptConnection-" + id).submit();
});

//IMAGES LAZY LOADING
$(function() {
    $('.lazyLoad').Lazy({
        scrollDirection: 'vertical',
        effect: 'fadeIn',
        effectTime: 2000,
        threshold: -50,
        visibleOnly: true,
        onError: function(element) {
            console.log('error loading ' + element.data('src'));
        }
    });
});