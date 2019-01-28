<? foreach($userWorkPosts as $userWorkPost) { ?>
        <div class="card-lg no-shadow no-shadow userWorkPost m-b-20" style="display: inline-block;" data-id="<?= $userWorkPost->id?>">
            <div class="card-block">
                <div class="col-sm-12 p-0">
                    <div class="avatar-sm m-r-10 m-l-10 popoverUser" style="background: url('<?= $userWorkPost->user->getProfilePicture()?>')"></div>
                    <p class="popoverUser col-sm-4 m-b-5" style="margin-top: 3px !important" data-toggle="popover" data-content='<?= $userWorkPost->user->getPopoverViewUserWork()?>'><?= $userWorkPost->user->firstname?></p>
                    <div class="hr col-sm-12 p-l-0"></div>
                </div>
                <div class="col-sm-12 p-relative desc p-0" style="min-height: 200px">
                    <? if(isset($user) && $user->id == $userWorkPost->user_id) { ?>
                        <i class="zmdi zmdi-more p-absolute f-20 c-pointer popoverMenu" data-toggle="popover" data-content='<?= $userWorkPost->getPopoverMenu()?>' style="top: -12px; right: 10px;"></i>
                    <? } ?>
                    <p class="f-17 m-t-15 m-b-5 descriptionUserWork-<?= $userWorkPost->id?>" style="padding: 5px !important; white-space: pre-line; word-break: break-all"><?= htmlspecialchars_decode($userWorkPost->description)?></p>
                    <? if(isset($user) && $user->id == $userWorkPost->user_id) { ?>
                        <div class="m-t-15 m-b-5 editUserWork-<?= $userWorkPost->id?> hidden">
                            <form action="/feed/editUserWorkPost" method="post">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <input type="hidden" name="userWorkId" value="<?= $userWorkPost->id?>">
                                <textarea id="description_id" class="col-sm-11 input" rows="6" name="newUserWorkDescription"><? if($userWorkPost->description != null) echo htmlspecialchars_decode($userWorkPost->description);?></textarea>
                                <div class="col-sm-12">
                                    <button class="pull-right btn btn-sm btn-inno m-r-15 m-b-10">Save</button>
                                </div>
                            </form>
                        </div>
                    <? } ?>
                    <div class="image p-relative">
                        <? if($userWorkPost->content != null) { ?>
                            <img class="lazyLoad"  data-src="<?= $userWorkPost->getImage()?>" style="width: 100%;">
                        <? } ?>
                        <div class="userSwitch p-absolute" style="left: -5px; bottom: -10px">
                            <? if((isset($user) && $user->id != $userWorkPost->user_id) || !isset($user)) { ?>
                            <label class="switch switch_type2 m-t-10  m-l-15" role="switch">
                                <input data-toggle="popover" <? if(isset($user) && $userWorkPost->user->hasSwitched()) echo "checked disabled"; ?> data-content='<?= \App\Services\UserConnections\ConnectionService::getPopoverSwitchView($userWorkPost->user)?>' type="checkbox" class="switch__toggle popoverSwitch">
                                <span class="switch__label"></span>
                            </label>
                            <? } ?>
                        </div>
                        <div class="m-t-5 p-absolute shadow" style="right: 5px; bottom: 0">
                            <a class="regular-link pull-right f-14 m-0 toggleComments" data-id="<?= $userWorkPost->id?>"><?= count($userWorkPost->getComments())?> Comments</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="collapse" id="commentCollapse-<?= $userWorkPost->id?>">
            <div class="card-lg" data-id="<?= $userWorkPost->id?>">
                <div class="card-block row">
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
                                    <textarea name="comment" placeholder="Write your comment..." class="comment input col-sm-11 messageInputDynamic" id="messageInput-<?= $userWorkPost->id?>" rows="1"></textarea>
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
<? } ?>
<? if(count($userWorkPosts) > 1) { ?>
    <div class=" d-flex js-center ">
        <img class="hidden loadingGear" src="/images/icons/loadingGear.gif" style="width: 30px !important; height: 30px !important" alt="">
    </div>
<? } ?>
<script defer async src="/js/lazyLoader.js"></script>
<script>

    $('.popoverSwitch').popover({ trigger: "manual" , html: true, animation:false, placement: 'top'})

    $('.popoverUser').popover({ trigger: "manual" , html: true, animation:false, placement: 'right'})
        .on("mouseenter", function () {
            var _this = $('.popoverUser');
            $(this).popover("show");
            $(".popover").on("mouseleave", function () {
                $(_this).popover('hide');
            });
        }).on("mouseleave", function () {
        var _this = this;
        setTimeout(function () {
            if (!$(".popover:hover").length) {
                $(_this).popover("hide");
            }
        }, 300);
    });

    $('.popoverMenu').popover({ trigger: "click" , html: true, animation:false, placement: 'right'});
    $('.popoverEmojis').popover({ trigger: "click" , html: true, animation:false, placement: 'auto'});


    $(document).on("click", ".closePopover", function () {
        var _this = $('.popoverUser');
        $(_this).popover("hide");
    });
</script>