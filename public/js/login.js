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

$(".submitRegister").on("click",function () {
    if($(".agreePrivacy").is(":checked") && $(".agreeTermOfService").is(":checked")){
        $(".registerForm").submit();
    } else {
        if(!$(".agreePrivacy").is(":checked")){
            $(".agreePrivacyLabel").css("color", "red");
        } else {
            $(".agreePrivacyLabel").css("color", "black");
        }

        if(!$(".agreeTermOfService").is(":checked")){
            $(".agreeTermsLabel").css("color", "red");
        } else {
            $(".agreeTermsLabel").css("color", "black");
        }
    }
});