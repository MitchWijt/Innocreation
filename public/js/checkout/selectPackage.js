$(".register").on("click",function () {
  $(".loginForm").addClass("hidden");
  $(".registerForm").removeClass("hidden");
  $(".collapse").collapse("show");
});

$(".login").on("click",function () {
    $(".loginForm").removeClass("hidden");
    $(".registerForm").addClass("hidden");
    $(".collapse").collapse("show");
});
$(document).ready(function () {
    $(".ui-menu").appendTo(".expertises");
    $(".token-input").attr("style", "");

    $(".tokenfield").removeClass("form-control");
    $(".tokenfield").addClass("col-sm-12");
});

$(".paymentPreference").on("click",function () {
    var package_id = $(this).data("package-id");
    var preference = $(this).data("preference");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/checkout/packagePricePreference",
        data: {'package_id': package_id, "preference": preference},
        success: function (data) {
            $(".packagePrice").text(data);
            if(preference == "yearly"){
                $(".packagePreference").text("/Yearly")
            } else {
                $(".packagePreference").text("/Monthly")
            }
        }
    });
});