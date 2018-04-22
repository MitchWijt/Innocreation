<? foreach($userChat->getMessages() as $message) { ?>
    <? if($message->sender_user_id == $user_id) { ?>
    <div class="row m-t-20">
        <div class="col-sm-12">
            <div class="col-sm-5 messageSent pull-right m-b-10">
                <p><?= $message->message?></p>
                <span class="f-12 pull-right"><?=$message->time_sent?></span>
            </div>
        </div>
    </div>
    <? } else { ?>
    <div class="row messageReceived m-b-10 m-r-200 m-l-30 m-t-15">
        <div class="col-sm-8">
            <p class=""><?=$message->message?></p>
        </div>
        <div class="col-sm-4">
            <span class="f-12"><?=$message->time_sent?></span>
        </div>
    </div>
    <? } ?>
<? } ?>