@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100">
        @include("includes.userAccount_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My join requests</h1>
            </div>
            <div class="hr col-md-12"></div>
            <? foreach($teamJoinRequests as $teamJoinRequest) { ?>
                <div class="row d-flex js-center">
                    <div class="col-md-9">
                        <div class="card card-lg m-t-20 m-b-20">
                            <div class="row card-block m-t-10">
                                <div class="col-sm-5 text-center m-t-15">
                                    <h3><?=$teamJoinRequest->teams->First()->team_name?></h3>
                                </div>
                                <div class="col-sm-3 text-center" style="margin-top: 20px;">
                                    <p><?= $teamJoinRequest->expertises->First()->title?></p>
                                </div>
                                <div class="col-sm-4 text-center p-b-15">
                                    <div class="circle circleImage p-relative pull-right">
                                        <? if($teamJoinRequest->accepted == 0) { ?>
                                            <p class="f-13 p-absolute c-orange" style="top: 10px; left: 17px;">On<br>hold</p>
                                        <? } else if($teamJoinRequest->accepted == 1) { ?>
                                            <span style="left: 22px; top: 9px" class="p-absolute f-25"><i class="zmdi zmdi-check c-orange"></i></span>
                                        <? } else if($teamJoinRequest->accepted == 2) { ?>
                                            <span style="left: 24px; top: 11px" class="p-absolute f-25"><i class="zmdi zmdi-close c-orange"></i></span>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My invites</h1>
            </div>
            <div class="hr col-md-12"></div>
            <? foreach($invites as $invite) { ?>
                <div class="row d-flex js-center">
                    <div class="col-md-9">
                        <div class="card card-lg m-t-20 m-b-20">
                            <div class="row card-block m-t-10">
                                <div class="col-sm-5 text-center m-t-15">
                                    <h3><?=$invite->teams->First()->team_name?></h3>
                                </div>
                                <? if($invite->accepted == 0) { ?>
                                <div class="col-sm-2 text-center" style="margin-top: 20px;">
                                    <p><?= $invite->expertises->First()->title?></p>
                                </div>
                                <? } else { ?>
                                <div class="col-sm-3 text-center" style="margin-top: 20px;">
                                    <p><?= $invite->expertises->First()->title?></p>
                                </div>
                                <? } ?>
                                <? if($invite->accepted == 0) { ?>
                                <div class="col-sm-5 text-center p-b-15">
                                    <? } else { ?>
                                    <div class="col-sm-4 text-center p-b-15">
                                    <? } ?>
                                        <? if($invite->accepted == 0) { ?>
                                        <form action="/my-account/rejectTeamInvite" class="rejectTeamInvite" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="invite_id" value="<?= $invite->id?>">
                                            <div class="circle circleImage p-relative pull-right c-pointer rejectInvite">
                                                <span style="left: 23px; top: 10px" class="p-absolute f-25"><i class="zmdi zmdi-close c-orange"></i></span>
                                            </div>
                                        </form>
                                        <form action="/my-account/acceptTeamInvite" class="acceptTeamInvite" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="invite_id" value="<?= $invite->id?>">
                                            <input type="hidden" name="user_id" value="<?= $invite->users->First()->id?>">
                                            <input type="hidden" name="expertise_id" value="<?= $invite->expertise_id?>">
                                            <input type="hidden" name="team_id" value="<?= $invite->team_id?>">
                                            <div class="circle circleImage p-relative pull-right c-pointer acceptInvite">
                                                <span style="left: 22px; top: 9px" class="p-absolute f-25"><i class="zmdi zmdi-check c-orange"></i></span>
                                            </div>
                                        </form>
                                        <? } else if($invite->accepted == 1) { ?>
                                        <div class="circle circleImage p-relative pull-right">
                                            <span style="left: 22px; top: 9px" class="p-absolute f-25"><i class="zmdi zmdi-check c-orange"></i></span>
                                        </div>
                                        <? } else if($invite->accepted == 2) { ?>
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
            </div>
        </div>
@endsection
        @section('pagescript')
            <script src="/js/user/userTeamJoinRequests.js"></script>
@endsection