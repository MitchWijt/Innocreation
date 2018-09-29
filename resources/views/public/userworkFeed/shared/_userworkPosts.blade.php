<? foreach($userWorkPosts as $userWorkPost) { ?>
    <div class="col-md-7 m-b-20">
        <div class="card-lg">
            <div class="card-block row">
                <div class="col-sm-12 m-t-15">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="avatar-sm m-r-10 m-l-10" style="background: url('<?= $userWorkPost->user->getProfilePicture()?>')"></div>
                            <p style="margin-top: 3px !important"><?= $userWorkPost->user->firstname?></p>
                        </div>
                        <div class="col-sm-6 p-r-25">
                            <p class="pull-right m-b-0" style="margin-top: 7px !important"><?= $userWorkPost->upvotes?></p>
                            <i class="zmdi zmdi-caret-up f-40 pull-right m-r-5"></i>
                        </div>
                    </div>
                    <div class="hr col-sm-12 p-l-0"></div>
                </div>
                <div class="col-sm-12 text-center">
                    <p class="f-17 m-t-15 m-b-5" style="padding: 5px !important"><?= $userWorkPost->description?></p>
                    <img style="width: 100% !important;" src="/images/portfolioImages/<?= $userWorkPost->content?>" alt="">
                </div>
                <div class="col-sm-12">
                    <div class="row m-t-15 m-b-15">
                        <div class="col-sm-12 p-l-25 p-r-25">
                            <i class="zmdi zmdi-share f-22 pull-left" style="margin-top: 8px !important"></i>
                            <p class="pull-right m-b-0" style="margin-top: 7px !important">Upvote</p>
                            <i class="zmdi zmdi-caret-up f-40 pull-right m-r-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<? } ?>
<div class="col-sm-12 d-flex js-center m-b-20">
    <img class="hidden loadingGear" src="/images/icons/loadingGear.gif" style="width: 30px !important; height: 30px !important" alt="">
</div>
