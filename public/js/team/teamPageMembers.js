$(".kickMember").on("click",function () {
    var user_id = $(this).data("user-id");

    $(".kickMemberModal").each(function () {
       if($(this).data("user-id") == user_id){
           $(this).modal().toggle();
       }
    });
});

$(".muteMember").on("click",function () {
    var user_id = $(this).data("user-id");

    $(".muteMemberModal").each(function () {
        if($(this).data("user-id") == user_id){
            $(this).modal().toggle();
        }
    });
});

$(".editMemberPermission").on("click",function () {
    var user_id = $(this).data("user-id");

    $(".editMemberPermissionsModal").each(function () {
        if($(this).data("user-id") == user_id){
            $(this).modal().toggle();
        }
    });
});

$(".generateInviteLink").on("click",function () {
    var team_id = $(this).data("team-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/my-team/generateInviteLink",
        data: {'team_id': team_id},
        success: function (data) {
           $(".inviteLink").val(data);
           $(".fb-share-button").attr("data-href", data);
           $(".fb-share-button").attr("href", data);
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));

            $(".twitter-share-button").attr("href", data);
            $(".twitter-share-button").removeClass("hidden");
            $(".tweet-button-link").attr("href", data);
            window.twttr = (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0],
                    t = window.twttr || {};
                if (d.getElementById(id)) return t;
                js = d.createElement(s);
                js.id = id;
                js.src = "https://platform.twitter.com/widgets.js";
                fjs.parentNode.insertBefore(js, fjs);

                t._e = [];
                t.ready = function(f) {
                    t._e.push(f);
                };

                return t;
            }(document, "script", "twitter-wjs"));
        }
    });
});

$('.shareFb').click( function() {
    console.log("gfdsa");
    var shareurl = $(this).attr("data-href");
    window.open('https://www.facebook.com/sharer/sharer.php?u='+escape(shareurl)+'&t='+document.title, '',
        'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
    return false;
});
