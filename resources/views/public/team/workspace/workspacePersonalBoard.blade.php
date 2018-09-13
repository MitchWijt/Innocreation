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
                <h1 class="sub-title-black @mobile f-25 @endmobile">Tasks from <?= $user->getName()?></h1>
            </div>
            @if(session('success'))
                <div class="alert alert-success m-b-0 p-b-10">
                    {{session('success')}}
                </div>
            @endif
            <hr class="m-b-20">
            <div class="row d-flex js-center m-t-20">
                <div class="col-md-9">
                    <div class="card card-lg">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="m-l-10 m-t-10 f-18 m-b-10 boardTitle">To do</p>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-sm-3">
                                    <span class="f-13">Title</span>
                                </div>
                                <div class="col-sm-3">
                                    <span class="f-13">Description</span>
                                </div>
                                <div class="col-sm-3">
                                    <span class="f-13">Due date</span>
                                </div>
                                <div class="col-sm-3">
                                    <span class="f-13"></span>
                                </div>
                            </div>
                            <hr class="col-md-10 p-b-20">
                            <div class="toDoTasksList">
                                <? if(isset($toDoTasks)) { ?>
                                    <? foreach($toDoTasks as $toDoTask) { ?>
                                        <div class="row text-center toDoTask" data-task-id="<?= $toDoTask->id?>">
                                            <div class="col-sm-3 toDoTitle">
                                                <p class="openPersonalBoardTaskModal c-pointer regular-link c-gray" data-task-id='<?= $toDoTask->id?>'><?= $toDoTask->title?></p>
                                            </div>
                                            <div class="col-sm-3 toDoDescription">
                                                <? if($toDoTask->description != null) { ?>
                                                <p class="m-0"><?= mb_strimwidth(str_replace("contenteditable", "", htmlspecialchars_decode(strip_tags($toDoTask->description))), 0, 130, "... <span class='c-orange underline c-pointer openPersonalBoardTaskModal' data-task-id='$toDoTask->id'>read more</span>");?></p>
                                                <? } else { ?>
                                                    <p> - </p>
                                                <? } ?>
                                            </div>
                                            <div class="dueDateAjax"></div>
                                            <div class="col-sm-3 dueDatePersonalBoard">
                                                <? if($toDoTask->due_date != null) { ?>
                                                    <p><?= date("d F Y", strtotime($toDoTask->due_date))?></p>
                                                <? } else { ?>
                                                    <p> - </p>
                                                <? } ?>
                                            </div>
                                            <div class="col-sm-3 d-flex js-center toDoCompleteCheck">
                                                <p class="circle circleSmall m-0 completeTaskPersonalBoard switchStatusTask" data-task-id="<?= $toDoTask->id?>"><i class="zmdi zmdi-check"></i></p>
                                            </div>
                                        </div>
                                    <? } ?>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex js-center m-t-20">
                <div class="col-md-9">
                    <div class="card card-lg">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="m-l-10 m-t-10 f-18 m-b-10 boardTitle">Completed tasks</p>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-sm-3">
                                    <span class="f-13">Title</span>
                                </div>
                                <div class="col-sm-3">
                                    <span class="f-13">Description</span>
                                </div>
                                <div class="col-sm-3">
                                    <span class="f-13">Due date</span>
                                </div>
                                <div class="col-sm-3">
                                    <span class="f-13"></span>
                                </div>
                            </div>
                            <hr class="col-md-10 p-b-20">
                            <div class="completedTasksList">
                                <? foreach($completedTasks as $completedTask) { ?>
                                    <div class="completedTask" data-task-id="<?= $completedTask->id?>">
                                        <div class="row text-center p-relative">
                                            <div class="col-sm-3 completedTaskTitle">
                                                <p class="openPersonalBoardTaskModal c-pointer regular-link c-gray" data-task-id='<?= $completedTask->id?>'><?= $completedTask->title?></p>
                                            </div>
                                            <div class="col-sm-3 completedTaskDescription">
                                                <? if($completedTask->description != null) { ?>
                                                    <p><?= mb_strimwidth(htmlspecialchars_decode(str_replace("contenteditable", "",$completedTask->description)), 0, 130, "... <span class='c-orange underline c-pointer openPersonalBoardTaskModal' data-task-id='$completedTask->id'>read more</span>");?></p>
                                                <? } else { ?>
                                                    <p> - </p>
                                                <? } ?>
                                            </div>
                                            <div class="col-sm-3 dueDatePersonalBoard">
                                                <? if($completedTask->due_date != null) { ?>
                                                    <p><?= date("d F Y", strtotime($completedTask->due_date))?></p>
                                                <? } else { ?>
                                                    <p> - </p>
                                                <? } ?>
                                            </div>
                                            <div class="col-sm-3 d-flex js-center completedTaskCheck">
                                                <p class="circle circleSmall m-0 c-black bcg-orange uncompleteTaskPersonalBoard switchStatusTask" data-task-id="<?= $completedTask->id?>"><i class="zmdi zmdi-check"></i></p>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex js-center m-t-20">
                <div class="col-md-9">
                    <div class="card card-lg">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="m-l-10 m-t-10 f-18 m-b-10 boardTitle">Missed deadline</p>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-sm-4">
                                    <span class="f-13">Title</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="f-13">Description</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="f-13">Due date</span>
                                </div>
                            </div>
                            <hr class="col-md-10 p-b-20">
                            <? foreach($missedDueDateTasks as $missedDueDateTask) { ?>
                                <div class="row text-center p-relative">
                                    <div class="col-sm-4">
                                        <p class="openPersonalBoardTaskModal c-pointer regular-link c-gray" data-task-id='<?= $missedDueDateTask->id?>'><?= $missedDueDateTask->title?></p>
                                    </div>
                                    <div class="col-sm-4">
                                        <? if($missedDueDateTask->description != null) { ?>
                                            <p contenteditable="false"><?= mb_strimwidth(htmlspecialchars_decode(str_replace("contenteditable", "",$missedDueDateTask->description)), 0, 130, "... <span class='c-orange underline c-pointer openPersonalBoardTaskModal' data-task-id='$missedDueDateTask->id'>read more</span>");?></p>
                                        <? } else { ?>
                                            <p> - </p>
                                        <? } ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <? if($missedDueDateTask->due_date != null) { ?>
                                            <p class="c-red"><?= date("d F Y", strtotime($missedDueDateTask->due_date))?></p>
                                        <? } ?>
                                    </div>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade personalBoardTaskModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content personalBoardTaskModalData">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/workspace/workspacePersonalBoard.js"></script>
@endsection