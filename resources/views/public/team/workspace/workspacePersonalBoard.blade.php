@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.workspace_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Tasks from <?= $user->getName()?></h1>
            </div>
            @if(session('success'))
                <div class="alert alert-success m-b-0 p-b-10">
                    {{session('success')}}
                </div>
            @endif
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
                        <div class="toDoTasksList">
                            <? if(isset($toDoTasks)) { ?>
                                <? foreach($toDoTasks as $toDoTask) { ?>
                                    <div class="row text-center toDoTask" data-task-id="<?= $toDoTask->id?>">
                                        <div class="col-sm-12 d-flex">
                                            <div class="col-sm-3 toDoTitle">
                                                <p><?= $toDoTask->title?></p>
                                            </div>
                                            <div class="col-sm-3 toDoDescription">
                                                <? if($toDoTask->description != null) { ?>
                                                    <p><?= mb_strimwidth($toDoTask->description, 0, 130, "... <span class='c-orange underline c-pointer openCompletedTaskModal' data-task-id='$toDoTask->id'>read more</span>");?></p>
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
                                        <? if($toDoTask->description != null) { ?>
                                            <div class="modal fade personalBoardTaskModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-task-id="<?= $toDoTask->id?>">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header text-center fd-column">
                                                            <h4 class="modal-title text-center c-black" id="modalLabel"><?= $toDoTask->title?></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <? if($toDoTask->checkAssistanceTicketRequest() == false) { ?>
                                                                        <small class="c-black m-t-5 assistanceToggleLink pull-left">Trouble with the task? <span class="c-orange regular-link toggleAssistanceForm">Ask a member for assistance!</span></small>
                                                                    <? } else { ?>
                                                                        <small class="c-black m-t-5 assistanceToggleLink pull-left">You have asked assistance for this task. Check the request <a href="/my-team/workspace/assistance-requests" class="regular-link">here</a></small>
                                                                    <? } ?>
                                                                    <small class="c-black m-t-5 closeAssistanceForm hidden pull-left"><i class="zmdi zmdi-close c-orange f-20"></i></small>
                                                                </div>
                                                            </div>
                                                            <div class="assistanceForm hidden">
                                                                <p class="c-black f-18 pull-left m-b-5">Ask a member for assistance:</p>
                                                                <form action="" method="post">
                                                                    <div class="row">
                                                                        <div class="col-sm-12 m-t-10">
                                                                            <textarea name="assistance_message" class="input col-sm-12" cols="80" rows="5" placeholder="Your question"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-12 border-bottom">
                                                                            <button class="text-center m-0 btn-sm btn btn-inno pull-right">Send request</button>
                                                                            <select name="assistanceMembers" class="input m-b-15 m-t-5 pull-right m-r-20">
                                                                                <option value="" selected disabled>Choose member</option>
                                                                                <? foreach($team->getMembers() as $member) { ?>
                                                                                    <option value="<?= $member->id?>"><?= $member->getName()?></option>
                                                                                <? } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <p class="c-black m-t-20" style="text-align: start"><?= $toDoTask->description?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <? } ?>
                                    </div>
                                <? } ?>
                            <? } ?>
                        </div>
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
                        <div class="completedTasksList">
                            <? foreach($completedTasks as $completedTask) { ?>
                                <div class="completedTask" data-task-id="<?= $completedTask->id?>">
                                    <div class="row text-center p-relative">
                                        <div class="col-sm-12 d-flex">
                                            <div class="col-sm-3 completedTaskTitle">
                                                <p><?= $completedTask->title?></p>
                                            </div>
                                            <div class="col-sm-3 completedTaskDescription">
                                                <? if($completedTask->description != null) { ?>
                                                    <p><?= mb_strimwidth($completedTask->description, 0, 130, "... <span class='c-orange underline c-pointer openCompletedTaskModal' data-task-id='$completedTask->id'>read more</span>");?></p>
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
                                    <? if($completedTask->description != null) { ?>
                                        <div class="modal fade personalBoardTaskModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-task-id="<?= $completedTask->id?>">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header d-flex js-center fd-column">
                                                        <h4 class="modal-title text-center c-black" id="modalLabel"><?= $completedTask->title?></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <? if($completedTask->checkAssistanceTicketRequest() == false) { ?>
                                                            <small class="c-black m-t-5 assistanceToggleLink pull-left">Trouble with the task? <span class="c-orange regular-link toggleAssistanceForm">Ask a member for assistance!</span></small>
                                                        <? } else { ?>
                                                            <small class="c-black m-t-5 assistanceToggleLink pull-left">You have asked assistance for this task. Check the request <a href="/my-team/workspace/assistance-requests" class="regular-link">here</a></small>
                                                        <? } ?>
                                                        <small class="c-black m-t-5 closeAssistanceForm hidden"><i class="zmdi zmdi-close c-orange f-20"></i></small>
                                                        <div class="assistanceForm hidden">
                                                            <p class="c-black f-18 m-b-5">Ask a member for assistance:</p>
                                                            <form action="/workspace/askForAssistance" method="post">
                                                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                                <input type="hidden" name="task_id" value="<?= $completedTask->id?>">
                                                                <input type="hidden" name="user_id" value="<?= $user->id?>">
                                                                <input type="hidden" name="team_id" value="<?= $team->id?>">
                                                                <div class="row">
                                                                    <div class="col-sm-12 m-t-10">
                                                                        <textarea name="assistance_message" class="input col-sm-12" cols="80" rows="5" placeholder="Your question"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12 border-bottom">
                                                                        <button class="text-center m-0 btn-sm btn btn-inno pull-right">Send request</button>
                                                                        <select name="assistanceMembers" class="input m-b-15 m-t-5 pull-right m-r-20">
                                                                            <option value="" selected disabled>Choose member</option>
                                                                            <? foreach($team->getMembers() as $member) { ?>
                                                                                <option value="<?= $member->id?>"><?= $member->getName()?></option>
                                                                            <? } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <p class="c-black m-t-20"><?= $completedTask->description?></p>
                                                            </div>
                                                        </div>
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
                                        <p><?= mb_strimwidth($missedDueDateTask->description, 0, 130, "... <span class='c-orange underline c-pointer' data-task-id='$missedDueDateTask->id'>read more</span>");?></p>
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
                            <? if($missedDueDateTask->description != null) { ?>
                                <div class="modal fade personalBoardTaskModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-task-id="<?= $missedDueDateTask->id?>">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex js-center">
                                                <h4 class="modal-title text-center c-black" id="modalLabel"><?= $missedDueDateTask->title?></h4>
                                            </div>
                                            <div class="modal-body ">
                                                <p class="c-black"><?= $missedDueDateTask->description?></p>
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
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/workspace/workspacePersonalBoard.js"></script>
@endsection