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

$(document).ready(function () {
   $(".ui-menu").appendTo(".expertises");
   $(".token-input").attr("style", "");

   $(".tokenfield").removeClass("form-control");
   $(".tokenfield").addClass("col-sm-9");
});