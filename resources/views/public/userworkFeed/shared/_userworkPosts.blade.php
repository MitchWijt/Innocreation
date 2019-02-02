<? foreach($userWorkPosts as $userWorkPost) { ?>
        <div class="card-lg no-shadow no-shadow userWorkPost m-b-20" style="display: inline-block;" data-id="<?= $userWorkPost->id?>">
            <div class="card-block">
                <div class="col-sm-12  m-t-10 p-0 p-absolute d-flex js-between align-start">
                    <div class="d-flex">
                        <a href="<?= $userWorkPost->user->getUrl()?>" target="_blank">
                            <div class="avatar-header m-r-10 m-l-10 popoverUser" style="background: url('<?= $userWorkPost->user->getProfilePicture()?>')"></div>
                        </a>
                        <div class="d-flex fd-column">
                            <p class="m-b-0"><a href="<?= $userWorkPost->user->getUrl()?>" target="_blank" class="c-gray"><?= $userWorkPost->user->getName()?></a></p>
                            <span class="f-12 c-dark-grey"><?= count(\App\Services\UserConnections\ConnectionService::acceptedConnections($userWorkPost->user_id))?> connections</span>
                        </div>
                    </div>
                    <? if(isset($user) && $user->id == $userWorkPost->user_id) { ?>
                        <i class="zmdi zmdi-more f-22 m-r-10 c-pointer popoverMenu" data-toggle="popover" data-content='<?= $userWorkPost->getPopoverMenu()?>'></i>
                    <? } ?>
                </div>
                <div class="col-sm-12 p-relative desc p-0">
                    <p class="f-17 m-t-15 m-b-5 descriptionUserWork-<?= $userWorkPost->id?>" style="padding: 5px !important; white-space: pre-line; word-break: normal"><?= htmlspecialchars_decode($userWorkPost->description)?></p>
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
                            <img class="zoom" data-id="<?= $userWorkPost->id?>" src="<?= $userWorkPost->getPlaceholder()?>" data-layzr="<?= $userWorkPost->getImage()?>" style="width: 100%;">
                        <? } ?>
                    </div>
                    <div class="col-sm-12">
                        <div class="m-t-5 m-b-5 d-flex align-start">
                            <a class="regular-link f-14 c-dark-grey m-0 zoom" data-id="<?= $userWorkPost->id?>"><?= count($userWorkPost->getComments())?> Comments</a>
                            <i class="zmdi zmdi-circle f-5 vertically-center c-dark-grey m-l-5 m-t-8 m-r-5"></i>
                            <a class="regular-link f-14 c-dark-grey m-0" data-id="<?= $userWorkPost->id?>"><?= count($userWorkPost->getComments())?> Likes</a>
                        </div>
                    </div>
                    <? if(count($userWorkPost->getComments()) > 0) { ?>
                        <div class="col-sm-12 gradientToTransparant zoom" data-id="<?= $userWorkPost->id?>" >
                            <? foreach(\App\Services\FeedServices\UserworkPost::getRecentComments($userWorkPost->id) as $comment) { ?>
                                <? if(isset($user) && $comment->sender_user_id == $user->id) { ?>
                                    <div class="row sendedMessageAjax">
                                        <div class="col-sm-12">
                                            <div class="@mobile col-10 @elsedesktop col-sm-8 @endmobile messageSent pull-right m-b-10 messageStyle">
                                                <p class="message break-word c-gray m-b-0"><?= $comment->message?></p>
                                                <span class="f-12 pull-right timeSent c-"><?=$comment->time_sent?></span>
                                            </div>
                                        </div>
                                    </div>
                                <? } else { ?>
                                    <div class="row messageReceivedAjax">
                                        <div class="col-sm-12 ">
                                            <div class="@mobile col-10 @elsedesktop col-sm-8 @endmobile pull-left m-b-10 messageReceived messageStyle">
                                                <div class="d-flex m-b-10 m-t-5">
                                                    <img src="<?= $comment->user->getProfilePicture()?>" alt="<?= $comment->user->firstname?>" class="circle circleSmall m-r-5">
                                                    <p class="c-orange m-0"><?= $comment->user->getName()?></p>
                                                </div>
                                                <p class="break-word c-gray m-b-0"><?= $comment->message?></p>
                                                <span class="f-12 pull-right c-gray"><?=$comment->time_sent?></span>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            <? } ?>
                        </div>
                    <? } ?>
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