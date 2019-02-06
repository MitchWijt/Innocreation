$(document).ready(function () {
    var page = $(".userworkData").data("page");
    var userId = $(".userworkData").data("user-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/feed/getUserworkPosts",
        data: {'page' : page, 'userId' : userId},
        success: function (data) {
            $(".userworkData").html(data);
        }
    });
});

var counterScroll = 0;
$(window).scroll(function () {
    if ($(window).scrollTop() >= $(document).height() - $(window).height() - 10) {
        counterScroll++;
        if(counterScroll <= 1) {
            var counter = 0;
            var userworkArray = [];
            $(".userWorkPost").each(function () {
                counter++;
                userworkArray.push($(this).data("id"));
            });
            if (counter < $(".totalAmount").val()) {
                $(".loadingGear").removeClass("hidden");
                var page = $(".userworkData").data("page");
                var userId = $(".userworkData").data("user-id");
                $.ajax({
                    method: "POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');

                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    url: "/feed/getMoreUserworkPosts",
                    data: {'userworkArray': userworkArray, 'page' : page, 'userId' : userId},
                    success: function (data) {
                        if (data.length > 1) {
                            $(".loadingGear").addClass("hidden");
                            $(".userworkData").append(data);
                            setTimeout(function(){
                                counterScroll = 0;
                            }, 2000);

                        }
                    }
                });
            }
        }
    } else {
        $(".loadingGear").addClass("hidden");
    }
});




$(document).on("click", ".zoom", function () {
    var userworkId = $(this).data("id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/getUserWorkPostModal",
        data: {"userworkId" : userworkId},
        success: function (data) {
            $("body").append(data);
            $(".userWorkPostModal").modal("toggle");
            $(".modal-backdrop").attr("style", "opacity: 0.5 !important");
        }
    });

    setTimeout(function(){
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/message/getUserWorkComments",
            data: {'user_work_id': userworkId},
            success: function (data) {
                $(".userWorkComments").html(data);
            }
        });
        setTimeout(function(){
            var objDiv = $(".userWorkComments");
            if (objDiv.length > 0) {
                objDiv[0].scrollTop = objDiv[0].scrollHeight;
            }
        }, 1000);
    }, 500);
});
$(document).on("shown.bs.modal", ".userWorkPostModal", function () {
    const comments = document.querySelector(".userWorkComments");
    bodyScrollLock.disableBodyScroll(comments);
});

$(document).on("hidden.bs.modal", ".userWorkPostModal", function () {
    $(".userWorkPostModal").remove();
});

$(document).on("click", ".emojiComment", function () {
    var id = $(this).data("id");
    var code = $(this).data("code");
    var val = $("#messageInput-" + id).val();

    $("#messageInput-" + id).val(val + code)
});

$(document).on("click", ".editPostBtn",function () {
    var id = $(this).data("id");
    $(".descriptionUserWork-" + id).addClass("hidden");
    $(".editUserWork-" + id).removeClass("hidden");
});

$(document).on("click", ".postComment", function () {
    var user_work_id = $(this).parents(".postCommentForm").find(".user_work_id").val();
    var sender_user_id = $(this).parents(".postCommentForm").find(".sender_user_id").val();
    var comment = $(this).parents(".postCommentForm").find(".comment").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/feed/postUserWorkComment",
        data: {'user_work_id': user_work_id, 'sender_user_id' : sender_user_id, 'comment' : comment},
        dataType: "JSON",
        success: function (data) {
            var message = $('.emptyMessage').first().clone();
            function Generator() {}

            Generator.prototype.rand =  Math.floor(Math.random() * 26) + Date.now();

            Generator.prototype.getId = function() {
                return this.rand++;
            };
            var idGen = new Generator();
            var newId = idGen.getId();
            message.attr("id", newId);
            var allMessages = $(".userWorkComments");
            $(message).appendTo(allMessages);
            message.removeClass("hidden");
            message.find(".message").text(data['message']);
            message.find(".timeSent").text(data['timeSent']);
            $("#" + newId).removeClass("hidden");
            $(".comment").val("");
        }
    });
    setTimeout(function(){
        var objDiv = $(".userWorkComments");
        if (objDiv.length > 0) {
            objDiv[0].scrollTop = objDiv[0].scrollHeight;
        }
    }, 1000);
});