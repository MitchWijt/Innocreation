//IMAGES LAZY LOADING


$('.lazyLoadHomeMobile').Lazy({
    scrollDirection: 'vertical',
    effect: 'fadeIn',
    effectTime: 2000,
    threshold: -850,
    visibleOnly: true,
    onError: function(element) {
        console.log('error loading ' + element.data('src'));
    }
});

$('.lazyLoadHome').Lazy({
    scrollDirection: 'vertical',
    effect: 'fadeIn',
    effectTime: 2000,
    threshold: -700,
    visibleOnly: true,
    onError: function(element) {
        console.log('error loading ' + element.data('src'));
    }
});


$('.lazyLoad').Lazy({
    scrollDirection: 'vertical',
    effect: 'fadeIn',
    effectTime: 2000,
    threshold: -200,
    visibleOnly: true,
    onError: function(element) {
        console.log('error loading ' + element.data('src'));
    }
});


var lazy = new Layzr();