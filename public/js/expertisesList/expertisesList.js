$(document).ready(function () {
   var height = $(".searchBar").height() - 3;
   $(".searchButton").attr("style", "height:" + height + "px !important");
});

$(document).on("click", ".ui-menu-item-wrapper", function () {
   var expertise = $(this).text();
   $(".searchInput").val(expertise);
   $(".searchExpertiseForm").submit();
});

$(".expertiseCard").on('click',function () {
   var link = $(this).data("url");
    var win = window.open(link, '_blank');
    if (win) {
        //Browser has allowed it to be opened
        win.focus();
    } else {
        //Browser has blocked it
        alert('Please allow popups for this website');
    }
});

$(".photographer").on("click",function (e) {
    e.stopPropagation();
});
