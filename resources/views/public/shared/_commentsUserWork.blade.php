<div class="row c-gray emptyMessage hidden">
    <div class="col-md-12">
        <div class="col-md-5 messageSent pull-right m-b-10">
            <p class="message break-word"></p>
            <span class="f-12 pull-right timeSent"></span>
        </div>
    </div>
</div>
<? foreach($userWork->getComments() as $comment) { ?>
    <div class="row c-gray d-flex m-l-20">
        <div class="d-flex">
            <img src="<?= $comment->user->getProfilePicture()?>" alt="<?= $comment->user->firstname?>" class="circle circleSmall m-r-5">
            <p class="m-0"><?= $comment->user->getName()?></p>
        </div>
        <div class="col-md-10">
            <p class="break-word thin"><?= $comment->message?></p>
        </div>
    </div>
<? } ?>


