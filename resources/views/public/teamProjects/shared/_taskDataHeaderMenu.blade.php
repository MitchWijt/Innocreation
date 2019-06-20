<div class="row col-sm-12">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-3 p-relative">
                <div class="changeFolderBtn c-pointer">
                    <i class="zmdi zmdi-folder-outline c-black f-25 m-r-10 c-pointer"></i><span id="folderTitle"><?= $taskData->folder->title?></span>
                </div>
                <div class="folderList p-absolute contextMenu hidden" style="max-width: 200px; z-index: 200;">
                    <? foreach($teamProject->getFolders() as $folder) { ?>
                        <div class="d-flex p-t-10 p-r-10 p-l-10 dark-hover transition c-pointer assignNewFolder <? if($folder->id == $taskData->folder->id) echo "active-item"?>" data-new-folder-id="<?= $folder->id?>" data-task-id="<?= $taskData->task->id?>">
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
        <div class="input-group mb-3 no-focus h-20" style="width: 15vw;">
            <div class="input-group-prepend no-focus">
                <span class="input-group-text no-focus c-pointer h-20" id="basic-addon1"><i class="zmdi zmdi-search f-15 "></i></span>
            </div>
            <input style="outline: none !important; -webkit-appearance:none !important; width: 5vw !important; height: 20px;" type="search" id="searchBar" class="form-control form-control-inno input-grey" placeholder="Search tasks..." aria-label="Tasks" aria-describedby="basic-addon1">
        </div>
    </div>
</div>