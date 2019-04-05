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
    setTimeout(function () {
        if($(".sharedLinkId").val()){
            var hash = $(".sharedLinkId").val();
            $.ajax({
                method: "POST",
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');

                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                url: "/feed/unhashId",
                data: {"hash" : hash},
                success: function (data) {
                    var _this = $(".zoom-" + data);
                    zoom(_this);
                }
            });
        }
    }, 500);
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

function zoom(_this){
    var userworkId = _this.data("id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/getUserWorkPostModal",
        dataType: "JSON",
        data: {"userworkId" : userworkId},
        success: function (data) {
            $("body").append(data['view']);
            $(".userWorkPostModal").modal("toggle");
            $(".modal-backdrop").attr("style", "opacity: 0.5 !important");
            history.replaceState("userWorkPostModal", "userWorkPostModal", '/innocreatives/' + data['hash']);
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
}


$(document).on("click", ".zoom", function () {
    zoom($(this));
});
// $(document).on("shown.bs.modal", ".userWorkPostModal", function () {
//     const comments = document.querySelector(".userWorkComments");
//     bodyScrollLock.disableBodyScroll(comments);
// });

$(document).on("hidden.bs.modal", ".userWorkPostModal", function () {
    $(".userWorkPostModal").remove();
    history.replaceState("innocreatives", "innocreatives", '/innocreatives');
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
            message.attr("style", "");
            message.find(".message").text(data['message']);
            message.find(".userNameComment").text(data['userName']);
            message.find(".userProfilePic2").attr("style", "background: url('" + data['userProfilePic'] + "')");
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

function plus_minus_interest(formUrl, _this){
    var userWorkId = _this.data("id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: formUrl,
        data: {'user_work_id': userWorkId},
        success: function (data) {
            $(".amountOfPoints-" + userWorkId).text(data);
        }
    });
}

if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    var eventTrigger = "touchstart";
} else {
    var eventTrigger = "click";
}
$(document).on(eventTrigger, ".fave", function () {
    if ($(this).hasClass("normal-fave")) {
        $(this).addClass("fave-animation");
        plus_minus_interest("/feed/interestPost", $(this));
    } else {
        $(this).addClass("fave-revert");
        plus_minus_interest("/feed/disInterestPost", $(this));
    }

    var _this = $(this);
    setTimeout(function () {
        if (_this.hasClass("normal-fave")) {
            _this.removeClass("fave-animation");
            _this.removeClass("normal-fave").addClass("active-fave");
        } else {
            _this.removeClass("fave-revert");
            _this.removeClass("active-fave").addClass("normal-fave");
        }
    }, 1000);
});

$(document).on("mouseover", ".zoom, .interestedButtonPost, .commentsButtonPost, .postedUser", function () {
    $(this).parents(".image").find(".imageOverlay").addClass("fadeIn");
    $(this).parents(".image").find(".interestedButtonPost").addClass("fadeInContent");
    $(this).parents(".image").find(".commentsButtonPost").addClass("fadeInContent");
    $(this).parents(".image").find(".postedUser").addClass("fadeInContent");
});

$(document).on("mouseleave", ".zoom, .interestedButtonPost, .commentsButtonPost, .postedUser", function () {
    $(this).parents(".image").find(".imageOverlay").removeClass("fadeIn");
    $(this).parents(".image").find(".interestedButtonPost").removeClass("fadeInContent");
    $(this).parents(".image").find(".commentsButtonPost").removeClass("fadeInContent");
    $(this).parents(".image").find(".postedUser").removeClass("fadeInContent");
});
