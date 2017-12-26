$("#toRegister").on("click",function () {
    $("#titleLogin").text("Register");
    $(".loginForm").fadeOut();
    $(".registerForm").fadeIn();
});

$("#toLogin").on("click",function () {
    $("#titleLogin").text("Login");
    $(".registerForm").fadeOut();
    $(".loginForm").fadeIn();
});