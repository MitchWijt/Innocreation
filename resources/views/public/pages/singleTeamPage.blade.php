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
                    <img class="circle circleImgLg m-r-0" src="<?=$team->getProfilePicture()?>" alt="<?=$team->team_name?>">
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
                            <input type="hidden" name="sender_user_id" value="<?=$user->id?>">
                            <input type="hidden" name="receiver_user_id" value="<?= $team->ceo_user_id?>">
                            <button class="btn btn-inno">Send chat message</button>
                        </form>
                    </div>
                </div>
            <? } ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
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
                                            <div class="col-sm-4">
                                                <p class="m-t-15"><?= $member->getName()?></p>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="d-flex fd-column">
                                                    <? foreach($member->getExpertises() as $memberExpertise) { ?>
                                                        <p><?= $memberExpertise->title?></p>
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
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
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
                                                       <p><?= $neededExpertise->Expertises->First()->title?></p>
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
                                                        <? if($user->checkJoinRequests($neededExpertise->expertise_id, $team->id) == false) { ?>
                                                            <div class="col-sm-5">
                                                                <button class="btn btn-inno openApplyModal pull-right" data-expertise-id="<?=$neededExpertise->expertise_id?>">Apply for expertise</button>
                                                            </div>
                                                        <? } else { ?>
                                                            <div class="col-sm-5">
                                                                <p class="c-orange pull-right m-t-10">Applied</p>
                                                            </div>
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
                                                                    <h2 class="m-b-20">Requirements:</h2>
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
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
                        <div class="card card-lg m-t-20 m-b-20">
                            <div class="card-block m-t-10">
                                <div class="row">
                                    <div class="col-sm-12 m-l-20">
                                        <h3>Team information</h3>
                                    </div>
                                </div>
                                <div class="d-flex fd-column">
                                    <div class="row d-flex js-center">
                                        <div class="col-sm-11">
                                            <p class="f-21 m-0">Our motivation</p>
                                            <hr>
                                            <p><?=$team->team_motivation?></p>
                                        </div>
                                    </div>
                                    <div class="row d-flex js-center">
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
            </div>
            <? if($user) { ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-flex js-center">
                            <div class="card card-lg m-t-20 m-b-20">
                                <div class="card-block m-t-10">
                                    <div class="row">
                                        <div class="col-sm-12 m-l-20">
                                            <h3>Team reviews</h3>
                                        </div>
                                    </div>
                                    <? foreach($reviews as $review) { ?>
                                        <div class="row d-flex js-center">
                                            <div class="col-sm-11 d-flex p-l-0">
                                                <div class="col-sm-2">
                                                    <div class="c-orange">
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
                                                </div>
                                                <div class="col-sm-9 p-l-0">
                                                    <p class="f-17"><?= $review->title?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex js-center">
                                            <div class="col-sm-11 p-l-0">
                                                <div class="col-sm-12 p-l-0">
                                                    <p class="p-l-15 f-18"><?= $review->users->First()->getName()?></p>
                                                    <p class="p-l-15 m-b-0"><?= $review->review?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex js-center m-b-20">
                                            <div class="col-sm-10">
                                               <span class="pull-right f-13 c-dark-grey"><?= date("d-m-Y", strtotime($review->created_at))?></span>
                                            </div>
                                        </div>
                                    <? } ?>
                                    <hr>
                                    <form action="/postTeamReview" method="post">
                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                        <input type="hidden" name="user_id" value="<?= $user->id?>">
                                        <input type="hidden" name="team_id" value="<?= $team->id?>">
                                        <input type="hidden" name="star_value" class="star_value" value="">
                                        <div class="row d-flex js-center m-t-15">
                                            <div class="col-sm-11 d-flex">
                                                <div class="col-sm-4 p-l-0">
                                                    <input type="text" name="review_title" class="input" placeholder="Title">
                                                </div>
                                                <div class="col-sm-8 c-orange f-20 stars c-pointer">
                                                    <i class="zmdi zmdi-star-outline star" data-star-value="1"></i>
                                                    <i class="zmdi zmdi-star-outline star" data-star-value="2"></i>
                                                    <i class="zmdi zmdi-star-outline star" data-star-value="3"></i>
                                                    <i class="zmdi zmdi-star-outline star" data-star-value="4"></i>
                                                    <i class="zmdi zmdi-star-outline star" data-star-value="5"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex js-center m-t-15">
                                            <div class="col-sm-11">
                                                <textarea placeholder="Write your review" name="review" rows="6" class="input col-sm-12"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 m-b-20">
                                                <button class="btn btn-inno pull-right m-r-30">Post review</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/singleTeamPage.js"></script>
@endsection