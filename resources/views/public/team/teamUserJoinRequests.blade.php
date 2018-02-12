@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.teamPage_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Team join requests</h1>
            </div>
            <hr>
            <? foreach($userJoinRequests as $userJoinRequest) { ?>
            <div class="card m-t-20 m-b-20">
                <div class="card-block m-t-10">
                    <div class="col-sm-12 d-flex">
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
                            <div class="col-sm-4 text-center p-b-15">
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
            <? } ?>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/teamUserJoinRequests.js"></script>
@endsection