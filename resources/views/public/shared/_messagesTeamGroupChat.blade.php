<? foreach($groupChat->getGroupChatMessages() as $message) { ?>
    <? if($message->sender_user_id == $user->id) { ?>
        <div class="row m-t-20">
            <div class="col-sm-12">
                <div class="col-sm-5 messageSent pull-right m-b-10">
                    <p><?= $message->message?></p>
                    <span class="f-12 pull-right"><?=$message->time_sent?></span>
                </div>
            </div>
        </div>
    <? } else { ?>
        <div class="row">
            <div class="col-sm-12">
                <? if($message->sender) { ?>
                    <div class="col-sm-5 pull-left m-b-10 messageReceived">
                        <? if($message->sender->First()->id == $team->ceo_user_id) { ?>
                            <p class="c-orange m-0"><?= $message->sender->First()->getName()?> - Team leader:</p>
                        <? } else { ?>
                            <p class="c-orange m-0"><?= $message->sender->First()->getName()?> - <?= $message->sender->First()->getJoinedExpertise()->expertises->First()->title?>:</p>
                        <? } ?>
                        <p><?= $message->message?></p>
                        <span class="f-12 pull-right"><?=$message->time_sent?></span>
                    </div>
                <? } else { ?>
                    <div class="col-sm-5 pull-left m-b-10 messageReceived">
                        <p class="c-orange m-0">User doesn't exist anymore</p>
                        <p><?= $message->message?></p>
                        <span class="f-12 pull-right"><?=$message->time_sent?></span>
                    </div>
                <? } ?>
            </div>
        </div>
    <? } ?>
<? } ?>