<? foreach($assistanceTicket->getMessages() as $message) { ?>
    <? if($message->sender_user_id == $user->id) { ?>
        <div class="row c-gray sendedMessageAjax">
            <div class="col-md-12">
                <div class="col-md-5 messageSent pull-right m-b-10">
                    <p class="message break-word"><?= $message->message?></p>
                    <span class="f-12 pull-right timeSent"><?=$message->time_sent?></span>
                </div>
            </div>
        </div>
    <? } else { ?>
        <div class="row c-gray">
            <div class="col-md-12">
                <div class="col-md-5 pull-left m-b-10 messageReceived">
                    <? if($message->sender->First()->id == $team->ceo_user_id) { ?>
                        <p class="c-orange m-0"><?= $message->sender->First()->getName()?> - Team leader:</p>
                    <? } else { ?>
                        <p class="c-orange m-0"><?= $message->sender->First()->getName()?></p>
                    <? } ?>
                    <p class="break-word"><?= $message->message?></p>
                    <span class="f-12 pull-right"><?=$message->time_sent?></span>
                </div>
            </div>
        </div>
    <? } ?>
<? } ?>