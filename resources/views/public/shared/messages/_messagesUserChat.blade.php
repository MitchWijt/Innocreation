<div class="row m-t-20 newChatMessage m-r-0 hidden">
    <div class="col-sm-12">
        <div class="col-sm-5 messageSent pull-right m-b-10 messageStyle">
            <p class="message c-white"></p>
            <span class="f-12 pull-right timeSent c-gray"></span>
        </div>
    </div>
</div>
<? foreach($userMessages as $message) { ?>
    <? if($admin == 0) { ?>
        <? if(isset($team)) { ?>
            <? if($message->sender_user_id == $user_id) { ?>
                <div class="row m-t-20 sendedMessageAjax m-r-0">
                    <div class="col-sm-12">
                        <div class="col-sm-5 messageSent pull-right m-b-10 messageStyle">
                            <p class="message c-white"><?= $message->message?></p>
                            <span class="f-12 pull-right timeSent c-gray"><?=$message->time_sent?></span>
                        </div>
                    </div>
                </div>
            <? } else { ?>
                <div class="row m-t-20 messageReceivedAjax m-r-0">
                    <div class="col-sm-12 ">
                        <div class="@mobile col-10 @elsedesktop col-sm-5 @endmobile pull-left m-b-10 messageReceived messageStyle">
                            <? if($message->sender->First()) { ?>
                                <p class="c-orange m-0"><?= $message->sender->First()->getName()?>:</p>
                            <? } else { ?>
                                <p class="c-orange m-0">User doesn't exist anymore</p>
                            <? } ?>
                            <p class="message c-white"><?= $message->message?></p>
                            <span class="f-12 pull-right timeSent c-gray"><?=$message->time_sent?></span>
                        </div>
                    </div>
                </div>
            <? } ?>
        <? } else { ?>
            <? if( isset($userChat) && $message->userChat->creator_user_id == 1) { ?>
                <? if($message->sender_user_id == $user_id) { ?>
                    <div class="row m-t-20 sendedMessageAjax m-r-0">
                        <div class="col-sm-12">
                            <div class="col-sm-5 messageSent pull-right m-b-10 messageStyle">
                                <p class="message c-white"><?= $message->message?></p>
                                <span class="f-12 pull-right timeSent c-gray"><?=$message->time_sent?></span>
                            </div>
                        </div>
                    </div>
                <? } else { ?>
                    <div class="row m-t-20 m-r-0">
                        <div class="col-sm-12">
                            <div class="col-sm-5 messageReceivedInnocreation messageReceived pull-left m-b-10 messageStyle">
                                <p class="message c-white"><?= $message->message?></p>
                                <span class="f-12 pull-right timeSent c-gray"><?=$message->time_sent?></span>
                            </div>
                        </div>
                    </div>
                <? } ?>
            <? } else { ?>
                <? if($message->sender_user_id == $user_id) { ?>
                    <div class="row m-t-20 m-r-0 sendedMessageAjax">
                        <div class="col-sm-12 ">
                            <div class="@mobile col-10 @elsedesktop col-sm-5 @endmobile messageSent pull-right m-b-10 messageStyle">
                                <p class="message c-white"><?= $message->message?></p>
                                <span class="f-12 pull-right timeSent c-gray"><?=$message->time_sent?></span>
                            </div>
                        </div>
                    </div>
                <? } else { ?>
                    <div class="row m-t-20 messageReceivedAjax m-r-0">
                        <div class="col-sm-12 ">
                            <div class="@mobile col-10 @elsedesktop col-sm-5 @endmobile pull-left m-b-10 messageReceived messageStyle">
                                <p class="message c-white"><?= $message->message?></p>
                                <span class="f-12 pull-right timeSent c-gray"><?=$message->time_sent?></span>
                            </div>
                        </div>
                    </div>
                <? } ?>
            <? } ?>
        <? }  ?>
    <? } else { ?>
        <? if($message->sender_user_id == 1) { ?>
            <div class="row m-t-20 m-r-0">
                <div class="col-sm-12">
                    <div class="col-sm-5 messageReceivedInnocreation messageSent pull-right m-b-10 messageStyle">
                        <p class="message"><?= $message->message?></p>
                        <span class="f-12 pull-right timeSent"><?=$message->time_sent?></span>
                    </div>
                </div>
            </div>
        <? } else { ?>
            <div class="row m-t-20 messageReceivedAjax m-r-0">
                <div class="col-sm-12 ">
                    <div class="col-sm-5 pull-left m-b-10 messageReceived messageStyle">
                        <p class="message"><?= $message->message?></p>
                        <span class="f-12 pull-right timeSent"><?=$message->time_sent?></span>
                    </div>
                </div>
            </div>
        <? } ?>
    <? } ?>
<? } ?>