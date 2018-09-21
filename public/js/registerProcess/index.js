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

    if($(".password").val().length < 1){
        $(".password").attr("style", "border: 1px solid red !important");
        $(".labelPassword").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".password").attr("style", "border: 1px solid black !important");
        $(".labelPassword").attr("style", "color: #C9CCCF !important");
    }

    if($(".password-confirm").val().length < 1){
        $(".password-confirm").attr("style", "border: 1px solid red !important");
        $(".labelConfirm").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".password-confirm").attr("style", "border: 1px solid black !important");
        $(".labelConfirm").attr("style", "color: #C9CCCF !important");
    }

    if(!$("#terms").is(":checked")){
        $(this).attr("style", "border: 1px solid red !important");
        $(".terms").attr("style", "color: red !important");
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
    } else {
        $('.errorMatch').addClass("hidden");
    }


    if(bool) {
        var firstname = $(".firstname").val();
        var middlename = $(".middlename").val();
        var lastname = $('.lastname').val();
        var password = $(".password").val();
        var email = $('.email').val();
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/registerProcess/saveUserCredentials",
            data: {'firstname': firstname, 'lastname' : lastname, 'middlename': middlename, 'password': password, 'email': email},
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
