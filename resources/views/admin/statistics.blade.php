@extends("layouts.app_admin")
@section("content")
    <div class="d-flex grey-background vh100">
        @include("includes.admin_sidebar")
        <div class="container">
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="m-t-5">Statistics user data</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 m-t-10 d-flex">
                                <div class="col-sm-2">
                                    <div class="text-center">
                                        <p class="f-20 m-b-0"><?= count($totalUsers)?></p>
                                        <p class="f-20">Users</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="text-center">
                                        <p class="f-20 m-b-0"><?= count($totalTeams)?></p>
                                        <p class="f-20">Teams</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="text-center">
                                        <p class="f-20 m-b-0"><?= count($totalTasks)?></p>
                                        <p class="f-20">Tasks created</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="text-center">
                                        <p class="f-20 m-b-0"><?= count($totalMessages)?></p>
                                        <p class="f-20">Messages sent</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="text-center">
                                        <p class="f-20 m-b-0"><?= count($totalInvited)?></p>
                                        <p class="f-20">Invites send</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="text-center">
                                        <p class="f-20 m-b-0"><?= count($totalRequests)?></p>
                                        <p class="f-20">Requests send</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="m-t-5">Statistics expertises</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="m-t-5">Statistics revenue/payments</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="m-t-5">Statistics crowd funding</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="m-t-5">Statistics charity</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection