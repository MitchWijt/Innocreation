@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black"><?=$team->team_name?></h1>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <? if(count($errors) > 0){ ?>
                        <? foreach($errors->all() as $error){ ?>
                            <p class="c-orange"><?=$error?></p>
                        <? } ?>
                    <? } ?>
                </div>
            </div>
            <hr class="m-b-20">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <img class="circle circleImgLg m-r-0 img-responsive" src="<?=$team->getProfilePicture()?>" alt="<?=$team->team_name?>">
                </div>
            </div>
            <? if($user) { ?>
                <div class="row">
                    <div class="col-sm-12 text-center favoriteIcons">
                        <? if(isset($favoriteTeam)) { ?>
                            <i style="font-size: 40px" class="favoriteIcon hidden zmdi zmdi-favorite-outline m-t-20"></i>
                            <i style="font-size: 40px" class="favoriteIconLiked c-orange triggerLike hidden zmdi zmdi-favorite m-t-20" data-team-id="<?=$team->id?>"></i>
                            <i style="font-size: 40px" class="triggerLike favAfterLike c-orange zmdi zmdi-favorite m-t-20 " data-team-id="<?=$team->id?>"></i>
                        <? } else { ?>
                            <i style="font-size: 40px" class="favoriteIcon zmdi zmdi-favorite-outline m-t-20"></i>
                            <i style="font-size: 40px" class="favoriteIconLiked triggerLike c-orange hidden zmdi zmdi-favorite m-t-20" data-team-id="<?=$team->id?>"></i>
                        <? } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center m-t-20">
                        <form action="/selectChatUser" method="post">
                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                            <input type="hidden" name="creator_user_id" value="<?=$user->id?>">
                            <input type="hidden" name="receiver_user_id" value="<?= $team->ceo_user_id?>">
                            <button class="btn btn-inno">Send chat message</button>
                        </form>
                    </div>
                </div>
            <? } ?>
            <div class="row d-flex js-center">
                <div class="col-md-9">
                    <div class="card card-lg m-t-20 m-b-20">
                        <div class="card-block m-t-10">
                            <div class="row">
                                <div class="col-sm-12 m-l-20">
                                    <h3>Members</h3>
                                </div>
                            </div>
                            <div class="d-flex fd-column">
                                <? foreach($team->getMembers() as $member) { ?>
                                    <div class="col-sm-12 m-b-20 d-flex">
                                        <div class="col-sm-4">
                                            <a target="_blank" href="<?= $member->getUrl()?>">
                                                <img class="circleImage circle" src="<?= $member->getProfilePicture()?>" alt="<?=$member->firstname?>">
                                            </a>
                                        </div>
                                        <div class="col-sm-4 text-center">
                                            <p class="m-t-15 <? if($team->ceo_user_id == $member->id) echo "m-b-0"; ?>"><?= $member->getName()?></p>
                                            <? if($team->ceo_user_id == $member->id) { ?>
                                                <p class="c-orange text f-12">Team leader</p>
                                            <? } ?>
                                        </div>
                                        <div class="col-sm-4" style="display: flex; justify-content: flex-end;">
                                            <div class="d-flex fd-column">
                                                <? if($team->ceo_user_id == $member->id) { ?>
                                                    <? foreach($member->getExpertises() as $memberExpertise) { ?>
                                                        <div class="d-flex" style="justify-content: flex-end">
                                                            <p><?= $memberExpertise->title?></p>
                                                        </div>
                                                    <? } ?>
                                                <? } else { ?>
                                                   <p class="m-t-15"><?= $member->getJoinedExpertise()->expertises->First()->title?></p>
                                                <? } ?>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex js-center">
                <div class="col-md-9">
                    <div class="card card-lg m-t-20 m-b-20">
                        <div class="card-block m-t-10">
                            <div class="row">
                                <div class="col-sm-12 m-l-20">
                                    <h3>Needed expertises</h3>
                                </div>
                            </div>
                            <div class="d-flex fd-column singleTeamNeededExpertises">
                                <? foreach($team->getNeededExpertises() as $neededExpertise) { ?>
                                <?if($neededExpertise->amount > 0) { ?>
                                        <? $requiredArray = []?>
                                        <? $counter = 0;?>
                                        <? $requirementExplode = explode(",",$neededExpertise->requirements)?>
                                        <?foreach($requirementExplode as $requirement) { ?>
                                            <? $counter++;?>
                                            <? array_push($requiredArray, $requirement)?>
                                        <? } ?>
                                        <div class="col-sm-12 m-b-20 d-flex">
                                            <? if($user && $user->team_id == null) { ?>
                                               <div class="col-sm-3">
                                                   <p class="m-t-10"><?= $neededExpertise->Expertises->First()->title?></p>
                                               </div>
                                                <div class="col-sm-4 text-center">
                                                    <p class="pull-right m-t-10">Amount needed: <?= $neededExpertise->amount?></p>
                                                </div>
                                            <? } else { ?>
                                                <div class="col-sm-5 m-b-10 border-inno text-center d-flex js-center">
                                                    <p class="m-t-10"><?= $neededExpertise->Expertises->First()->title?></p>
                                                </div>
                                                <div class="col-sm-7">
                                                    <p class="pull-right m-t-10">Amount needed: <?= $neededExpertise->amount?></p>
                                                </div>
                                            <? } ?>
                                            <? if($user) { ?>
                                                <? if($user->team_id == null) { ?>
                                                    <? if($user->isActiveInExpertise($neededExpertise->expertise_id)) { ?>
                                                        <? if($user->checkJoinRequests($neededExpertise->expertise_id, $team->id) == false) { ?>
                                                            <div class="col-sm-5">
                                                                <? if(!$team->packageDetails() || !$team->hasPaid()) { ?>
                                                                    <? if(count($team->getMembers()) >= 2) { ?>
                                                                        <button data-toggle="modal" data-target="#teamLimitNotification" class="btn btn-inno openUpgradeModal pull-right" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                    <? } else { ?>
                                                                        <button class="btn btn-inno openApplyModal pull-right" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                    <? } ?>
                                                                <? } else { ?>
                                                                   <? if($team->hasPaid()) { ?>
                                                                        <? if($team->packageDetails()->custom_team_package_id == null) { ?>
                                                                           <? if($team->packageDetails()->membershipPackage->id == 3) { ?>
                                                                            <button class="btn btn-inno openApplyModal pull-right" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                            <? } else if(count($team->getMembers()) >= $team->packageDetails()->membershipPackage->members) { ?>
                                                                                <button data-toggle="modal" data-target="#teamLimitNotification" class="btn btn-inno openUpgradeModal pull-right" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                            <? } else { ?>
                                                                                <button class="btn btn-inno openApplyModal pull-right" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                            <? } ?>
                                                                        <? } else { ?>
                                                                            <? if(count($team->getMembers()) >= $team->packageDetails()->customTeamPackage->members && $team->packageDetails()->customTeamPackage->members != "unlimited") { ?>
                                                                                <button data-toggle="modal" data-target="#teamLimitNotification" class="btn btn-inno openUpgradeModal pull-right" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                            <? } else { ?>
                                                                                <button class="btn btn-inno openApplyModal pull-right" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                                            <? } ?>
                                                                        <? } ?>
                                                                   <? } else { ?>
                                                                        <button data-toggle="modal" data-target="#teamLimitNotification" class="btn btn-inno openUpgradeModal pull-right" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
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
            <div class="row d-flex js-center">
               <div class="col-md-9">
                    <div class="card card-lg m-t-20 m-b-20">
                        <div class="card-block m-t-10">
                            <div class="row m-l-20">
                                <h3>Team information</h3>
                            </div>
                            <div class="d-flex fd-column">
                                <div class="row d-flex js-center @mobile p-15 @endmobile">
                                    <div class="col-md-11">
                                        <p class="f-21 m-0">Our motivation</p>
                                        <hr>
                                        <p><?=$team->team_motivation?></p>
                                    </div>
                                </div>
                                <div class="row d-flex js-center @mobile p-15 @endmobile">
                                    <div class="col-sm-11">
                                        <p class="f-21 m-0">Our introduction</p>
                                        <hr>
                                        <p><?=$team->team_introduction?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
            <div class="row d-flex js-center">
                <div class="col-md-9">
                    <div class="card card-lg m-t-20 m-b-20">
                        <div class="card-block m-t-10">
                            <div class="row m-l-20">
                                <h3>Team reviews</h3>
                            </div>
                            <? foreach($reviews as $review) { ?>
                                <div class="row d-flex js-center m-l-25">
                                    <div class="col-sm-12 d-flex fd-row">
                                        <div class="c-orange m-r-30">
                                            <? if($review->stars == 5) { ?>
                                                <i class="zmdi zmdi-star"></i>
                                                <i class="zmdi zmdi-star"></i>
                                                <i class="zmdi zmdi-star"></i>
                                                <i class="zmdi zmdi-star"></i>
                                                <i class="zmdi zmdi-star"></i>
                                            <? } else if($review->stars == 4) { ?>
                                                <i class="zmdi zmdi-star"></i>
                                                <i class="zmdi zmdi-star"></i>
                                                <i class="zmdi zmdi-star"></i>
                                                <i class="zmdi zmdi-star"></i>
                                                <i class="zmdi zmdi-star-outline"></i>
                                            <? } else if($review->stars == 3) { ?>
                                                <i class="zmdi zmdi-star"></i>
                                                <i class="zmdi zmdi-star"></i>
                                                <i class="zmdi zmdi-star"></i>
                                                <i class="zmdi zmdi-star-outline"></i>
                                                <i class="zmdi zmdi-star-outline"></i>
                                            <? } else if($review->stars == 2) { ?>
                                                <i class="zmdi zmdi-star"></i>
                                                <i class="zmdi zmdi-star"></i>
                                                <i class="zmdi zmdi-star-outline"></i>
                                                <i class="zmdi zmdi-star-outline"></i>
                                                <i class="zmdi zmdi-star-outline"></i>
                                            <? } else if($review->stars == 1) { ?>
                                                <i class="zmdi zmdi-star"></i>
                                                <i class="zmdi zmdi-star-outline"></i>
                                                <i class="zmdi zmdi-star-outline"></i>
                                                <i class="zmdi zmdi-star-outline"></i>
                                                <i class="zmdi zmdi-star-outline"></i>
                                            <? } ?>
                                        </div>
                                        <p class="f-17"><?= $review->title?></p>
                                    </div>
                                </div>
                                <div class="row d-flex js-center m-l-25">
                                    <div class="col-md-12">
                                        <p class="f-18"><?= $review->users->First()->getName()?></p>
                                        <p class="m-b-0"><?= $review->review?></p>
                                    </div>
                                </div>
                                <div class="row d-flex js-center m-b-20 ">
                                    <div class="col-sm-10 m-r-10">
                                       <span class="pull-right f-13 c-dark-grey"><?= date("d-m-Y", strtotime($review->created_at))?></span>
                                    </div>
                                </div>
                            <? } ?>
                            <? if($user) { ?>
                                <hr>
                                <form action="/postTeamReview" method="post">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <input type="hidden" name="user_id" value="<?= $user->id?>">
                                    <input type="hidden" name="team_id" value="<?= $team->id?>">
                                    <input type="hidden" name="star_value" class="star_value" value="">
                                    <div class="row m-t-15 col-sm-12">
                                        <div class="col-sm-6">
                                            <input type="text" name="review_title" class="input" placeholder="Title">
                                        </div>
                                        <div class="col-sm-6 c-orange f-20 stars c-pointer">
                                            <i class="zmdi zmdi-star-outline star" data-star-value="1"></i>
                                            <i class="zmdi zmdi-star-outline star" data-star-value="2"></i>
                                            <i class="zmdi zmdi-star-outline star" data-star-value="3"></i>
                                            <i class="zmdi zmdi-star-outline star" data-star-value="4"></i>
                                            <i class="zmdi zmdi-star-outline star" data-star-value="5"></i>
                                        </div>
                                    </div>
                                    <div class="row d-flex js-center m-t-15 @handheld p-10 @endhandheld">
                                        <div class="col-sm-11 @notmobile p-0 @endnotmobile">
                                            <textarea placeholder="Write your review" name="review" rows="6" class="input col-sm-12"></textarea>
                                        </div>
                                    </div>
                                    <div class="row m-t-20">
                                        <div class="col-sm-12 m-b-20">
                                            <button class="btn btn-inno pull-right m-r-30">Post review</button>
                                        </div>
                                    </div>
                                </form>
                            <? } ?>
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