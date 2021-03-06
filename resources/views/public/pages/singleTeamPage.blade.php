@extends("layouts.app")
<link rel="stylesheet" href="/css/responsiveness/singleTeamPage.css">
@section("content")
    <div class="d-flex grey-background <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <? if(count($errors) > 0){ ?>
                        <? foreach($errors->all() as $error){ ?>
                            <p class="c-orange"><?=$error?></p>
                        <? } ?>
                    <? } ?>
                </div>
            </div>
            <div class="banner p-relative" style="background: url('<?= $team->getBanner()?>');">
                <? if($user && $user->id == $team->ceo_user_id) { ?>
                    <form action="/my-team/editBannerImage" method="post" class="hidden bannerImgForm" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="team_id" value="<?= $team->id?>">
                        <input type="file" name="bannerImg" class="bannerImgInput">
                    </form>
                    <i class="zmdi zmdi-edit editBtn editBannerImage c-black @handheld no-hover @endhandheld" @handheld style="display: block !important;"@endhandheld></i>
                <? } ?>
                <div class="avatar-med absolutePF p-absolute" style="background: url('<?= $team->getProfilePicture('extra-small')?>'); z-index: 100 !important">
                    <? if($user && $user->id == $team->ceo_user_id) { ?>
                        <form action="/my-team/saveTeamProfilePicture" method="post" class="hidden profileImageForm" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                            <input type="hidden" name="team_id" value="<?= $team->id?>">
                            <input type="file" name="profile_picture" class="profile_picture">
                        </form>
                        <i class="zmdi zmdi-edit c-black editBtn shadow @handheld no-hover @endhandheld" id="editProfilePicture"></i>
                    <? } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4">
                    <div class="row d-flex fd-column userName" style="margin-top: 60px !important">
                        <p class="f-30 bold m-b-0" style="margin-left: 8%"><?= $team->team_name?></p>
                    </div>
                </div>
                <div class="col-xl-8 <? if(!isset($user)) echo "m-t-65";?>">
                    <div class="row">
                        <? if($user && $user->id == $team->ceo_user_id) { ?>
                            <div class="col-sm-12 m-t-10 m-b-20 navbarBox">
                                <div class="navbar-user-desktop">
                                    <? if($team->split_the_bill == 1 && $team->packageDetails()) { ?>
                                        <a href="/my-team/payment-details"><span class="iconCTA pull-right m-r-10 " >Payment details</span></a>
                                    <? } ?>
                                    <? if(count($team->getMembers()) > 1 && $team->packageDetails()) { ?>
                                        <a href="/my-team/payment-settings"><span class="iconCTA pull-right m-r-10 " >Payment settings</span></a>
                                    <? } ?>
                                    <a href="#" class="teamPrivacySettings" data-id="<?= $team->id?>"><span class="iconCTA pull-right m-r-10 " >Privacy settings</span></a>
                                    <? $workspaceShortTermPlanner = \App\WorkspaceShortTermPlannerBoard::select("*")->where("team_id", $team->id)->get()?>
                                    <? if(count($workspaceShortTermPlanner) > 0) { ?>
                                        <a href="/my-team/workspace/short-term-planner/<?= $workspaceShortTermPlanner->First()->id?>"><span class="iconCTA pull-right m-r-10 " >My workspace</span></a>
                                    <? } else { ?>
                                        <a href="/my-team/workspace"><span class="iconCTA pull-right m-r-10 " >My workspace</span></a>
                                    <? } ?>
                                </div>
                                <div class="navbar-user-mobile" style="display: none">
                                    <a href="#" class="teamPrivacySettings" data-id="<?= $team->id?>"><span class="iconCTA pull-right m-r-10"><i class="zmdi zmdi-settings"></i></span></a>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                    <h3 class="bold m-b-10">Introduction</h3>
                    <p class="m-l-10 c-dark-grey" style="margin-bottom: 30px;"><?= $team->team_introduction?></p>
                    <h3 class="bold m-b-10">Motivation</h3>
                    <p class="m-l-10 c-dark-grey" style="margin-bottom: 30px;"><?= $team->team_motivation?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-12 m-l-20 m-b-10" style="margin-top: 40px">
                            <h3 class="bold f-30">Collaborators</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 50px;">
                <? foreach($team->getMembers() as $member) { ?>
                    <div class="col-xl-4 m-t-10">
                        <div class="card userCard m-t-20 m-b-20">
                            <div class="card-block p-relative c-pointer" data-url="/" style="max-height: 210px !important">
                                <a href="<?= $member->getUrl()?>">
                                    <div class="overlay-expertise-user"></div>
                                </a>
                                <a class="userCardContent" href="<?= $member->getUrl()?>">
                                    <div class="p-absolute" style="z-index: 20; opacity: 1 !important; top: 39%; left: 50%; transform: translate(-50%, -50%)">
                                        <div class="avatar" style="background: url('<?= $member->getProfilePicture()?>'); z-index: 2000000; opacity: 1 !important"></div>
                                    </div>
                                    <div class="p-absolute memberName" style="z-index: 20; opacity: 1 !important; top: 66%; left: 50%; transform: translate(-50%, -50%)">
                                        <p class="c-white f-16"><? if($user && $user->id == $team->ceo_user_id) { ?><i class="zmdi zmdi-chevron-down f-15 popoverMember" data-toggle="popover" data-content='<?= view("/public/team/shared/_memberMenuPopover", compact("team", 'member'))?>'></i> <? } ?><?= $member->getName()?></p>
                                    </div>
                                    <div class="p-absolute" style="z-index: 20; opacity: 1 !important; top: 77%; left: 50%; transform: translate(-50%, -50%)">
                                        <p class="c-orange f-11">@<?= $member->slug?></p>
                                    </div>
                                </a>
                                <a href="<?= $member->getUrl()?>" style="z-index: 400;">
                                    <div class="userCardContent lazyLoad" data-src="<?= $member->getBanner()?>"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
            <div class="row d-flex js-center">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-12 m-l-20 m-b-10 d-flex js-between" style="margin-top: 40px">
                            <h3 class="bold f-30">Needed expertises</h3>
                            <? if($user && $user->id == $team->ceo_user_id) { ?>
                                <i  style="z-index: 2;"  data-team-id="<?= $team->id?>"  class="editBtn zmdi zmdi-plus f-20 p-r-15 p-l-15 p-b-10 p-t-10 editNeededExpertise @handheld no-hover @endhandheld"></i>
                            <? } ?>
                        </div>
                    </div>
                    <div class="singleTeamNeededExpertises m-t-20 <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
                        <? foreach($team->getNeededExpertises() as $neededExpertise) { ?>
                        <?if($neededExpertise->amount > 0) { ?>
                                <? $requiredArray = []?>
                                <? $counter = 0;?>
                                <? $requirementExplode = explode(",",$neededExpertise->requirements)?>
                                <?foreach($requirementExplode as $requirement) { ?>
                                    <? $counter++;?>
                                    <? array_push($requiredArray, $requirement)?>
                                <? } ?>
                                <div class="row">
                                    <div class="col-sm-4 m-b-30">
                                        <div class="card">
                                            <div class="card-block expertiseCard p-relative ">
                                                <div class="p-t-40 p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                                                    <a class="c-gray f-9 c-pointer" target="_blank" href="<?= $neededExpertise->expertises->First()->image_link?>">Photo</a> <span class="f-9 c-gray"> by </span> <a class="c-gray f-9 c-pointer" target="_blank" href="<?= $neededExpertise->expertises->First()->photographer_link?>"><?= $neededExpertise->expertises->First()->photographer_name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer"  href="https://unsplash.com" target="_blank">Unsplash</a>
                                                </div>
                                                <div class="overlay-users"> </div>
                                                <div class="contentExpertiseUsers" style="background: url('<?= $neededExpertise->expertises->First()->image?>');">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 p-r-0">
                                        <div class="c-black">
                                            <p><?= $neededExpertise->description?></p>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <ul class="p-l-25">
                                                    <? for($i = 0; $i < $counter; $i++) { ?>
                                                    <li><?= $requiredArray[$i]?></li>
                                                    <? } ?>
                                                </ul>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="p-t-40 text-right">
                                                    <? if($user) { ?>
                                                        <? if($user->team_id == null) { ?>
                                                            <? if($user->checkJoinRequests($neededExpertise->expertise_id, $team->id) == false) { ?>
                                                                <div class="col-sm-5">
                                                                    <? if(\App\Services\TeamServices\TeamPackage::checkPackageAndPayment($team->id, $neededExpertise->expertises)) { ?>
                                                                        <button class="btn btn-inno openApplyModal btn-sm" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                    <? } else { ?>
                                                                        <button data-toggle="modal" data-target="#teamLimitNotification" class="btn btn-inno openUpgradeModal btn-sm" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                    <? } ?>
                                                                </div>
                                                            <? } else { ?>
                                                                <div class="col-sm-5">
                                                                    <p class="c-orange pull-right m-t-10">Applied</p>
                                                                </div>
                                                            <? } ?>
                                                        <? } ?>
                                                        <? if($user && $user->id == $team->ceo_user_id) { ?>
                                                            <i  style="z-index: 2;" data-needed-expertise-id="<?= $neededExpertise->id?>" data-team-id="<?= $team->id?>" class="editBtn zmdi zmdi-edit f-20 p-r-10 p-l-10 p-b-5 p-t-5 editNeededExpertise @handheld no-hover @endhandheld"></i>
                                                        <? } ?>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <? if($user) { ?>
                                    <div class="modal applyForExpertise fade fade-scale" data-expertise-id="<?=$neededExpertise->expertise_id?>" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content modal-content-border">
                                                <div class="modal-header d-flex js-center modal-header-border">
                                                    <h4 class="text-center c-black" id="modalLabel"><?=$neededExpertise->Expertises->First()->title?></h4>
                                                </div>
                                                <div class="modal-body modal-body-border">
                                                    <div class="c-black">
                                                        <p><?= $neededExpertise->description?></p>
                                                    </div>
                                                    <div class="c-black">
                                                        <h4 class="m-b-10">Requirements:</h4>
                                                        <ul>
                                                        <? for($i = 0; $i < $counter; $i++) { ?>
                                                            <li><?= $requiredArray[$i]?></li>
                                                        <? } ?>
                                                        </ul>
                                                    </div>
                                                    <form action="/applyForTeam" method="post">
                                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                        <input type="hidden" name="expertise_id" value="<?=$neededExpertise->expertise_id?>">
                                                        <input type="hidden" name="user_id" value="<?=$user->id?>">
                                                        <input type="hidden" name="team_id" value="<?=$team->id?>">
                                                        <div class="row">
                                                            <div class="col-sm-12 text-center">
                                                                <button class="btn btn-inno text-center">Apply here</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            <? } ?>
                        <? } ?>
                    </div>
                </div>
            </div>
            <div class="modal teamLimitNotification fade" id="teamLimitNotification" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body ">
                            <p>We're sorry but this team has reached its max member capacity. <br> Keep on the lookout maybe there will be a place anytime soon!  But don't worry, you can take a look at the <a class="regular-link" href="/forum">forum</a> or the <a class="regular-link" href="/teams">teams list</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/pages/singleTeamPage.js"></script>
    <script defer async src="/js/lazyLoader.js"></script>
@endsection