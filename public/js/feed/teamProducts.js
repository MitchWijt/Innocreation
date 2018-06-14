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