$(".startRegisterProcess").on("click",function () {
    ga('send', {
        hitType: 'event',
        eventCategory: 'RegisterProcess',
        eventAction: 'submit/click'
    });
    $(".startRegisterForm").submit();
});