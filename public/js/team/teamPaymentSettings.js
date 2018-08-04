$(".splitTheBill").on("change",function () {
    if($(this).is(":checked")) {
        $("#splitTheBillCollapse").collapse("show");
    } else {
        $("#splitTheBillCollapse").collapse("hide");
    }
});

number_format = function (number, decimals, dec_point, thousands_sep) {
    number = number.toFixed(decimals);

    var nstr = number.toString();
    nstr += '';
    x = nstr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? dec_point + x[1] : '';
    var rgx = /(\d+)(\d{3})/;

    while (rgx.test(x1))
        x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

    return x1 + x2;
};

$(".splitEqually").on("click",function () {
    var totalAmount = $(".totalAmount").text();
    $(".totalPrice").text("0.00");
    var counter = 0;
    $(".splittedAmountMember").each(function () {
        counter++;
    });
    var splittedAmount = totalAmount / counter;
    $(".splittedAmountMember").each(function () {
        $(this).val(number_format(splittedAmount, 2, ".", "."));
    });
    $(".splitError").text("");
    $(".amountExceeded").addClass("hidden");
    $(".savePaymentSettings").attr("disabled", false);

});
$(document).ready(function () {
    splitTheBill();
});

$(".splittedAmountMember").on("keyup",function () {
    splitTheBill();
});

function splitTheBill() {
    var totalPrice = parseFloat($(".totalAmount").text());
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
        $(".splitError").text("You exceeded your split limit. please alter the amoudnt");
        var exceededAmount = amountLeft;
        $(".exceededAmount").text(exceededAmount.toFixed(2));
        $(".amountExceeded").removeClass("hidden");
        $(".savePaymentSettings").attr("disabled", true);
        amountLeft = 0;
    } else if(amountLeft > totalPrice){
        $(".splitError").text("You exceeded your split limit. please alter the amount");
        $(".toStep3").attr("disabled", true);
    } else {
        $(".splitError").text("");
        $(".amountExceeded").addClass("hidden");
        $(".savePaymentSettings").attr("disabled", false);
    }
    if(amountLeft != 0){
        $(".splitError").text("Please split the whole price");
        $(".savePaymentSettings").attr("disabled", true);
    }
    $(".totalPrice").text(amountLeft.toFixed(2));
}


$(".savePaymentSettings").on("click",function () {
    if($("#splitTheBillOnOff").is(":checked")){
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
                $(".savePaymentSettingsForm").submit();
            }
        });
    } else {
        $(".savePaymentSettingsForm").submit();
    }
});