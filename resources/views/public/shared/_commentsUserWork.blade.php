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
            <div class="avatar-sm m-r-5" style="background: url('<?= $comment->user->getProfilePicture()?>')"></div>
            <p class="m-0"><?= $comment->user->getName()?></p>
        </div>
        <div class="col-md-10">
            <p class="break-word thin"><?= $comment->message?></p>
        </div>
    </div>
<? } ?>


