<div class="p-l-20 m-t-5">
<p class="heavy f-21">Your improvement points</p>
    <ul class="checkboxlist">
        <? foreach($taskData->validations as $validationItem) { ?>
        <li class="liCheck liCheckImprovementPoint <? if($validationItem->validation->checked == 1) echo "checkedCheckbox"?> d-flex" data-id="<?= $validationItem->validation->id?>" data-task-id="<?= $validationItem->task->id?>">
            <div class="d-flex m-t-7">
                <div class="avatar-sm img p-t-0 m-l-10 m-r-5 border-none" style="background: url('<?= $validationItem->userPF?>')"></div>
                <span class="bold m-r-5 f-14 m-t-2"><?= $validationItem->user->firstname?>:</span>
                <span class="f-14 m-t-2 c-auto"><?= $validationItem->validation->feedback_description?></span>
            </div>
        </li>
        <? } ?>
    </ul>
    </div>
</div>
