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
                <h1 class="sub-title-black @mobile f-25 @endmobile">Team join requests</h1>
            </div>
            <hr>
            <? foreach($userJoinRequests as $userJoinRequest) { ?>
            <div class="row d-flex js-center">
                <div class="col-md-9">
                    <div class="card m-t-20 m-b-20">
                        <div class="card-block m-t-10 row">
                            <div class="col-sm-5 text-center m-t-15">
                                <h3><?=$userJoinRequest->users->First()->getName()?></h3>
                            </div>
                            <? if($userJoinRequest->accepted == 0) { ?>
                            <div class="col-sm-2 text-center" style="margin-top: 20px;">
                                <p><?= $userJoinRequest->expertises->First()->title?></p>
                            </div>
                            <? } else { ?>
                            <div class="col-sm-3 text-center" style="margin-top: 20px;">
                                <p><?= $userJoinRequest->expertises->First()->title?></p>
                            </div>
                            <? } ?>
                            <? if($userJoinRequest->accepted == 0) { ?>
                            <div class="col-sm-5 text-center p-b-15">
                                <? } else { ?>
                                    <div class="col-sm-4 text-center d-flex js-center p-b-15 p-r-0">
                                <? } ?>
                                    <? if($userJoinRequest->accepted == 0) { ?>
                                        <? if($user_id == $userJoinRequest->teams->First()->ceo_user_id) { ?>
                                        <form action="/my-team/rejectUserFromTeam" class="rejectUserFromTeam" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="request_id" value="<?= $userJoinRequest->id?>">
                                            <div class="circle circleImage p-relative pull-right c-pointer rejectUser">
                                                <span style="left: 23px; top: 10px" class="p-absolute f-25"><i class="zmdi zmdi-close c-orange"></i></span>
                                            </div>
                                        </form>
                                        <form action="/my-team/acceptUserInteam" class="acceptUserInTeam" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="request_id" value="<?= $userJoinRequest->id?>">
                                            <input type="hidden" name="user_id" value="<?= $userJoinRequest->users->First()->id?>">
                                            <input type="hidden" name="expertise_id" value="<?= $userJoinRequest->expertise_id?>">
                                            <input type="hidden" name="team_id" value="<?= $userJoinRequest->team_id?>">
                                            <div class="circle circleImage p-relative pull-right c-pointer acceptUser">
                                                <span style="left: 22px; top: 9px" class="p-absolute f-25"><i class="zmdi zmdi-check c-orange"></i></span>
                                            </div>
                                        </form>
                                        <? } else { ?>
                                            <div class="circle circleImage p-relative pull-right">
                                                <span style="left: 23px; top: 10px" class="p-absolute f-25"><i class="zmdi zmdi-close c-orange"></i></span>
                                            </div>
                                            <div class="circle circleImage p-relative pull-right">
                                                <span style="left: 22px; top: 9px" class="p-absolute f-25"><i class="zmdi zmdi-check c-orange"></i></span>
                                            </div>
                                        <? } ?>
                                    <? } else if($userJoinRequest->accepted == 1) { ?>
                                        <div class="circle circleImage p-relative pull-right">
                                            <span style="left: 22px; top: 9px" class="p-absolute f-25"><i class="zmdi zmdi-check c-orange"></i></span>
                                        </div>
                                    <? } else if($userJoinRequest->accepted == 2) { ?>
                                        <div class="circle circleImage p-relative pull-right">
                                            <span style="left: 24px; top: 11px" class="p-absolute f-25"><i class="zmdi zmdi-close c-orange"></i></span>
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Invites</h1>
            </div>
            <hr>
            <? foreach($invites as $invite) { ?>
                <div class="row d-flex js-center">
                    <div class="col-md-9">
                        <div class="card m-t-20 m-b-20">
                            <div class="card-block m-t-10 row">
                                <div class="col-sm-5 text-center m-t-15">
                                    <h3><?=$invite->users->First()->getName()?></h3>
                                </div>
                                <div class="col-sm-3 text-center" style="margin-top: 20px;">
                                    <p><?= $invite->expertises->First()->title?></p>
                                </div>
                                <div class="col-sm-4 text-center p-b-15 d-flex js-center p-r-0">
                                    <div class="circle circleImage p-relative pull-right">
                                        <? if($invite->accepted == 0) { ?>
                                        <p class="f-13 p-absolute c-orange" style="top: 10px; left: 17px;">On<br>hold</p>
                                        <? } else if($invite->accepted == 1) { ?>
                                        <span style="left: 22px; top: 9px" class="p-absolute f-25"><i class="zmdi zmdi-check c-orange"></i></span>
                                        <? } else if($invite->accepted == 2) { ?>
                                        <span style="left: 24px; top: 11px" class="p-absolute f-25"><i class="zmdi zmdi-close c-orange"></i></span>
                                        <? } ?>
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
@section('pagescript')
    <script src="/js/team/teamUserJoinRequests.js"></script>
@endsection