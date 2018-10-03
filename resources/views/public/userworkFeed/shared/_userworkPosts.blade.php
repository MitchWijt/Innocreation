<? foreach($userWorkPosts as $userWorkPost) { ?>
    <div class="col-md-7 m-b-20">
        <div class="card-lg userWorkPost" data-id="<?= $userWorkPost->id?>">
            <div class="card-block row">
                <div class="col-sm-12 m-t-15">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="avatar-sm m-r-10 m-l-10" style="background: url('<?= $userWorkPost->user->getProfilePicture()?>')"></div>
                            <p style="margin-top: 3px !important" data-toggle="popover" data-content='<?= $userWorkPost->user->getPopoverViewUserWork()?>'><?= $userWorkPost->user->firstname?></p>
                        </div>
                        <div class="col-sm-6 p-r-25">
                            <p class="pull-right m-b-0 upvoteNumber-<?= $userWorkPost->id?>" style="margin-top: 7px !important"><?= $userWorkPost->upvotes?></p>
                            <i class="zmdi zmdi-caret-up f-40 pull-right m-r-5"></i>
                        </div>
                    </div>
                    <div class="hr col-sm-12 p-l-0"></div>
                </div>
                <div class="col-sm-12 text-center">
                    <p class="f-17 m-t-15 m-b-5" style="padding: 5px !important; white-space: pre-line;"><?= htmlspecialchars_decode($userWorkPost->description)?></p>
                    <? if($userWorkPost->content != null) { ?>
                        <? if($userWorkPost->link != null) { ?>
                            <a target="_blank" href="<?= $userWorkPost->link?>">
                                <img style="width: 100% !important;" src="<?= $userWorkPost->getImage()?>" alt="<?= $userWorkPost->user->firstname?>">
                            </a>
                        <? } else { ?>
                            <img style="width: 100% !important;" src="<?= $userWorkPost->getImage()?>" alt="<?= $userWorkPost->user->firstname?>">
                        <? } ?>
                    <? } ?>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6 p-l-25 m-t-10">
                            <? if($userWorkPost->progress != null) { ?>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                         aria-valuemin="0" aria-valuemax="100" style="width:<?= $userWorkPost->progress?>;"><?= $userWorkPost->progress?> finished
                                    </div>
                                </div>
                            <? } ?>
                        </div>
                        <div class="col-sm-6 m-t-5 p-r-25">
                            <a class="regular-link pull-right f-14 m-0 toggleComments" data-id="<?= $userWorkPost->id?>"><?= count($userWorkPost->getComments())?> Comments</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row m-t-15 m-b-15">
                        <div class="col-sm-12 p-l-25 p-r-25 actionList actions-<?= $userWorkPost->id?>">
                            <input type="hidden" class="user_work_id" value="<?= $userWorkPost->id?>">
                            <? if(isset($user)) { ?>
                                <i class="zmdi zmdi-share c-pointer f-22 pull-left toggleModal" data-url="<?= $_SERVER["HTTP_HOST"]?>/innocreatives/<?= $userWorkPost->id?>" style="margin-top: 8px !important"></i>
                            <? } else { ?>
                                <i class="zmdi zmdi-share c-pointer f-22 pull-left toggleLink" data-url="<?= $_SERVER["HTTP_HOST"]?>/innocreatives/<?= $userWorkPost->id?>" style="margin-top: 10px !important"></i>
                            <? } ?>
                            <? if(isset($user) && $user->hasUpvote($userWorkPost->id)) { ?>
                                <p class="pull-right m-b-0 upvoteText c-orange c-pointer" style="margin-top: 7px !important">Upvoted</p>
                            <? } else { ?>
                                <p class="pull-right m-b-0 upvoteBtn upvoteText c-pointer" style="margin-top: 7px !important">Upvote</p>
                                <i class="zmdi zmdi-caret-up f-40 pull-right m-r-5 upvoteBtn upvoteIcon c-pointer"></i>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="collapse" id="commentCollapse-<?= $userWorkPost->id?>">
            <div class="card-lg userWorkPost" data-id="<?= $userWorkPost->id?>">
                <div class="card-block row">
                    <div class="col-sm-12 comments m-t-15" data-id="<?= $userWorkPost->id?>">
                        <div class="o-scroll m-t-20 userWorkComments p-10" data-id="<?= $userWorkPost->id?>" style="height: 350px;">

                        </div>
                        <? if(isset($user)) { ?>
                            <hr class="col-md-11">
                            <form class="postCommentForm" action="/feed/postUserWorkComment" method="post">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <input type="hidden" name="sender_user_id" class="sender_user_id" value="<?= $user->id?>">
                                <input type="hidden" name="user_work_id" class="user_work_id" value="<?= $userWorkPost->id?>">
                                <div class="text-center m-t-10">
                                    <textarea name="comment" placeholder="Write your comment..." class="comment input col-sm-11" rows="1"></textarea>
                                </div>
                                <div class="d-flex js-center">
                                    <div class="col-sm-11 p-r-0 m-b-10">
                                        <button type="button" class="btn btn-inno btn-sm pull-right postComment">Comment</button>
                                    </div>
                                </div>
                            </form>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<? } ?>
<? if(count($userWorkPosts) > 1) { ?>
    <div class="col-sm-12 d-flex js-center m-b-20">
        <img class="hidden loadingGear" src="/images/icons/loadingGear.gif" style="width: 30px !important; height: 30px !important" alt="">
    </div>
<? } ?>
<script>
    $('[data-toggle="popover"]').popover({ trigger: "manual" , html: true, animation:false, placement: 'auto'})
        .on("mouseenter", function () {
            var _this = $('[data-toggle="popover"]');
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

    $(document).on("click", ".closePopover", function () {
        var _this = $('[data-toggle="popover"]');
        $(_this).popover("hide");
    });
</script>
