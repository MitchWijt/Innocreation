<div class="row c-gray emptyMessage hidden">
    <div class="col-md-12">
        <div class="col-md-5 messageSent pull-right m-b-10">
            <p class="message break-word"></p>
            <span class="f-12 pull-right timeSent"></span>
        </div>
    </div>
</div>
<? foreach($userWork->getComments() as $comment) { ?>
    <? if(isset($user)) { ?>
        <? if($comment->sender_user_id == $user->id) { ?>
            <div class="row m-t-20 sendedMessageAjax">
                <div class="col-sm-12">
                    <div class="@mobile col-10 @elsedesktop col-sm-5 @endmobile messageSent pull-right m-b-10">
                        <p class="message break-word c-gray"><?= $comment->message?></p>
                        <span class="f-12 pull-right timeSent c-gray"><?=$comment->time_sent?></span>
                    </div>
                </div>
            </div>
            <? } else { ?>
            <div class="row m-t-20 messageReceivedAjax">
                <div class="col-sm-12 ">
                    <div class="@mobile col-10 @elsedesktop col-sm-5 @endmobile pull-left m-b-10 messageReceived">
                        <div class="d-flex m-b-10 m-t-5">
                            <img src="<?= $comment->user->getProfilePicture()?>" alt="<?= $comment->user->firstname?>" class="circle circleSmall m-r-5">
                            <p class="c-orange m-0"><?= $comment->user->getName()?></p>
                        </div>
                        <p class="break-word c-gray"><?= $comment->message?></p>
                        <span class="f-12 pull-right c-gray"><?=$comment->time_sent?></span>
                    </div>
                </div>
            </div>
        <? } ?>
    <? } else { ?>
        <div class="row c-gray">
            <div class="col-md-12">
                <div class="col-md-5 pull-left m-b-10 messageReceived">
                    <div class="d-flex fd-row">
                        <img src="<?= $comment->user->getProfilePicture()?>" alt="<?= $comment->user->firstname?>" class="circle circleSmall m-r-5">
                        <p class="c-orange m-0"><?= $comment->user->getName()?></p>
                    </div>
                    <p class="break-word c-gray"><?= $comment->message?></p>
                    <span class="f-12 pull-right c-gray"><?=$comment->time_sent?></span>
                </div>
            </div>
        </div>
    <? } ?>
<? } ?>


