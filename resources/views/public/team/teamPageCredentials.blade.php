@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background">
        @include("includes.teamPage_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My team</h1>
            </div>
            <div class="hr"></div>
            <form action="/my-team/saveTeamProfilePicture" enctype="multipart/form-data" method="post" class="saveTeamProfilePicture">
                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                <input type="hidden" name="team_id" value="<? if(isset($team)) echo $team->id ?>">
                <div class="form-group d-flex js-center m-b-0 ">
                    <div class="d-flex fd-column col-sm-9 m-t-20">
                        <div class="row text-center">
                            <div class="col-sm-12">
                                <input type="file" name="profile_picture" class="hidden uploadFile">
                                <img style="width: 250px; height: 250px;" class="circle circleImgLg m-0" src="<?=$team->getProfilePicture()?>" alt="Profile picture">
                            </div>
                        </div>
                        <? if($team->ceo_user_id == $user->id || $user->role == 3 || $user->role == 1) { ?>
                            <div class="row text-center m-t-20 m-b-20">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-inno editProfilePicture">Edit profile picture</button>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </form>
            <form action="/my-team/saveTeamPage" method="post">
                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                <input type="hidden" name="team_id" value="<? if(isset($team)) echo $team->id ?>">
                <div class="form-group d-flex js-center m-b-0 ">
                    <div class="d-flex fd-column col-sm-9 m-t-20">
                        <div class="hr"></div>
                        <div class="row text-center m-t-20">
                            <div class="col-sm-4">
                                <p class="m-t-30">Team motivation:</p>
                            </div>
                            <div class="col-sm-8">
                                <textarea class="input" name="motivation_team" cols="50" rows="8"><? if(isset($team->team_motivation)) echo $team->team_motivation ?></textarea>
                            </div>
                        </div>
                        <div class="row text-center m-t-20">
                            <div class="col-sm-4">
                                <p class="m-t-30">Team introduction:</p>
                            </div>
                            <div class="col-sm-8">
                                <textarea class="input" name="introduction_team" cols="50" rows="8"><? if(isset($team->team_introduction)) echo $team->team_introduction ?></textarea>
                            </div>
                        </div>
                        <? if($team->ceo_user_id == $user->id || $user->role == 4 || $user->role == 3 || $user->role == 1) { ?>
                            <div class="row m-t-20 p-b-20">
                                <div class="col-sm-12">
                                    <button class="btn btn-inno pull-right">Save my team</button>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/teamPageCredentials.js"></script>
@endsection