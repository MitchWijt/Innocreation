$(".toRegister").on("click",function () {
    $("#titleLogin").text("Register");
    $(".loginForm").addClass("hidden");
    $(".registerForm").removeClass("hidden");
});

$(".toLogin").on("click",function () {
    $("#titleLogin").text("Login");
    $(".registerForm").addClass("hidden");
    $(".loginForm").removeClass("hidden");
});
