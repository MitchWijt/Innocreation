
$(".addPortfolioNew").on("click",function () {
    var portfolioItem = $('#portofolio-item').first().clone();
    var item = $(".portfolioForm");


    $(portfolioItem).appendTo(item);

    $(".portfolio_image:last").val("");
    $(".portfolio_description:last").val("");
    $(".portfolio_title:last").val("");
    $(".portfolio_link:last").val("");
    $(".fileName:last").text("");
});
$(".addPortfolioEmpty").on("click",function () {
    var portfolioItem = $('#emptyForm').first().clone();
    var item = $(".emptyForms");
    $(portfolioItem).appendTo(item);

    $(".portfolio_image:last").val("");
    $(".portfolio_description:last").val("");
    $(".portfolio_title:last").val("");
    $(".portfolio_link:last").val("");
    $(".fileName:last").text("");
});

$(document).on('click', '.uploadPortfolioImage', function() {
    $(this).parents(".fileUpload").find(".portfolio_image_new").click();
});

$(document).on("change", ".portfolio_image_new",function () {
    var filename = $(this).val().split('\\').pop();
    $(".fileNameNew:last").text(filename);
});

$(document).on('click', '.editPortfolioImage', function() {
    $(this).parents(".fileUpload").find(".portfolio_image").click();
});

$(document).on("change", ".portfolio_image",function () {
    var _this = $(this);
    var filename = $(this).val().split('\\').pop();
    _this.parents(".fileUpload").find(".fileName").text(filename);

});

$(".deleteCrossPortfolio").on("click",function () {
    if (confirm('Are you sure you want to delete this portfolio?')) {
        var postData = "";
        var portfolio_id = $(this).data("portfolio-id");
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/deleteUserPortfolio",
            data: {'portfolio_id': portfolio_id},
            success: function (data) {
                if(data == 1) {
                    $('.portfolioForm').each(function () {
                        if ($(this).data("portfolio_id") == portfolio_id) {
                            $(this).fadeOut();
                        }
                    });
                }
            }
        });
    }
});

$(".saveAsUserWork").on("click",function () {
    var id = $(this).data("id");

    $(".saveAsUserWorkForm-" + id).submit();
});

$("#fileBox").on("change",function () {
   $(".addImagesPortfolio").submit();
});

$(document).ready(function () {
    $(".descPortImg").removeClass("hidden").toggle();
    $(".titlePortImg").removeClass("hidden").toggle();
    $(".hrPortImg").removeClass("hidden").toggle();
});


$(".editPortfolioImage").on("click",function () {
   var id = $(this).data("file-id");

   $(".title-" + id).toggle().focus();
   $(".hr-" + id).toggle();
   $(".desc-" + id).toggle();
   $(".contentFixed").attr("style", "display:none !important");
});

$(".titlePortImg").on("change",function () {
    var file_id = $(this).data("id");
    var title = $(this).val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/user/editTitlePortfolioImage",
        data: {'fileId': file_id, 'title': title},
        success: function (data) {
            $(".titlePortFixed-" + file_id).text(title);
            $(".title-" + file_id).toggle();
            $(".hr-" + file_id).toggle();
            $(".desc-" + file_id).toggle();
            if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                $('.contentFixed').attr("style", "display:none");
            } else {
                $('.contentFixed').attr("style", "display:block");
            }
        }
    });
});

$(".descPortImg").on("change",function () {
    var file_id = $(this).data("id");
    var desc = $(this).val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/user/editDescPortfolioImage",
        data: {'fileId': file_id, 'description' : desc},
        success: function (data) {
            $(".descPortFixed-" + file_id).text(desc);
            $(".title-" + file_id).toggle();
            $(".hr-" + file_id).toggle();
            $(".desc-" + file_id).toggle();
            if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                $('.contentFixed').attr("style", "display:none");
            } else {
                $('.contentFixed').attr("style", "display:block");
            }
        }
    });
});

$(".removeImage").on("click",function () {
    var id = $(this).data("id");
    $(".removeImageForm-" + id).submit();
});

$(".addMusicImage").on("click",function () {
    var id = $(this).data("file-id");
    $("#imageAudio-" + id).click();
});
$(".deletePortfolio").on("click",function (e) {
    if(confirm("Are you sure you, want to delete this portfolio and all contents of it?")) {
        var id = $(this).data("id");
        $(".deletePortfolio-" + id).submit();
        e.stopPropagation();
        e.preventDefault();
    }
});

$(".imageForAudio").on("change",function () {
    var id = $(this).data("file-id");
    $(".addImageToAudio-" + id).submit();
});
