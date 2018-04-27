<? foreach($supportTicket->getMessages() as $message) { ?>
    <? if($message->sender_user_id == $user->id) { ?>
        <div class="row c-gray sendedMessageAjax">
            <div class="col-sm-12">
                <div class="col-sm-5 messageSent pull-right m-b-10">
                    <p class="message break-word"><?= $message->message?></p>
                    <span class="f-12 pull-right timeSent"><?=$message->time_sent?></span>
                </div>
            </div>
        </div>
        <? } else { ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-5 pull-left m-b-10 messageReceivedInnocreation">
                    <p class="break-word"><?= $message->message?></p>
                    <span class="f-12 pull-right"><?=$message->time_sent?></span>
                </div>
            </div>
        </div>
    <? } ?>
<? } ?>