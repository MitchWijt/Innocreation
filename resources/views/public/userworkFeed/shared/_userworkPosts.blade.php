<? foreach($userWorkPosts as $userWorkPost) { ?>
<div class="card userWorkPost p-relative m-b-10 desktopViewPosts" style="display: inline-block;" data-id="<?= $userWorkPost->id?>">
    <div class="card-block">
        <div class="col-sm-12 p-relative desc p-0 <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
            <div class="image p-relative">
                <div class="imageOverlay p-relative"></div>
                <div class="postedUser">
                    <a href="<?= $userWorkPost->user->getUrl()?>" class="td-none">
                        <div class="d-flex p-relative usernameDiv">
                            <div class="avatar-sm img m-t-0 p-t-0 avatarPoster" style="background: url('<?= $userWorkPost->user->getProfilePicture()?>');"></div>
                            <p class="m-b-0 m-l-5 c-white usernamePost"><?= $userWorkPost->user->getName()?></p>
                        </div>
                    </a>
                </div>
                <? if($userWorkPost->content != null) { ?>
                <img class="zoom zoom-<?= $userWorkPost->id?>" data-id="<?= $userWorkPost->id?>" src="<?= $userWorkPost->getPlaceholder()?>" data-layzr="<?= $userWorkPost->getImage()?>" style="width: 100%;">
                <? } ?>
                <div class="interestedButtonPost">
                    <? if(isset($user)) { ?>
                    <div class="d-flex p-relative">
                        <? if($user->hasPlusPointed($userWorkPost->id)) { ?>
                        <span class="fave active-fave c-pointer" data-id="<?= $userWorkPost->id?>"></span>
                        <? } else { ?>
                        <span class="fave normal-fave c-pointer" data-id="<?= $userWorkPost->id?>"></span>
                        <? } ?>
                        <a style="position: absolute; top: 10px; right: -5px;"><span class="amountOfPoints-<?= $userWorkPost->id?>"><?= count($userWorkPost->getInterests());?></span></a>
                    </div>
                    <? } else { ?>
                    <div class="d-flex p-relative">
                        <span class="active-fave c-pointer" data-id="<?= $userWorkPost->id?>"></span>
                        <a style="position: absolute; top: 10px; right: -5px;"><span class="amountOfPoints-<?= $userWorkPost->id?>"><?= count($userWorkPost->getInterests());?></span></a>
                    </div>
                    <? } ?>
                </div>
                <div class="commentsButtonPost zoom zoom-<?= $userWorkPost->id?>" data-id="<?= $userWorkPost->id?>">
                    <div class="d-flex p-relative">
                        <i class="zmdi zmdi-comment-text f-20 m-l-10"></i>
                        <a style="position: absolute; top: -2px; right: -25px;"><span><?= count($userWorkPost->getComments());?></span></a>
                    </div>
                </div>
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