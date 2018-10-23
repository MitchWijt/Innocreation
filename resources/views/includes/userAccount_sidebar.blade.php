<?
    $user = \App\User::select("*")->where("id", \Illuminate\Support\Facades\Session::get("user_id"))->first();
    $userChats = \App\UserChat::select("*")->where("creator_user_id", $user->id)->orWhere("receiver_user_id", $user->id)->get();
    $counterMessages = 0;
    if(count($userChats) > 0){
        foreach($userChats as $userChat) {
            $unreadMessages = \App\UserMessage::select("*")->where("user_chat_id", $userChat->id)->where("sender_user_id", "!=", $user->id)->where("seen_at" ,null)->get();
            $counterMessages = $counterMessages + count($unreadMessages);
        }
    }

    $invites = \App\InviteRequestLinktable::select("*")->where("user_id", $user->id)->where("accepted", 0)->get();
    $userJoinRequestsCounter = count($invites);

    if($user->team_id != null){
        $team_id = $user->team_id;
        $userJoinRequests = \App\JoinRequestLinktable::select("*")->where("team_id", $team_id)->where("accepted", 0)->get();
        $teamJoinRequestsCounter = count($userJoinRequests);
    }

    $teamCreateRequests = \App\TeamCreateRequest::select("*")->where("receiver_user_id", $user->id)->where("accepted", 0)->get();
    $teamCreateCounter = count($teamCreateRequests);
?>
@notmobile
<div class="sidebar">
    <div class="text-center col-sm-12">
        <div class="row">
            <div class="col-sm-3 p-r-0" style="margin-top: 3px ">
                <div class="avatar-sm m-l-10" style="background: url('<?= $user->getProfilePicture()?>')"></div>
            </div>
            <div class="col-sm-9 p-l-10">
                <p class="c-gray f-20 pull-left m-0"><?= \Illuminate\Support\Facades\Session::get("user_name")?></p>
            </div>
        </div>
    </div>
    <div class="hr-main m-t-5 m-b-5"></div>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-account">My Profile</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-account/expertises">Expertises</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <? if($user->team_id != null) { ?>
            <div class="d-flex js-center">
                <a class="regular-link c-gray m-r-10" href="/my-team">My team </a>
                <? if($teamJoinRequestsCounter > 0) { ?>
                    <div class="circle circleNotification c-orange text-center">
                        <span><?= $teamJoinRequestsCounter?></span>
                    </div>
                <? } ?>
            </div>
        <? } else { ?>
            <a class="regular-link c-gray" href="/my-account/teamInfo">Team</a>
        <? } ?>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-account/favorite-expertises">Favorite expertises</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-account/support-tickets">My support tickets</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-account/payment-details">Package details</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-account/billing">Billing</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <div class="d-flex js-center">
            <a class="regular-link c-gray m-r-10" href="/my-account/team-join-requests">Join requests </a>
            <? if($userJoinRequestsCounter > 0) { ?>
            <div class="circle circleNotification c-orange text-center">
                <span><?= $userJoinRequestsCounter?></span>
            </div>
            <? } ?>
        </div>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <div class="d-flex js-center">
            <a class="regular-link c-gray m-r-10" href="/my-account/team-create-requests">Create team requests </a>
            <? if($teamCreateCounter > 0) { ?>
            <div class="circle circleNotification c-orange text-center">
                <span><?= $teamCreateCounter?></span>
            </div>
            <? } ?>
        </div>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-account/portfolio">My portfolio</a>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <div class="d-flex js-center">
            <a class="regular-link c-gray m-r-10" href="/my-account/chats">Chat </a>
            <? if(count($userChats) > 0 && $counterMessages > 0) { ?>
                <div class="circle circleNotification c-orange text-center">
                    <span><?= $counterMessages?></span>
                </div>
            <? } ?>
        </div>
    </div>
    <hr>
    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-account/favorite-teams">Favorite teams</a>
    </div>
    <hr>
</div>
@elsemobile
<i class="zmdi zmdi-view-toc f-25 m-t-10 toggleSidebar p-t-10 p-b-10 p-l-10 p-r-10" style="border: 1px solid #77787a !important; border-radius: 15px;" data-toggle="modal" data-target=".sidebarModal"></i></span>
<div class="modal fade sidebarModal" id="sidebarModal" tabindex="-1" role="dialog" aria-labelledby="sidebarModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body d-flex js-center p-relative">
                @mobile
                    <i class="zmdi zmdi-close p-absolute c-orange f-22" data-dismiss="modal" style="top: 6px; right: 9px; padding: 5px !important"></i>
                @endmobile
                <div class="sidebar">
                    <div class="text-center col-sm-12">
                        <div class="row">
                            <div class="col-3 p-r-0" style="margin-top: 3px ">
                                <div class="avatar-sm m-l-10" style="background: url('<?= $user->getProfilePicture()?>')"></div>
                            </div>
                            <div class="col-9 p-l-10">
                                <p class="c-gray f-20 pull-left m-0"><?= \Illuminate\Support\Facades\Session::get("user_name")?></p>
                            </div>
                        </div>
                    </div>
                    <div class="hr-main m-t-5 m-b-5"></div>
                    <div class="sidebar-tab text-center">
                        <a class="regular-link c-gray" href="/my-account">My Profile</a>
                    </div>
                    <hr>
                    <div class="sidebar-tab text-center">
                        <a class="regular-link c-gray" href="/my-account/expertises">Expertises</a>
                    </div>
                    <hr>
                    <div class="sidebar-tab text-center">
                        <? if($user->team_id != null) { ?>
                        <a class="regular-link c-gray" href="/my-team">Team</a>
                        <? } else { ?>
                        <a class="regular-link c-gray" href="/my-account/teamInfo">Team</a>
                        <? } ?>
                    </div>
                    <hr>
                    <div class="sidebar-tab text-center">
                        <a class="regular-link c-gray" href="/my-account/favorite-expertises">Favorite expertises</a>
                    </div>
                    <hr>
                    <div class="sidebar-tab text-center">
                        <a class="regular-link c-gray" href="/my-account/support-tickets">My support tickets</a>
                    </div>
                    <hr>
                    <div class="sidebar-tab text-center">
                        <a class="regular-link c-gray" href="/my-account/payment-details">Package details</a>
                    </div>
                    <hr>
                    <div class="sidebar-tab text-center">
                        <a class="regular-link c-gray" href="/my-account/billing">Billing</a>
                    </div>
                    <hr>
                    <div class="sidebar-tab text-center">
                        <a class="regular-link c-gray" href="">Recent transactions</a>
                    </div>
                    <hr>
                    <div class="sidebar-tab text-center">
                        <div class="d-flex js-center">
                            <a class="regular-link c-gray m-r-10" href="/my-account/team-join-requests">Join requests </a>
                            <? if($userJoinRequestsCounter > 0) { ?>
                            <div class="circle circleNotification c-orange text-center">
                                <span><?= $userJoinRequestsCounter?></span>
                            </div>
                            <? } ?>
                        </div>
                    </div>
                    <hr>
                    <div class="sidebar-tab text-center">
                        <div class="d-flex js-center">
                            <a class="regular-link c-gray m-r-10" href="/my-account/team-create-requests">Create team requests </a>
                            <? if($teamCreateCounter > 0) { ?>
                            <div class="circle circleNotification c-orange text-center">
                                <span><?= $teamCreateCounter?></span>
                            </div>
                            <? } ?>
                        </div>
                    </div>
                    <hr>
                    <div class="sidebar-tab text-center">
                        <a class="regular-link c-gray" href="/my-account/portfolio">My portfolio</a>
                    </div>
                    <hr>
                    <div class="sidebar-tab text-center">
                        <a class="regular-link c-gray" href="/my-account/chats">Chat</a>
                    </div>
                    <hr>
                    <div class="sidebar-tab text-center">
                        <a class="regular-link c-gray" href="/user/favorite-teams">Favorite teams</a>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endnotmobile
