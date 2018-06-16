$(".likeTeamProduct").on("click",function () {
    var team_product_id = $(this).data("id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/feed/likeTeamProduct",
        data: {'team_product_id': team_product_id},
        success: function (data) {
            $(".likeTeamProduct").each(function () {
               if($(this).data("id") == team_product_id){
                   $(this).addClass("hidden");
                   $(this).parents(".socials").find(".likedTeamProduct").removeClass("hidden");
                   var likes = parseInt($(this).parents(".socials").find(".amountLikes").text()) + 1;
                   $(this).parents(".socials").find(".amountLikes").text(likes);
               }
            });
        }
    });
});

$(".favoriteTeamProduct").on("click",function () {
    var team_product_id = $(this).data("id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/feed/favoriteTeamProduct",
        data: {'team_product_id': team_product_id},
        success: function (data) {
            $(".favoriteTeamProduct").each(function () {
                if($(this).data("id") == team_product_id){
                    if(data == 1) {
                        $(this).addClass("c-orange");
                    } else {
                        $(this).removeClass("c-orange");
                    }
                }
            });
        }
    });
});

$(".searchUsers").on("click",function () {
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

$(".toggleModal").on("click",function () {
    var url = $(this).data("url");
    var id = $(this).data("id");
    $(".shareTeamProductModal").modal().toggle();
    $(".message").val(url);
    $(".team_product_id").val(id);

});

$(".shareWithUsersRadio").on("click",function () {
    $(".shareWithUsers").removeClass("hidden");
    $(".shareProductMessage").removeClass("hidden");
});

$(".shareWithTeam").on("click",function () {
    $(".shareWithUsers").addClass("hidden");
    $(".shareProductMessage").removeClass("hidden");
});

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).val()).select();
    document.execCommand("copy");
    $temp.remove();
}

$(".toggleLink").on("click",function () {
    var copyElement = $(this).parents(".socials").find(".linkToCopy");
    copyToClipboard(copyElement);
    $(this).parents(".socials").find(".shareCopyLink").toggle();
});

$(document).ready(function () {
    $(".shareCopyLink").removeClass("hidden");
    $(".shareCopyLink").toggle();

    $(".comments").removeClass("hidden");
    $(".comments").toggle();
});

$(".copyLinkIcon").on("click",function () {
    var notificaton = $(this).parents(".socials").find(".copiedLinkNotification");
    var copyElement = $(this).parents(".socials").find(".linkToCopy");
    copyToClipboard(copyElement);
    notificaton.fadeIn();
    setTimeout(function(){
        notificaton.fadeOut();
    }, 1000);
});

$(".toggleComments").on("click",function () {
    var team_product_id = $(this).data("id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/message/getTeamProductComments",
        data: {'team_product_id': team_product_id},
        success: function (data) {
            $(".comments").each(function () {
                if($(this).data("id") == team_product_id){
                    $(this).find(".teamProductComments").html(data);
                    $(this).toggle();
                }
            });
        }
    });
});

$(document).ready(function () {
    if($(".teamProductSlug").val() != "0") {
        $(".teamProductCard").each(function () {
           if($(".teamProductSlug").val() == $(this).data("slug")){
               $('html, body').animate({
                   scrollTop: $(this).offset().top
               }, 1000);
               var product = $(this);
               product.css({"border-color": "#FF6100",
                   "border-width":"2px",
                   "border-style":"solid"});
               product.css({"background-color": "rgba(255, 177, 20, 0.4)", "transition": "background-color 500ms linear"});
               setTimeout(function() {
                   product.css({"background-color": "black", "transition": "background-color 500ms linear"});
               }, 1000);
               setTimeout(function() {
                   product.css({"background-color": "rgba(255, 177, 20, 0.4)", "transition": "background-color 500ms linear"});
               }, 1700);
               setTimeout(function() {
                   product.css({"background-color": "black", "transition": "background-color 500ms linear"});
               }, 2700);
           }
        });
    }
});