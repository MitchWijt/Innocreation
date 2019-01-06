<? $userchats = []?>
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
            <? array_push($userchats, array('userchat' => $userChat, 'timeSentLast' => date("Y-m-d", strtotime($recentChat->created_at)), "recentChat" => $recentChat, 'user' => $user))?>
        <? } ?>
    <? } ?>
 <? } ?>
<?
usort($userchats, function($a, $b) {
    return ($a['timeSentLast'] > $b['timeSentLast']) ? -1 : 1;
});
?>

<? foreach($userchats as $userchat) {
    $userChat = $userchat['userchat']; ?>
    <div class="row p-t-10 notificationHover" style="border-bottom: 1px solid #77787a">
        <div class="col-3 p-l-10 d-flex js-center">
            <div class="avatar-header img m-t-0 p-t-0 m-l-15 m-b-10" style="background: url('<?= $userchat['user']->getProfilePicture()?>'); border-color: #000 !important"></div>
        </div>
        <div class="col-9 p-r-0">
            <p class="f-16 m-b-0"><?= $userchat['user']->getName()?></p>
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

<? } ?>


