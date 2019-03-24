@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.workspace_sidebar")
        @endnotmobile
        <div class="container">
            @mobile
                @include("includes.workspace_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <input type="text" class="renameShortTermPlannerBoardInput input f-19 hidden m-b-20" value="<?= $shortTermPlannerBoard->title?>" data-short-term-planner-board-id="<?= $shortTermPlannerBoard->id?>">
                <h1 class="sub-title-black shortTermPlannerBoardTitle"><?= $shortTermPlannerBoard->title?></h1><i class="zmdi zmdi-chevron-down f-20 m-l-10 m-t-15 toggleBoardRename"></i>
            </div>
            <div class="row">
                <div class="col-sm-12 d-flex js-center ">
                    <div class="col-sm-2">
                        <div class="boardMenu hidden">
                            <p class="border-default text-center f-13 renameShortTermPlannerBoard btn-inno m-b-5">Rename board</p>
                            <? foreach($allShortTermPlannerBoards as $allShortTermPlannerBoard) { ?>
                                <a class="regular-link td-none" href="<?= $allShortTermPlannerBoard->getUrl()?>"><p class="border-default text-center f-13 btn-inno m-b-5"><?= $allShortTermPlannerBoard->title?></p></a>
                            <? } ?>
                        </div>
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
                           <button class="btn btn-inno m-b-5 toggleBucketlistGoals">Bucketlist goals</button>
                           <button class="btn btn-inno m-b-5 togglePassedIdeas">Passed ideas</button>
                           <button class="btn btn-inno m-b-5">Completed tasks <br> (later)</button>
                       </div>
                        <hr>
                        <div class="p-20 o-scroll" style="max-height: 500px;">
                            <div class="uncompletedBucketlistGoals hidden">
                                <? foreach($uncompletedBucketlistGoals as $uncompletedBucketlistGoal) { ?>
                                    <div class="m-b-10 shortTermTask" id="drag-<?=$uncompletedBucketlistGoal->id?>-menuTask-<?= $shortTermPlannerBoard->id ?>-bucketlist" draggable="true" ondragstart="drag(event)" ondrop="return false" ondragover="return false" data-short-planner-task-id="">
                                        <div class="card card-task col-sm-12 menuTask" data-short-planner-task-id="" data-menu-task-id="<?=$uncompletedBucketlistGoal->id?>">
                                            <div class="card-block-new card-block" data-short-planner-task-id="" data-team-id="<?= $team->id?>" style="min-height: 100%">
                                                <p class="m-t-10 f-19 m-b-0"><?= $uncompletedBucketlistGoal->title?></p>
                                                <small class="priorityTask m-b-10 c-black" data-short-planner-task-id="">.</small>
                                                <div class="d-flex js-between">
                                                    <div class="assignMember hidden">
                                                        <div class="circle circleSmall placeholderMemberAssign assignTaskToMemberToggle" data-short-planner-task-id="">
                                                            <div class="text-center memberAssignPlaceholder">
                                                                <i class="zmdi zmdi-account memberAssignIcon"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <i class="zmdi zmdi-check c-orange border-inno-black f-18 text-center completeShortTermTaskCard hidden" data-short-planner-task-id=""></i>
                                                    <div class="d-flex fd-row dueDateHover">
                                                        <p class="c-orange f-13 m-b-0 m-t-5 dueDate underline c-pointer hidden" data-short-planner-task-id=""><i class="zmdi zmdi-plus m-r-5"></i>Set due date</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <input type="text" class="datepicker input-transparant pull-right c-transparant col-sm-5 hidden" data-short-planner-task-id="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse collapseExample" >
                                            <div class="card card-task col-sm-12 m-b-10 p-0">
                                                <div class="">
                                                    <span class="m-l-10 m-t-10">Assign this task to: <br></span>
                                                    <hr>
                                                    <div class="text-center">
                                                        <select name="assignMembers" class="input col-sm-11 m-t-10 assignTaskToMember">
                                                            <? foreach($team->getMembers() as $member) { ?>
                                                                <option value="<?= $member->id?>" data-short-planner-task-id=""><?= $member->getName()?></option>
                                                            <? } ?>
                                                            <option value="nobody" class="unassign" data-short-planner-task-id="">Unassign</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            </div>
                            <div class="passedIdeas hidden">
                                <? foreach($passedIdeas as $passedIdea) { ?>
                                    <div class="m-b-10 shortTermTask" id="drag-<?=$passedIdea->id?>-menuTask-<?= $shortTermPlannerBoard->id?>-idea" draggable="true" ondragstart="drag(event)" ondrop="return false" ondragover="return false" data-short-planner-task-id="">
                                        <div class="card card-task col-sm-12 menuTask" data-short-planner-task-id="" data-menu-task-id="<?=$passedIdea->id?>">
                                            <div class="card-block-new card-block" data-short-planner-task-id="" data-team-id="<?= $team->id?>" style="min-height: 100%">
                                                <p class="m-t-10 f-19 m-b-0"><?=$passedIdea->title?></p>
                                                <small class="priorityTask m-b-10 c-black" data-short-planner-task-id="">.</small>
                                                <div class="d-flex js-between">
                                                    <div class="assignMember hidden">
                                                        <div class="circle circleSmall placeholderMemberAssign assignTaskToMemberToggle" data-short-planner-task-id="">
                                                            <div class="text-center memberAssignPlaceholder">
                                                                <i class="zmdi zmdi-account memberAssignIcon"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <i class="zmdi zmdi-check c-orange border-inno-black f-18 text-center completeShortTermTaskCard hidden" data-short-planner-task-id=""></i>
                                                    <div class="d-flex fd-row dueDateHover">
                                                        <p class="c-orange f-13 m-b-0 m-t-5 dueDate underline c-pointer hidden" data-short-planner-task-id=""><i class="zmdi zmdi-plus m-r-5"></i>Set due date</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <input type="text" class="datepicker input-transparant pull-right c-transparant col-sm-5 hidden" data-short-planner-task-id="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse collapseExample" >
                                            <div class="card card-task col-sm-12 m-b-10 p-0">
                                                <div class="">
                                                    <span class="m-l-10 m-t-10">Assign this task to: <br></span>
                                                    <hr>
                                                    <div class="text-center">
                                                        <select name="assignMembers" class="input col-sm-11 m-t-10 assignTaskToMember">
                                                            <? foreach($team->getMembers() as $member) { ?>
                                                                <option value="<?= $member->id?>" data-short-planner-task-id=""><?= $member->getName()?></option>
                                                            <? } ?>
                                                            <option value="nobody" class="unassign" data-short-planner-task-id="">Unassign</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <? if($shortTermPlannerBoard->short_term_planner_type == 1) { ?>
                    <?
                        $shortTermPlannerCategories = [];
                        for($i = 1; $i < 13; $i++) {
                            array_push($shortTermPlannerCategories, $i . ":00AM");
                        }
                        for($i = 1; $i < 13; $i++) {
                            array_push($shortTermPlannerCategories, $i . ":00PM");
                        }
                    ?>
                <? } else if($shortTermPlannerBoard->short_term_planner_type == 2) { ?>
                     <?
                        $shortTermPlannerCategories = [];
                        $weekDays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                        for($i = 0; $i < 7; $i++) {
                            array_push($shortTermPlannerCategories, $weekDays[$i] );
                        }
                    ?>
                <? } else if($shortTermPlannerBoard->short_term_planner_type == 3) { ?>
                     <?
                        $shortTermPlannerCategories = [];
                        for($i = 1; $i < 5; $i++) {
                            array_push($shortTermPlannerCategories, "Week " . $i );
                        }
                    ?>
                <? } ?>
                <div class="m-b-10 shortTermTask emptyCard hidden" id="" draggable="true" ondragstart="drag(event)" ondrop="return false" ondragover="return false" data-short-planner-task-id="">
                    <div class="card card-task col-sm-12" data-short-planner-task-id="" >
                        <div class="card-block-new card-block" data-short-planner-task-id="" data-team-id="<?= $team->id?>" style="min-height: 100%">
                            <input type="text" class="input-transparant m-t-10 shortTermTaskTitleInput" data-creator-user-id="<?= $user->id?>" data-board-id="<?=$shortTermPlannerBoard->id?>">
                            <input type="hidden" name="category" class="categoryTask" value="">
                            <p class="m-t-10 f-19 shortTermPlannerTaskTitle m-b-0"></p>
                            <small class="priorityTask m-b-10 c-black" data-short-planner-task-id="">.</small>
                            <div class="d-flex js-between">
                                <div class="assignMember hidden">
                                    <div class="circle circleSmall placeholderMemberAssign assignTaskToMemberToggle" data-short-planner-task-id="">
                                        <div class="text-center memberAssignPlaceholder">
                                            <i class="zmdi zmdi-account memberAssignIcon"></i>
                                        </div>
                                    </div>
                                </div>
                                <i class="zmdi zmdi-check c-orange border-inno-black f-18 text-center completeShortTermTaskCard hidden" data-short-planner-task-id=""></i>
                                <div class="d-flex fd-row dueDateHover">
                                    <p class="c-orange f-13 m-b-0 m-t-5 dueDate underline c-pointer hidden" data-short-planner-task-id=""><i class="zmdi zmdi-plus m-r-5"></i>Set due date</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="text" class="input-transparant pull-right c-transparant col-sm-5 date hidden" data-short-planner-task-id="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collapse collapseExample" >
                        <div class="card card-task col-sm-12 m-b-10 p-0">
                            <div class="">
                                <span class="m-l-10 m-t-10">Assign this task to: <br></span>
                                <hr>
                                <div class="text-center">
                                    <select name="assignMembers" class="input col-sm-11 m-t-10 assignTaskToMember">
                                        <? foreach($team->getMembers() as $member) { ?>
                                        <option value="<?= $member->id?>" data-short-planner-task-id=""><?= $member->getName()?></option>
                                        <? } ?>
                                        <option value="nobody" class="unassign" data-short-planner-task-id="">Unassign</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex fd-row x-scroll p-b-20 board" onclick="void(0);">
                    <input type="hidden" name="urlParameter" class="urlParameter" value="<? if(isset($urlParameter)) echo $urlParameter?>">
                    <? foreach($shortTermPlannerCategories as $shortTermPlannerCategory) { ?>
                        <div class="col-sm-3 category @tablet min-248 m-l-5 m-r-5 @endtablet">
                            <p class="f-19 text-center"><?=$shortTermPlannerCategory?> <i class="zmdi zmdi-chevron-down toggleMenu"></i></p>
                            <div class="menuShortTermPlanner hidden text-center">
                                <a class="m-r-10 completeAllTasks btn btn-sm btn-inno c-gray" id="completeAllTasks-<?= $shortTermPlannerCategory?>" data-category="<?= $shortTermPlannerCategory?>">Complete all in column</a>
                            </div>
                            <div class="text-center">
                                <i class="zmdi zmdi-plus f-25 addShortTermTask" data-short-term-planner-category="<?=$shortTermPlannerCategory?>"></i>
                            </div>
                            <div class="shortTermtasksColumn" data-short-term-planner-category="<?=$shortTermPlannerCategory?>">
                                <div id="div"  style="padding-bottom: 400px!important">
                                    <? foreach($shortTermPlannerTasks as $shortPlannerTask) { ?>
                                        <? if($shortPlannerTask->category == $shortTermPlannerCategory) { ?>
                                            <div class="m-b-10 shortTermTask min-248" id="drag-<?=$shortPlannerTask->id?>" draggable="true" ondrag="dragging(event)" ondragstart="drag(event)" ondrop="return false" ondragover="return false" data-short-planner-task-id="<?= $shortPlannerTask->id?>">
                                                <div class="card card-task col-sm-12 " data-short-planner-task-id="<?= $shortPlannerTask->id?>" data-category="<?= $shortPlannerTask->category?>" data-completed="<? if($shortPlannerTask->completed == 1) echo 1; else echo 0?>">
                                                    <div class="card-block" style="min-height: 100%" data-short-planner-task-id="<?= $shortPlannerTask->id?>" data-team-id="<?= $team->id?>">
                                                        <p class="m-t-10 f-19 m-b-0"><?= $shortPlannerTask->title?></p>
                                                        <? if($shortPlannerTask->priority != null) { ?>
                                                            <? if($shortPlannerTask->priority == 1) { ?>
                                                                <small class="c-red priorityTask" data-short-planner-task-id="<?= $shortPlannerTask->id?>">High</small>
                                                            <? } else if($shortPlannerTask->priority == 2) { ?>
                                                                <small class="c-orange priorityTask" data-short-planner-task-id="<?= $shortPlannerTask->id?>">Medium</small>
                                                            <? } else if($shortPlannerTask->priority == 3) { ?>
                                                                <small class="c-green priorityTask" data-short-planner-task-id="<?= $shortPlannerTask->id?>">Low</small>
                                                            <? } ?>
                                                        <? } else { ?>
                                                            <small class="priorityTask m-b-10 c-black" data-short-planner-task-id="<?= $shortPlannerTask->id?>">.</small>
                                                        <? } ?>
                                                        <div class="d-flex js-between m-t-5">
                                                            <? if($shortPlannerTask->assigned_to != null) { ?>
                                                                <div class="assignMember">
                                                                    <? if($shortPlannerTask->assignedUser) { ?>
                                                                        <div class="avatar-sm assignTaskToMemberToggle img" data-short-planner-task-id="<?= $shortPlannerTask->id?>" style="background: url('<?= $shortPlannerTask->assignedUser->getProfilePicture()?>')"></div>
                                                                    <? } else { ?>
                                                                        <div class="text-center">
                                                                            <div class="circle circleSmall assignTaskToMemberToggle" data-short-planner-task-id="<?= $shortPlannerTask->id?>"><i class="zmdi zmdi-eye-off "></i></div>
                                                                        </div>
                                                                    <? } ?>
                                                                    <div class="hasImage hidden">
                                                                        <div class="circle circleSmall placeholderMemberAssign assignTaskToMemberToggle" data-short-planner-task-id="<?= $shortPlannerTask->id?>">
                                                                            <div class="text-center memberAssignPlaceholder">
                                                                                <i class="zmdi zmdi-account memberAssignIcon"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <? } else { ?>
                                                                <div class="assignMember">
                                                                    <div class="circle circleSmall placeholderMemberAssign assignTaskToMemberToggle" data-short-planner-task-id="<?= $shortPlannerTask->id?>">
                                                                        <div class="text-center memberAssignPlaceholder">
                                                                            <i class="zmdi zmdi-account memberAssignIcon"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <? } ?>
                                                            <i class="zmdi zmdi-check c-orange f-18 text-center completeShortTermTaskCard <? if($shortPlannerTask->completed != 1) echo "hidden"?>" data-short-planner-task-id="<?= $shortPlannerTask->id?>"></i>
                                                            <? if($shortPlannerTask->due_date != null) { ?>
                                                                <div class="d-flex fd-row dueDateHover">
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
                                                        <div class="card-assign">
                                                            <span class="m-l-10 m-t-10">Assign this task to: <br></span>
                                                            <hr>
                                                            <div class="text-center">
                                                                <select name="assignMembers" class="input col-sm-11 m-t-10 m-b-20 assignTaskToMember">
                                                                    <option value="" selected disabled>Choose member</option>
                                                                    <? foreach($team->getMembers() as $member) { ?>
                                                                        <option value="<?= $member->id?>" data-short-planner-task-id="<?= $shortPlannerTask->id?>"><?= $member->getName()?></option>
                                                                    <? } ?>
                                                                    <option value="nobody" data-short-planner-task-id="<?= $shortPlannerTask->id?>">Unassign</option>
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
                    <? if(isset($shortPlannerTask)) { ?>
                        <div class="modal fade shortTermTaskModal shortTermTaskModalShared" id="shortTermTaskModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-short-planner-task-id="<?= $shortPlannerTask->id?>">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content taskModalData">

                                </div>
                            </div>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/workspace/workspaceShortTermPlannerBoard.js"></script>
    @mobile
        <script src="/js/DragDropTouch.js"></script>
    @endmobile
@endsection