$(".openModalChangePackage").on("click",function () {
    var user_id = $(this).data("user-id");
    var membership_package_id = $(this).data("membership-package-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/checkout/getChangePackageModal",
        data: {'user_id': user_id, "membership_package_id" : membership_package_id},
        success: function (data) {
            $(".changePackageModalData").html(data);
            $('.changePackageModal').modal().toggle();
        }
    });
});

$(".openFunctionsModal").on("click", function () {
    var membership_package_id = $(this).data("membership-package-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/checkout/getFunctionsModal",
        data: {"membership_package_id" : membership_package_id},
        success: function (data) {
            $("body").append(data);
            $('.packageFunctionsModel').modal("toggle");
        }
    });
});

$(document).on("hidden.bs.modal", ".packageFunctionsModel", function () {
    $(".packageFunctionsModel").remove();
});

