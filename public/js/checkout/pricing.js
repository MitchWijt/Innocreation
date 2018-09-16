$(".amount").on("change",function () {
    var chosenPrice = $(this).parents(".customSelect").find(".amount option:selected").data("price");
    var option = $(this).parents(".customSelect").find(".amount option:selected").val();
    var title = $(this).parents(".customSelect").find(".titleCustom").text();
    if(title == "Members" && option < $(".teamMembers").val()){
        $(".limitMembersCustom").modal().toggle();
        $('.customBtn').attr("disabled", true);
    } else if(title == "Members" && option > $(".teamMembers").val()){
        $('.customBtn').attr("disabled", false);
    }
    if($(".priceCustom").text().length < 1) {
        $(".priceCustom").text(chosenPrice + ".00");
    } else {
        if(title == "Members"){
            if($(".recentMemberOption").val() != "" && option < $(".recentMemberOption").val()){
                var priceNow = parseInt($(".priceCustom").text());
                var recentPrice = parseInt($(".recentMemberOption").attr("data-recent-price"));
                var fullPrice = priceNow - recentPrice + chosenPrice;
                $(".priceCustom").text(fullPrice + ".00");
            } else {
                var priceNow = parseInt($(".priceCustom").text());
                if($(".recentMemberOption").attr("data-recent-price").length > 0) {
                    var recentPrice = parseInt($(".recentMemberOption").attr("data-recent-price"));
                    var fullPrice = chosenPrice + priceNow - recentPrice;
                } else {
                    var fullPrice = chosenPrice + priceNow;
                }
                $(".priceCustom").text(fullPrice + ".00");
            }
        } else if(title == "Task planners"){
            if($(".recentTaskOption").val() != "" && option < $(".recentTaskOption").val()){
                var priceNow = parseInt($(".priceCustom").text());
                var recentPrice = parseInt($(".recentTaskOption").attr("data-recent-price"));
                var fullPrice = priceNow - recentPrice + chosenPrice;
                $(".priceCustom").text(fullPrice + ".00");
            } else {
                var priceNow = parseInt($(".priceCustom").text());
                if($(".recentTaskOption").attr("data-recent-price").length > 0) {
                    var recentPrice = parseInt($(".recentTaskOption").attr("data-recent-price"));
                    var fullPrice = chosenPrice + priceNow - recentPrice;
                } else {
                    var fullPrice = chosenPrice + priceNow;
                }
                $(".priceCustom").text(fullPrice + ".00");
            }
        } else if(title == "Meetings"){
            if($(".recentMeetingOption").val() != "" && option < $(".recentMeetingOption").val()){
                var priceNow = parseInt($(".priceCustom").text());
                var recentPrice = parseInt($(".recentMeetingOption").attr("data-recent-price"));
                var fullPrice = priceNow - recentPrice + chosenPrice;
                $(".priceCustom").text(fullPrice + ".00");
            } else {
                var priceNow = parseInt($(".priceCustom").text());
                if($(".recentMeetingOption").attr("data-recent-price").length > 0) {
                    var recentPrice = parseInt($(".recentMeetingOption").attr("data-recent-price"));
                    var fullPrice = chosenPrice + priceNow - recentPrice;
                } else {
                    var fullPrice = chosenPrice + priceNow;
                }
                $(".priceCustom").text(fullPrice + ".00");
            }
        }
    }

    if(title == "Members"){
        $(".recentMemberOption").val(option);
        $(".recentMemberOption").attr("data-recent-price", chosenPrice);
    } else if(title == "Task planners"){
        $(".recentTaskOption").val(option);
        $(".recentTaskOption").attr("data-recent-price", chosenPrice);
    } else if(title == "Meetings"){
        $(".recentMeetingOption").val(option);
        $(".recentMeetingOption").attr("data-recent-price", chosenPrice);
    }
    $(".price").removeClass("hidden");
});

$(".newsLetter").on("change",function () {
    var chosenPrice = $(this).parents(".customSelectNewsletter").find(".newsLetter option:selected").data("price");
    var option = $(this).parents(".customSelectNewsletter").find(".newsLetter option:selected").val();

    if(option == 1){
        var priceNow = parseInt($(".priceCustom").text());
        var fullPrice = priceNow + chosenPrice;
        $(".priceCustom").text(fullPrice + ".00");
    } else {
        var priceNow = parseInt($(".priceCustom").text());
        var fullPrice = priceNow - chosenPrice;
        $(".priceCustom").text(fullPrice + ".00");
    }
});
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

$(document).on("click", ".submitCustomForm",function () {
    $(".customPackageForm").submit();
});

$(document).on("click", ".submitVerificationRequest",function () {
    $(".verificationChangePackageForm").submit();
});

$(".submitCustom").on("click",function () {
    var members = $(".members").val();
    var taskplanner = $(".task-planners").val();
    var meetings = $(".meetings").val();
    var newsletter = $(".newsLetter").val();
    if(meetings && taskplanner && members && newsletter){
       var bool = true;
    } else if(!members){
        var error = "Please enter the amount of members value to continue";
        bool = false;
    } else if(!taskplanner){
        var error = "Please enter the amount of task planners you would like";
        bool = false;
    } else if(!meetings){
        var error = "Please enter the amount of meetings you would like";
        bool = false;
    } else if(!newsletter){
        var error = "Please let us know if you want to create newsletters";
        bool = false;
    }
    if(bool){
        $(".customPackageForm").submit();
    } else{
        $(".error").text(error);
    }
});