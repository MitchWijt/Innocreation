<? foreach($userChats as $userchat) { ?>
    <form action="/notification/toChat" method="post" class="toChat-<?= $userchat['userchat']->id?><??>">
        <input type="hidden" name="_token" value="<?= csrf_token()?>">
        <input type="hidden" name="userChatId" value="<?= $userchat['userchat']->id?>">
        <div class="row p-t-10 notificationHover c-pointer toChat" data-chat-id="<?= $userchat['userchat']->id?>" style="border-bottom: 1px solid #77787a">
            <div class="col-3 p-l-10 d-flex js-center">
                    <div class="avatar-header img m-t-0 p-t-0 m-l-15 m-b-10" style="background: url('<?= $userchat['user']->getProfilePicture()?>'); border-color: #000 !important"></div>
            </div>
            <div class="col-9 p-r-0">
                <p class="f-16 m-b-0"><?= $userchat['user']->getName()?> <i class="zmdi zmdi-circle f-13 c-orange unreadNotification unseen-<?= $userchat['userchat']->id?> <? if($userchat['userchat']->getUnreadMessages($userId) < 1 ) echo "hidden";?>" data-user-chat-id="<?= $userchat['userchat']->id?>"></i></p>
            <? if($userchat['recentChat']->sender_user_id == $userId) { ?>
                    <div class="d-flex">
                        <p class="f-12 p-0 m-b-0" style="color: #77787a !important"><?= $userchat['recentChat']->message?></p>
                        <? if($userchat['recentChat']->seen_at != null) { ?>
                            <div class="avatar-msg-seen img p-t-0" style="background: url('<?= $userchat['user']->getProfilePicture()?>'); margin-top: 2px !important"></div>
                        <? } ?>
                    </div>
                <? } else { ?>
                    <p class="f-12 p-0 m-b-0" style="color: #77787a !important"><?= $userchat['recentChat']->message?><i class="zmdi zmdi-check-all c-dark-grey f-12 m-l-5"></i></p>
                <? } ?>
                <span class="c-dark-grey f-12 pull-right m-r-20"><?= $userchat['recentChat']->time_sent?></span>
            </div>
        </div>
    </form>
<? } ?>


