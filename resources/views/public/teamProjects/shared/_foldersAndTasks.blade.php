<? foreach($foldersAndTasks as $folderAndTask) { ?>
    <div class="col-sm-12 m-t-10 p-0  singleFolder singleFolder-<?= $folderAndTask->folder->id?>">
        <div class="o-hidden wp-no-wrap" style="text-overflow: ellipsis; max-width: 150px;">
            <span class="m-b-5 collapseFolderButton m-l-15 c-pointer folder-<?= $folderAndTask->folder->id?>" id="<?= $folderAndTask->folder->id?>"><i class="zmdi zmdi-chevron-right f-20 c-black m-r-5"></i><i class="zmdi zmdi-folder-outline c-black f-25 m-r-5"></i><span class="folderTitle"><?= $folderAndTask->folder->title?></span></span>
        </div>
    </div>
<? } ?>
