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
            <div class="row m-b-20">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Billing</h1>
            </div>
            <hr class="col-xs-12">
            <? if(isset($payments)) { ?>
                <div class="row d-flex js-center p-b-20 m-t-20">
                    <div class="col-md-10">
                        <div class="card card-lg">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-12 m-b-10">
                                        <p class="m-l-10 m-t-10 f-18 m-b-0">Credit card</p>
                                        <i class="m-l-10 m-t-10 f-11 c-dark-grey">Card will be charged monthly for packages purchased. All major credit cards accepted.</i>
                                    </div>
                                </div>
                                <div class="hr p-b-10 col-md-12"></div>
                                <div class="row">
                                    <div class="col-sm-9 p-l-30">
                                        <p class="m-0"><?= $user->getName()?> xxx-<?= $card->number?></p>
                                        <p class="m-0 c-dark-grey">Expires: <?= $card->expiryMonth?>/<?= $card->expiryYear?></p>
                                        <p><?= $paymentMethod?></p>
                                    </div>
                                    <div class="col-sm-3 p-r-30">
                                        <button class="btn btn-inno btn-danger btn-block">Cancel subscription</button>
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