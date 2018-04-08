@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.workspace_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Dashboard</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <small>(realtime data compared to the last 24 hours)</small>
                </div>
            </div>
            <hr class="m-b-20 col-sm-12">
            <div class="row d-flex js-center m-t-20">
                <div class="card card-lg">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="m-l-10 m-t-10 f-18 m-b-10">Chats/assistance tickets  <i class="zmdi zmdi-chevron-down toggleChatsAssistanceMenu"></i></p>
                            </div>
                        </div>
                        <div class="col-sm-2 text-center chatsAssistanceDashBoardMenu hidden  f-12">
                            <p class="bcg-black border-default border-bottom-none m-b-0 menu-item filterChatsAssistanceDashBoard" data-filter="Total">Total values</p>
                            <p class="bcg-black border-default border-bottom-none m-b-0 menu-item filterChatsAssistanceDashBoard" data-filter="Week">Week values</p>
                            <p class="bcg-black border-default border-bottom-none m-b-0 menu-item filterChatsAssistanceDashBoard" data-filter="Month">Month values</p>
                            <p class="bcg-black border-default menu-item filterChatsAssistanceDashBoard" data-filter="Default">Default Values</p>
                        </div>
                        <input type="hidden" name="user_id" class="user_id" value="<?= $user->id?>">
                        <input type="hidden" name="team_id" class="team_id" value="<?= $team->id?>">
                        <div class="hr p-b-20"></div>
                        <div class="row text-center" >
                            <div class="col-sm-12 d-flex">
                                <div class="col-sm-3">
                                    <div class="d-flex fd-row js-center">
                                        <p  class="f-25 totalTeamChats"></p>
                                        <div class="d-flex fd-column m-l-10">
                                            <i class="fas fa-caret-up f-23 c-green totalTeamChatsValUp hidden"></i>
                                            <i class="fas fa-caret-down f-23 c-red totalTeamChatsValDown hidden"></i>
                                            <i class="zmdi zmdi-window-minimize totalTeamChatsValNeutral f-23 hidden "></i>
                                            <span class="f-13 totalTeamChatsNewValue"></span>
                                        </div>
                                    </div>
                                    <input type="hidden" class="totalTeamChats24Hours" value="<?= $totalTeamChatsLast24Hours?>">
                                    <p>Amount of team chats</p>
                                </div>
                                <div class="col-sm-3">
                                    <div class="d-flex fd-row js-center">
                                        <p class="f-25 totalAssistanceTickets"></p>
                                        <div class="d-flex fd-column m-l-10">
                                            <i class="fas fa-caret-up f-23 c-green totalAssistanceTicketsValUp hidden"></i>
                                            <i class="fas fa-caret-down f-23 c-red totalAssistanceTicketsValDown hidden"></i>
                                            <i class="zmdi zmdi-window-minimize totalAssistanceTicketsValNeutral f-20 hidden "></i>
                                            <span class="f-13 totalAssistanceTicketsNewValue"></span>
                                        </div>
                                    </div>
                                    <input type="hidden" class="totalAssistanceTickets24Hours" value="<?= $totalAssistanceTicketsLast24Hours?>">
                                    <p>Assistance tickets created</p>
                                </div>
                                <div class="col-sm-3">
                                    <div class="d-flex fd-row js-center">
                                        <p class="f-25 totalAssistanceTicketsCompleted"></p>
                                        <div class="d-flex fd-column m-l-10">
                                            <i class="fas fa-caret-up f-23 c-green totalAssistanceTicketsCompletedValUp hidden"></i>
                                            <i class="fas fa-caret-down f-23 c-red totalAssistanceTicketsCompletedValDown hidden"></i>
                                            <i class="zmdi zmdi-window-minimize totalAssistanceTicketsCompletedValNeutral f-20 hidden"></i>
                                            <span class="f-13 totalAssistanceTicketsCompletedNewValue"></span>
                                        </div>
                                    </div>
                                    <input type="hidden" class="totalAssistanceTicketsCompleted24Hours" value="<?= $totalAssistanceTicketsCompletedLast24Hours?>">
                                    <p>Assistance tickets completed</p>
                                </div>
                                <div class="col-sm-3">
                                    <div class="d-flex fd-column js-center">
                                        <p  class="f-25 mostTicketsValue"></p>
                                        <p class="m-0 mostTicketsMember"></p>
                                    </div>
                                    <p class="m-b-5">Most tickets this <span class="mostTicketsCategory"></span> <i class="zmdi zmdi-chevron-down chatsDashboardMenuToggle"></i></p>
                                    <div class="row">
                                        <div class="col-sm-12 d-flex js-center ">
                                            <div class="col-sm-10">
                                                <div class="chatsDashboardMenu hidden">
                                                    <p class="border-default text-center f-13 btn-inno m-b-5 changeCategoryMostTickets">Week</p>
                                                    <p class="border-default text-center f-13 btn-inno m-b-5 changeCategoryMostTickets">Month</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex js-center m-t-20">
                <div class="card card-lg">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="m-l-10 m-t-10 f-18 m-b-10">Mmeber tasks list <small class="f-12">(total all boards)</small></p>
                            </div>
                        </div>
                        <input type="hidden" name="user_id" class="user_id" value="<?= $user->id?>">
                        <input type="hidden" name="team_id" class="team_id" value="<?= $team->id?>">
                        <div class="hr p-b-20"></div>
                        <div class="row text-center">
                            <div class="col-sm-12 d-flex">
                                <div class="col-sm-4">
                                    <span class="f-13">Member</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="f-13">Tasks completed</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="f-13">Tasks To Do</span>
                                </div>
                            </div>
                        </div>
                        <div class="hr-card p-b-20"></div>
                        <? foreach($team->getMembers() as $member) { ?>
                            <div class="row text-center p-relative">
                                <div class="col-sm-12 d-flex">
                                    <div class="col-sm-4">
                                        <p><?= $member->getName()?></p>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="d-flex fd-row js-center memberTasksCom" data-member-id="<?= $member->id?>">
                                            <p class="f-25 memberTasksCompleted"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="d-flex fd-row js-center memberTasksDo" data-member-id="<?= $member->id?>">
                                            <p class="f-25 memberTasksToDo"></p>
                                        </div>
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
                                <p class="m-l-10 m-t-10 f-18 m-b-10">Bucketlist goals <i class="zmdi zmdi-chevron-down toggleBucketlistMenu"></i> </p>
                            </div>
                        </div>
                        <div class="col-sm-2 text-center bucketlistDashBoardMenu hidden  f-12">
                            <p class="bcg-black border-default border-bottom-none m-b-0 menu-item filterBucketlistDashboard" data-filter="Total">Total values</p>
                            <p class="bcg-black border-default border-bottom-none m-b-0 menu-item filterBucketlistDashboard" data-filter="Week">Week values</p>
                            <p class="bcg-black border-default border-bottom-none m-b-0 menu-item filterBucketlistDashboard" data-filter="Month">Month values</p>
                            <p class="bcg-black border-default menu-item filterBucketlistDashboard" data-filter="Default">Default Values</p>
                        </div>
                        <input type="hidden" name="user_id" class="user_id" value="<?= $user->id?>">
                        <input type="hidden" name="team_id" class="team_id" value="<?= $team->id?>">
                        <div class="hr p-b-20"></div>
                        <div class="row text-center" >
                            <div class="col-sm-12 d-flex">
                                <div class="col-sm-12 d-flex">
                                    <div class="col-sm-6">
                                        <div class="d-flex fd-row js-center">
                                            <p  class="f-25 totalCompletedGoals"></p>
                                            <div class="d-flex fd-column m-l-10">
                                                <i class="fas fa-caret-up f-23 c-green completedGoalsValUp hidden"></i>
                                                <i class="fas fa-caret-down f-23 c-red completedGoalsValDown hidden"></i>
                                                <i class="zmdi zmdi-window-minimize completedGoalsValNeutral f-23 hidden "></i>
                                                <span class="f-13 completedGoalsNewValue"></span>
                                            </div>
                                        </div>
                                        <input type="hidden" class="completedGoals24Hours" value="<?= $completedGoalsLast24Hours?>">
                                        <p>Completed goals</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="d-flex fd-row js-center">
                                            <p class="f-25 totalUnCompletedGoals"></p>
                                            <div class="d-flex fd-column m-l-10">
                                                <i class="fas fa-caret-up f-23 c-green unCompletedGoalsValUp hidden"></i>
                                                <i class="fas fa-caret-down f-23 c-red unCompletedGoalsValDown hidden"></i>
                                                <i class="zmdi zmdi-window-minimize unCompletedGoalsValNeutral f-20 hidden "></i>
                                                <span class="f-13 unCompletedGoalsNewValue"></span>
                                            </div>
                                        </div>
                                        <input type="hidden" class="unCompletedGoals24Hours" value="<?= $unCompletedGoalsLast24Hours?>">
                                        <p>Still to complete</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex js-center m-t-20">
                <div class="card card-lg">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="m-l-10 m-t-10 f-18 m-b-10">Ideas <i class="zmdi zmdi-chevron-down toggleIdeasMenu"></i> </p>
                            </div>
                        </div>
                        <div class="col-sm-2 text-center ideasDashBoardMenu hidden  f-12">
                            <p class="bcg-black border-default border-bottom-none m-b-0 menu-item filterIdeasDashboard" data-filter="Total">Total values</p>
                            <p class="bcg-black border-default border-bottom-none m-b-0 menu-item filterIdeasDashboard" data-filter="Week">Week values</p>
                            <p class="bcg-black border-default border-bottom-none m-b-0 menu-item filterIdeasDashboard" data-filter="Month">Month values</p>
                            <p class="bcg-black border-default menu-item filterIdeasDashboard" data-filter="Default">Default Values</p>
                        </div>
                        <input type="hidden" name="user_id" class="user_id" value="<?= $user->id?>">
                        <input type="hidden" name="team_id" class="team_id" value="<?= $team->id?>">
                        <div class="hr p-b-20"></div>
                        <div class="row text-center" >
                            <div class="col-sm-12 d-flex">
                                <div class="col-sm-12 d-flex">
                                    <div class="col-sm-3">
                                        <div class="d-flex fd-row js-center">
                                            <p  class="f-25 totalIdeas"></p>
                                            <div class="d-flex fd-column m-l-10">
                                                <i class="fas fa-caret-up f-23 c-green totalIdeasValUp hidden"></i>
                                                <i class="fas fa-caret-down f-23 c-red totalIdeasValDown hidden"></i>
                                                <i class="zmdi zmdi-window-minimize totalIdeasValNeutral f-23 hidden "></i>
                                                <span class="f-13 totalIdeasNewValue"></span>
                                            </div>
                                        </div>
                                        <input type="hidden" class="totalIdeas24Hours" value="<?= $totalIdeasLast24Hours?>">
                                        <p>Total ideas</p>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-flex fd-row js-center">
                                            <p class="f-25 totalIdeasOnHold"></p>
                                            <div class="d-flex fd-column m-l-10">
                                                <i class="fas fa-caret-up f-23 c-green totalIdeasOnHoldValUp hidden"></i>
                                                <i class="fas fa-caret-down f-23 c-red totalIdeasOnHoldValDown hidden"></i>
                                                <i class="zmdi zmdi-window-minimize totalIdeasOnHoldValNeutral f-20 hidden "></i>
                                                <span class="f-13 totalIdeasOnHoldNewValue"></span>
                                            </div>
                                        </div>
                                        <input type="hidden" class="totalIdeasOnHold24Hours" value="<?= $totalIdeasOnHoldLast24Hours?>">
                                        <p>Ideas on hold</p>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-flex fd-row js-center">
                                            <p class="f-25 totalIdeasPassed"></p>
                                            <div class="d-flex fd-column m-l-10">
                                                <i class="fas fa-caret-up f-23 c-green totalIdeasPassedValUp hidden"></i>
                                                <i class="fas fa-caret-down f-23 c-red totalIdeasPassedValDown hidden"></i>
                                                <i class="zmdi zmdi-window-minimize totalIdeasPassedValNeutral f-20 hidden "></i>
                                                <span class="f-13 totalIdeasPassedNewValue"></span>
                                            </div>
                                        </div>
                                        <input type="hidden" class="totalIdeasPassed24Hours" value="<?= $totalIdeasPassedLast24Hours?>">
                                        <p>Ideas passed</p>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-flex fd-row js-center">
                                            <p class="f-25 totalIdeasRejected"></p>
                                            <div class="d-flex fd-column m-l-10">
                                                <i class="fas fa-caret-up f-23 c-green totalIdeasRejectedValUp hidden"></i>
                                                <i class="fas fa-caret-down f-23 c-red totalIdeasRejectedValDown hidden"></i>
                                                <i class="zmdi zmdi-window-minimize totalIdeasRejectedValNeutral f-20 hidden "></i>
                                                <span class="f-13 totalIdeasRejectedNewValue"></span>
                                            </div>
                                        </div>
                                        <input type="hidden" class="totalIdeasRejected24Hours" value="<?= $totalIdeasRejectedLast24Hours?>">
                                        <p>Ideas rejected</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex js-center m-t-20">
                <div class="card card-lg">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 d-flex">
                                <p class="m-l-10 m-t-10 f-18 m-b-10 m-r-10">Short term planner taks</p>
                                <button class="btn btn-inno btn-sm m-t-10 m-b-10 toggleShortTermPlannerDashboardMenu"><i class="zmdi zmdi-settings"></i> Filter</button>
                            </div>
                        </div>
                        <div class="row shortTermPlannerDashboardMenu hidden">
                            <div class="col-sm-12">
                                <div class="d-flex fd-column col-sm-12">
                                    <select name="short_term_tasks_board_filter" class="short_term_tasks_board_filter input col-sm-3 m-b-10">
                                        <option selected disabled> Choose your board</option>
                                        <? foreach($short_term_planner_boards as $short_term_planner_board) { ?>
                                            <option value="<?= $short_term_planner_board->id?>"><?= $short_term_planner_board->title?></option>
                                        <? } ?>
                                        <option value=""></option>
                                    </select>
                                    <select name="short_term_tasks_range_filter" class="short_term_tasks_range_filter input col-sm-3 m-b-10">
                                        <option selected disabled>Choose time range</option>
                                        <option value="Total">Total</option>
                                        <option value="Week">Week</option>
                                        <option value="Month">Month</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="user_id" class="user_id" value="<?= $user->id?>">
                        <input type="hidden" name="team_id" class="team_id" value="<?= $team->id?>">
                        <div class="hr p-b-20"></div>
                        <div class="row text-center" >
                            <div class="col-sm-12 d-flex">
                                <div class="col-sm-12 d-flex">
                                    <div class="col-sm-3">
                                        <div class="d-flex fd-row js-center">
                                            <p  class="f-25 totalTasksCreated"></p>
                                            <div class="d-flex fd-column m-l-10">
                                                <i class="fas fa-caret-up f-23 c-green totalTasksCreatedValUp hidden"></i>
                                                <i class="fas fa-caret-down f-23 c-red totalTasksCreatedValDown hidden"></i>
                                                <i class="zmdi zmdi-window-minimize totalTasksCreatedValNeutral f-23 hidden "></i>
                                                <span class="f-13 totalTasksCreatedNewValue"></span>
                                            </div>
                                        </div>
                                        <input type="hidden" class="totalTasksCreated24Hours" value="<?= $totalTasksCreatedLast24Hours?>">
                                        <p>Total tasks created</p>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-flex fd-row js-center">
                                            <p class="f-25 totalTasksCompleted"></p>
                                            <div class="d-flex fd-column m-l-10">
                                                <i class="fas fa-caret-up f-23 c-green totalTasksCompletedOnHoldValUp hidden"></i>
                                                <i class="fas fa-caret-down f-23 c-red totalTasksCompletedValDown hidden"></i>
                                                <i class="zmdi zmdi-window-minimize totalTasksCompletedValNeutral f-20 hidden "></i>
                                                <span class="f-13 totalTasksCompletedNewValue"></span>
                                            </div>
                                        </div>
                                        <input type="hidden" class="totalTasksCompleted24Hours" value="<?= $totalTasksCompletedLast24Hours?>">
                                        <p>Total tasks completed</p>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-flex fd-row js-center">
                                            <p class="f-25 totalTasksToDo"></p>
                                            <div class="d-flex fd-column m-l-10">
                                                <i class="fas fa-caret-up f-23 c-green totalTasksToDoPassedValUp hidden"></i>
                                                <i class="fas fa-caret-down f-23 c-red totalTasksToDoValDown hidden"></i>
                                                <i class="zmdi zmdi-window-minimize totalTasksToDoValNeutral f-20 hidden "></i>
                                                <span class="f-13 totalTasksToDoNewValue"></span>
                                            </div>
                                        </div>
                                        <input type="hidden" class="totalTasksToDo24Hours" value="<?= $totalTasksToDoLast24Hours?>">
                                        <p>Total tasks to do</p>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="d-flex fd-row js-center">
                                            <p class="f-25 totalTasksExpiredDueDate"></p>
                                            <div class="d-flex fd-column m-l-10">
                                                <i class="fas fa-caret-up f-23 c-green totalTasksExpiredDueDateValUp hidden"></i>
                                                <i class="fas fa-caret-down f-23 c-red totalTasksExpiredDueDateValDown hidden"></i>
                                                <i class="zmdi zmdi-window-minimize totalTasksExpiredDueDateValNeutral f-20 hidden "></i>
                                                <span class="f-13 totalTasksExpiredDueDatedNewValue"></span>
                                            </div>
                                        </div>
                                        <input type="hidden" class="totalTasksExpiredDueDate24Hours" value="<?= $totalTasksExpiredDueDateLast24Hours?>">
                                        <p>Total tasks expired due date</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/workspace/workspaceDashboard.js"></script>
@endsection