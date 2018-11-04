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

    <div class="sidebar-tab text-center">
        <a class="regular-link c-gray" href="/my-account/expertises">Expertises</a>
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
       <i class="zmdi zmdi-more c-gray f-30 pull-right m-r-15 c-pointer userAccountPopover" data-toggle="popover" data-content='<?= view("includes.popovers.userAccountSidebar_popover")?>'></i>
    </div>
</div>
@elsemobile
<div id="mobileMenu" class="row p-t-20 p-l-5 p-r-5 hidden p-relative">
    <i class="zmdi zmdi-arrow-left c-orange f-20 p-absolute menuBackArrow closePopover" style="top: 5px; right: 15px;"></i>
    <div class="col-4 text-center" style="background: #000; border: 1px solid #FF6100 !important">
        <a class="regular-link c-gray" href="/my-account/expertises">Expertises</a>
    </div>
    <div class="col-4 text-center" style="background: #000; border: 1px solid #FF6100 !important">
        <a class="regular-link c-gray" href="/my-account/portfolio">portfolio</a>
    </div>
    <i class="zmdi zmdi-more c-black f-30 m-l-30 c-pointer userAccountPopover" data-toggle="popover" data-content='<?= view("includes.popovers.userAccountSidebar_popover")?>'></i>
</div>
<div class="row">
    <div class="col-2 sidebarIcon">
        <i class="zmdi zmdi-view-toc f-25 m-t-10 toggleSidebar p-10" style="border: 1px solid #77787a !important; border-radius: 15px;" data-target="mobileMenu" data-toggle="toggle"></i>
    </div>
</div>
@endnotmobile
