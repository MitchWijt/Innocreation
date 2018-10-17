@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.teamPage_sidebar")
        @endnotmobile
        <div class="container">
            @mobile
                @include("includes.teamPage_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black p-relative TeamName"><?= $team->team_name?><i class="zmdi zmdi-edit f-18 p-absolute c-pointer editTeamName" style="right: -20px;"></i></h1>
                <div class="p-relative">
                    <p class="error c-red m-0 f-14"></p>
                    <input type="text" name="teamName" class="hidden newTeamNameInput input m-b-15" value="<?= $team->team_name?>">
                    <input type="hidden" name="teamId" class="teamId" value="<?= $team->id?>">
                    <i class="zmdi zmdi-close f-18 p-absolute c-pointer closeEditName hidden" style="right: -20px; top: -10px"></i>
                </div>
            </div>
            <div class="hr col-md-10"></div>
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
                            <div class="row text-center m-t-20">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-inno editProfilePicture">Edit team picture</button>
                                </div>
                            </div>
                        <? } ?>
                        <div class="row text-center m-t-20 m-b-20">
                            <div class="col-sm-12">
                                <a href="<?=$team->getUrl()?>" class="btn btn-sm btn-inno">Go to live page</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="hr col-md-10"></div>
            <form action="/my-team/saveTeamPage" method="post">
                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                <input type="hidden" name="team_id" value="<? if(isset($team)) echo $team->id ?>">
                <div class="form-group d-flex js-center m-b-0 ">
                    <div class="d-flex fd-column col-sm-9 m-t-20">
                        <div class="row text-center m-t-20">
                            <div class="col-sm-4">
                                <p class="m-t-30">Team motivation:</p>
                            </div>
                            <div class="col-sm-8">
                                <textarea class="input col-sm-12" name="motivation_team" rows="8"><? if(isset($team->team_motivation)) echo $team->team_motivation ?></textarea>
                            </div>
                        </div>
                        <div class="row text-center m-t-20">
                            <div class="col-sm-4">
                                <p class="m-t-30">Team introduction:</p>
                            </div>
                            <div class="col-sm-8">
                                <textarea class="input col-sm-12" name="introduction_team" rows="8"><? if(isset($team->team_introduction)) echo $team->team_introduction ?></textarea>
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
    <script src="/js/team/teamPageCredentials.js"></script>
@endsection