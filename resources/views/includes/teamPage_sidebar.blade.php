<div class="sidebar">
    <div class="text-center">
        <p class="c-gray f-20 text-center m-0"><?= \Illuminate\Support\Facades\Session::get("team_name")?></p>
        <span class="c-orange  f-12 m-0">(slug)</span>
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
        <? if(count($unseenMessages) > 0) { ?>
            <p class="circle circleSmall p-absolute c-orange" style="top: -1px; left: 170px;"><?= count($unseenMessages)?></p>
        <? } ?>
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
