@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Reset password</h1>
            </div>
            <div class="hr col-sm-12 m-b-20"></div>
            <div class="row d-flex js-center p-b-20">
                <div class="col-md-8">
                    <div class="card text-center">
                        <div class="card-block">
                            <div class="col-sm-12 p-10">
                                <form action="/user/resetPassword" method="post">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <input type="hidden" name="user_id" value="<?= $user->id?>">
                                    <div class="row d-flex js-center">
                                        <div class="col-sm-8">
                                            <p class="m-0">Your new password</p>
                                            <input type="password" name="password" placeholder="new password" class="input">
                                            <p class="m-b-0 m-t-10">Confirm new password</p>
                                            <input type="password" name="confirm_password" placeholder="confirm new password" class="input">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <button class="btn btn-inno btn-sm pull-right m-t-20">Reset password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection