$(document).ready(function () {
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

