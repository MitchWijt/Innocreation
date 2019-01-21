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
<div class="sidebar-tab m-b-5">
    <a class="regular-link c-gray" href="/my-account/favorite-expertises">Favorite expertises</a>
</div>
<div class="sidebar-tab m-b-5">
    <a class="regular-link c-gray" href="/my-account/support-tickets">My support tickets</a>
</div>
<div class="sidebar-tab m-b-5">
    <a class="regular-link c-gray" href="/my-account/payment-details">Package details</a>
</div>
<div class="sidebar-tab m-b-5">
    <a class="regular-link c-gray" href="/my-account/billing">Billing</a>
</div>
<div class="sidebar-tab <? if($userJoinRequestsCounter < 1) echo "m-b-5";?>">
    <div class="row">
        <div class="col-8 p-r-0">
            <a class="regular-link c-gray" href="/my-account/team-join-requests">Join requests </a>
        </div>
        <div class="col-3 p-l-0 m-b-5">
            <? if($userJoinRequestsCounter > 1) { ?>
                <div class="circle circleNotification c-orange text-center p-relative">
                    <span class="m-t-15 p-absolute" style="top: -13px; right: 8px;"><?= $userJoinRequestsCounter?></span>
                </div>
            <? } ?>
        </div>
    </div>
</div>
<div class="sidebar-tab <? if($teamCreateCounter < 1) echo "m-b-5";?>">
    <div class="row">
        <div class="col-8 p-r-0">
            <a class="regular-link c-gray" href="/my-account/team-create-requests">Create team requests </a>
        </div>
        <div class="col-3 p-l-0">
            <? if($teamCreateCounter > 1) { ?>
                <div class="circle circleNotification c-orange text-center p-relative">
                    <span class="m-t-15 p-absolute" style="top: -13px; right: 8px;"><?= $teamCreateCounter?></span>
                </div>
            <? } ?>
        </div>
    </div>
</div>
<div class="sidebar-tab m-b-5">
    <a class="regular-link c-gray" href="/my-account/favorite-teams">Favorite teams</a>
</div>
@mobile
<div class="sidebar-tab m-b-5">
    <div class="row">
        <div class="col-3 p-r-0">
            <a class="regular-link c-gray" href="/my-account/chats">Chat </a>
        </div>
        <div class="col-9 p-l-0">
            <? if(count($userChats) > 0 && $counterMessages > 0) { ?>
                <div class="circle circleNotification c-orange text-center p-relative">
                    <span class="m-t-15 p-absolute" style="top: -12px; right: 8px;"><?= $counterMessages?></span>
                </div>
            <? } ?>
        </div>
    </div>
</div>
@endmobile