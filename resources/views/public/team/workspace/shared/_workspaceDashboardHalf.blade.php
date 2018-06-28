<div class="row d-flex js-center m-t-20 ">
    <div class="col-md-10">
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
                <div class="hr p-b-20 col-md-12"></div>
                <div class="row text-center" >
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
    <div class="col-md-10">
        <div class="card card-lg">
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <p class="m-l-10 m-t-10 f-18 m-b-10">Member tasks list <small class="f-12">(total all boards)</small></p>
                    </div>
                </div>
                <input type="hidden" name="user_id" class="user_id" value="<?= $user->id?>">
                <input type="hidden" name="team_id" class="team_id" value="<?= $team->id?>">
                <div class="hr p-b-20 col-md-12"></div>
                <div class="row text-center">
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
                <div class="hr-card p-b-20 col-md-10"></div>
                <? foreach($team->getMembers() as $member) { ?>
                <div class="row text-center">
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
                <? } ?>
            </div>
        </div>
    </div>
</div>
<div class="row d-flex js-center m-t-20">
    <div class="col-md-10">
        <div class="card card-lg">
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
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
                <div class="hr p-b-20 col-md-12"></div>
                <div class="row text-center">
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
