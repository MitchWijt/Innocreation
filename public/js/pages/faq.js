$(".answerFaq").on("click",function () {
    $(this).parents(".faq").find(".faqAnswerModal").modal().toggle();
});