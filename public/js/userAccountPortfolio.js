
$(".addPortfolioNew").on("click",function () {
    var portfolioItem = $('#portofolio-item').first().clone();
    var item = $(".portfolioForm");


    $(portfolioItem).appendTo(item);

    $(".portfolio_image:last").val("");
    $(".portfolio_description:last").val("");
    $(".portfolio_title:last").val("");
    $(".fileName:last").text("");
});
$(".addPortfolioEmpty").on("click",function () {
    var portfolioItem = $('#emptyForm').first().clone();
    var item = $(".emptyForms");
    $(portfolioItem).appendTo(item);

    $(".portfolio_image:last").val("");
    $(".portfolio_description:last").val("");
    $(".portfolio_title:last").val("");
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