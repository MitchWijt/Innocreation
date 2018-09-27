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
?>
@notmobile
<div class="sidebar">
    <div class="text-center">
        <p class="c-gray f-20 text-center m-0"><?= \Illuminate\Support\Facades\Session::get("user_name")?></p>
    </div>
    <hr>
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
                <a class="regular-link c-gray m-r-10" href="/my-team">Team </a>
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
<i class="zmdi zmdi-view-toc f-25 m-t-10 toggleSidebar" data-toggle="modal" data-target=".sidebarModal"></i>
<div class="modal fade sidebarModal" id="sidebarModal" tabindex="-1" role="dialog" aria-labelledby="sidebarModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body d-flex js-center">
                <div class="sidebar">
                    <div class="text-center">
                        <p class="c-gray f-20 text-center m-0"><?= \Illuminate\Support\Facades\Session::get("user_name")?></p>
                    </div>
                    <hr>
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
