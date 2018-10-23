<?
    $user = \App\User::select("*")->where("id", \Illuminate\Support\Facades\Session::get("user_id"))->first();
    $team_id = $user->team_id;
    $userJoinRequests = \App\JoinRequestLinktable::select("*")->where("team_id", $team_id)->where("accepted", 0)->get();
    $teamJoinRequestsCounter = count($userJoinRequests);
?>
@notmobile
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
            $team = \App\Team::select("*")->where("team_name", $user->team->team_name)->first();
            $unseenMessages = \App\UserMessage::select("*")->where("team_id", $team->id)->where("seen_at" ,null)->get();
        ?>
        <a class="regular-link c-gray" href="/my-team/team-chat">Team chat</a>

    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-team/team-products">My team products</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-team/payment-details">Payment details</a>
    </div>
    <hr>
    <? if($user->id == $team->ceo_user_id) { ?>
        <div class="sidebar-tab text-center">
            <a class="regular-link c-gray" href="/my-team/payment-settings">Payment settings</a>
        </div>
        <hr>
    <? } ?>
    <div class="sidebar-tab text-center">
        <div class="d-flex js-center">
            <a class="regular-link c-gray m-r-10" href="/my-team/user-join-requests">Team join requests </a>
            <? if($teamJoinRequestsCounter > 0) { ?>
                <div class="circle circleNotification c-orange text-center">
                    <span><?= $teamJoinRequestsCounter?></span>
                </div>
            <? } ?>
        </div>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-team/neededExpertises">My needed expertises</a>
    </div>
    <hr>
    {{--<div class="sidebar-tab text-center">--}}
        {{--<a class="regular-link c-gray" href="">My team newsletters</a>--}}
    {{--</div>--}}
    {{--<hr>--}}
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
@elsemobile
<i class="zmdi zmdi-view-toc f-25 m-t-10 toggleSidebar p-t-10 p-b-10 p-l-10 p-r-10" style="border: 1px solid #77787a !important; border-radius: 15px;" data-toggle="modal" data-target=".sidebarModal"></i>
<div class="modal fade sidebarModal" id="sidebarModal" tabindex="-1" role="dialog" aria-labelledby="sidebarModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body d-flex js-center p-relative">
                @mobile
                    <i class="zmdi zmdi-close p-absolute c-orange f-22" data-dismiss="modal" style="top: 4px; right: 7px; padding: 5px !important"></i>
                @endmobile
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
                        <a class="regular-link c-gray" href="/my-team/team-products">My team products</a>
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
                    {{--<div class="sidebar-tab text-center">--}}
                        {{--<a class="regular-link c-gray" href="">My team newsletters</a>--}}
                    {{--</div>--}}
                    {{--<hr>--}}
                    <div class="sidebar-tab text-center">
                        <? $workspaceShortTermPlanner = \App\WorkspaceShortTermPlannerBoard::select("*")->where("team_id", $user->team->id)->get()?>
                        <? if(count($workspaceShortTermPlanner) > 0) { ?>
                            <a class="regular-link c-gray" href="/my-team/workspace/short-term-planner/<?= $workspaceShortTermPlanner->First()->id?>">My workspace</a>
                        <? } else { ?>
                            <a class="regular-link c-gray" href="/my-team/workspace">My workspace</a>
                        <? } ?>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endnotmobile
