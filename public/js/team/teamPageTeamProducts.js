$(document).on('click', '.uploadTeamProductImage', function() {
    $(".uploadImageInput").click();
});

$(document).on("change", ".uploadImageInput",function () {
    var filename = $(this).val().split('\\').pop();
    $(".fileName").text(filename);
});

$(document).on('click', '.uploadTeamProductImageModal', function() {
    $(".uploadImageInputModal").click();
});

$(document).on("change", ".uploadImageInputModal",function () {
    var filename = $(this).val().split('\\').pop();
    $(".fileNameModal").text(filename);
});

$(".editTeamProduct").on("click",function () {
    var team_product_id = $(this).data("id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/my-team/getTeamProductModalData",
        data: {'team_product_id': team_product_id},
        success: function (data) {
            $(".teamProductModalData").html(data);
            $(".teamProductModal").modal().toggle();
        }
    });
});

$(".deleteTeamProduct").on("click",function () {
    var team_product_id = $(this).data("id");
    if(confirm("Are you sure you want to delete this team product?")) {
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/my-team/deleteTeamProduct",
            data: {'team_product_id': team_product_id},
            success: function (data) {
                $(".teamProduct").each(function () {
                    if ($(this).data("id") == team_product_id) {
                        $(this).remove();
                    }
                });
            }
        });
    }
});
