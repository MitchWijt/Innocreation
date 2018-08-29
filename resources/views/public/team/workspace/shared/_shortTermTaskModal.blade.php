
<div class="shortTermTaskModalContainer">
    <div class="modal-header d-flex js-center">
        <div class="d-flex fd-column">
            <? if($shortPlannerTask->completed == 0) { ?>
                <h4 class="modal-title" id="modalLabel"> <i class="zmdi zmdi-check circle circleSmall border-inno-black f-18 text-center completeShortTermTask" data-short-planner-task-id="<?= $shortPlannerTask->id?>"></i><?= $shortPlannerTask->title?> <i class="zmdi zmdi-chevron-down toggleTaskDelete" ></i></h4>
            <? } else { ?>
                <h4 class="modal-title" id="modalLabel"> <i class="zmdi zmdi-check circle circleSmall border-inno-black f-18 text-center completeShortTermTask bcg-orange" data-short-planner-task-id="<?= $shortPlannerTask->id?>"></i><?= $shortPlannerTask->title?> <i class="zmdi zmdi-chevron-down toggleTaskDelete" ></i></h4>
            <? } ?>
            <a class="regular-link td-none"><p class="border-default text-center f-13 btn-inno btn-small m-b-5 hidden deleteShortTermTask m-t-5" data-short-planner-task-id="<?= $shortPlannerTask->id?>">Delete</p></a>
        </div>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" class="taskModalCheck" value="1">
            <div class="col-sm-7 @mobile d-flex js-center @endmobile">
                <? if($shortPlannerTask->assigned_to != null) { ?>
                    <div class="d-flex fd-row">
                        <div class="assignMember m-t-10">
                            <? if($shortPlannerTask->assignedUser) { ?>
                            <img class="circle circleSmall assignTaskToMemberToggle" data-short-planner-task-id="<?= $shortPlannerTask->id?>" src="<?= $shortPlannerTask->assignedUser->getProfilePicture()?>" alt="<?=$shortPlannerTask->assignedUser->getName()?>">
                            <? } else { ?>
                            <div class="text-center">
                                <div class="circle circleSmall assignTaskToMemberToggle" data-short-planner-task-id="<?= $shortPlannerTask->id?>"><i class="zmdi zmdi-eye-off "></i></div>
                            </div>
                            <? } ?>
                            <div class="hasImage hidden">
                                <div class="circle circleSmall placeholderMemberAssign assignTaskToMemberToggle border-inno-black" data-short-planner-task-id="<?= $shortPlannerTask->id?>">
                                    <div class="text-center memberAssignPlaceholder">
                                        <i class="zmdi zmdi-account memberAssignIcon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <select name="assignMembers" class="input m-t-10 assignTaskToMember">
                            <option value="" selected disabled>Choose member</option>
                            <? foreach($team->getMembers() as $member) { ?>
                            <option value="<?= $member->id?>" data-short-planner-task-id="<?= $shortPlannerTask->id?>"><?= $member->getName()?></option>
                            <? } ?>
                            <option value="nobody" data-short-planner-task-id="<?= $shortPlannerTask->id?>">Unassign</option>
                        </select>
                    </div>
                <? } else { ?>
                    <div class="d-flex fd-row">
                        <div class="assignMember m-t-10">
                            <div class="circle circleSmall placeholderMemberAssign assignTaskToMemberToggle border-inno-black" data-short-planner-task-id="<?= $shortPlannerTask->id?>">
                                <div class="text-center memberAssignPlaceholder">
                                    <i class="zmdi zmdi-account memberAssignIcon"></i>
                                </div>
                            </div>
                        </div>
                        <select name="assignMembers" class="input m-t-10 assignTaskToMember">
                            <option value="" selected disabled>Choose member</option>
                            <? foreach($team->getMembers() as $member) { ?>
                            <option value="<?= $member->id?>" data-short-planner-task-id="<?= $shortPlannerTask->id?>"><?= $member->getName()?></option>
                            <? } ?>
                            <option value="nobody" data-short-planner-task-id="<?= $shortPlannerTask->id?>">Unassign</option>
                        </select>
                    </div>
                <? } ?>
            </div>
            <div class="col-sm-5 m-t-10">
                <div class="row">
                    <div class="col-sm-5 p-r-0 @mobile text-center @endmobile">
                        <p class="m-b-0 @notmobile pull-right @endnotmobile">Priority:</p>
                    </div>
                    <div class="col-sm-7 @mobile text-center @endmobile">
                        <input type="hidden" value="<?= $shortPlannerTask->id?>" class="short-planner-task-id">
                        <select name="shortTermTaskPriority" class="setShortTermTaskPriority input @notmobile pull-right @endnotmobile">
                            <option value="default" selected disabled>Select priority</option>
                            <option value="1" <? if($shortPlannerTask->priority == 1) echo "selected"?>>High</option>
                            <option value="2" <? if($shortPlannerTask->priority == 2) echo "selected"?>>Medium</option>
                            <option value="3" <? if($shortPlannerTask->priority == 3) echo "selected"?>>Low</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="@desktop m-l-50 col-sm-3 @elsemobile row text-center @enddesktop">
            <div class="@desktop d-flex fd-column m-t-5 @elsemobile m-t-5 col-sm-12 @enddesktop">
                <? if($shortPlannerTask->due_date != null) { ?>
                    <div class="d-flex fd-row dueDateHover @mobile d-flex js-center @endmobile">
                        <? if(strtotime(date("Y-m-d")) >= strtotime(date("Y-m-d", strtotime($shortPlannerTask->due_date)))) { ?>
                            <p class="c-red f-13 m-b-0 m-t-5 dueDate underline c-pointer" data-short-planner-task-id="<?= $shortPlannerTask->id?>"><?= date("d F Y", strtotime($shortPlannerTask->due_date))?></p>
                        <? } else { ?>
                            <p class="c-orange f-13 m-b-0 m-t-5 dueDate underline c-pointer" data-short-planner-task-id="<?= $shortPlannerTask->id?>"><?= date("d F Y", strtotime($shortPlannerTask->due_date))?></p>
                        <? } ?>
                        <i class="zmdi zmdi-close hidden removeDueDate m-t-6 m-l-10 c-pointer" data-short-planner-task-id="<?= $shortPlannerTask->id?>"></i>
                    </div>
                <? } else { ?>
                    <div class="d-flex fd-row dueDateHover">
                        <p class="c-orange f-13 m-b-0 m-t-5 dueDate underline c-pointer" data-short-planner-task-id="<?= $shortPlannerTask->id?>"><i class="zmdi zmdi-plus m-r-5"></i>Set due date</p>
                    </div>
                <? } ?>
                <input type="text" class="datepicker input-transparant c-transparant col-sm-1" data-short-planner-task-id="<?= $shortPlannerTask->id?>">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 m-t-10">
                <div class="customTextarea">
                    <span class="clicked hidden"></span>
                    <div data-editable data-name="main-content-<?= $shortPlannerTask->id?>" class="editorPlanner" style="padding: 5px">
                        <? if($shortPlannerTask->description != null) { ?>
                            <?= htmlspecialchars_decode($shortPlannerTask->description)?>
                        <? } else { ?>
                            <p class="shortTermPlannertextarea" contenteditable><span></span></p>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>