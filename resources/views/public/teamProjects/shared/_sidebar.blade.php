<div class="sidebar p-t-15" style="height: 125vh;">
    <input type="hidden" id="selectedFolder" value="<?= \Illuminate\Support\Facades\Session::get("folder_id")?>">
    <? if(\Illuminate\Support\Facades\Session::has("team_id")) { ?>
        <? $team = \App\Team::select("*")->where("id", \Illuminate\Support\Facades\Session::get("team_id"))->first()?>
        <div class="d-flex c-pointer">
            <div class="avatar-header img m-t-0 p-t-0 m-l-10" style="background: url('<?= $team->getProfilePicture()?>');"></div>
            <div class="o-hidden wp-no-wrap m-t-5 m-l-5" style="text-overflow: ellipsis; max-width: 150px;">
                <span class="bold f-19"><?= $team->team_name?></span>
            </div>
            <i class="zmdi zmdi-chevron-down f-25 c-black m-l-10 m-t-6"></i>
        </div>
        <div class="AddTaskDiv addTask c-pointer" data-task-category="public">
            <span class="cta-circle" style="margin-left: 19px;"><i class="zmdi zmdi-plus p-l-5 p-r-5 m-t-15"></i></span>
            <span class="f-14 m-l-5">New task</span>
        </div>
        <div class="AddFolderDiv addNewFolder c-pointer">
            <span class="cta-circle" style="margin-left: 19px;"><i class="zmdi zmdi-plus p-l-5 p-r-5 m-t-10 m-b-20"></i></span>
            <span class="f-14 m-l-5">New folder</span>
        </div>
    <? } ?>
    <div class="foldersAndTasks">

    </div>
</div>