<div id="folderCollapse-<?= $folderId?>" class="collaps collapse-<?= $folderId?>">
    <? foreach($tasks as $task) { ?>
        <div class="col-sm-12 m-b-10 plannerTask  d-flex task-<?= $task->id?>" data-task-id="<?= $task->id?>" id="singleTask-<?= $task->id?>">
            <div class="o-hidden wp-no-wrap m-l-20" style="text-overflow: ellipsis; max-width: 130px;">
                <span class="c-black"><?= \App\Services\CustomIconService::getIcon("file-outline", '20px')?><?= $task->title?></span>
            </div>
            <span><? if(\App\TeamProjectTask::PRIVATE_TASK == $task->type) { ?> <i class="zmdi zmdi-lock-outline m-l-10" style="color: rgba(255,97,0, 0.5); margin-top: 3px;"></i> <? } ?></span>
        </div>
    <? } ?>
</div>