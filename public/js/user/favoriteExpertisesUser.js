$(".card-fav").on("click", function () {
    var postData = "";
    var user_id = $(this).parents(".ChoosefavExpertisesForm").find(".user_id").val();
    var expertise_id = $(this).parents(".ChoosefavExpertisesForm").find(".expertise_id").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/saveFavoriteExpertisesUser",
        data: {'user_id': user_id, 'expertise_id': expertise_id},
        success: function (data) {
            console.log(data);
            if(data == "max"){
                location.reload();
            }
            $('.card-fav-').each(function () {
                if ($(this).data("expertise-id") == expertise_id) {
                    $(this).removeClass("card-fav");
                    $(this).addClass("card-fav-chosen");
                    $(this).find(".checkMark").removeClass("hidden");
                }
            });
        }
    });
});

$(".filterFavExpertises").on("click",function () {
    location.reload();
});

$(".editFavExpertisesBtn").on("click",function () {
    $(".deleteCross").toggle();
});

$(document).ready(function () {
    $(".deleteCross").removeClass("hidden");
    $(".deleteCross").toggle();
});

$(".deleteCross").on("click",function (e) {
    e.stopPropagation();
    $(".editFavExpertises").submit();
});

