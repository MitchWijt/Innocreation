@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My favorite teams</h1>
            </div>
            <div class="hr p-b-20 col-md-10"></div>
            <? foreach($favoriteTeams as $favoriteTeam) { ?>
                <div class="row d-flex js-center m-b-20">
                    <div class="col-md-9">
                        <div class="card card-lg ">
                            <div class="card-block">
                                <div class="row m-t-20">
                                        <div class="col-sm-4 text-center">
                                            <div class="d-flex js-center ">
                                                <div class="avatar" style="background: url('<?=$favoriteTeam->team->getProfilePicture()?>')"></div>
                                            </div>
                                            <p class="m-t-10"><?= $favoriteTeam->team->team_name?></p>
                                        </div>
                                    <div class="col-sm-8 p-r-30">
                                        <div class="text-center">
                                            <h4>Team motivation</h4>
                                        </div>
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