<?
    $user = \App\User::select("*")->where("id", \Illuminate\Support\Facades\Session::get("user_id"))->first();
?>
<div class="sidebar">
    <div class="text-center">
        <a href="/account" class="td-none">
            <i class="c-dark-grey f-10"><i class="zmdi zmdi-long-arrow-left"> </i>Back to account</i>
        </a>
        <p class="c-gray f-20 text-center m-0"><?= $user->team->team_name?></p>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-team">My Team</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-team/members">Team members</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center p-relative">
        <?
            $team = \App\Team::select("*")->where("team_name", \Illuminate\Support\Facades\Session::get("team_name"))->first();
            $unseenMessages = \App\UserMessage::select("*")->where("team_id", $team->id)->where("seen_at" ,null)->get();
        ?>
        <a class="regular-link c-gray" href="/my-team/team-chat">Team chat</a>

    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="">Payments</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-team/user-join-requests">Team join requests</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-team/neededExpertises">My needed expertises</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="">My team newsletters</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <? $workspaceShortTermPlanner = \App\WorkspaceShortTermPlannerBoard::select("*")->where("team_id", $team->id)->get()?>
        <? if(count($workspaceShortTermPlanner) > 0) { ?>
            <a class="regular-link c-gray" href="/my-team/workspace/short-term-planner/<?= $workspaceShortTermPlanner->First()->id?>">My workspace</a>
        <? } else { ?>
            <a class="regular-link c-gray" href="/my-team/workspace">My workspace</a>
        <? } ?>
    </div>
    <hr>
</div>
