var url = $(location). attr("href");
$(document).on("click", ".toMotivation",function () {
    $('html, body').animate({
        scrollTop: $(".toLivePage").offset().top
    }, 2000);
});

$(document).on("change", ".introductionUser",function () {
    $(".helperTextCredentials").text("Great! Now users will know you! P.S dont forget to save :)");
    $(".continueStep1").removeClass("hidden");
});

$(document).ready(function () {
    if(url.indexOf("my-") == -1) {
        if ($(".introductionUser").val().length > 1) {
            $(".helperTextCredentials").text("Great! Now users will know you! P.S dont forget to save :)");
            $(".continueStep1").removeClass("hidden");
        }
    }
    if(url.indexOf("expertises") != 0) {
        if ($(".desc:first").text().length > 1) {
            $(".helperTextExpertises").text("Perfect. Well done! now i know who you are and what you are specialized in. I'd love to see some recent work of you! ");
            $(".continueStep2").removeClass("hidden");
        }
    }
});
if(url.indexOf("expertises") != 0) {
    $(document).on("change", ".inputExpertise", function () {
        $(".helperTextExpertises").text("Perfect. Well done! now i know who you are and what you are specialized in. I'd love to see some recent work of you! ");
        $(".continueStep2").removeClass("hidden");
    });
}

if(url.indexOf("portfolio") != 0) {
    $(document).on("click", ".joinTeamBtn", function () {
        $(".joinTeamForm").submit();
    });
}

if(url.indexOf("members") != 0) {
    $(document).on("click", ".continueStep3", function () {
        $(".helperTextTeamMembersFirst").addClass("hidden");
        $(".helperTextTeamMembers").removeClass("hidden");
        $(".toChatBtn").removeClass("hidden");
    });
}

