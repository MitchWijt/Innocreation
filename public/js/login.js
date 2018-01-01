$("#toRegister").on("click",function () {
    $("#titleLogin").text("Register");
    $(".loginForm").fadeOut();
    $(".registerForm").removeClass("hidden");
});

$("#toLogin").on("click",function () {
    $("#titleLogin").text("Login");
    $(".registerForm").fadeOut();
    $(".loginForm").removeClass("hidden")
});