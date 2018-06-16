<? foreach($teamProduct->getComments() as $comment) { ?>
    <? if(isset($user)) { ?>
        <? if($comment->sender_user_id == $user->id) { ?>
            <div class="row c-gray sendedMessageAjax">
                <div class="col-md-12">
                    <div class="col-md-5 messageSent pull-right m-b-10">
                        <p class="message break-word"><?= $comment->message?></p>
                        <span class="f-12 pull-right timeSent"><?=$comment->time_sent?></span>
                    </div>
                </div>
            </div>
        <? } else { ?>
            <div class="row c-gray">
                <div class="col-md-12">
                    <div class="col-md-5 pull-left m-b-10 messageReceived">
                        <? if($comment->user->team_id == $teamProduct->team_id && $comment->user->team_id != null) { ?>
                            <img src="<?= $comment->user->getProfilePicture()?>" alt="<?= $comment->user->firstname?>" class="circle circleSmall">
                            <p class="c-orange m-0"><?= $comment->user->getName()?> - <?= $teamProduct->team->team_name?></p>
                        <? } else { ?>
                            <img src="<?= $comment->user->getProfilePicture()?>" alt="<?= $comment->user->firstname?>" class="circle circleSmall">
                            <p class="c-orange m-0"><?= $comment->user->getName()?></p>
                        <? } ?>
                        <p class="break-word"><?= $comment->message?></p>
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
                    <? if($comment->user->team_id == $teamProduct->team_id && $comment->user->team_id != null) { ?>
                        <img src="<?= $comment->user->getProfilePicture()?>" alt="<?= $comment->user->firstname?>" class="circle circleSmall m-r-5">
                        <p class="c-orange m-0"><?= $comment->user->getName()?> - <?= $teamProduct->team->team_name?></p>
                    <? } else { ?>
                        <img src="<?= $comment->user->getProfilePicture()?>" alt="<?= $comment->user->firstname?>" class="circle circleSmall m-r-5">
                        <p class="c-orange m-0"><?= $comment->user->getName()?></p>
                    <? } ?>
                    </div>
                    <p class="break-word"><?= $comment->message?></p>
                    <span class="f-12 pull-right"><?=$comment->time_sent?></span>
                </div>
            </div>
        </div>
    <? } ?>
<? } ?>