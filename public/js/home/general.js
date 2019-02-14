$(".toggleNavMenu").off("click").on("click", function() {
    $(".main-navMenu-mobile").fadeToggle("slow");
});


$(document).ready(function () {
    $(".main-navMenu-mobile").removeClass("hidden");
    $(".main-navMenu-mobile").hide();
});


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

$(document).on("click", ".popoverNotifications, .popoverNotificationsMob", function () {
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
            $(".notificationIndicator").addClass("hidden");
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

$(document).on("click", ".popoverMessages, .popoverMessagesMob", function () {
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
            $(".messageIndicator").addClass("hidden");
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

//Join requests box
$('.popoverRequests').popover({ trigger: "click" , html: true, animation:false, placement: 'bottom'})
    .on("click", function () {
        var _this = $('.popover');
        _this.addClass("popover-notification");
        _this.find(".popover-body").addClass("p-0");
    });

$('.popoverRequests').on('hide.bs.popover', function () {
    var _this = $('.popover');
    _this.addClass("popover-black");
});

$(document).on("click", ".popoverRequests, .popoverRequestsMob", function () {
    var id = $(this).data("user-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/notification/getTeamInvites",
        data: {"user_id": id},
        success: function (data) {
            $(".teamInvitesBox").html(data);
        }
    });
});

$('.popoverRequestsMob').popover({ trigger: "click" , html: true, animation:false, placement: 'bottom'})
    .on("click", function () {
        var _this = $('.popover');
        _this.addClass("popover-notification-mob");
        _this.find(".popover-body").addClass("p-0");
    });

$('.popoverRequestsMob').on('hide.bs.popover', function () {
    var _this = $('.popover');
    _this.addClass("popover-black");
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



$(document).on("click", ".toChat", function () {
   var id = $(this).data("chat-id");
   $(".toChat-" + id).submit();
});

$(document).on("click", ".declineInvite .acceptInvite", function (e) {
   e.preventDefault();
});
$(document).on("click", ".openConnectionsModal", function () {
    var userId = $(this).data("id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/openConnectionModal",
        data: {'userId': userId},
        success: function (data) {
            $("body").append(data);
            $("#connectionsModal").modal("toggle");
        }
    });
});

$(document).on("hidden.bs.modal", ".connectionsModal", function () {
    $(".connectionsModal").remove();
});

$(document).on("click", ".openInterestsModal", function () {
    var userWorkId = $(this).data("id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/openInterestsModal",
        data: {'userWorkId': userWorkId},
        success: function (data) {
            $("body").append(data);
            $(".interestsListModal").modal("toggle");
        }
    });
});

$(document).on("hidden.bs.modal", ".interestsListModal", function () {
    $(".interestsListModal").remove();
});

$(document).on("click", ".switch__toggle", function () {
    var _this = $(this);
    if($(this).is(":checked")) {
        var senderUserId = $(this).data("sender-id");
        var recieverId = $(this).data("receiver-id");
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/user/sendConnectRequest",
            data: {'senderId': senderUserId, "receiverId": recieverId},
            success: function (data) {
                $(".notificationIndicator").removeClass("hidden");
                _this.parents(".switcher").find(".connectionSent").removeClass("hidden");
                _this.parents(".switcher").find(".switch").addClass("hidden");
            }
        });
    }
});


$(document).on("shown.bs.modal", ".modal", function () {
    const targetElement = document.querySelector(".modal");
    bodyScrollLock.disableBodyScroll(targetElement);
});

$(document).on("hidden.bs.modal", ".modal", function () {
    bodyScrollLock.clearAllBodyScrollLocks();
});