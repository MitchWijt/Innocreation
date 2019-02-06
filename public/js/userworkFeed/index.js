if($(".userJS").val() == 1) {
    var textarea = document.querySelector('textarea');

    textarea.addEventListener('keydown', autosize);

    function autosize() {
        var el = this;
        setTimeout(function () {
            el.style.cssText = 'height:auto; ';
            el.style.cssText = 'height:' + el.scrollHeight + 'px';
        }, 200);
    }
}

$(document).on('click', '.addPicture', function() {
    $(this).parents(".fileUpload").find(".userwork_image").click();
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#previewUpload').attr('src', e.target.result);
            $(".previewBox").removeClass("hidden");
            $("#removePreview").removeClass("hidden");
        };

        reader.readAsDataURL(input.files[0]);
    }
}
$(document).on("change", ".userwork_image",function () {
    readURL(this);
});

$(".submitPost").on("click",function () {
    var bool = true;
    if($("#description_id").val().length < 1){
        $("#description_id").attr("style", "border: 1px solid red !important");
        bool = false;
    }
    if(bool) {
        $(".userWorkForm").submit();
    }
});

$(document).on("mouseover", ".previewBox", function () {
    $("#removePreview").removeClass("hidden");
});

$(document).on("mouseleave", ".previewBox", function () {
    $("#removePreview").addClass("hidden");
});

$(document).on("click", "#removePreview", function () {
   $("#previewUpload").attr("src", "");
   $(".previewBox").addClass("hidden");
   $(this).addClass("hidden");
   $(".userwork_image").val("");
});

$(document).on("keyup", ".attachmentLink", function () {
   var val = $(this).val();
   $(".attachmentLinkDB").val(val);
});

$(document).on("click", ".popoverAttachment", function () {
    if($(".attachmentLinkDB").val().length > 0){
        var val = $(".attachmentLinkDB").val();
        $(".attachmentLink").val(val);
    }
});

$(document).on("click", ".emoji", function () {
   var code = $(this).data("code");
   var val = $("#description_id").val();
   $("#description_id").val(val + code);
});

$(document).on("click", ".activeContent", function (e) {
    e.stopPropagation();
});

$(document).on("click", "body", function () {
    $(".overlayContent").removeClass("has-overlay");
    $(".contentActive").removeClass("activeContent");
    $(".contentActiveIcons").removeClass("activeIcons");
    $(".descDesktop").blur();
    $('.extraOptions').addClass("hidden");
});

$(document).on("touchstart", ".has-overlay", function () {
    $(".overlayContent").removeClass("has-overlay");
    $(".contentActive").removeClass("activeContent");
    $(".contentActiveIcons").removeClass("activeIcons");
    $(".descDesktop").blur();
    $('.extraOptions').addClass("hidden");
});

$(".descDesktop").on("focus",function () {
    $(".overlayContent").addClass("has-overlay");
    $(".contentActive").addClass("activeContent");
    $(".contentActiveIcons").addClass("activeIcons");
    $('.extraOptions').removeClass("hidden");
});

$('.triggerSlider, .closeSlider').click(function() {
    $('.sliderUpDown').toggleClass('close');
    $(".sliderContent").toggleClass('hidden');
});

$(".postInnocreativePost").on("click",function () {
    $(".userWorkForm").submit();
});



