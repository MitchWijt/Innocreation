@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black @mobile f-20 @endmobile">All users active in <?= $expertise->title?></h1>
            </div>
            <hr class="m-b-0">
            <? foreach($expertise->getActiveUsers() as $user) { ?>
                <div class="row d-flex js-center m-b-20">
                    <div class="col-md-8">
                        <div class="card-lg m-t-20">
                            <div class="card-block m-t-10">
                                <div class="row m-t-10 m-b-10">
                                    <div class="col-sm-6">
                                        <div class="d-flex fd-column">
                                            <div class="col-sm-9 text-center m-b-10">
                                                <div class="d-flex js-center @mobile m-b-10 @endmobile">
                                                    <div class="avatar" style="background: url('<?= $user->getProfilePicture()?>')"></div>
                                                </div>
                                            </div>
                                            @nottablet
                                                <? if($user->team_id != null) { ?>
                                                    <div class="col-sm-9 text-center @mobile text-center @endmobile">
                                                        <span >Team: <a target="_blank" class="regular-link" href="<?= $user->team->getUrl()?>"><?= $user->team->team_name?></a></span>
                                                    </div>
                                                <? } ?>
                                            @endnottablet
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="col-sm-12 text-center @mobile m-t-15 m-b-15 @elsedesktop m-t-30 @endmobile">
                                            <a href="<?= $user->getUrl()?>" class="btn btn-inno">Go to <?= $user->firstname?></a>
                                        </div>
                                    </div>
                                    @nottablet
                                        <? if(count($user->getExpertiseLinktable()) > 2) { ?>
                                            @mobile
                                                <div class="col-sm-12 moreLink text-center d-flex js-center">
                                                   <p class="m-b-0 m-r-5 regular-link collapseExpertise" data-user-id="<?= $user->id?>" data-toggle="collapse" data-target="#collapseExpertise-<?= $user->id?>" aria-expanded="false" aria-controls="collapseExpertise-<?= $user->id?>">Show more expertises</p> <i class="zmdi zmdi-chevron-left m-t-5 m-r-10 c-orange"></i>
                                                </div>
                                            @elsedesktop
                                                <div class="col-sm-12 moreLink">
                                                    <i class="zmdi zmdi-chevron-left pull-right m-t-5 m-r-10 c-orange"></i> <p class="m-b-0 pull-right m-r-5 regular-link collapseExpertise" data-user-id="<?= $user->id?>" data-toggle="collapse" data-target="#collapseExpertise-<?= $user->id?>" aria-expanded="false" aria-controls="collapseExpertise-<?= $user->id?>">Show more expertises</p>
                                                </div>
                                            @endmobile
                                        <? } ?>
                                    @endnottablet
                                </div>
                                @tablet
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <? if($user->team_id != null) { ?>
                                                <span class="col-sm-12 m-0">Team: <a target="_blank" class="regular-link" href="<?= $user->team->getUrl()?>"><?= $user->team->team_name?></a></span>
                                            <? } else { ?>
                                                <span class="col-sm-12 m-0">Team: -</span>
                                            <? } ?>
                                        </div>
                                        <? if(count($user->getExpertiseLinktable()) > 2) { ?>
                                            <div class="col-sm-6 moreLink">
                                                <i class="zmdi zmdi-chevron-left pull-right m-t-5 m-r-10 c-orange"></i> <p class="m-b-0 pull-right m-r-5 regular-link collapseExpertise" data-user-id="<?= $user->id?>" data-toggle="collapse" data-target="#collapseExpertise-<?= $user->id?>" aria-expanded="false" aria-controls="collapseExpertise-<?= $user->id?>">Show more expertises</p>
                                            </div>
                                        <? } ?>
                                    </div>
                                @endtablet
                            </div>
                        </div>
                        <div class="row p-l-15 p-r-15">
                            <? $counter = 0;?>
                            <? $arrayExpertiseId = []; ?>
                            <? foreach($user->getExpertiseLinktable() as $expertiseLinktable) { ?>
                                <? if($counter < 2) { ?>
                                    <? array_push($arrayExpertiseId, $expertiseLinktable->id)?>
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
                                <? $counter++;?>
                            <? } ?>
                        </div>
                        <div class="row p-l-15 p-r-15 collapse" id="collapseExpertise-<?= $user->id?>">
                            <? if($counter > 2) { ?>
                                <? foreach($user->getExpertiseLinktable() as $expertiseLinktable) { ?>
                                    <? if(!in_array($expertiseLinktable->id, $arrayExpertiseId)) { ?>
                                    <? array_push($arrayExpertiseId, $expertiseLinktable->id)?>
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
                                <? } ?>
                            <? } ?>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/usersList/usersList.js"></script>
@endsection