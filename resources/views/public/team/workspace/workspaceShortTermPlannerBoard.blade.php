@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background">
        @include("includes.workspace_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black"><?= $shortTermPlannerBoard->title?><i class="zmdi zmdi-chevron-down f-20 m-l-10 toggleBoardRename"></i></h1>
            </div>
            <div class="row">
                <div class="col-sm-12 d-flex js-center ">
                    <div class="col-sm-2">
                        <p class="border-default text-center f-13 renameShortTermPlannerBoard btn-inno hidden">Rename board</p>
                    </div>
                </div>
            </div>
            <hr class="m-b-10">
            <div class="col-sm-3">
                <button class="btn btn-inno m-b-20 toggleTaskmenu">All tasks/ideas</button>
            </div>
            <div class="d-flex js-between">
                <div class="col-sm-3 taskMenu hidden">
                    <div class="border-default m-b-20">
                       <div class="d-flex fd-column p-20">
                           <button class="btn btn-inno m-b-5">Bucketlist goals</button>
                           <button class="btn btn-inno m-b-5">Passed ideas</button>
                           <button class="btn btn-inno m-b-5">Custom planner tasks</button>
                       </div>
                        <hr>
                        <div class="p-20 o-scroll" style="max-height: 500px;">
                            <? foreach($uncompletedBucketlistGoals as $uncompletedBucketlistGoal) { ?>
                                <div class="m-b-10 shortTermTask" id="drag-<?=$uncompletedBucketlistGoal->id?>" draggable="true" ondragstart="drag(event)" ondrop="return false" ondragover="return false">
                                    <div class="card card-task col-sm-12 " data-short-planner-task-id="<?= $uncompletedBucketlistGoal->id?>">
                                        <div class="card-block" style="min-height: 100%">
                                            <p class="m-t-10 f-19"><?= $uncompletedBucketlistGoal->title?></p>
                                            <div class="d-flex js-between">
                                                <div class="assignMember">
                                                    <div class="circle circleSmall placeholderMemberAssign assignTaskToMemberToggle" data-short-planner-task-id="<?= $uncompletedBucketlistGoal->id?>">
                                                        <div class="text-center memberAssignPlaceholder">
                                                            <i class="zmdi zmdi-account memberAssignIcon"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex fd-row dueDateHover">
                                                    <p class="c-orange f-13 m-b-0 m-t-5 dueDate underline c-pointer" data-short-planner-task-id="<?= $uncompletedBucketlistGoal->id?>"><i class="zmdi zmdi-plus m-r-5"></i>Set due date</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <input type="text" class="datepicker input-transparant pull-right c-transparant col-sm-5" data-short-planner-task-id="<?= $uncompletedBucketlistGoal->id?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                </div>
                <? if($shortTermPlannerBoard->short_term_planner_type == 1) { ?>
                    <?
                        $dayTimes = [];
                        for($i = 1; $i < 13; $i++) {
                            array_push($dayTimes, $i . ":00AM");
                        }
                        for($i = 1; $i < 13; $i++) {
                            array_push($dayTimes, $i . ":00PM");
                        }
                    ?>
                    <div class="card card-task col-sm-12 m-b-10 emptyCard hidden">
                        <div class="card-block">
                            <input type="text" class="input-transparant m-t-10 shortTermTaskTitleInput" data-creator-user-id="<?= $user->id?>" data-board-id="<?=$shortTermPlannerBoard->id?>">
                            <input type="hidden" name="category" class="categoryTask" value="">
                            <p class="m-t-10 f-19 shortTermPlannerTaskTitle"></p>
                        </div>
                    </div>
                    <div class="d-flex fd-row x-scroll p-b-20">
                        <? foreach($dayTimes as $dayTime) { ?>
                            <div class="col-sm-3">
                                <p class="f-19 text-center"><?=$dayTime?></p>
                                <div class="text-center">
                                    <i class="zmdi zmdi-plus f-25 addShortTermTask" data-day-time="<?=$dayTime?>"></i>
                                </div>
                                <div class="shortTermtasksColumn" data-day-time="<?=$dayTime?>">
                                    <div id="div" ondrop="drop(event, this, $(this).parents('.shortTermtasksColumn').data('day-time'))"  ondragover="allowDrop(event)" class="p-b-100">
                                        <? foreach($shortTermPlannerTasks as $shortPlannerTask) { ?>
                                            <? if($shortPlannerTask->category == $dayTime) { ?>
                                                <div class="m-b-10 shortTermTask" id="drag-<?=$shortPlannerTask->id?>" draggable="true" ondragstart="drag(event)" ondrop="return false" ondragover="return false">
                                                    <div class="card card-task col-sm-12 " data-short-planner-task-id="<?= $shortPlannerTask->id?>">
                                                        <div class="card-block" style="min-height: 100%">
                                                            <p class="m-t-10 f-19"><?= $shortPlannerTask->title?></p>
                                                            <div class="d-flex js-between">
                                                                <? if($shortPlannerTask->assigned_to != null) { ?>
                                                                    <img class="circle circleSmall assignTaskToMemberToggle" data-short-planner-task-id="<?= $shortPlannerTask->id?>" src="<?= $shortPlannerTask->assignedUser->getProfilePicture()?>" alt="<?=$shortPlannerTask->assignedUser->getName()?>">
                                                                <? } else { ?>
                                                                    <div class="assignMember">
                                                                        <div class="circle circleSmall placeholderMemberAssign assignTaskToMemberToggle" data-short-planner-task-id="<?= $shortPlannerTask->id?>">
                                                                            <div class="text-center memberAssignPlaceholder">
                                                                                <i class="zmdi zmdi-account memberAssignIcon"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <? } ?>
                                                                <? if($shortPlannerTask->due_date != "1970-01-01 00:00:00") { ?>
                                                                    <div class="d-flex fd-row dueDateHover">
                                                                        <p class="c-orange f-13 m-b-0 m-t-5 dueDate underline c-pointer" data-short-planner-task-id="<?= $shortPlannerTask->id?>"><?= date("d F Y", strtotime($shortPlannerTask->due_date))?></p>
                                                                        <i class="zmdi zmdi-close hidden removeDueDate m-t-6 m-l-10 c-pointer" data-short-planner-task-id="<?= $shortPlannerTask->id?>"></i>
                                                                    </div>
                                                                <? } else { ?>
                                                                    <div class="d-flex fd-row dueDateHover">
                                                                        <p class="c-orange f-13 m-b-0 m-t-5 dueDate underline c-pointer" data-short-planner-task-id="<?= $shortPlannerTask->id?>"><i class="zmdi zmdi-plus m-r-5"></i>Set due date</p>
                                                                    </div>
                                                                <? } ?>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <input type="text" class="datepicker input-transparant pull-right c-transparant col-sm-5" data-short-planner-task-id="<?= $shortPlannerTask->id?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="collapse collapseExample" >
                                                        <div class="card card-task col-sm-12 m-b-10 p-0">
                                                            <div class="card-block">
                                                                <span class="m-l-10 m-t-10">Assign this task to: <br></span>
                                                                <hr>
                                                                <div class="text-center">
                                                                    <select name="assignMembers" class="input col-sm-11 m-t-10 assignTaskToMember">
                                                                        <? foreach($team->getMembers() as $member) { ?>
                                                                            <option value="<?= $member->id?>" data-short-planner-task-id="<?= $shortPlannerTask->id?>"><?= $member->getName()?></option>
                                                                        <? } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <? } ?>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/workspace/workspaceShortTermPlannerBoard.js"></script>
@endsection