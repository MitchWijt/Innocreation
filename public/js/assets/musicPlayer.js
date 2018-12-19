
$(".video").on("mouseover",function () {
    document.getElementById('video').play();
});

$(".video").on("mouseleave",function () {
   var video =  document.getElementById('video');
   video.currentTime = 0;
   video.pause();
});
