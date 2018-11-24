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
    console.log("gfdsa");
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

$('body').on('click', function (e) {
    $('[data-toggle=popover]').each(function () {
        // hide any open popovers when the anywhere else in the body is clicked
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});

$(document).on("click", ".emojiGen", function () {
   var id = $(this).data('id');
   var emoji = $(this).data('code');

   var textarea = $(".input-" + id);
   var val = textarea.val();
   textarea.val(val + emoji);
});

$('.popoverHeader').popover({ trigger: "click" , html: true, animation:false, placement: 'bottom'})
    .on("click", function () {
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
            console.log(data);
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