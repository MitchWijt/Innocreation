<div class="row col-sm-12">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-3 p-relative">
                <div class="changeFolderBtn">
                    <i class="zmdi zmdi-folder-outline c-black f-25 m-r-10"></i><span id="folderTitle" class="thin"><?= $taskData->folder->title?></span>
                </div>
            </div>
            <div class="col-sm-3 p-relative toggleAssignMemberDropdown">
                <div class="d-flex toggleAssignMemberDropdown no-select">
                    <div class="avatar-header avatar-assigner-user img m-b-10 p-t-0 m-r-10 toggleAssignMemberDropdown" style="background: url('<?= $taskData->assigned_user_profilepicture?>');"></div>
                    <p class="m-t-6 name-assigned-user toggleAssignMemberDropdown thin"><?= $taskData->assigned_user->firstname . " " . $taskData->assigned_user->lastname?></p>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="d-flex">
                    <i class="zmdi zmdi-time c-black f-25 m-r-10"></i>
                    <input type='text' disabled placeholder="No due date"  class="input-transparant thin  no-cursor" />
                    <span class="hidden due_date_val"><? if(isset($taskData->task->due_date)) echo date("d F Y", strtotime($taskData->task->due_date))?></span>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="d-flex">
                    <div>
                        <?= \App\Services\CustomIconService::getIcon("tag-outline")?>
                    </div>
                    <input type="text" placeholder="Add label..." class="input-transparant c-black m-l-5 " name="labels" id="tokenfieldLabels" disabled value=""/>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 d-flex jc-end">
        <div class="input-group mb-3 no-focus h-20" style="width: 15vw;">
            <div class="input-group-prepend no-focus">
                <span class="input-group-text no-focus h-20 c-pointer" id="basic-addon1"><i class="zmdi zmdi-search f-15 "></i></span>
            </div>
            <input style="outline: none !important; -webkit-appearance:none !important; width: 5vw !important; height: 20px;" type="search" id="searchBar" class="form-control form-control-inno input-grey" placeholder="Search tasks..." aria-label="Tasks" aria-describedby="basic-addon1">
        </div>
    </div>
</div>