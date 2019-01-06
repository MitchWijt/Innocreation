<? foreach($userChats as $userChat) {
     if($userChat->creator_user_id == $userId) {
         $user = $userChat->receiver;
         $receiver = $userChat->creator;
     } else {
         $user = $userChat->creator;
         $receiver = $userChat->receiver;
     }
     if(isset($user)) { ?>
        <? $recentChat = $userChat->getMostRecentMessage($userChat->id); ?>
        <? if(isset($recentChat->message) && strlen($recentChat->message) != 0) { ?>
            <div class="row p-t-10 notificationHover" style="border-bottom: 1px solid #77787a">
                <div class="col-sm-3 p-l-10">
                    <div class="avatar-header img m-t-0 p-t-0 m-l-15 m-b-10" style="background: url('<?= $user->getProfilePicture()?>'); border-color: #000 !important"></div>
                </div>
                <div class="col-sm-9 p-r-0">
                    <p class="f-16 m-b-0"><?= $user->getName()?></p>
                        <? if($recentChat->sender_user_id == $userId) { ?>
                            <div class="d-flex">
                                <p class="f-12 p-0 m-b-0" style="color: #77787a !important"><?= $recentChat->message?></p>
                                <div class="avatar-msg-seen img p-t-0" style="background: url('<?= $user->getProfilePicture()?>'); margin-top: 2px !important"></div>
                            </div>

                        <? } else { ?>
                            <p class="f-12 p-0 m-b-0" style="color: #77787a !important"><?= $recentChat->message?></p>
                        <? } ?>
                    <p></p>
                </div>
            </div>
        <? } ?>
    <? } ?>
 <? } ?>
