$(document).ready(function () {
   var height = $(".searchBar").height() - 3;
   $(".searchButton").attr("style", "height:" + height + "px !important");
});

$(document).on("click", ".ui-menu-item-wrapper", function () {
   var expertise = $(this).text();
   $(".searchInput").val(expertise);
   $(".searchExpertiseForm").submit();
});