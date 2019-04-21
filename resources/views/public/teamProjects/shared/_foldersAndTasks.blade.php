<? foreach($foldersAndTasks as $folderAndTask) { ?>
    <div class="col-sm-12 m-t-10">
        <p class="m-b-5 collapseFolderButton c-pointer folder-<?= $folderAndTask->folder->id?>" data-id="<?= $folderAndTask->folder->id?>" data-toggle="collapse" data-target="#folderCollapse-<?= $folderAndTask->folder->id?>"><i class="zmdi zmdi-chevron-right f-20 c-black m-r-5"></i><i class="zmdi zmdi-folder-outline c-black f-25 m-r-5"></i><?= $folderAndTask->folder->title?></p>
        <div id="folderCollapse-<?= $folderAndTask->folder->id?>" class="collapse">
            <? foreach($folderAndTask->tasks as $task) { ?>
                <div class="col-sm-12 m-b-10 plannerTask task-<?= $task->id?>" data-task-id="<?= $task->id?>">
                    <p class="m-b-5 m-l-15 c-pointer"><?= \App\Services\CustomIconService::getIcon("file-outline", '20px')?><span class="m-l-5"><?= $task->title?></span></p>
                </div>
            <? } ?>
        </div>
    </div>
<? } ?>
