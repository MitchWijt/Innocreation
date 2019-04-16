$(".submitRegisterForm").on("click",function () {
    var bool = true;

    if($(".firstname").val().length < 1){
        $(".firstname").attr("style", "border: 1px solid red !important");
        $(".labelFirstname").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".firstname").attr("style", "border: 1px solid black !important");
        $(".labelFirstname").attr("style", "color: #000 !important");
    }

    if($(".lastname").val().length < 1){
        $(".lastname").attr("style", "border: 1px solid red !important");
        $(".labelLastname").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".lastname").attr("style", "border: 1px solid black !important");
        $(".labelLastname").attr("style", "color: #000 !important");
    }


    if($(".country option:selected").val().length < 1){
        $(".country").attr("style", "border: 1px solid red !important");
        $(".labelCountry").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".country").attr("style", "border: 1px solid black !important");
        $(".labelCountry").attr("style", "color: #000 !important");
    }


    if($(".username").val().length < 1){
        $(".username").attr("style", "border: 1px solid red !important");
        $(".labelUsername").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".username").attr("style", "border: 1px solid black !important");
        $(".labelUsername").attr("style", "color: #000 !important");
    }

    if($(".expertises").val().length < 1){
        $(".tokenfield").attr("style", "border: 1px solid red !important");
        $(".labelExpertises").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".tokenfield").attr("style", "border: 1px solid black !important");
        $(".labelExpertises").attr("style", "color: #000 !important");
    }

    if ($(".password").val().length < 1) {
        $(".password").attr("style", "border: 1px solid red !important");
        $(".labelPassword").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".password").attr("style", "border: 1px solid black !important");
        $(".labelPassword").attr("style", "color: #000 !important");
    }

    if($(".email").val().length < 1){
        $(".email").attr("style", "border: 1px solid red !important");
        $(".labelEmail").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".email").attr("style", "border: 1px solid black !important");
        $(".labelEmail").attr("style", "color: #000 !important");
    }


    if(bool) {
        var firstname = $(".firstname").val();
        var lastname = $('.lastname').val();
        var password = $(".password").val();
        var email = $('.email').val();
        var country = $(".country option:selected").val();
        var username = $(".username").val();
        var expertises =  $('.expertises').val();

        $(".submitRegisterForm").addClass("hidden");
        $(".loadingGear").removeClass("hidden");
        $.ajax({
            method: "POST",
            dataType: "JSON",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/registerProcess/saveUserCredentials",
            data: {'firstname': firstname, 'lastname' : lastname, 'password': password, 'email': email, 'username' : username, 'country' : country, 'expertises' : expertises},
            success: function (data) {
                if(data['error']){
                    if(data['error'] == "existingUsername"){
                        $(".existingErrorUsername").text("There already seems to be an existing account with the username " + username);
                        $(".submitRegisterForm").removeClass("hidden");
                        $(".loadingGear").addClass("hidden");
                    } else {
                        $(".existingError").text("There already seems to be an existing account with the email " + email);
                        $(".submitRegisterForm").removeClass("hidden");
                        $(".loadingGear").addClass("hidden");
                    }
                } else{
                    $(".submitRegisterForm").addClass("hidden");
                    $(".loadingGear").removeClass("hidden");
                    window.location.href = "user/" + data['slug'];
                }
            }
        });
    }
});