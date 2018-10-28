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
<div class="sidebar-tab m-b-5">
    <a class="regular-link c-gray m-r-10" href="/my-account/team-join-requests">Join requests </a>
</div>
<div class="sidebar-tab m-b-5">
    <a class="regular-link c-gray m-r-10" href="/my-account/team-create-requests">Create team requests </a>
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
            <? if(count($userChats) < 1 && $counterMessages < 1) { ?>
                <div class="circle circleNotification c-orange text-center p-relative">
                    <span class="m-t-15 p-absolute" style="top: -12px; right: 8px;"><?= $counterMessages?></span>
                </div>
            <? } ?>
        </div>
    </div>
</div>
@endmobile