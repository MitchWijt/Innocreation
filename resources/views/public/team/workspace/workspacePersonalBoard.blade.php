@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.workspace_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Tasks from <?= $user->getName()?></h1>
            </div>
            <hr class="m-b-20">
            <div class="row d-flex js-center m-t-20">
                <div class="card card-lg">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="m-l-10 m-t-10 f-18 m-b-10 boardTitle">To do</p>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-sm-12 d-flex">
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
                        </div>
                        <div class="hr-card p-b-20"></div>
                        <? foreach($toDoTasks as $toDoTask) { ?>
                            <div class="row text-center p-relative">
                                <div class="col-sm-12 d-flex">
                                    <div class="col-sm-3">
                                        <p><?= $toDoTask->title?></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <? if($toDoTask->description != null) { ?>
                                        <p><?= mb_strimwidth($toDoTask->description, 0, 80, "... <span class='c-orange underline c-pointer'>read more</span>");?></p>
                                        <? } ?>
                                    </div>
                                    <div class="col-sm-3">
                                        <? if($toDoTask->due_date != null) { ?>
                                            <p><?= date("d F Y", strtotime($toDoTask->due_date))?></p>
                                        <? } ?>
                                    </div>
                                    <div class="col-sm-3 d-flex js-center">
                                        <? if($toDoTask->completed == 0) { ?>
                                            <p class="circle circleSmall m-0" data-task-id="<?= $toDoTask->id?>"><i class="zmdi zmdi-check"></i></p>
                                        <? } else { ?>
                                            <p class="circle circleSmall m-0 c-black" style="background: #FF6100" data-task-id="<?= $toDoTask->id?>"><i class="zmdi zmdi-check"></i></p>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>
            <div class="row d-flex js-center m-t-20">
                <div class="card card-lg">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="m-l-10 m-t-10 f-18 m-b-10 boardTitle">Completed tasks</p>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-sm-12 d-flex">
                                <div class="col-sm-6">
                                    <span class="f-13">Title</span>
                                </div>
                                <div class="col-sm-6">
                                    <span class="f-13">Description</span>
                                </div>
                            </div>
                        </div>
                        <div class="hr-card p-b-20"></div>
                        <? foreach($completedTasks as $completedTask) { ?>
                            <div class="completedTask">
                                <div class="row text-center p-relative">
                                    <div class="col-sm-12 d-flex">
                                        <div class="col-sm-6">
                                            <p><?= $completedTask->title?></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <? if($completedTask->description != null) { ?>
                                            <p><?= mb_strimwidth($completedTask->description, 0, 100, "... <span class='c-orange underline c-pointer openCompletedTaskModal'>read more</span>");?></p>
                                            <? } ?>
                                        </div>
                                    </div>
                                </div>
                                <? if($completedTask->description != null) { ?>
                                    <div class="modal fade" id="personalBoardTaskModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex js-center">
                                                    <h4 class="modal-title text-center c-black" id="modalLabel"><?= $completedTask->title?></h4>
                                                </div>
                                                <div class="modal-body ">
                                                    <p class="c-black"><?= $completedTask->description?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>
            <div class="row d-flex js-center m-t-20">
                <div class="card card-lg">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="m-l-10 m-t-10 f-18 m-b-10 boardTitle">Missed deadline</p>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-sm-12 d-flex">
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
                        </div>
                        <div class="hr-card p-b-20"></div>
                        <? foreach($missedDueDateTasks as $missedDueDateTask) { ?>
                        <div class="row text-center p-relative">
                            <div class="col-sm-12 d-flex">
                                <div class="col-sm-4">
                                    <p><?= $missedDueDateTask->title?></p>
                                </div>
                                <div class="col-sm-4">
                                    <? if($missedDueDateTask->description != null) { ?>
                                    <p><?= mb_strimwidth($missedDueDateTask->description, 0, 80, "... <span class='c-orange underline c-pointer'>read more</span>");?></p>
                                    <? } ?>
                                </div>
                                <div class="col-sm-4">
                                    <? if($missedDueDateTask->due_date != null) { ?>
                                    <p class="c-red"><?= date("d F Y", strtotime($missedDueDateTask->due_date))?></p>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/workspace/workspacePersonalBoard.js"></script>
@endsection