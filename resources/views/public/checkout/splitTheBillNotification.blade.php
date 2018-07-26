@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Almost there!</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <hr class="m-b-20">
            <div class="row d-flex js-center p-b-20">
                <div class="card card-lg">
                    <div class="card-block">
                        <div class="sub-title-container p-t-20">
                            <h1 class="sub-title-black c-gray f-30">Thank you <?= $user->team->team_name?> in advance!</h1>
                        </div>
                        <div class="hr-card p-b-20"></div>
                        <div class="col-sm-12">
                            <p class="m-0">You have chosen to split the bill with your innovative team,</p>
                            <p class="m-0">There has been sent a message to every team member to accept the request and validate their credit card.</p>
                            <p class="m-0">Once they have all been verified and accepted the payment will continue and your team will officially be a <span class="c-orange"><? if(\Illuminate\Support\Facades\Session::has("customPackagesArray")) echo "innovator"; else echo str_replace("-", " ", lcfirst($teamPackage->title))?></span></p>
                            <p>Goodluck!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection