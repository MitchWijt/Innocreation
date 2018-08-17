window.addEventListener('load', function() {
    var editor;
    editor = ContentTools.EditorApp.get();
    editor.init('*[data-editable]', 'data-name');

    editor.addEventListener('saved', function (ev) {
        var name, payload, regions, xhr;

        // Check that something changed
        regions = ev.detail().regions;
        if (Object.keys(regions).length == 0) {
            return;
        }

        // Set the editor as busy while we save our changes
        // this.busy(true);


        // Collect the contents of each region into a FormData instance
        payload = new FormData();
        for (name in regions) {
            if (regions.hasOwnProperty(name)) {
                payload.append(name, regions[name]);
            }
        }
        var explode = name.split("-");
        var region = "main-content-" + explode[2];
        var task_id = explode[2];
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/workspace/saveShortTermPlannerTaskDescription",
            data: {'task_id': task_id, "description" :regions[region]},
            success: function (data) {

            }
        });
        //
        // xhr = new XMLHttpRequest();
        // xhr.addEventListener('readystatechange', onStateChange);
        // xhr.open('POST', '/workspace/saveShortTermPlannerTaskDescription');
        // xhr.send(payload);
    });
    // Add support for auto-save
    editor.addEventListener('start', function (ev) {
        var _this = this;

        // Call save every 30 seconds
        function autoSave() {
            _this.save(true);
        };
        this.autoSaveTimer = setInterval(autoSave, 1000);
    });

    editor.addEventListener('stop', function (ev) {
        // Stop the autosave
        clearInterval(this.autoSaveTimer);
    });

});
