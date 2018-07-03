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

$(".splitTheBill").on("change",function () {
    if($(this).is(":checked")) {
        $("#splitTheBillCollapse").collapse("show");
    } else {
        $("#splitTheBillCollapse").collapse("hide");
    }
});

$(".splitEqually").on("click",function () {
    var totalAmount = $(".packagePrice:first").text();
    $(".totalPrice").text("0");
    var counter = 0;
    $(".splittedAmountMember").each(function () {
        counter++;
    });
    var splittedAmount = totalAmount / counter;
    $(".splittedAmountMember").each(function () {
        $(this).val(splittedAmount);
    });
    $(".splitError").text("");
    $(".amountExceeded").addClass("hidden");

});

$(".splittedAmountMember").on("keyup",function () {
    var totalPrice = parseFloat($(".packagePrice").text());
    var amountSplitted = 0;
    $(".splittedAmountMember").each(function () {
        if($(this).val().length > 0) {
            var addAmount =  parseFloat($(this).val());
        } else {
            var addAmount =  0;
        }
        amountSplitted = amountSplitted + addAmount;
    });
    var amountLeft = totalPrice - amountSplitted;
    if(amountLeft < 0){
        $(".splitError").text("You exceeded your split limit. please alter the amount");
        var exceededAmount = amountLeft;
        $(".exceededAmount").text(exceededAmount.toFixed(2));
        $(".amountExceeded").removeClass("hidden");
        $(".toStep3").attr("disabled", true);
        amountLeft = 0;
    } else if(amountLeft > totalPrice){
        $(".splitError").text("You exceeded your split limit. please alter the amount");
        $(".toStep3").attr("disabled", true);
    } else {
        $(".splitError").text("");
        $(".amountExceeded").addClass("hidden");
        $(".toStep3").attr("disabled", false);
    }
    if(amountLeft != 0){
        $(".splitError").text("Please split the whole price");
        $(".toStep3").attr("disabled", true);
    }
    $(".totalPrice").text(amountLeft.toFixed(2));
});


$(".toStep3").on("click",function () {
    if($(".splitTheBill").is(":checked")){
        var teamId = $(".team_id").val();
        var userIds = [];
        var prices = [];
        $(".splittedAmountMember").each(function () {
            userIds.push($(this).data("member-id"));
            prices.push($(this).val());
        });
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/checkout/setSplitTheBillData",
            data: {'userIds': userIds, "prices": prices, "teamId" : teamId},
            success: function (data) {
                $(".savePaymentInfoForm").submit();
            }
        });
    } else {

    }
});