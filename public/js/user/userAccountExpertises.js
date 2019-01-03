$(".editDescriptionBtn").on("click",function () {
    // var _this = $(".expertise-description");
    $(this).hide();
    $(this).parents(".expertiseButtons").find(".saveDescriptionBtn").removeClass("hidden");
    var id = $(this).data("expertise-id");

    $('.editUserExpertiseField').each(function () {
        if($(this).data("id") == id){
            $(this).closest(".formHidden").removeClass("hidden");
        }
    });

    $('.expertise-description').each(function () {
        if($(this).data("id") == id){
            $(this).closest(".expertise-description").hide();
        }
    });
});

$(".saveDescriptionBtn").on("click",function () {
    var id = $(this).data("expertise-id");

    $('.editUserExpertiseField').each(function () {
        if($(this).data("id") == id){
            $(this).closest(".editUserExpertiseField").submit();
        }
    });
});

$(".deleteCross").on("click",function (e) {
    e.stopPropagation();
    if (confirm('Are you sure you want to delete this expertise?')) {
        var postData = "";
        var expertise_id = $(this).data("expertise-id");
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/deleteUserExpertise",
            data: {'expertise_id': expertise_id},
            success: function (data) {
                if(data == 1) {
                    $(".expertise").each(function () {
                        if($(this).data("expertise-id") == expertise_id){
                            $(this).fadeOut();
                        }
                    });

                }
            }
        });
    }
});

$(document).ready(function () {
    $(".token-input").attr("style", "");

    $(".tokenfield").removeClass("form-control");
    $(".tokenfield").addClass("col-sm-12");

    $(".token-input").attr("style", "width: 100% !important");
});

$(".editImage").on("click",function () {
    var expertise_id = $(this).data("expertise-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/user/getEditUserExpertiseModal",
        data: {'expertise_id': expertise_id},
        success: function (data) {
           $(".editImageModalData").html(data);
           $(".editImageModal").modal().toggle();
        }
    });
});

$(document).on("click", ".userExpImg", function () {
    var expertise_id = $(this).data("expertise-id");
    var image = $(this).data("img");
    var photographerLink = $(this).data("pl");
    var photographerName = $(this).data("pn");
    var id = $(this).data("id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/user/editUserExpertiseImage",
        data: {'expertise_id': expertise_id, 'photographerLink' : photographerLink, 'image' : image, 'photographerName' : photographerName, "imgId" : id},
        success: function (data) {
           window.location.reload();
        }
    });
});

$(document).on("click", ".closeModal" ,function () {
    $(".editImageModal").modal().toggle();
});

$('#tokenfield')
    .on('tokenfield:createdtoken', function (e) {
        var tokens = $('#tokenfield').tokenfield('getTokens');
        if(tokens.length >= 1){
            $(".textWarning").text("You can add a max. of 1 expertise at the same time");
        }
    })
    .tokenfield({
        showAutocompleteOnFocus: true,
        createTokensOnBlur: true,
        limit: 1
    });