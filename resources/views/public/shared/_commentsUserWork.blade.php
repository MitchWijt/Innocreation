
    <div class="row c-gray d-flex m-l-20 emptyMessage" style="display: none !important;">
        <div class="d-flex">
            <div class="avatar-sm m-r-5 userProfilePic2"></div>
            <p class="m-0 userNameComment"></p>
        </div>
        <div class="col-md-10">
            <p class="break-word message thin"></p>
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


