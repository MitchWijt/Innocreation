var colorPicker = new iro.ColorPicker('#color-picker-container',{
    width: 120
});

// color:change event callback
// color:change callbacks receive the current color and a changes object
function onColorChange(color, changes) {
    var hex = color.hexString;
    document.execCommand("foreColor", false, hex);
    var task_id = $("#taskId").val();

    var content = $(".taskContentEditor").html();
    clearTimeout(typingTimerTitle);
    if (content) {
        typingTimerTitle = setTimeout(function () {
            doneTyping(content, task_id, "content")
        }, 1000);
    }
}

function updateColor(hexColor){
    if(hexColor){
        colorPicker.color.hexString = hexColor;
    }
}

// listen to a color picker's color:change event
colorPicker.on('color:change', onColorChange, updateColor());

