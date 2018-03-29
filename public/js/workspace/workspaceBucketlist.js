$(".addNewBucketlistBoard").on("click",function () {
    var bucketlistBoard = $('.bucketlistBoard').first().clone();
    var item = $(".allBucketlistBoards");


    $(bucketlistBoard).appendTo(item);
    $('html, body').animate({
        scrollTop: $(".allBucketlistBoards").offset().top
    }, 1000);


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

$(document).ready(function () {
    $(".bucketlistBoardMenu").removeClass("hidden");
    $(".bucketlistBoardMenu").toggle();
});

$(document).on("click",".openBoardMenu",function () {
    $(this).parents(".bucketlistBoard").find(".bucketlistBoardMenu").toggle();
});

$(".deleteBucketlistBoard").on("click",function () {
    if (confirm('Are you sure you want to delete this board and all of his content?')) {
        var bucketlist_type_id = $(this).data("bucketlist-type-id");
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/workspace/deleteBucketlistBoard",
            data: {'bucketlist_type_id': bucketlist_type_id},
            success: function (data) {
                $(".bucketlistBoard").each(function () {
                    if ($(this).data("bucketlist-type-id") == bucketlist_type_id) {
                        $(this).remove();
                    }
                });
            }
        });
    }
});

$(".renameBucketlistBoard").on("click",function () {
    $(this).parents(".bucketlistBoard").find(".rename_bucketlistType_title").removeClass("hidden");
    $(this).parents(".bucketlistBoard").find(".boardTitle").addClass("hidden");
    $(this).parents(".bucketlistBoard").find(".bucketlistBoardMenu").toggle();
});

$(".rename_bucketlistType_title").on("change",function () {
    var bucketlist_type_id = $(this).data("bucketlist-type-id");
    var new_bucketlistboard_title = $(this).val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/renameBucketlistBoard",
        data: {'bucketlist_type_id': bucketlist_type_id, 'new_title' : new_bucketlistboard_title},
        success: function (data) {
            $(".rename_bucketlistType_title").each(function () {
                if($(this).data("bucketlist-type-id") == bucketlist_type_id){
                   $(this).addClass("hidden");
                   $(this).parents(".bucketlistBoard").find(".boardTitle").text(new_bucketlistboard_title);
                   $(this).parents(".bucketlistBoard").find(".boardTitle").removeClass("hidden");
                   $(this).parents(".bucketlistBoard").find(".boardTitle").append("<i class='m-l-10 zmdi zmdi-chevron-down openBoardMenu'></i>")
                }
            });
        }
    });
});
function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev, el,type_id) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    el.appendChild(document.getElementById(data));
    var bucketlist_id_text = ev.dataTransfer.getData("text");
    var bucketlist_id = bucketlist_id_text.split("-");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/changePlaceBucketlistGoal",
        data: {'bucketlist_type_id': type_id, 'bucketlist_id' : bucketlist_id[1], 'place' : bucketlist_id[2]},
        success: function (data) {

        }
    });
}

$(".deleteBucketlistGoal").on("click",function () {
    var bucketlist_id = $(this).data("bucketlist-id");
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/deleteSingleBucketlistGoal",
        data: {'bucketlist_id': bucketlist_id},
        success: function (data) {
            $(".singleBucketlistGoal").each(function () {
                if($(this).data("bucketlist-id") == bucketlist_id){
                    $(this).fadeOut();
                }
            });
        }
    });
});
