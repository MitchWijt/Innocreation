$(".goToStep2").on("click",function () {
    var bool = true;

    if($(".firstname").val().length < 1){
        $(".firstname").attr("style", "border: 1px solid red !important");
        $(".labelFirstname").attr("style", "color: red !important");
        bool = false;
    } else {
        $(".firstname").attr("style", "border: 1px solid red !important");
        $(".labelFirstname").attr("style", "color: red !important");
    }






    if(bool) {
        $(".progress-bar").attr("style", "width: 40% !important");
        $(".progress-bar").text("40% complete");

        $(".credentials").addClass("hidden");
        var firstname = $(".firstname").val();
        var header = "Welcome " + firstname + ", what is your residence info?";
        $(".residenceHeader").text(header);
        $('.residence').removeClass("hidden");
    }
});