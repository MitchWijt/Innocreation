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