<div class="sidebar">
    <div class="text-center">
        <p class="c-gray f-20 text-center m-0"><?= \Illuminate\Support\Facades\Session::get("team_name")?></p>
        <span class="c-orange  f-12 m-0">workspace</span>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-team/workspace/ideas">Idea's</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-team/workspace/bucketlist">Bucketlist</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <? $shortTermPlannerBoards = \App\WorkspaceShortTermPlannerBoard::select("*")->where("team_id", \Illuminate\Support\Facades\Session::get("team_id"))->get();?>
        <a data-toggle="collapse" data-target="#sidebarShortTermCollapse" aria-expanded="false" aria-controls="sidebarShortTermCollapse" class="regular-link c-gray">Short term task planner <i class="zmdi zmdi-chevron-down m-l-10"></i></a>
        <div class="collapse" id="sidebarShortTermCollapse">
            <div class="sidebar-tab text-center">
                <a class="regular-link c-orange" href="/my-team/workspace/short-term-planner-options">Create new planner</a>
            </div>
            <? foreach($shortTermPlannerBoards as $shortTermPlannerBoard) { ?>
                <div class="sidebar-tab text-center">
                    <a class="regular-link c-gray" href="<?= $shortTermPlannerBoard->getUrl()?>"><?= $shortTermPlannerBoard->title?></a>
                </div>
            <? } ?>
        </div>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-team/workspace/my-tasks">Tasks assigned to me</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-team/workspace/dashboard">Dashboard</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-team/meetings">Meetings</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-team/workspace/assistance-requests">Assistance requests</a>
    </div>
    <hr>
</div>