<link rel="stylesheet" href="/css/selects/custom-select-clean.css">
<link rel="stylesheet" href="/assets/datepicker/datepicker.min.css">
<input type="hidden" id="taskId" value="<?= $taskData->task->id?>">
<input type="hidden" id="folderId" name="currentFolderId" value="<?= $taskData->folder->id?>">
<input type="hidden" id="showCompleteInfo" value="<?= $user->notification_task_completed?>">
<input type="hidden" id="userId" value="<?= $user->id?>">
<input type="hidden" id="assignedUserId" value="<? if(isset($taskData->task->assigned_user_id)) echo $taskData->task->assigned_user_id; else echo 0?>">
<?

    if(\App\Services\TeamProject\TaskEditorService::isDisabled($taskData->task->id)) {
        echo view("/public/teamProjects/shared/_taskDataHeaderMenuDisabled", compact("taskData", "teamProject", "team"));
    } else {
        echo view("/public/teamProjects/shared/_taskDataHeaderMenu", compact("taskData", "teamProject", "team"));
    }

 ?>
<? if($taskData->task->validation_needed == null) { ?>
    <? if(!\App\Services\TeamProject\TaskEditorService::isDisabled($taskData->task->id)) { ?>
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
            <div class="col-sm-4 p-0 ">
                <div class="d-flex jc-end">
                    <button class="btn-inno-cta m-b-5 validateTask">Task completed <i class="zmdi zmdi-check"></i> </button>
                </div>
                <p class="f-10 c-red text-right hidden complete-error">Please assign a member before completing.</p>
            </div>
        </div>
    <? } ?>
<? } else { ?>
    {{--CREATE SHARED VIEWS AND FUNCTIONS OF ALL OF THIS--}}
    <div class="m-l-15 m-t-20">
        <? if($taskData->task->assigned_user_id != \Illuminate\Support\Facades\Session::get("user_id")) { ?>
            <? if(\App\Services\TeamProject\TeamProjectTaskValidationService::hasReviewed($taskData->task->id)) { ?>
                <p class="m-b-0 f-12">You have already reviewed this task. Your answer was: <span class="bold c-orange"><?=  \App\Services\TeamProject\TypeOfTaskReview::getTitle(\App\Services\TeamProject\TeamProjectTaskValidationService::getSingleReview($taskData->task->id)->type_review)?></span></p>
                <p class="f-15 m-t-5 "><?= \App\Services\TeamProject\TeamProjectTaskValidationService::getRespondedReviewPercentage(count($team->getMembers()), $taskData->task->id)?> of all members have reviewed the task</p>
        <? } else { ?>
                <p class="m-b-0 f-12">This task has been tagged as completed. You and your team members need to review the task before it will be pushed to completed</p>
                <p class="f-12">You and other are not able to edit the task at this stage. Only review and download the attached files.</p>
                <div class="d-flex">
                    <form action="/teamProject/savePassedTask" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="task_id" value="<?= $taskData->task->id?>">
                        <input type="hidden" name="project_id" value="<?= $teamProject->id?>">
                        <div class="d-flex fd-column m-r-20">
                            <button class="btn-inno-success c-pointer f-15 p-t-5 p-b-5 p-l-10 p-r-10" type="submit" style="">Passed all criteria <?= str_replace("U+", "&#x", "U+1F44C")?></button>
                            <span class="thin f-12 text-center"><?= \App\Services\TeamProject\TeamProjectTaskValidationService::getPercentagePassed($taskData->task->id)?> has responded this</span>
                        </div>
                    </form>

                    <div class="d-flex fd-column">
                        <button class="btn-inno-cta c-black c-pointer no-focus f-15 p-t-5 p-b-5 p-l-10 p-r-10" data-toggle="modal" data-target="#taskReviewImprovement">Improvements needed <?= str_replace("U+", "&#x", "U+1F612")?></button>
                        <span class="thin f-12 text-center"><?= \App\Services\TeamProject\TeamProjectTaskValidationService::getPercentageImprove($taskData->task->id)?> has responded this</span>
                    </div>
                </div>
            <? } ?>
        <? } else { ?>
            <p class="m-b-0 f-12">This task has been tagged as completed. Your team members need to review the task before it will be pushed to completed</p>
            <p class="f-12 m-b-0">You are not able to edit the task at this stage.</p>
            <p class="f-15 m-t-5 "><?= \App\Services\TeamProject\TeamProjectTaskValidationService::getRespondedReviewPercentage(count($team->getMembers()), $taskData->task->id)?> of all members have reviewed the task</p>
        <? } ?>
    </div>
<? } ?>
<hr>
<div class="col-sm-12 m-t-5 p-r-0">
    <? if($taskData->task->validation_needed != null || $taskData->task->completed != null) { ?>
        <div class="overlay-disabled"></div>
    <? } ?>
    <div contenteditable="true" class="input-transparant titleTask c-black f-40 bold" data-task-id="<?= $taskData->task->id?>"><?= $taskData->task->title?></div>
    <div contenteditable="true" style="height: 100vh;" id="editable" class="col-sm-12 taskContentEditor m-l-0 p-l-0 m-t-10 no-focus p-r-0" data-task-id="<?= $taskData->task->id?>">
        <?= $taskData->task->content?>
    </div>
</div>

<div class="modal fade fade-scale taskReviewImprovement" id="taskReviewImprovement" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered-custom" style="min-width: 1000px !important" role="document">
        <div class="modal-content">
            <div class="modal-body ">
                <p class="f-18 bold">Explain as clear as possible which part of the task needs improvement</p>
                <form action="/teamProject/saveImprovementTask" method="post">
                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                    <input type="hidden" name="task_id" value="<?= $taskData->task->id?>">
                    <input type="hidden" name="project_id" value="<?= $teamProject->id?>">
                    <div class="col-sm-12 p-l-0">
                        <textarea class="input btn-block no-focus-border" placeholder="Your improvement points" name="improvement_points" rows="5"></textarea>
                    </div>
                    <div class="col-sm-12 p-l-0 text-right m-t-10">
                        <button class="btn-inno-cta c-pointer" type="submit">Finish review <i class="zmdi zmdi-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fade-scale completedTaskInfo" id="completedTaskInfo" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-lg-custom o-hidden" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p class="bold f-21 m-b-20 text-center">Congrats on finishing your task!</p>
                <div class="text-center m-b-20">
                    <p class="f-15 m-b-15">But wait a minute your task has <span class="bold">not</span> been totally completed just yet. It has been put in the validation process. What does this mean?</p>
                    <p class="f-15 m-b-0">Every member in your team has gotten a notification to check your task if you have "passed all the criteria &#x1F44C;" or if the task still needs some "improvements &#x1F612;"</p>
                    <p class="f-15 m-b-10">All members need to approve that you passed all the criteria. After that your task will be 100% complete!</p>
                    <p class="f-15 m-b-0">If your task still needs some improvement, your task will be put back in the “my tasks” folder with the reviews of your members in the task. </p>
                    <p class="f-15">This way you will know what to improve</p>
                </div>
                <p class="f-25 bold text-center">Goodluck! &#x1F91D;</p>
                <div class="modalImage"></div>
                <div class="text-right f-12">
                    <input type="checkbox" id="doNotShowTaskInfo" class="input"><label for="doNotShowTaskInfo" class="thin m-l-5">Do not show again</label>
                </div>
            </div>
        </div>
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