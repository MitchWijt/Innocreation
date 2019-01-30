<div class="modal userWorkPostModal" id="userWorkPostModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-border">
            <i class="zmdi zmdi-close c-orange f-22 p-absolute" data-dismiss="modal" style="top: 3%; right: 3%; z-index: 1"></i>
            <div class="col-sm-12 p-0 d-flex m-l-10 align-start m-t-5 m-b-5">
                    <a href="<?= $userWorkPost->user->getUrl()?>" target="_blank">
                        <div class="avatar-header m-r-10 m-l-10 popoverUser" style="background: url('<?= $userWorkPost->user->getProfilePicture()?>')"></div>
                    </a>
                    <p class="m-b-0 m-t-5"><a href="<?= $userWorkPost->user->getUrl()?>" target="_blank" class="c-black"><?= $userWorkPost->user->getName()?></a></p>
            </div>
            <img src="<?= $userWorkPost->getImage()?>" style="width: 100%">
            <div class="col-sm-12 comments" data-id="<?= $userWorkPost->id?>">
                <div class="o-scroll userWorkComments p-10" data-id="<?= $userWorkPost->id?>" style="height: 350px;">

                </div>
                <? if(isset($user)) { ?>
                    <div class="hr col-sm-12 p-l-0"></div>
                    <form class="postCommentForm" action="/feed/postUserWorkComment" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="sender_user_id" class="sender_user_id" value="<?= $user->id?>">
                        <input type="hidden" name="user_work_id" class="user_work_id" value="<?= $userWorkPost->id?>">
                        <div class="text-center m-t-10 @mobile p-10 @endmobile">
                            <textarea name="comment" placeholder="Write your comment..." class="comment input col-sm-11 messageInputDynamic no-focus" id="messageInput-<?= $userWorkPost->id?>" rows="1"></textarea>
                        </div>
                        <div class="d-flex js-center @mobile m-r-20 @endmobile">
                            <div class="col-sm-11 p-r-0 m-b-10">
                                <button type="button" class="btn btn-inno btn-sm pull-right postComment">Comment</button>
                                <i class="iconCTAComments zmdi zmdi-mood c-pointer popoverEmojis pull-right m-r-10" data-toggle="popover" data-content='<?= view("/public/userworkFeed/shared/_popoverEmojiComments", compact("emojis", "userWorkPost"))?>'></i>
                            </div>
                        </div>
                    </form>
                <? } ?>
            </div>
        </div>
    </div>
</div>
<script>
    $('.popoverEmojis').popover({ trigger: "click" , html: true, animation:false, placement: 'auto'});
</script>