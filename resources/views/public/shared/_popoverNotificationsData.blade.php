<? foreach($notifications as $notification) { ?>
    <?
        $today = new DateTime(date("Y-m-d H:i:s"));
        $date = new DateTime(date("Y-m-d H:i:s",strtotime($notification['time'])));
        $interval = $date->diff($today);
        if(isset($notification['receiver'])){
            $sender = ['firstname' => "Innocreation", 'profilePic' => '/images/cartwheel.png'];
            if($notification['receiver'] != 1){
                $sender = \App\User::select("*")->where("id", $notification['receiver'])->first();
            }
        ?>
            <a class="td-none notificationLink" href="/my-account/chats?user_chat_id=<?= $notification['userChat']?>">
                <div class="row p-b-10 notificationHover" style="border-bottom: 1px solid #FF6100 !important">
                    <div class="col-2 m-b-5 m-t-15">
                        <? if($notification['receiver'] != 1) { ?>
                            <div class="avatar-header img m-t-0 p-t-0 m-l-15" style="background: url('<?= $sender->getProfilePicture()?>'); border-color: #000 !important"></div>
                        <? } else { ?>
                            <div class="avatar-header img m-t-0 p-t-0 m-l-15" style="background: url('<?= $sender['profilePic']?>'); border-color: #000 !important"></div>
                        <? } ?>
                    </div>
                    <div class="col-10 text-center m-t-15">
                        <? if($notification['verb'] == "userMessage") { ?>
                            <? if($notification['receiver'] != 1) { ?>
                                <p><?= $sender->firstname?> has sent you a message!</p>
                            <? } else { ?>
                                <p><?= $sender['firstname']?> has sent you a message!</p>
                            <? } ?>
                        <? } else { ?>
                            <? if($notification['receiver'] != 1) { ?>
                                <p>New notification from <?= $sender->firstname?> </p>
                            <? } else { ?>
                                <p>New notification from <?= $sender['firstname']?> </p>
                            <? } ?>
                        <? } ?>
                        <div class="pull-right">
                            <i class="c-dark-grey f-12"><?= \App\Services\GenericService::dateDiffToString($interval)?></i>
                        </div>
                    </div>
                </div>
            </a>
        <? } ?>
<? } ?>
