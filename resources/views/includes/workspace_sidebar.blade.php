@desktop
<div class="sidebar">
    <div class="text-center">
        <a href="/my-team" class="td-none">
            <i class="c-dark-grey f-10"><i class="zmdi zmdi-long-arrow-left"> </i>Back to team</i>
        </a>
        <p class="c-gray f-20 text-center m-0"><?= \Illuminate\Support\Facades\Session::get("team_name")?></p>
        <span class="c-orange f-12 m-0">workspace</span>
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
@elsehandheld
<i class="zmdi zmdi-view-toc f-25 m-t-10 @tablet m-l-20 @endtablet toggleSidebar p-10" style="border: 1px solid #77787a !important; border-radius: 15px;" data-toggle="modal" data-target=".sidebarModal"></i>
<div class="modal fade sidebarModal" id="sidebarModal" tabindex="-1" role="dialog" aria-labelledby="sidebarModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body d-flex js-center p-relative">
                @mobile
                    <i class="zmdi zmdi-close p-absolute c-orange f-22" data-dismiss="modal" style="top: 4px; right: 7px; padding: 5px !important"></i>
                @endmobile
                <div class="sidebar">
                    <div class="text-center">
                        <a href="/my-team" class="td-none">
                            <i class="c-dark-grey f-10"><i class="zmdi zmdi-long-arrow-left"> </i>Back to team</i>
                        </a>
                        <p class="c-gray f-20 text-center m-0"><?= \Illuminate\Support\Facades\Session::get("team_name")?></p>
                        <span class="c-orange f-12 m-0">workspace</span>
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
            </div>
        </div>
    </div>
</div>
@enddesktop