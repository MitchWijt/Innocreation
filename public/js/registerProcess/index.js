$(".goToStep2").on("click",function () {
    var bool = true;

    if($(".firstname").val().length < 1){
        $(".firstname").attr("style", "border: 1px solid red !important");
        $(".labelFirstname").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".firstname").attr("style", "border: 1px solid black !important");
        $(".labelFirstname").attr("style", "color: #C9CCCF !important");
    }

    if($(".lastname").val().length < 1){
        $(".lastname").attr("style", "border: 1px solid red !important");
        $(".labelLastname").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".lastname").attr("style", "border: 1px solid black !important");
        $(".labelLastname").attr("style", "color: #C9CCCF !important");
    }


    if($(".back").val() == 0) {
        if ($(".password").val().length < 1) {
            $(".password").attr("style", "border: 1px solid red !important");
            $(".labelPassword").attr("style", "color: red !important");
            bool = false;
        } else {
            $(".password").attr("style", "border: 1px solid black !important");
            $(".labelPassword").attr("style", "color: #C9CCCF !important");
        }

        if ($(".password-confirm").val().length < 1) {
            $(".password-confirm").attr("style", "border: 1px solid red !important");
            $(".labelConfirm").attr("style", "color: red !important");
            bool = false;
        } else {
            $(".password-confirm").attr("style", "border: 1px solid black !important");
            $(".labelConfirm").attr("style", "color: #C9CCCF !important");
        }
    }

    if(!$("#terms").is(":checked")){
        $(this).attr("style", "border: 1px solid red !important");
        $(".terms").attr("style", "color: red !important");
        bool = false
    }

    if($(".email").val().length < 1){
        $(".email").attr("style", "border: 1px solid red !important");
        $(".labelEmail").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".email").attr("style", "border: 1px solid black !important");
        $(".labelEmail").attr("style", "color: #C9CCCF !important");
    }

    if($(".password-confirm").val() != $(".password").val()){
        $('.errorMatch').removeClass("hidden");
        bool = false;
    } else {
        $('.errorMatch').addClass("hidden");
    }


    if(bool) {
        var firstname = $(".firstname").val();
        var middlename = $(".middlename").val();
        var lastname = $('.lastname').val();
        var password = $(".password").val();
        var email = $('.email').val();
        var back  = $(".back").val();
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/registerProcess/saveUserCredentials",
            data: {'firstname': firstname, 'lastname' : lastname, 'middlename': middlename, 'password': password, 'email': email, 'back': back},
            success: function (data) {
                if(data == 1) {
                    $(".progress-bar").attr("style", "width: 40% !important");
                    $(".progress-bar").text("40% complete");

                    $(".credentials").addClass("hidden");
                    var firstname = $(".firstname").val();
                    var header = "Welcome " + firstname + ", what is your residence info?";
                    $(".residenceHeader").text(header);
                    $('.residence').removeClass("hidden");
                } else {
                    $(".existingError").text("There already seems to be an existing account with the email " + email);
                }
            }
        });
    }
});


$(".goToStep3").on("click",function () {
    var bool = true;

    if($(".city").val().length < 1){
        $(".city").attr("style", "border: 1px solid red !important");
        $(".labelCity").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".city").attr("style", "border: 1px solid black !important");
        $(".labelCity").attr("style", "color: #C9CCCF !important");
    }

    if($(".postalcode").val().length < 1){
        $(".postalcode").attr("style", "border: 1px solid red !important");
        $(".labelPostalcode").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".postalcode").attr("style", "border: 1px solid black !important");
        $(".labelPostalcode").attr("style", "color: #C9CCCF !important");
    }

    if($(".country option:selected").val().length < 1){
        $(".country").attr("style", "border: 1px solid red !important");
        $(".country").attr("style", "color: red");
        bool = false;
    } else {
        $(".country").attr("style", "border: 1px solid black !important");
        $(".country").attr("style", "color: #000 !important");
    }

    if(bool) {
        var city = $(".city").val();
        var postalcode = $(".postalcode").val();
        var countryId = $('.country option:selected').val();
        var phonenumber = $(".phonenumber").val();
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/registerProcess/saveUserResidence",
            data: {'city': city, 'postalcode' : postalcode, 'countryId': countryId, 'phonenumber': phonenumber},
            success: function (data) {
                $(".progress-bar").attr("style", "width: 60% !important");
                $(".progress-bar").text("60% complete");
                $(".residence").addClass("hidden");
                $('.expertises').removeClass("hidden");

            }
        });
    }
});

$(".goToStep4").on("click",function () {
    var bool = true;

    if($(".expertisesInput").val().length < 1){
        $(".tokenfield").attr("style", "border: 1px solid red !important");
        $(".labelExpertises").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".tokenfield").attr("style", "border: 1px solid black !important");
        $(".labelExpertises").attr("style", "color: #C9CCCF !important");
    }

    if(bool) {
        var expertisesInput = $(".expertisesInput").val();
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/registerProcess/saveUserExpertises",
            data: {'expertises': expertisesInput},
            success: function (data) {
                $(".progress-bar").attr("style", "width: 80% !important");
                $(".progress-bar").text("80% complete");
                $(".innoText").html("I am 'Inno' and my motivation is to help you and welcome you as best as i can on Innocreation! Now tell me more about yourself, so i will get to know you better");
                $(".expertises").addClass("hidden");
                $('.introText').removeClass("hidden");

            }
        });
    }
});

$(".goToStep5").on("click",function () {
    var bool = true;

    if($(".introUser").val().length < 1){
        $(".introUser").attr("style", "border: 1px solid red !important");
        $(".labelIntro").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".introUser").attr("style", "border: 1px solid black !important");
        $(".labelIntro").attr("style", "color: #C9CCCF !important");
    }

    if($(".motivationUser").val().length < 1){
        $(".motivationUser").attr("style", "border: 1px solid red !important");
        $(".labelMotivation").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".motivationUser").attr("style", "border: 1px solid black !important");
        $(".labelMotivation").attr("style", "color: #C9CCCF !important");
    }

    if(bool) {
        var introduction = $(".introUser").val();
        var motivation = $(".motivationUser").val();
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/registerProcess/saveUserTexts",
            data: {'introduction': introduction, 'motivation': motivation},
            success: function (data) {
                $(".progress-bar").attr("style", "width: 90% !important");
                $(".progress-bar").text("90% complete");
                $(".innoText").html("You're doing a great job! <br> Here you can join a team of like-minded and ceative people to participate in a new idea/dream! <br> Or you can create your own team and invite like-minded people to help you with your idea/dream!");
                $(".introText").addClass("hidden");
                $('.teamOverview').removeClass("hidden");
                location.reload();
            }
        });
    }
});

$(".backToStep1").on("click",function () {
   $(".residence").addClass("hidden");
   $(".credentials").removeClass("hidden");
    $(".progress-bar").attr("style", "width: 20% !important");
    $(".progress-bar").text("20% complete");
});

$(".backToStep2").on("click",function () {
    $(".residence").removeClass("hidden");
    $(".expertises").addClass("hidden");
    $(".progress-bar").attr("style", "width: 40% !important");
    $(".progress-bar").text("40% complete");
});

$(".backToStep3").on("click",function () {
    $(".expertises").removeClass("hidden");
    $(".introText").addClass("hidden");
    $(".innoText").html("Welcome! <br> Follow the steps below to start creating!");
    $(".progress-bar").attr("style", "width: 60% !important");
    $(".progress-bar").text("60% complete");
});

$(".backToStep4").on("click",function () {
    $(".introText").removeClass("hidden");
    $(".teamOverview").addClass("hidden");
    $(".innoText").html("I am 'Inno' and my motivation is to help you and welcome you as best as i can on Innocreation! Now tell me more about yourself, so i will get to know you better");
    $(".progress-bar").attr("style", "width: 80% !important");
    $(".progress-bar").text("80% complete");
});

$(document).ready(function () {
    $(".ui-menu").appendTo(".expertisesTokens");
    $(".token-input").attr("style", "");

    $(".tokenfield").removeClass("form-control");
    $(".tokenfield").addClass("col-sm-12");
});