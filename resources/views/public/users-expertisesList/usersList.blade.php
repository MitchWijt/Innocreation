@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">All users active in <?= $expertise->title?></h1>
            </div>
            <hr class="m-b-0">
            <? foreach($expertise->getActiveUsers() as $user) { ?>
                <div class="row d-flex js-center">
                    <div class="col-md-8">
                        <div class="card-lg m-t-20 m-b-20">
                            <div class="card-block m-t-10">
                                <div class="row m-t-10 m-b-10">
                                    <div class="col-sm-4">
                                        <div class="d-flex fd-column">
                                            <div class="col-sm-9 text-center m-b-10">
                                                <img class="circle circleImage m-0 p-0" src="<?= $user->getProfilePicture()?>" alt="<?= $expertise->title?>">
                                            </div>
                                            <div class="col-sm-9 text-center">
                                                <span class=""><?= $user->getName()?></span>
                                            </div>
                                            <? if($user->team_id != null) { ?>
                                                <div class="col-sm-12">
                                                    <span class="pull-left">Team: <a target="_blank" class="regular-link" href="/team/<?= $user->team->team_name?>"><?= $user->team->team_name?></a></span>
                                                </div>
                                            <? } ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="col-sm-12 text-center m-t-30">
                                            <a href="<?= $user->getUrl()?>" class="btn btn-inno">Go to <?= $user->firstname?></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="col-sm-12 m-t-25">
                                            <div class="d-flex fd-column pull-right">
                                                <? foreach($user->getExpertises() as $userExpertise) { ?>
                                                    <div class="pull-right">
                                                        <p class="pull-right m-0"><?= $userExpertise->title ?></p>
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
            <? } ?>
        </div>
    </div>
@endsection