<link rel="stylesheet" href="/css/selects/custom-select-clean.css">
<link rel="stylesheet" href="/assets/datepicker/datepicker.min.css">
<input type="hidden" id="taskId" value="<?= $taskData->task->id?>">
<input type="hidden" id="folderId" name="currentFolderId" value="<?= $taskData->folder->id?>">
<div class="row col-sm-12">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-3 p-relative">
                <div class="changeFolderBtn c-pointer">
                    <i class="zmdi zmdi-folder-outline c-black f-25 m-r-10 c-pointer"></i><span id="folderTitle"><?= $taskData->folder->title?></span>
                </div>
                <div class="folderList p-absolute contextMenu hidden" style="max-width: 200px; z-index: 200;">
                    <? foreach($teamProject->getFolders() as $folder) { ?>
                        <div class="d-flex p-t-10 p-r-10 p-l-10 dark-hover transition c-pointer assignNewFolder <? if($folder->id == $taskData->folder->id) echo "active"?>" data-new-folder-id="<?= $folder->id?>" data-task-id="<?= $taskData->task->id?>">
                            <i class="zmdi zmdi-folder-outline c-black f-25 m-r-10"></i>
                            <p class="m-t-6"><?= $folder->title?></p>
                        </div>
                    <? } ?>
                </div>
            </div>
            <div class="col-sm-3 p-relative toggleAssignMemberDropdown">
                <div class="d-flex toggleAssignMemberDropdown no-select c-pointer">
                    <? if($taskData->assigned_user == null) { ?>
                        <div>
                            <i class="zmdi zmdi-account-o c-black f-25 m-r-10 toggleAssignMemberDropdown no-select assignMemberIcon"></i>
                        </div>
                        <span class="thin toggleAssignMemberDropdown no-select assignMemberPlaceholder">Assign to member</span>
                    <? } ?>

                    <? if($taskData->assigned_user == null) { ?>
                        <div class="avatar-header avatar-assigner-user img m-b-10 p-t-0 m-r-10 hidden toggleAssignMemberDropdown"></div>
                        <p class="m-t-6 name-assigned-user hidden toggleAssignMemberDropdown"></p>
                    <? } else { ?>
                        <div class="avatar-header avatar-assigner-user img m-b-10 p-t-0 m-r-10 toggleAssignMemberDropdown c-pointer" style="background: url('<?= $taskData->assigned_user_profilepicture?>');"></div>
                        <p class="m-t-6 name-assigned-user toggleAssignMemberDropdown c-pointer"><?= $taskData->assigned_user->firstname . " " . $taskData->assigned_user->lastname?></p>
                    <? } ?>
                </div>
                <div class="assignMemberBox p-absolute contextMenu hidden" style="max-width: 200px; z-index: 100;">
                    <? foreach($team->getMembers() as $member) { ?>
                        <div class="d-flex p-t-10 p-r-10 p-l-10 dark-hover transition c-pointer assignUser" data-member-id="<?= $member->id?>" data-task-id="<?= $taskData->task->id?>">
                            <div class="avatar-header img m-b-10 p-t-0 m-r-10" style="background: url('<?= $member->getProfilePicture()?>')"></div>
                            <p class="m-t-6"><?= $member->getName()?></p>
                        </div>
                    <? } ?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="d-flex">
                    <i class="zmdi zmdi-time c-black f-25 m-r-10"></i>
                    <input type='text' placeholder="Add due date..."  class="datepicker-here datepickerClass input-transparant thin  no-cursor c-pointer" data-language='en' />
                    <span class="hidden due_date_val"><? if(isset($taskData->task->due_date)) echo date("d F Y", strtotime($taskData->task->due_date))?></span>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="d-flex">
                    <div>
                        <?= \App\Services\CustomIconService::getIcon("tag-outline")?>
                    </div>
                    <input type="text" placeholder="Add label..." class="input-transparant c-black m-l-5 labelsTask" name="labels" id="tokenfieldLabels" value=""/>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 d-flex jc-end">
        <div class="input-group mb-3 no-focus" style="width: 15vw; height: 20px;">
            <div class="input-group-prepend no-focus">
                <span class="input-group-text no-focus c-pointer" id="basic-addon1"><i class="zmdi zmdi-search f-15 "></i></span>
            </div>
            <input style="outline: none !important; -webkit-appearance:none !important; width: 5vw !important; height: 20px;" type="search" id="searchBar" class="form-control form-control-inno input-grey" placeholder="Search tasks..." aria-label="Tasks" aria-describedby="basic-addon1">
        </div>
    </div>
</div>
<div class="row col-sm-12 contentEditFunctions hidden">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-6">
                <div class="row d-flex">
                    <button class="no-button-style">
                        <div class="custom-select font p-b-0 m-t-5" data-type="fontStyle" data-task-id="<?= $taskData->task->id?>">
                            <select name="fontStyle" class="fontStyle">
                                <? foreach(\App\Services\TeamProject\TaskEditorService::getFontStyles() as $fontStyle) { ?>
                                    <option <? if($fontStyle == "Corbert-Regular") echo "selected"?> value="<?= $fontStyle?>"><?= $fontStyle?></option>
                                <? } ?>
                            </select>
                        </div>
                    </button>
                    <button class="no-button-style">
                        <div class="custom-select fontSize p-b-0 m-t-5" data-type="fontSize" data-task-id="<?= $taskData->task->id?>">
                            <select name="fontSize" class="fontSizeSelect">
                                <? foreach(\App\Services\TeamProject\TaskEditorService::getFontSizes() as $fontSize) { ?>
                                    <option <? if($fontSize == 14) echo "selected"?> value="<?= $fontSize?>"><?= $fontSize?></option>
                                <? } ?>
                            </select>
                        </div>
                    </button>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4 d-flex m-t-20">
                        <button class="no-button-style"><i class="zmdi zmdi-format-bold f-14 m-r-10 c-pointer textEditor boldText" data-task-id="<?= $taskData->task->id?>" data-detector="<b>" data-type="bold" style="color: black"></i></button>
                        <button class="no-button-style"><i class="zmdi zmdi-format-italic f-14 m-r-10 c-pointer textEditor italicText" data-task-id="<?= $taskData->task->id?>" data-detector="<i>" data-type="italic" style="color: black"></i></button>
                        <button class="no-button-style"><i class="zmdi zmdi-format-underlined f-14 c-pointer textEditor underlinedText" data-task-id="<?= $taskData->task->id?>" data-detector="<u>" data-type="underline" style="color: black"></i></button>
                    </div>
                    <div class="col-sm-4 d-flex m-t-20 p-relative">
                        <button class="no-button-style"><i class="zmdi zmdi-format-color-text f-14 m-r-10 c-pointer font-color-icon" style="color: black"></i></button>
                        <div id="color-picker-container" style="left: -35px; top: 20px; z-index: 900" class="p-absolute hidden colorpicker"></div>
                        <button class="no-button-style"><i class="zmdi zmdi-code f-14 c-pointer codeToggleIcon m-r-10" style="color: black"></i></button>
                        <i class="zmdi zmdi-mic-outline f-14 c-black m-r-10 c-pointer"></i>
                        <i class="zmdi zmdi-attachment-alt f-14 c-black m-r-10 c-pointer"></i>
                    </div>
                    <div class="col-sm-4 d-flex m-t-15">
                        <button class="no-button-style"><span><i class="zmdi zmdi-format-list-bulleted f-14 m-r-10 c-pointer textEditor" data-task-id="<?= $taskData->task->id?>" data-type="insertUnorderedList" style="margin-top: 2px;"></i></span></button>
                        <button class="no-button-style"><span><i class="zmdi zmdi-format-list-numbered f-14 c-pointer textEditor" data-task-id="<?= $taskData->task->id?>" data-type="insertOrderedList" style="margin-top: 2px; margin-right: 6px;"></i></span></button>
                        <button class="no-button-style"><i class="c-black" id="checkboxListToggle"><?= \App\Services\CustomIconService::getIcon("checkbox-list", "18px");?></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <? if($taskData->task->validation_needed == null) { ?>
        <div class="col-sm-4 p-0 d-flex jc-end">
            <button class="btn-inno-cta m-b-5 validateTask">Task completed <i class="zmdi zmdi-check"></i> </button>
        </div>
    <? } ?>
</div>
<hr>
<div class="col-sm-12 m-t-5 p-r-0">
    <div contenteditable="true" class="input-transparant titleTask c-black f-40 bold" data-task-id="<?= $taskData->task->id?>"><?= $taskData->task->title?></div>
    <div contenteditable="true" style="height: 100vh;" id="editable" class="col-sm-12 taskContentEditor m-l-0 p-l-0 m-t-10 no-focus p-r-0" data-task-id="<?= $taskData->task->id?>">
        <?= $taskData->task->content?>
    </div>
</div>
<script>

    $('#tokenfieldLabels')
        .on('tokenfield:createdtoken', function (e) {
            var tokens = $('#tokenfieldLabels').tokenfield('getTokensList');
            if(getExistingTokens().indexOf(tokens) < 0){
                saveLabels();
            }
        })
        .on('tokenfield:removedtoken', function (e) {
            saveLabels();
        })
        .tokenfield({
        autocomplete: {
            source: [
                <? foreach($allLabels as $label) { ?>
                    <?= "'" . $label ."'"?>,
                <? } ?>
            ],
            delay: 100
        },
        showAutocompleteOnFocus: true,
        createTokensOnBlur: true
    });

    $('#tokenfieldLabels').tokenfield('setTokens', '<?= $taskData->labels?>');

    function getExistingTokens(){
        var array = "";
        <? $allLabels = explode(", ", $taskData->labels)?>
        <? foreach($allLabels as $label){ ?>
            if(array == ""){
               array = '<?= $label?>';
            } else {
                array = array + ", " + '<?= $label?>';
            }
        <? } ?>

        return array;
    }
    function saveLabels(){
        var tokens = $('#tokenfieldLabels').tokenfield('getTokensList');
        var task_id = $("#taskId").val();
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/teamProject/editLabelsTask",
            data: {'tokens' : tokens, "taskId": task_id},
            success: function (data) {
            }
        });
    }

    var counter = 0;
    $('.datepickerClass').datepicker({
        language: 'en',
        minDate: new Date(), // Now can select only dates, which goes after today
        onSelect: function onSelect(fd, date) {
            counter++;
            if(counter == 1) {
                $(".datepickerClass").val("");
                var assignedDate = fd;
                var task_id = $("#taskId").val();
                $.ajax({
                    method: "POST",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');

                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    url: "/teamProject/addDueDate",
                    dataType: "JSON",
                    data: {'date': assignedDate, "taskId": task_id},
                    success: function (data) {
                        var day = data["day"];
                        var month = data['month'];
                        var year = data['year'];
                        var textDate = data['textDate'];
                        setDate(day, month, year);
                        $(".datepickerClass").val(textDate);
                    }
                });
            } else {
                counter = 0;
            }
        }
    });

    function setDate(day, month, year){
        var dp = $('.datepickerClass').datepicker().data('datepicker');
        dp.selectDate(new Date(year, month, day));
        return false;
    }

    $(document).ready(function () {
        setTimeout(function () {
            var date = $(".due_date_val").text();
            if(date != "01 January 1970"){
                var dp = $('.datepickerClass').datepicker().data('datepicker');
                dp.selectDate(new Date(date));
            }
        }, 500);

//        window.open("www.google.com", "myWindowName", "width=800, height=600");
    });


    //set set for datepicker. By example after the ajax call. :)




</script>

<script defer async src="/js/assets/customSelect.js"></script>
<script defer async src="/js/assets/colorpicker.js"></script>
<script src="/assets/datepicker/datepicker.min.js"></script>
<script src="/assets/datepicker/datepicker.en.js"></script>