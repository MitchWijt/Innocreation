$(document).on("mouseover", ".videoContent", function () {
    var id = $(this).data("id");
    var counter = $(this).data("counter");
    playVid(id, counter);
});

$(document).on("touchstart", ".videoContentMobile", function () {
    var id = $(this).data("id");
    var counter = $(this).data("counter");
    playVid(id, counter);
});

$(document).on("mouseleave", ".videoContent", function () {
    var id = $(this).data("id");
    var counter = $(this).data("counter");
    pauseVid(id, counter);
});

$(document).on("mouseover", ".videoContentTablet", function () {
    var id = $(this).data("id");
    var counter = $(this).data("counter");
    playVid(id, counter);
});

$(document).on("mouseleave", ".videoContentTablet", function () {
    var id = $(this).data("id");
    var counter = $(this).data("counter");
    pauseVid(id, counter);
});

function playVid(id, counter){
    $('.video-' + id).trigger('play');
    $(".play-" + id).addClass("hidden");
    vars[counter + 'newCarousel'].pause();
}

function pauseVid(id, counter){
    var video =  $('.video-' + id);
    $(".play-" + id).removeClass("hidden");
    video.autoplay = false;
    setTimeout(function(){
        video.trigger('load');
    }, 500);
    vars[counter + 'newCarousel'].play();
}