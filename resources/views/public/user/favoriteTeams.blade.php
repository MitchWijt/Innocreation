@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
        @include("includes.userAccount_sidebar")
        @endnotmobile
        <div class="container">
            @mobile
            @include("includes.userAccount_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My favorite teams</h1>
            </div>
            <div class="hr p-b-20 col-md-10"></div>
            <? foreach($favoriteTeams as $favoriteTeam) { ?>
                <div class="row d-flex js-center m-b-20">
                    <div class="col-md-9">
                        <div class="card card-lg text-center">
                            <div class="card-block">
                                <div class="row m-t-20  ">
                                        <div class="col-sm-3">
                                            <img class="circle circleImage m-0" src="<?= $favoriteTeam->team->getProfilePicture()?>" alt="<?= $favoriteTeam->team->team_name?>">
                                            <p class="m-t-10"><?= $favoriteTeam->team->team_name?></p>
                                        </div>
                                    <div class="col-sm-9 p-r-30">
                                        <h4>Team motivation</h4>
                                        <hr>
                                        <p><?= $favoriteTeam->team->team_motivation?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 m-b-10">
                                        <a href="<?= $favoriteTeam->team->getUrl()?>" class="btn btn-inno btn-sm pull-right m-r-10">See <?= $favoriteTeam->team->team_name?></a>
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