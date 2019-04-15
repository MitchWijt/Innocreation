//IMAGES LAZY LOADING

if($(".mobile").text() == '1'){
    $('.lazyLoad').Lazy({
        scrollDirection: 'vertical',
        effect: 'fadeIn',
        effectTime: 2000,
        threshold: -900,
        visibleOnly: true,
        onError: function(element) {
            console.log('error loading ' + element.data('src'));
        }
    });
} else {
    $('.lazyLoad').Lazy({
        scrollDirection: 'vertical',
        effect: 'fadeIn',
        effectTime: 2000,
        threshold: -800,
        visibleOnly: true,
        onError: function(element) {
            console.log('error loading ' + element.data('src'));
        }
    });
}



