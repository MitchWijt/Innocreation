<div class="p-absolute contextMenu task-click-menu f-14 hidden" style="max-width: 200px; z-index: 200;">
    <? foreach(\App\Services\TeamProject\TaskEditorService::getTaskContextmenuOptions($task) as $option) { ?>
        <div class="d-flex p-t-5 p-r-5 p-l-10 dark-hover transition c-pointer <? if($option['action'] == "form") echo "contextMenuAction"; else echo "copyLink"?>" data-task-id="<?= $task->id?>" <? if($option['action'] == "form") { ?> data-form-url="<?= $option['formUrl'] ?>" <? } else { ?> data-link="https://secret.innocreation.net/my-team/project/<?= $task->folder->teamProject->slug?>?th=<?= \App\Services\Encrypter::encrypt_decrypt('encrypt', $task->id)?>&fh=<?= \App\Services\Encrypter::encrypt_decrypt('encrypt', $task->team_project_folder_id)?>" <? } ?>>
            <p class="m-b-5"><?= $option['title']?></p>
        </div>
    <? } ?>
</div>