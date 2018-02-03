@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black"><?=$team->team_name?></h1>
            </div>
            <hr class="m-b-20">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <img class="circle m-r-0" src="<?=$team->getProfilePicture()?>" alt="<?=$team->team_name?>">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <i style="font-size: 40px" class="favoriteIcon zmdi zmdi-favorite-outline m-t-20"></i>
                    <i style="font-size: 40px" class="favoriteIconLiked c-orange hidden zmdi zmdi-favorite m-t-20"></i>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center m-t-20">
                    <button class="btn btn-inno">Send chat message</button>
                </div>
            </div>
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
                                                <img class="circleImage circle" src="<?= $member->getProfilePicture()?>" alt="<?=$member->firstname?>">
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
                                <div class="d-flex fd-column">
                                    <? foreach($team->getNeededExpertises() as $neededExpertise) { ?>
                                        <div class="col-sm-12 m-b-20 d-flex">
                                           <div class="col-sm-9">
                                               <p><?= $neededExpertise->title?></p>
                                           </div>
                                            <? if($user) { ?>
                                                <? if($user->team_id == null) { ?>
                                                    <div class="col-sm-3">
                                                        <button class="btn btn-inno">Apply for expertise</button>
                                                    </div>
                                                <? } ?>
                                            <? } ?>
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/singleTeamPage.js"></script>
@endsection