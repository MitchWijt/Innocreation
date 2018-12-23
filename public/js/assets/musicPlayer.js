function play(id, counter){
    document.getElementById('player-' + id).play();
    $(".playSong").addClass("hidden");
    $(".pauseSong").removeClass("hidden");
    vars[counter + 'newCarousel'].pause();
}

function pause(id, counter){
    document.getElementById('player-' + id).pause();
    $(".playSong").removeClass("hidden");
    $(".pauseSong").addClass("hidden");
    vars[counter + 'newCarousel'].play();
}

$(document).on("click", ".pauseSong", function () {
    var id = $(this).data("id");
    var counter = $(this).data("counter");
    pause(id, counter);
});

$(document).on("click", ".playSong", function () {
    var id = $(this).data("id");
    var counter = $(this).data("counter");
    play(id, counter);
});

function getCurrentTime(event, id) {
    $(".cur-" + id).text(formatTime(event.currentTime));
    var percentage = Math.floor(event.currentTime / event.duration * 100);
    $('.musicBar-' + id).val(percentage);
}

function formatTime(seconds) {
    minutes = Math.floor(seconds / 60);
    minutes = (minutes >= 10) ? minutes : "0" + minutes;
    seconds = Math.floor(seconds % 60);
    seconds = (seconds >= 10) ? seconds : "0" + seconds;
    return minutes + ":" + seconds;
}

$(document).ready(function () {
    $(".duration").each(function () {
        var id = $(this).data("id");
        setTimeout(function(){
            var time = document.getElementById('player-' + id);
            $(".dur-" + id).text(formatTime(time.duration));
        }, 1500);
    });
    $(".currentTime").text("00:00");


});

$(document).on("change", ".music-progress-bar", function () {
    var id = $(this).data("id");
    var counter = $(this).data("counter");
    var player =  document.getElementById('player-' + id);
    var percentage = $(this).val();
    var duration = player.duration;
    var newTime = (duration / 100) * percentage;
    player.currentTime = newTime;
    play(id, counter);
});
