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
            <? if(isset($payments) && $user->subscription_canceled == 0) { ?>
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
                                    <div class="col-sm-7 p-l-30">
                                        <p class="m-0"><?= $user->getName()?> xxx-<?= $card->number?></p>
                                        <p class="m-0 c-dark-grey">Expires: <?= $card->expiryMonth?>/<?= $card->expiryYear?></p>
                                        <p><?= $paymentMethod?></p>
                                    </div>
                                    <div class="col-sm-5 p-r-30">
                                        <? if($user->team->split_the_bill == 1 && count($user->team->getMembers()) > 2 && $user->id == $user->team->ceo_user_id) { ?>
                                            <button type="button" data-toggle="modal" data-target=".splitEmptyTeamModal" class="btn btn-inno btn-danger btn-block">Cancel subscription</button>
                                        <? } else { ?>
                                            <? if(count($user->team->getMembers()) > 2  && $user->id == $user->team->ceo_user_id) { ?>
                                                <button type="button" data-toggle="modal" data-target=".team2MembersModal" class="btn btn-inno btn-danger btn-block">Cancel subscription</button>
                                            <? } else { ?>
                                                <form action="/user/cancelSubscription" method="post">
                                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                    <input type="hidden" name="user_id" value="<?= $user->id?>">
                                                    <input type="hidden" name="team_id" value="<?= $user->team_id?>">
                                                    <button type="submit" class="btn btn-inno btn-danger btn-block">Cancel subscription and leave team</button>
                                                </form>
                                            <? } ?>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
            <div class="modal fade splitEmptyTeamModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body ">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>You have chosen for "split the bill" and there are still members in your team paying for the team package.</p>
                                    <p>Kick all the members from your team to cancel your own subscription</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade team2MembersModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body ">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>Your team has more than 2 members. If you want to cancel your subscrition make sure to have max 2 members in your team.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection