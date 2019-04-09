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

$(document).on('click', '.browseImage', function() {
    $(".input_image").click();
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

$(document).on("click", ".emoji", function () {
   var code = $(this).data("code");
   var val = $("#description_id").val();
   $("#description_id").val(val + code);
});


$('.triggerSlider, .closeSlider').click(function() {
    window.scrollTo(0,0);
    setTimeout(function () {
        $('.sliderUpDown').toggleClass('close');
        $(".sliderContent").toggleClass('hidden');
        if($(".sliderUpDown").hasClass("close")){
            bodyScrollLock.clearAllBodyScrollLocks();
        } else {
            const slider = document.querySelector(".sliderUpDown");
            bodyScrollLock.disableBodyScroll(slider);
        }
    }, 100);

});

$(".postInnocreativePost").on("click",function () {
    $(".userWorkForm").submit();
});

// When popover opend and click on body popover wil close.
$('body').on('click', function (e) {
    $('[data-toggle=popover]').each(function () {
        // hide any open popovers when the anywhere else in the body is clicked
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});

// Popover initiater for emoticons.
$('.popoverEmojis').popover({ trigger: "click" , html: true, animation:false, placement: 'auto'});


$(".submitPost").on("click", function () {
    $(this).addClass("hidden");
    $("#loadingPostRequest").removeClass("hidden");
    var file = image.files[0];
    var formData = new FormData();
    var description = $("#description_id").val();
    var relatedExpertises = $("#tokenfieldPost").val();
    var user_id = $(".user_id").val();
    formData.append('file', file);
    formData.append('description', description);
    formData.append('relatedExpertises', relatedExpertises);
    formData.append('user_id', user_id);


    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/feed/requestPostUserWork",
        data: formData,
        processData: false,  // tell jQuery not to process the data
        contentType: false,  // tell jQuery not to set contentType
        success: function (data) {
           $(".submittingForm").addClass("hidden");
           $(".completedPostRequest").removeClass("hidden");
        }
    });
});

// Reads the url of placed image and shows preview of the image before upload.
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

$(document).on("change", ".input_image",function () {
    var mimetype = this.files[0].type;
    if(mimetype != "image/jpeg") {
        $(".errorMimetype").removeClass("hidden");
    } else {
        $(".errorMimetype").addClass("hidden");
        readURL(this);
    }
});

if($(".user_id").val() != 0) {
// Change color when file if being dragged over the dropcontainer + action when file is being dropped into it. 
    dropContainer.ondragover = dropContainer.ondragenter = function (evt) {
        $("#dropContainer").attr("style", "background-color: rgba(252, 74, 9, 0.8);");
        evt.preventDefault();
    };

    dropContainer.ondragleave = function (evt) {
        $("#dropContainer").attr("style", "background: #fff; border: 1px dashed #000");
        evt.preventDefault();
    };


    dropContainer.ondrop = function (evt) {
        // Detects the drop container div. When file is being dropped onto it.
        image.files = evt.dataTransfer.files;
        var imgName = image.files[0].name;
        var mimetype = image.files[0].type;
        if (mimetype != "image/jpeg") {
            $(".errorMimetype").removeClass("hidden");
        } else {
            $(".errorMimetype").addClass("hidden");
            readURL(image);
        }
        $("#dropContainer").attr("style", "background: #fff; border: 1px dashed #000");
        evt.preventDefault();
    };
}



