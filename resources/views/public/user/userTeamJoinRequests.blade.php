@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100">
        @include("includes.userAccount_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My join requests</h1>
            </div>
            <div class="hr col-sm-12"></div>
            <? foreach($teamJoinRequests as $teamJoinRequest) { ?>
                <div class="card m-t-20 m-b-20">
                    <div class="card-block m-t-10">
                        <div class="col-sm-12 d-flex">
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
            <? } ?>
        </div>
    </div>
@endsection