$(".toggleNavMenu").off("click").on("click", function() {
    $(".main-navMenu-mobile").fadeToggle("slow");
});


$(document).ready(function () {
    $(".main-navMenu-mobile").removeClass("hidden");
    $(".main-navMenu-mobile").hide();
});

$(".toggleSidebar").off("click").on("click", function() {
   $(".sidebarModal").modal().toggle();
});

$(document).on("click touchstart", ".closePopover", function () {
    console.log("gfdsa");
    var _this = $('[data-toggle="popover"]');
    $(_this).popover("hide");
});

$('.userAccountPopover').popover({ trigger: "click" , html: true, animation:false, placement: 'right'})
    .on("click", function () {
        var _this = $('.popover');
        _this.addClass("popover-userAccSidebar");
    });