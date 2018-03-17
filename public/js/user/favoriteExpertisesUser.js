var counterFav = 0;
$(".card-square").on("click", function () {
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
            counterFav++;
            if(data == "max"){
                location.reload();
            }
            $('.card-square').each(function () {
                if ($(this).data("expertise-id") == expertise_id) {
                    $(this).removeClass("card-square");
                    $(this).addClass("card-chosen");
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

$(".deleteCross").on("click",function () {
    $(".editFavExpertises").submit();
});

