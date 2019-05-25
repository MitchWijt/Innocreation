<? foreach($foldersAndTasks as $folderAndTask) { ?>
    <div class="col-sm-12 m-t-10 singleFolder singleFolder-<?= $folderAndTask->folder->id?>">
        <p class="m-b-5 collapseFolderButton c-pointer folder-<?= $folderAndTask->folder->id?>" id="<?= $folderAndTask->folder->id?>"><i class="zmdi zmdi-chevron-right f-20 c-black m-r-5"></i><i class="zmdi zmdi-folder-outline c-black f-25 m-r-5"></i><span class="folderTitle"><?= $folderAndTask->folder->title?></span></p>
    </div>
<? } ?>
