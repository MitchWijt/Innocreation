$(document).on('click', '.addFiles', function() {
    $(this).parents(".fileUpload").find(".files").click();
});

$(document).on("change", ".files",function () {
    var files = $(this)[0].files;
    for (var i = 0; i < files.length; i++) {
        $(".fileName").append("<li>" + files[i].name + "</li>");
    }
});

$(".submitContactForm").on("click",function () {
    if($(".firstname").val().length < 1){
        $(".firstname").attr("style", "border: 1px solid red !important");
    } else {
        $(".firstname").attr("style", "border: 1px solid #000 !important");
    }

    if($(".lastname").val().length < 1){
        $(".lastname").attr("style", "border: 1px solid red !important");
    } else {
        $(".lastname").attr("style", "border: 1px solid #000 !important");
    }

    if($(".email").val().length < 1){
        $(".email").attr("style", "border: 1px solid red !important");
    } else {
        $(".email").attr("style", "border: 1px solid #000 !important");
    }

    if($(".message").val().length < 1){
        $(".message").attr("style", "border: 1px solid red !important");
    } else {
        $(".message").attr("style", "border: 1px solid #000 !important");
    }

    if($(".message").val().length > 1 && $(".firstname").val().length > 1 && $(".lastname").val().length > 1 && $(".email").val().length > 1){
        $(".contactUsForm").submit();
    }
});