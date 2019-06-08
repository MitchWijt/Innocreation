<div id="folderCollapse-<?= $folderId?>" class="collaps collapse-<?= $folderId?>">
    <? foreach($tasks as $task) { ?>
        <div class="col-sm-12 m-b-10 plannerTask task-<?= $task->id?>" data-task-id="<?= $task->id?>">
            <p class="m-b-5 m-l-5 c-pointer"><?= \App\Services\CustomIconService::getIcon("file-outline", '20px')?><span class="m-l-5"><?= $task->title?></span> <? if(\App\TeamProjectTask::PRIVATE_TASK == $task->type) { ?> <i class="zmdi zmdi-lock-outline m-r-10" style="color: rgba(119,120,122, 0.5)"></i> <? } ?></p>
        </div>
    <? } ?>
</div>