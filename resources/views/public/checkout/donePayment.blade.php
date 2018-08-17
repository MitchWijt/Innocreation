@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">You're team is oficially a <? if(\Illuminate\Support\Facades\Session::has("customPackagesArray")) echo "innovator"; else echo str_replace("-", " ", lcfirst($teamPackage->title))?></h1>
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
                            <h1 class="sub-title-black c-gray f-30">Thank you <?= $teamPackage->team->team_name?>!</h1>
                        </div>
                        <div class="hr-card p-b-20"></div>
                        <div class="col-sm-12">
                            <p class="m-0">We at Innocreation,</p>
                            <p class="m-0">wish you a very innovative, creative and fun journey to the reality of your idea/dream!</p>
                            <p>Goodluck!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection