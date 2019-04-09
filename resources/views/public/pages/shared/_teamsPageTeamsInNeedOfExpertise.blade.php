<? foreach($teams as $team) { ?>
    <? if($team->getAmountNeededExpertises() > 0) { ?>
        <? if(isset($user) && $team->checkNeededExpertises($user->getExpertisesArray())) { ?>
            <div class="col-xl-4 m-t-10">
                <a class="userCardContent" href="<?= $team->getUrl()?>">
                    <div class="card userCard m-t-20 m-b-20">
                        <div class="card-block p-relative c-pointer" data-url="/" style="min-height: 260px !important">
                            <div class="bannerTeam lazyLoad" data-src="<?= $team->getBanner()?>"></div>
                            <div class="p-absolute" style="z-index: 2000000; opacity: 1 !important; top: 40%; left: 50%; transform: translate(-50%, -50%)">
                                <div class="avatar" style="background: url('<?= $team->getProfilePicture()?>'); z-index: 2000000; opacity: 1 !important"></div>
                            </div>
                            <div class="p-absolute" style="z-index: 2000000; opacity: 1 !important; top: 64%; left: 50%; transform: translate(-50%, -50%)">
                                <p class="c-black bold f-20"><?= $team->team_name?></p>
                            </div>
                            <div class="p-absolute" style="z-index: 2000000; opacity: 1 !important; top: 84%; left: 50%; transform: translate(-50%, -50%)">
                                <div class="d-flex expertiseCirclesDiv">
                                    <? foreach(\App\Services\TeamServices\TeamExpertisesService::getMaxNeededExpertises($team) as $neededExpertise) { ?>
                                    <div class="expertiseCircle m-l-10 m-r-10">
                                        <div class="half-circle-expertise-img" style="background: url('<?= $neededExpertise->expertises->First()->image?>')"></div>
                                        <div class="half-circle-expertise-title p-relative">
                                            <div class="o-hidden p-absolute" style="white-space: nowrap; text-overflow: ellipsis; max-width: 55px; top: 33%; left: 50%; transform: translate(-50%, -50%);">
                                                <span class="f-9 m-0 bold c-black"><?= $neededExpertise->expertises->First()->title?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <? } ?>
    <? } ?>
<? } ?>
<style>
    .half-circle-expertise-img {
        width: 70px;
        height: 35px;
        border-top-left-radius: 100px;
        border-top-right-radius: 100px;
        border-bottom: 0;
        background-size:     cover !important;
        background-repeat:   no-repeat !important;
        background-position: center center !important;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .half-circle-expertise-title {
        width: 70px;
        height: 35px;
        border-bottom-left-radius: 100px;
        border-bottom-right-radius: 100px;
        border-bottom: 1px solid grey;
        border-right: 1px solid grey;
        border-left: 1px solid grey;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
</style>
