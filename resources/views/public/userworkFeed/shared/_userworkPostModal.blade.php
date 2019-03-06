<div class="modal userWorkPostModal o-scroll <?= \App\Services\UserAccount\UserAccount::getTheme();?>" id="userWorkPostModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <i class="zmdi zmdi-close c-pointer c-orange f-30" data-dismiss="modal" @desktop style="top: 1%; right: 1%; z-index: 1; position: fixed !important" @elsemobile style="top: 5%; right: 5%; z-index: 1; position: fixed !important" @enddesktop></i>
    <div class="modal-dialog modal-lg fixed-modal modal-dialog-centered custom-dialog-margin" role="document">
        <div class="modal-content modal-content-border">
            <div class="d-flex align-start js-between">
                <div class="p-0 d-flex m-l-10 align-start m-t-5 m-b-5">
                    <a href="<?= $userWorkPost->user->getUrl()?>" target="_blank">
                        <div class="avatar-header m-r-10 m-l-10 popoverUser" style="background: url('<?= $userWorkPost->user->getProfilePicture()?>')"></div>
                    </a>
                    <p class="m-b-0 m-t-10 vertically-center titleGrayBlack"><a href="<?= $userWorkPost->user->getUrl()?>" target="_blank" class="c-black"><?= $userWorkPost->user->getName()?></a></p>
                </div>
                <div class="d-flex align-start">
                    <div class="m-t-5">
                        <? if(isset($user)) { ?>
                        <? if($user->hasPlusPointed($userWorkPost->id)) { ?>
                            <section class="fave active-fave" data-id="<?= $userWorkPost->id?>"></section>
                        <? } else { ?>
                            <section class="fave normal-fave" data-id="<?= $userWorkPost->id?>"></section>
                        <? } ?>
                        <? } ?>
                    </div>
                    <?= \App\Services\UserConnections\ConnectionService::getSwitch($userWorkPost->user->id)?>
                </div>

            </div>
            <div class="p-20 text-center no-select">
                <img class="no-select" src="<?= $userWorkPost->getPlaceholder()?>" data-layzr="<?= $userWorkPost->getImage()?>" style="max-width: 75vw; max-height: 85vh">
            </div>
            <div class="comments" data-id="<?= $userWorkPost->id?>">
                <? if(count($userWorkPost->getComments()) > 0) {
                    $height = 350;
                } else {
                    $height = 100;
                }
                ?>
                <div class="o-scroll userWorkComments p-20" data-id="<?= $userWorkPost->id?>" style="height: <?= $height?>px; max-width: 75vw">

                </div>
                <? if(isset($user)) { ?>
                    <div class="hr col-sm-12 p-l-0"></div>
                    <form class="postCommentForm m-t-20" action="/feed/postUserWorkComment" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="sender_user_id" class="sender_user_id" value="<?= $user->id?>">
                        <input type="hidden" name="user_work_id" class="user_work_id" value="<?= $userWorkPost->id?>">
                        <div class="text-center m-t-10 @mobile p-10 @endmobile">
                            <textarea name="comment" placeholder="Write your comment..." class="comment input col-sm-11 messageInputDynamic no-focus" id="messageInput-<?= $userWorkPost->id?>" rows="1"></textarea>
                        </div>
                        <div class="m-t-15 d-flex js-center @mobile m-r-20 @endmobile">
                            <div class="col-sm-11 p-r-0 m-b-10">
                                <button type="button" class="btn btn-inno btn-sm pull-right postComment">Comment</button>
                                <i class="iconCTA c-black zmdi zmdi-mood c-pointer popoverEmojis pull-right m-r-10" data-toggle="popover" data-content='<?= view("/public/userworkFeed/shared/_popoverEmojiComments", compact("emojis", "userWorkPost"))?>'></i>
                            </div>
                        </div>
                    </form>
                <? } ?>
            </div>
        </div>
    </div>
</div>
<script defer async src="/js/lazyLoader.js"></script>
<script>
    $('.popoverEmojis').popover({ trigger: "click" , html: true, animation:false, placement: 'auto'});
</script>