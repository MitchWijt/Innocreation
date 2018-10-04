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