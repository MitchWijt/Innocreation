<? $array = [];?>
<? foreach($notifications as $notification) { ?>
    <? array_push($array, ['object' => $notification, 'category' => 'message', 'time' => date("Y-m-d H:i:s",strtotime($notification['time']))]); ?>
<? } ?>
<? foreach($connections as $connection) { ?>
    <? array_push($array, ['object' => $connection, 'category' => 'connection', 'time' => date("Y-m-d H:i:s", strtotime($connection->created_at))]); ?>
<? }
    usort($array, function($a, $b) {
        return ($a['time'] > $b['time']) ? -1 : 1;
    });
?>
<? foreach($array as $item) { ?>
    <? if($item['category'] == 'message') { ?>
        <?
            $today = new DateTime(date("Y-m-d H:i:s"));
            $date = new DateTime(date("Y-m-d H:i:s",strtotime($item['time']. "+1 hours")));
            $interval = $date->diff($today);
            if(isset($item['object']['receiver'])){
                $sender = ['firstname' => "Innocreation", 'profilePic' => '/images/cartwheel.png'];
                if($item['object']['receiver'] != 1){
                    $sender = \App\User::select("*")->where("id", $item['object']['receiver'])->first();
            } ?>
            <a class="td-none notificationLink" href="/my-account/chats?user_chat_id=<?= $item['object']['userChat']?>">
                <div class="row p-b-10 notificationHover" style="border-bottom: 1px solid #FF6100 !important">
                    <div class="col-2 m-b-5 m-t-15">
                        <? if($item['object']['receiver'] != 1) { ?>
                            <div class="avatar-header img m-t-0 p-t-0 m-l-15" style="background: url('<?= $sender->getProfilePicture()?>'); border-color: #000 !important"></div>
                        <? } else { ?>
                            <div class="avatar-header img m-t-0 p-t-0 m-l-15" style="background: url('<?= $sender['profilePic']?>'); border-color: #000 !important"></div>
                        <? } ?>
                    </div>
                    <div class="col-10 text-center m-t-15">
                        <? if($item['object']['verb'] == "userMessage") { ?>
                            <? if($item['object']['receiver'] != 1) { ?>
                                <p><?= $sender->firstname?> has sent you a message!</p>
                            <? } else { ?>
                                <p><?= $sender['firstname']?> has sent you a message!</p>
                            <? } ?>
                        <? } else { ?>
                            <? if($item['object']['receiver'] != 1) { ?>
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
    <? } else if ($item['category'] == 'connection') { ?>
        <?
        $today = new DateTime(date("Y-m-d H:i:s"));
        $date = new DateTime(date("Y-m-d H:i:s",strtotime($item['time'])));
        $interval = $date->diff($today);
        ?>
            <div class="row p-b-10 notificationHover" style="border-bottom: 1px solid #FF6100 !important">
                <div class="col-2 m-b-5 m-t-15">
                    <div class="avatar-header img m-t-0 p-t-0 m-l-15" style="background: url('<?= $item['object']->sender->getProfilePicture()?>'); border-color: #000 !important"></div>
                </div>
                <div class="col-10 text-center m-t-15">
                    <p class="m-0">New request from <?= $item['object']->sender->firstname?> </p>
                    <label class="switch switch_type2 m-t-0" role="switch">
                        <input type="checkbox" class="switch__toggle acceptConnectionNotification" data-id="<?= $item['object']->id?>">
                        <span class="switch__label"></span>
                    </label>
                </div>
                <form action="/user/acceptConnection" method="post" class="acceptConnection-<?= $item['object']->id?> hidden">
                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                    <input type="hidden" name="connection_id" value="<?= $item['object']->id?>">
                </form>
                <div class="col-12">
                    <div class="pull-right">
                        <i class="c-dark-grey f-12 pull-right"><?= \App\Services\GenericService::dateDiffToString($interval)?></i>
                    </div>
                </div>
            </div>
    <? } ?>
<? } ?>

