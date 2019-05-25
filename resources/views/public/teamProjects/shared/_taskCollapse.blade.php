<div id="folderCollapse-<?= $folderId?>" class="collaps collapse-<?= $folderId?>">
    <? foreach($tasks as $task) { ?>
        <div class="col-sm-12 m-b-10 plannerTask task-<?= $task->id?>" data-task-id="<?= $task->id?>">
            <p class="m-b-5 m-l-15 c-pointer"><?= \App\Services\CustomIconService::getIcon("file-outline", '20px')?><span class="m-l-5"><?= $task->title?></span></p>
        </div>
    <? } ?>
</div>