@extends("layouts.app")
<link rel="stylesheet" href="/css/responsiveness/singleTeamPage.css">
@section("content")
    <div class="d-flex grey-background">
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
                <div class="avatar-med absolutePF p-absolute" style="background: url('<?= $team->getProfilePicture()?>');"></div>
            </div>
            <? if($user) { ?>
            <div class="row">
                <div class="col-sm-4">
                    <div class="row d-flex fd-column userName" style="margin-top: 60px !important">
                        <p class="f-25 m-b-0" style="margin-left: 10%"><?= $team->team_name?></p>
                        <div class="favoriteIcons" style="margin-left: 25%">
                            <? if(isset($favoriteTeam)) { ?>
                                <i style="font-size: 40px" class="favoriteIcon hidden zmdi zmdi-favorite-outline"></i>
                                <i style="font-size: 40px" class="favoriteIconLiked c-orange triggerLike hidden zmdi zmdi-favorite" data-team-id="<?=$team->id?>"></i>
                                <i style="font-size: 40px" class="triggerLike favAfterLike c-orange zmdi zmdi-favorite" data-team-id="<?=$team->id?>"></i>
                            <? } else { ?>
                                <i style="font-size: 40px" class="favoriteIcon zmdi zmdi-favorite-outline"></i>
                                <i style="font-size: 40px" class="favoriteIconLiked triggerLike c-orange hidden zmdi zmdi-favorite" data-team-id="<?=$team->id?>"></i>
                            <? } ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8 m-t-10">
                    <h3>Introduction:</h3>
                    <p class="m-l-10 c-dark-grey"><?= $team->team_introduction?></p>
                    <h3>Motivation:</h3>
                    <p class="m-l-10 c-dark-grey"><?= $team->team_motivation?></p>
                </div>
            </div>
            <? } ?>
            <div class="row d-flex js-center">
                <div class="col-md-12">
                    <div class="card card-lg m-t-20 m-b-20">
                        <div class="card-block m-t-10">
                            <div class="row">
                                <div class="col-sm-12 m-l-20">
                                    <h3>Members</h3>
                                </div>
                            </div>
                            <? foreach($team->getMembers() as $member) { ?>
                                <div class="col-sm-12 m-b-20 d-flex moreLink">
                                    <div class="col-sm-4 m-t-10">
                                        <a target="_blank" href="<?= $member->getUrl()?>">
                                            <div class="avatar" style="background: url('<?=$member->getProfilePicture()?>')"></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <p class="m-t-15 <? if($team->ceo_user_id == $member->id) echo "m-b-0"; ?>"><?= $member->getName()?></p>
                                        <? if($team->ceo_user_id == $member->id) { ?>
                                            <p class="c-orange text f-12">Team leader</p>
                                        <? } ?>
                                    </div>
                                    <div class="col-sm-4 text-center m-t-20">
                                        <p class="m-b-0 pull-right m-r-5 regular-link collapseExpertise collapseExpertiseResponsive" style="display: none;" data-user-id="<?= $member->id?>" data-toggle="collapse" data-target="#collapseExpertise-<?= $member->id?>" aria-expanded="false" aria-controls="collapseExpertise-<?= $member->id?>">Expertises <i class="zmdi zmdi-chevron-left m-t-5 m-l-10 c-orange"></i></p>
                                        <p class="m-b-0 pull-right m-r-5 regular-link collapseExpertise" data-user-id="<?= $member->id?>" data-toggle="collapse" data-target="#collapseExpertise-<?= $member->id?>" aria-expanded="false" aria-controls="collapseExpertise-<?= $member->id?>">Show expertises <i class="zmdi zmdi-chevron-left m-t-5 m-l-10 c-orange"></i></p>
                                    </div>
                                </div>
                                <div class="row p-l-15 p-r-15 collapse" id="collapseExpertise-<?= $member->id?>">
                                    <? foreach($member->getExpertiseLinktable() as $expertiseLinktable) { ?>
                                        <div class="<? if(count($user->getExpertiseLinktable()) > 1) echo "col-sm-6"; else echo "col-sm-12"?> p-0">
                                            <div class="card" >
                                                <div class="card-block expertiseCard p-relative " style="max-height: 150px !important">
                                                    <div class="p-t-40 p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                                                        <a class="c-gray f-9 c-pointer" target="_blank" href="<?= $expertiseLinktable->image_link?>">Photo</a> <span class="f-9 c-gray"> by </span> <a class="c-gray f-9 c-pointer" target="_blank" href="<?= $expertiseLinktable->photographer_link?>"><?= $expertiseLinktable->photographer_name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer"  href="https://unsplash.com" target="_blank">Unsplash</a>
                                                    </div>
                                                    <div class="p-t-40 p-absolute" style="z-index: 100; top: 35%; left: 50%; transform: translate(-50%, -50%);">
                                                        <div class="hr-sm"></div>
                                                    </div>
                                                    <div class="p-t-40 p-absolute" style="z-index: 99; top: 25%; left: 50%; transform: translate(-50%, -50%);">
                                                        <p class="c-white f-20"><?= $expertiseLinktable->expertises->First()->title?></p>
                                                    </div>
                                                    <div class="overlay-users">
                                                        <div class="contentExpertiseUsers" style="background: url('<?= $expertiseLinktable->image?>');"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <? } ?>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex js-center">
                <div class="col-md-12">
                    <div class="card card-lg m-t-20 m-b-20">
                        <div class="card-block m-t-10">
                            <div class="row">
                                <div class="col-sm-12 m-l-20">
                                    <h3>Needed expertises</h3>
                                </div>
                            </div>
                            <div class="singleTeamNeededExpertises">
                                <? foreach($team->getNeededExpertises() as $neededExpertise) { ?>
                                <?if($neededExpertise->amount > 0) { ?>
                                        <? $requiredArray = []?>
                                        <? $counter = 0;?>
                                        <? $requirementExplode = explode(",",$neededExpertise->requirements)?>
                                        <?foreach($requirementExplode as $requirement) { ?>
                                            <? $counter++;?>
                                            <? array_push($requiredArray, $requirement)?>
                                        <? } ?>
                                        <div class="col-sm-12 m-b-20">
                                            <div class="card">
                                                <div class="card-block expertiseCard p-relative " style="max-height: 150px !important">
                                                    <div class="p-t-40 p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                                                        <a class="c-gray f-9 c-pointer" target="_blank" href="<?= $neededExpertise->expertises->First()->image_link?>">Photo</a> <span class="f-9 c-gray"> by </span> <a class="c-gray f-9 c-pointer" target="_blank" href="<?= $neededExpertise->expertises->First()->photographer_link?>"><?= $neededExpertise->expertises->First()->photographer_name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer"  href="https://unsplash.com" target="_blank">Unsplash</a>
                                                    </div>
                                                    <div class="p-t-40 p-absolute" style="z-index: 102; top: 66%; left: 50%; transform: translate(-50%, -50%);">
                                                        <? if($user) { ?>
                                                            <? if($user->team_id == null) { ?>
                                                                <? if($user->isActiveInExpertise($neededExpertise->expertise_id)) { ?>
                                                                    <? if($user->checkJoinRequests($neededExpertise->expertise_id, $team->id) == false) { ?>
                                                                        <div class="col-sm-5">
                                                                            <? if(!$team->packageDetails() || !$team->hasPaid()) { ?>
                                                                                <? if(count($team->getMembers()) >= 2) { ?>
                                                                                    <button data-toggle="modal" data-target="#teamLimitNotification" class="btn btn-inno openUpgradeModal btn-sm" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                                <? } else { ?>
                                                                                    <button class="btn btn-inno openApplyModal btn-sm" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                                <? } ?>
                                                                            <? } else { ?>
                                                                                <? if($team->hasPaid()) { ?>
                                                                                    <? if($team->packageDetails()->custom_team_package_id == null) { ?>
                                                                                        <? if($team->packageDetails()->membershipPackage->id == 3) { ?>
                                                                                            <button class="btn btn-inno openApplyModal pull-right btn-sm" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                                        <? } else if(count($team->getMembers()) >= $team->packageDetails()->membershipPackage->members) { ?>
                                                                                            <button data-toggle="modal" data-target="#teamLimitNotification btn-sm" class="btn btn-inno openUpgradeModal" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                                        <? } else { ?>
                                                                                            <button class="btn btn-inno openApplyModal btn-sm" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                                        <? } ?>
                                                                                    <? } else { ?>
                                                                                        <? if(count($team->getMembers()) >= $team->packageDetails()->customTeamPackage->members && $team->packageDetails()->customTeamPackage->members != "unlimited") { ?>
                                                                                            <button data-toggle="modal" data-target="#teamLimitNotification" class="btn btn-inno openUpgradeModal btn-sm" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                                        <? } else { ?>
                                                                                            <button class="btn btn-inno openApplyModal btn-sm" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                                        <? } ?>
                                                                                    <? } ?>
                                                                                <? } else { ?>
                                                                                    <button data-toggle="modal" data-target="#teamLimitNotification" class="btn btn-inno openUpgradeModal btn-sm" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                                <? } ?>
                                                                            <? } ?>
                                                                        </div>
                                                                    <? } else { ?>
                                                                        <div class="col-sm-5">
                                                                            <p class="c-orange pull-right m-t-10">Applied</p>
                                                                        </div>
                                                                    <? } ?>
                                                                <? } ?>
                                                            <? } ?>
                                                        <? } ?>
                                                    </div>
                                                    <div class="p-t-40 p-absolute" style="z-index: 102; top: 44%; left: 50%; transform: translate(-50%, -50%);">
                                                        <p class="c-white @tablet f-14 @elsedesktop f-20 @endtablet">Amount needed: <?= $neededExpertise->amount?></p>
                                                    </div>
                                                    <div class="p-t-40 p-absolute" style="z-index: 100; top: 25%; left: 50%; transform: translate(-50%, -50%);">
                                                        <div class="hr-sm"></div>
                                                    </div>
                                                    <div class="p-t-40 p-absolute" style="z-index: 99; top: 15%; left: 50%; transform: translate(-50%, -50%);">
                                                        <p class="c-white f-20"><?= $neededExpertise->expertises->First()->title?></p>
                                                    </div>
                                                    <div class="overlay-users">
                                                        <div class="contentExpertiseUsers" style="background: url('<?= $neededExpertise->expertises->First()->image?>');"></div>
                                                    </div>
                                                    <? if($user && $user->team_id == null) { ?>
                                                    <?}?>
                                                </div>
                                            </div>
                                        </div>
                                        <? if($user) { ?>
                                            <div class="modal applyForExpertise fade" data-expertise-id="<?=$neededExpertise->expertise_id?>" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header d-flex js-center">
                                                            <h4 class="text-center c-black" id="modalLabel"><?=$neededExpertise->Expertises->First()->title?></h4>
                                                        </div>
                                                        <div class="modal-body ">
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
@endsection