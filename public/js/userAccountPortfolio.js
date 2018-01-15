// $(".addPortfolio").on("click",function () {
//     $(".portofolio-item").clone();
// });

$(".addPortfolio").on("click",function () {
    var portfolioItem = $('#portofolio-item').first().clone();
    var item = $(".portfolioForm");


    $(portfolioItem).appendTo(item);

    $(".portfolio_image:last").val("");
    $(".portfolio_description:last").val("");
    $(".portfolio_title:last").val("");
    $(".fileName:last").text("");
});

$(document).on('click', '.editPortfolioImage', function() {
    $(this).parents(".fileUpload").find(".portfolio_image").click();
});

$(document).on("change", ".portfolio_image",function () {
    var filename = $(this).val().split('\\').pop();
    $(".fileName:last").text(filename);
});