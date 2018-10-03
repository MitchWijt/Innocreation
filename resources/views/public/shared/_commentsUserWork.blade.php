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
<div class="row c-gray sendedMessageAjax">
    <div class="col-md-12">
        <div class="col-md-5 messageSent pull-right m-b-10">
            <p class="message break-word"><?= $comment->description?></p>
            <span class="f-12 pull-right timeSent"><?=$comment->time_sent?></span>
        </div>
    </div>
</div>
<? } else { ?>
<div class="row c-gray">
    <div class="col-md-12">
        <div class="col-md-5 pull-left m-b-10 messageReceived">
            <img src="<?= $comment->user->getProfilePicture()?>" alt="<?= $comment->user->firstname?>" class="circle circleSmall">
            <p class="c-orange m-0"><?= $comment->user->getName()?></p>
            <p class="break-word"><?= $comment->description?></p>
            <span class="f-12 pull-right"><?=$comment->time_sent?></span>
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
                <p class="break-word"><?= $comment->description?></p>
                <span class="f-12 pull-right"><?=$comment->time_sent?></span>
            </div>
        </div>
    </div>
<? } ?>
<? } ?>