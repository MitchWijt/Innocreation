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

$(".editPortfolioImage").on("click",function () {
    $(".portfolio_image:last").click();
});

$(".portfolio_image").on("change",function () {
    console.log("test");
    var filename = $(".portfolio_image").val().split('\\').pop();
    console.log(filename);
    $(".fileName").text(filename);
});