<? foreach($foldersAndTasks as $folderAndTask) { ?>
    <div class="col-sm-12 m-t-10">
        <p class="m-b-5"><i class="zmdi zmdi-folder-outline c-black f-25 m-r-5"></i><?= $folderAndTask->folder->title?></p>
        <? foreach($folderAndTask->tasks as $task) { ?>
              <p class="m-b-5"><?= \App\Services\CustomIconService::getIcon("file-outline", '20px')?><?= $task->title?></p>
        <? } ?>
    </div>
<? } ?>
