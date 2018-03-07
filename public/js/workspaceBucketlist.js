$(".addNewBucketlistBoard").on("click",function () {
    var bucketlistBoard = $('.bucketlistBoard').first().clone();
    var item = $(".allBucketlistBoards");


    $(bucketlistBoard).appendTo(item);


});

$(document).on("change", ".bucketlistType_title",function () {
    var bucketlistType_title = $(this).val();
    var team_id = $(this).data("team-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/addBucketlistBoard",
        data: {'bucketlistType_title': bucketlistType_title, 'team_id' : team_id},
        success: function (data) {
            $(".bucketlistType_title").each(function () {
               if($(this).val() == bucketlistType_title){
                   $(this).parents(".bucketlistBoard").find(".newBoardTitle").removeClass("hidden");
                    $(this).parents(".bucketlistBoard").find(".newBoardTitle").text(bucketlistType_title);
                    $(this).addClass("hidden");
               }
            });
        }
    });
});

$(".completeBucketlistGoal").on("click",function () {
    var bucketlist_id = $(this).data("bucketlist-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/completeBucketlistGoal",
        data: {'bucketlist_id': bucketlist_id},
        success: function (data) {
            $(".completeBucketlistGoal").each(function () {
               if($(this).data("bucketlist-id") == bucketlist_id){
                   if(data == 1) {
                       $(this).removeClass("c-black");
                       $(this).attr("style", "");
                       $(this).attr("style", "background: #FF6100; color: #000;");
                   } else {
                       $(this).removeClass("c-black");
                       $(this).attr("style", "");
                       $(this).attr("style", "background: #000; color: ##BDC1C5;");
                   }
               }
            });
        }
    });
});