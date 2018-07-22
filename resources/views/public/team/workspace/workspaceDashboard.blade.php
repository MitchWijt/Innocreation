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
            <div class="m-b-20">
                <div class="sub-title-container p-t-20">
                    <h1 class="sub-title-black">Dashboard</h1>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <small>(realtime data compared to the last 24 hours)</small>
                    </div>
                </div>
                <input type="hidden" class="team_id" value="<?= $team->id?>">
                <input type="hidden" class="user_id" value="<?= $user->id?>">
                <hr class="m-b-20 col-xs-12">
                <? if(!$team->packageDetails()) { ?>

                <? } else { ?>
                    <? if($team->packageDetails()->custom_team_package_id == null) { ?>
                        <?
                            if($team->packageDetails()->membershipPackage->dashboard == "half") {
                                echo view("/public/team/workspace/shared/_workspaceDashboardHalf", compact("user", "team","totalTeamChatsLast24Hours", "totalAssistanceTicketsLast24Hours", "totalAssistanceTicketsCompletedLast24Hours", "completedGoalsLast24Hours", "unCompletedGoalsLast24Hours", "totalIdeasLast24Hours", "totalIdeasOnHoldLast24Hours", "totalIdeasPassedLast24Hours", "totalIdeasRejectedLast24Hours", "short_term_planner_boards", "totalTasksCreatedLast24Hours", "totalTasksCompletedLast24Hours", "totalTasksToDoLast24Hours", "totalTasksExpiredDueDateLast24Hours"));
                            } else if($team->packageDetails()->membershipPackage->dashboard == "full"){
                                echo view("/public/team/workspace/shared/_workspaceDashboardFull", compact("user", "team","totalTeamChatsLast24Hours", "totalAssistanceTicketsLast24Hours", "totalAssistanceTicketsCompletedLast24Hours", "completedGoalsLast24Hours", "unCompletedGoalsLast24Hours", "totalIdeasLast24Hours", "totalIdeasOnHoldLast24Hours", "totalIdeasPassedLast24Hours", "totalIdeasRejectedLast24Hours", "short_term_planner_boards", "totalTasksCreatedLast24Hours", "totalTasksCompletedLast24Hours", "totalTasksToDoLast24Hours", "totalTasksExpiredDueDateLast24Hours"));
                            } else if($team->packageDetails()->membershipPackage->dashboard == "no"){
                                echo view("/public/team/workspace/shared/_workspaceDashboardNo", compact("user", "team","totalTeamChatsLast24Hours", "totalAssistanceTicketsLast24Hours", "totalAssistanceTicketsCompletedLast24Hours", "completedGoalsLast24Hours", "unCompletedGoalsLast24Hours", "totalIdeasLast24Hours", "totalIdeasOnHoldLast24Hours", "totalIdeasPassedLast24Hours", "totalIdeasRejectedLast24Hours", "short_term_planner_boards", "totalTasksCreatedLast24Hours", "totalTasksCompletedLast24Hours", "totalTasksToDoLast24Hours", "totalTasksExpiredDueDateLast24Hours"));
                            }
                        ?>
                    <? } else { ?>
                        <?
                            if($team->packageDetails()->customTeamPackage->dashboard == "half") {
                                echo view("/public/team/workspace/shared/_workspaceDashboardHalf", compact("user", "team","totalTeamChatsLast24Hours", "totalAssistanceTicketsLast24Hours", "totalAssistanceTicketsCompletedLast24Hours", "completedGoalsLast24Hours", "unCompletedGoalsLast24Hours", "totalIdeasLast24Hours", "totalIdeasOnHoldLast24Hours", "totalIdeasPassedLast24Hours", "totalIdeasRejectedLast24Hours", "short_term_planner_boards", "totalTasksCreatedLast24Hours", "totalTasksCompletedLast24Hours", "totalTasksToDoLast24Hours", "totalTasksExpiredDueDateLast24Hours"));
                            } else if($team->packageDetails()->customTeamPackage->dashboard == "full"){
                                echo view("/public/team/workspace/shared/_workspaceDashboardFull", compact("user", "team","totalTeamChatsLast24Hours", "totalAssistanceTicketsLast24Hours", "totalAssistanceTicketsCompletedLast24Hours", "completedGoalsLast24Hours", "unCompletedGoalsLast24Hours", "totalIdeasLast24Hours", "totalIdeasOnHoldLast24Hours", "totalIdeasPassedLast24Hours", "totalIdeasRejectedLast24Hours", "short_term_planner_boards", "totalTasksCreatedLast24Hours", "totalTasksCompletedLast24Hours", "totalTasksToDoLast24Hours", "totalTasksExpiredDueDateLast24Hours"));
                            } else if($team->packageDetails()->customTeamPackage->dashboard == "no"){
                                echo view("/public/team/workspace/shared/_workspaceDashboardNo", compact("user", "team","totalTeamChatsLast24Hours", "totalAssistanceTicketsLast24Hours", "totalAssistanceTicketsCompletedLast24Hours", "completedGoalsLast24Hours", "unCompletedGoalsLast24Hours", "totalIdeasLast24Hours", "totalIdeasOnHoldLast24Hours", "totalIdeasPassedLast24Hours", "totalIdeasRejectedLast24Hours", "short_term_planner_boards", "totalTasksCreatedLast24Hours", "totalTasksCompletedLast24Hours", "totalTasksToDoLast24Hours", "totalTasksExpiredDueDateLast24Hours"));
                            }
                        ?>
                    <? } ?>
                <? } ?>

            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/workspace/workspaceDashboard.js"></script>
@endsection