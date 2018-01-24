$(".toRegister").on("click",function () {
    $("#titleLogin").text("Register");
    $(".loginForm").hide();
    $(".registerForm").removeClass("hidden");
});

$(".toLogin").on("click",function () {
    $("#titleLogin").text("Login");
    $(".registerForm").addClass("hidden");
    $(".loginForm").show();
});
