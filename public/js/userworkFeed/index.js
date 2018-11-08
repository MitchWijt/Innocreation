$(document).ready(function () {
    $('#toggle-demo').bootstrapToggle();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/feed/getUserworkPosts",
        data: "",
        success: function (data) {
            $(".userworkData").html(data);
        }
    });

    setTimeout(function(){
        if($(".sharedUserWorkId").val() != 0){
            if($(".sharedUserWorkId").val() > 15) {
                var userworkArray = [];
                $(".userWorkPost").each(function () {
                    userworkArray.push($(this).data("id"));
                });
                $.ajax({
                    method: "POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');

                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    url: "/feed/getMoreUserworkPosts",
                    data: {'userworkArray': userworkArray},
                    success: function (data) {
                        if (data.length > 1) {
                            $(".loadingGear").addClass("hidden");
                            $(".userworkData").append(data);
                        }
                    }
                });
            }
            setTimeout(function() {
                $(".userWorkPost").each(function () {
                    if($(this).data("id") == $(".sharedUserWorkId").val()){
                        $('html, body').animate({
                            scrollTop: $(this).offset().top
                        }, 1000);
                        var product = $(this);
                        product.attr("style", "border-color: #FF6100 !important; border-width: 2px !important; border-style:solid !important");
                        product.attr("style", "background-color: rgba(255, 177, 20, 0.4) !important; transition: background-color 500ms linear !important;");
                        setTimeout(function() {
                            product.attr("style", "background-color: black !important; transition: background-color 500ms linear !important;");
                        }, 1000);
                        setTimeout(function() {
                            product.attr("style", "background-color: rgba(255, 177, 20, 0.4) !important; transition: background-color 500ms linear !important;");
                        }, 1700);
                        setTimeout(function() {
                            product.attr("style", "background-color: black !important; transition: background-color 500ms linear !important;");
                        }, 2700);
                    }
                });
            }, 500);
        }
    }, 1000);
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
                $.ajax({
                    method: "POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');

                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    url: "/feed/getMoreUserworkPosts",
                    data: {'userworkArray': userworkArray},
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

$(document).on("mouseover", ".upvoteBtn",function () {
    $(this).parents(".actionList").find(".upvoteIcon").attr("style","color: #FF6100 !important");
});

$(document).on("mouseleave", ".upvoteBtn",function () {
    $(this).parents(".actionList").find(".upvoteIcon").attr("style","color: #C9CCCF !important");
});

$(document).on("click", ".upvoteBtn",function () {
    var userWorkId = $(this).parents(".actionList").find(".user_work_id").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/feed/upvoteUserWork",
        data: {'userWorkId': userWorkId},
        success: function (data) {
            if(data == 1) {
                var number = parseInt($(".upvoteNumber" + "-" + userWorkId).text());
                $(".upvoteNumber" + "-" + userWorkId).text(number + 1);
                $(".actions" + "-" + userWorkId).find(".upvoteIcon").remove();
                $(".actions" + "-" + userWorkId).find(".upvoteText").text("Upvoted").removeClass("upvoteBtn").attr("style", "color: #FF6100 !important");
            } else {
                window.open('/login', '_blank');
            }
        }
    });
});

$(document).on("change",".selectUser",function () {
    var userId = $(this).data("id");
    var userName = $(this).parents(".searchUserResult").find(".userName").text();
    if($(this).is(":checked")){
        var listItem = "<li class='selectedUserName'>" + userName + "</li>";
        $(".selectedUsers").append(listItem);
        $(".shareTeamProductUsersForm").append("<input type='hidden' class='user_id' name='userIds[]' value="+userId+">")
    } else {
        $(".selectedUserName").each(function () {
            if($(this).text() == userName){
                $(this).remove();
            }
        });

        $(".user_id").each(function () {
            if($(this).val() == userId){
                $(this).remove();
            }
        });
    }
});

$(document).on("click",".toggleModal",function () {
    var url = $(this).data("url");
    $(".shareUserWork").modal().toggle();
    $(".message").val(url);
});

$(".shareWithUsersRadio").on("click",function () {
    $(".shareWithUsers").removeClass("hidden");
    $(".shareProductMessage").removeClass("hidden");
});

$(".shareWithTeam").on("click",function () {
    $(".shareWithUsers").addClass("hidden");
    $(".shareProductMessage").removeClass("hidden");
});

$(document).on("click",".searchUsers",function () {
    var searchInput = $(".searchUsersInput").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/feed/getSearchedUsersTeamProduct",
        data: {'searchInput': searchInput},
        success: function (data) {
            $(".resultList").html(data);
        }
    });
});

$(document).on("click",".toggleLink",function () {
    window.open('/login', '_blank');
});


if($(".userJS").val() == 1) {
    var textarea = document.querySelector('textarea');

    textarea.addEventListener('keydown', autosize);

    function autosize() {
        var el = this;
        setTimeout(function () {
            el.style.cssText = 'height:auto; ';
            // for box-sizing other than "content-box" use:
            // el.style.cssText = '-moz-box-sizing:content-box';
            el.style.cssText = 'height:' + el.scrollHeight + 'px';
        }, 200);
    }
}

$(".submitPost").on("mouseover",function () {
    $(this).attr("style", "color: #FF6100")
});

$(".submitPost").on("mouseleave",function () {
    $(this).attr("style", "color: #000000")
});

$(".openForm").on("mouseover",function () {
    $(this).attr("style", "color: #FF6100")
});

$(".openForm").on("mouseleave",function () {
    $(this).attr("style", "color: #646567")
});

$(".openForm").on("click",function () {
    $(".userworkPostForm").removeClass("hidden");
    $(this).addClass("hidden");
});

$(".closeForm").on("click",function () {
    $(".userworkPostForm").addClass("hidden");
    $(".openForm").removeClass("hidden");
});


$(document).on('click', '.addPicture', function() {
    $(this).parents(".fileUpload").find(".userwork_image").click();
});

$(document).on("change", ".userwork_image",function () {
    var _this = $(this);
    var filename = $(this).val().split('\\').pop();
    _this.parents(".fileUpload").find(".fileName").text(filename);

});

$(".submitPost").on("click",function () {
    $(".userWorkForm").submit();
});

$(document).on("click", ".toggleComments", function () {
    var user_work_id = $(this).data("id");

    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/message/getUserWorkComments",
        data: {'user_work_id': user_work_id},
        success: function (data) {
            $(".comments").each(function () {
                if($(this).data("id") == user_work_id){
                    $(this).find(".userWorkComments").html(data);
                    $("#commentCollapse-" + user_work_id).toggle();
                }
            });
        }
    });
    setTimeout(function(){
        $(".userWorkComments").each(function () {
            if($(this).data("id") == user_work_id) {
                var objDiv = $(this);
                if (objDiv.length > 0) {
                    objDiv[0].scrollTop = objDiv[0].scrollHeight;
                }
            }
        });
    }, 1000);
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
            $(".userWorkComments").each(function () {
                if($(this).data("id") == user_work_id){
                    var allMessages = $(this);
                    $(message).appendTo(allMessages);
                    message.removeClass("hidden");
                    message.find(".message").text(data['message']);
                    message.find(".timeSent").text(data['timeSent']);
                    $(".comment").val("");
                }
            });
        }
    });
    setTimeout(function(){
        $(".userWorkComments").each(function () {
            if($(this).data("id") == user_work_id) {
                var objDiv = $(this);
                if (objDiv.length > 0) {
                    objDiv[0].scrollTop = objDiv[0].scrollHeight;
                }
            }
        });
    }, 1000);
});

$(document).on("click", ".editPostBtn",function () {
    var id = $(this).data("id");
    $(".descriptionUserWork-" + id).addClass("hidden");
    $(".editUserWork-" + id).removeClass("hidden");
});

$(document).on("click", ".switch__toggle", function () {
    var _this = $(this);
    if($(".userId").val() != 0) {
        if (!$(this).is(":checked")) {
            $(this).parents(".userSwitch").find(".popoverSwitch").popover.toggle();
        }

        $(this).parents(".userSwitch").find(".popoverSwitch").popover("show");
    } else {
        _this.prop("checked", true);
        setTimeout(function(){
            _this.prop("checked", false);
            _this.parents(".userSwitch").find(".popoverSwitch").popover("show");
        }, 500);

    }

});

$(document).on("keyup", ".attachmentLink", function () {
   var val = $(this).val();
   $(".attachmentLinkDB").val(val);
});

$(document).on("click", ".emoji", function () {
   var code = $(this).data("code");
   var val = $("#description_id").val();
   $("#description_id").val(val + code);
});