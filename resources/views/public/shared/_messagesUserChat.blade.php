<? foreach($userChat->getMessages() as $message) { ?>
    <? if($admin == 0) { ?>
        <? if($userChat->creator_user_id == 1) { ?>
            <? if($message->sender_user_id == $user_id) { ?>
                <div class="row m-t-20 sendedMessageAjax">
                    <div class="col-sm-12">
                        <div class="col-sm-5 messageSent pull-right m-b-10">
                            <p class="message"><?= $message->message?></p>
                            <span class="f-12 pull-right timeSent"><?=$message->time_sent?></span>
                        </div>
                    </div>
                </div>
            <? } else { ?>
                <div class="row m-t-20">
                    <div class="col-sm-12">
                        <div class="col-sm-5 messageReceivedInnocreation messageReceived pull-left m-b-10">
                            <p class="message"><?= $message->message?></p>
                            <span class="f-12 pull-right timeSent"><?=$message->time_sent?></span>
                        </div>
                    </div>
                </div>
            <? } ?>
        <? } else { ?>
            <? if($message->sender_user_id == $user_id) { ?>
                <div class="row m-t-20 sendedMessageAjax">
                    <div class="col-sm-12">
                        <div class="col-sm-5 messageSent pull-right m-b-10">
                            <p class="message"><?= $message->message?></p>
                            <span class="f-12 pull-right timeSent"><?=$message->time_sent?></span>
                        </div>
                    </div>
                </div>
            <? } else { ?>
                <div class="row messageReceived m-b-10 m-r-200 m-l-30 m-t-15">
                    <div class="col-sm-8">
                        <p class="message"><?=$message->message?></p>
                    </div>
                    <div class="col-sm-4">
                        <span class="f-12 timeSent"><?=$message->time_sent?></span>
                    </div>
                </div>
            <? } ?>
        <? } ?>
    <? } else { ?>
        <? if($message->sender_user_id == 1) { ?>
            <div class="row m-t-20">
                <div class="col-sm-12">
                    <div class="col-sm-5 messageReceivedInnocreation pull-right m-b-10">
                        <p><?= $message->message?></p>
                        <span class="f-12 pull-right"><?=$message->time_sent?></span>
                    </div>
                </div>
            </div>
        <? } else { ?>
            <div class="row m-t-20">
                <div class="col-sm-12">
                    <div class="col-sm-5 messageSent pull-left m-b-10">
                        <p><?= $message->message?></p>
                        <span class="f-12 pull-right"><?=$message->time_sent?></span>
                    </div>
                </div>
            </div>
        <? } ?>
    <? } ?>
<? } ?>