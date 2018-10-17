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
                <h1 class="sub-title-black">Team create requests</h1>
            </div>
            <div class="hr col-md-12"></div>
            <? foreach($teamCreateRequests as $teamCreateRequest) { ?>
                <div class="row d-flex js-center">
                    <div class="col-md-9">
                        <div class="card card-lg m-t-20 m-b-20">
                            <div class="row card-block m-t-10">
                                <div class="col-sm-5 text-center m-t-15">
                                    <p><?=$teamCreateRequest->sender->firstname?> would like to create a team with you, do you accept or decline?</p>
                                </div>
                                <? if($teamCreateRequest->accepted == 0) { ?>
                                <div class="col-sm-5 text-center p-b-15">
                                    <? } else { ?>
                                    <div class="col-sm-4 text-center d-flex js-center p-b-15 p-r-0">
                                        <? } ?>
                                        <? if($teamCreateRequest->accepted == 0) { ?>
                                        <form action="/my-account/rejectCreateTeamRequest" class="rejectCreateRequest" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="teamCreateRequestId" value="<?= $teamCreateRequest->id?>">
                                            <div class="circle circleImage p-relative pull-right c-pointer rejectInvite">
                                                <span style="left: 23px; top: 10px" class="p-absolute f-25"><i class="zmdi zmdi-close c-orange"></i></span>
                                            </div>
                                        </form>
                                        <form action="/my-account/acceptCreateTeamRequest" class="acceptCreateRequest" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="teamCreateRequestId" value="<?= $teamCreateRequest->id?>">
                                            <input type="hidden" name="receiver_user_id" value="<?= $teamCreateRequest->receiver->id?>">
                                            <div class="circle circleImage p-relative pull-right c-pointer acceptInvite">
                                                <span style="left: 22px; top: 9px" class="p-absolute f-25"><i class="zmdi zmdi-check c-orange"></i></span>
                                            </div>
                                        </form>
                                        <? } else if($teamCreateRequest->accepted == 1) { ?>
                                        <div class="circle circleImage p-relative pull-right">
                                            <span style="left: 22px; top: 9px" class="p-absolute f-25"><i class="zmdi zmdi-check c-orange"></i></span>
                                        </div>
                                        <? } else if($teamCreateRequest->accepted == 2) { ?>
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
    <script src="/js/user/teamCreateRequests.js"></script>
@endsection