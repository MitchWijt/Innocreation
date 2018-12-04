$(".openPortfolioModal").on("click",function () {
   $(this).parents(".portfolio").find(".portfolioModal").modal().toggle();
});

$(".read-more").on("click",function () {
   console.log("gfdsa");
    var id = $(this).data("toggle");
    $("#collapse-" + id).collapse('toggle');
});