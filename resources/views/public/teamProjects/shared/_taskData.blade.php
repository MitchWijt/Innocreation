<link rel="stylesheet" href="/css/selects/custom-select-clean.css">
<div class="row col-sm-12">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-3">
                <i class="zmdi zmdi-folder-outline c-black f-25 m-r-10"></i><?= $taskData->folder->title?>
            </div>
            <div class="col-sm-3 p-relative toggleAssignMemberDropdown">
                <div class="toggleAssignMemberDropdown no-select c-pointer">
                    <i class="zmdi zmdi-account-o c-black f-25 m-r-10 toggleAssignMemberDropdown no-select"></i><span class="thin toggleAssignMemberDropdown no-select">Assign to member</span>
                </div>
                <div class="assignMemberBox p-absolute bcg-grey hidden" style="max-width: 200px; border-radius: 5px;">
                    <? foreach($team->getMembers() as $member) { ?>
                        <div class="d-flex p-t-10 p-r-10 p-l-10" data-member-id="<?= $member->id?>">
                            <div class="avatar-header img m-b-10 p-t-0 m-r-10" style="background: url('<?= $member->getProfilePicture()?>')"></div>
                            <p class="m-t-6"><?= $member->getName()?></p>
                        </div>
                    <? } ?>
                </div>
            </div>
            <div class="col-sm-3">
                <i class="zmdi zmdi-time c-black f-25 m-r-10"></i><span class="thin">Add due date</span>
            </div>
            <div class="col-sm-3">
                <div class="d-flex">
                    <div>
                        <?= \App\Services\CustomIconService::getIcon("tag-outline")?>
                    </div>
                    <input type="text" class="input-transparant c-black m-l-5" placeholder="Add label...">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row m-t-20 col-sm-12">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-6">
                <div class="row d-flex">
                    <div class="custom-select col-sm-3 font p-b-0 m-t-5">
                        <select name="fontStyle" class="fontStyle">
                            <? foreach(\App\Services\TeamProject\TaskEditorService::getFontStyles() as $fontStyle) { ?>
                            <option value="<?= $fontStyle?>"><?= $fontStyle?></option>
                            <? } ?>
                        </select>
                    </div>
                    <div class="custom-select col-sm-2 fontSize p-b-0 m-t-5">
                        <select name="fontSize" class="fontSize">
                            <? foreach(\App\Services\TeamProject\TaskEditorService::getFontSizes() as $fontSize) { ?>
                                <option value="<?= $fontSize?>"><?= $fontSize?></option>
                            <? } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4 d-flex m-t-20">
                        <button class="no-button-style"><i class="zmdi zmdi-format-bold f-14 m-r-10 c-pointer boldText" style="color: black"></i></button>
                        <button class="no-button-style"><i class="zmdi zmdi-format-italic f-14 m-r-10 c-pointer" style="color: black"></i></button>
                        <button class="no-button-style"><i class="zmdi zmdi-format-underlined f-14 c-pointer" style="color: black"></i></button>
                    </div>
                    <div class="col-sm-4 d-flex m-t-20">
                        <button class="no-button-style"><i class="zmdi zmdi-format-color-text f-14 m-r-10 c-pointer" style="color: black"></i></button>
                        <button class="no-button-style"><i class="zmdi zmdi-code f-14 c-pointer" style="color: black"></i></button>
                    </div>
                    <div class="col-sm-4 d-flex m-t-15">
                        <button class="no-button-style"><span><i class="zmdi zmdi-format-list-bulleted f-14 m-r-10 c-pointer c-black" style="margin-top: 2px;"></i></span></button>
                        <button class="no-button-style"><span><i class="zmdi zmdi-format-list-numbered f-14 c-pointer c-black" style="margin-top: 2px; margin-right: 6px;"></i></span></button>
                        <button class="no-button-style"><i class="c-black"><?= \App\Services\CustomIconService::getIcon("checkbox-list", "18px");?></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="col-sm-12 m-t-5 p-r-0">
    <div contenteditable="true" class="input-transparant titleTask c-black f-40 bold" data-task-id="<?= $taskData->task->id?>"><?= $taskData->task->title?></div>
    <div contenteditable="true" class="col-sm-12 taskContentEditor m-l-0 p-l-0 m-t-10 no-focus p-r-0" data-task-id="<?= $taskData->task->id?>">
        <?= $taskData->task->content?>
    </div>
</div>

<script defer async src="/js/assets/customSelect.js"></script>
<?//= dd($taskData)?>