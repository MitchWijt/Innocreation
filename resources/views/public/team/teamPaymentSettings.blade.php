@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85 <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
        @notmobile
            @include("includes.teamPage_sidebar")
        @endnotmobile
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            @mobile
                @include("includes.teamPage_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black bold">Team Payment settings</h1>
            </div>
            <?
                $counterValidated = 0;
            ?>
            <div class="hr p-b-20 col-md-10"></div>
            <? if(count($team->getMembers()) > 1 && $team->packageDetails()) { ?>
                <div class="row d-flex js-center m-t-20">
                    <div class="col-md-10">
                        <form action="/my-team/savePaymentSettings" method="post" class="savePaymentSettingsForm">
                            <input type="hidden" name="splitTheBillOnOff" value="1">
                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                            <input type="hidden" class="team_id" name="team_id" value="<?= $team->id?>">
                            <div class="row m-b-30">
                                <div class="col-sm-9 m-b-10">
                                    <p>Current package: <?= $teamPackage->title?></p>
                                    <p>Price: <span>€</span><span class="totalAmount"><?= number_format($teamPackage->price, 2, ".", ".")?></span></p>
                                    <p class="m-b-0">Amount left to split: <span>€</span><span class="packagePrice totalPrice"><?= number_format($teamPackage->price, 2, ".", ".")?></span></p><br>
                                    <p class="c-orange amountExceeded hidden m-b-0">Amount exceeded: <span>€</span><i class="exceededAmount"></i></p>
                                </div>
                                <div class="col-sm-3 m-t-10">
                                    <button type="button" class="btn btn-inno btn-sm pull m-b-10 splitEqually m-t-20">Split price equally</button>
                                </div>
                            </div>
                            <? foreach($team->getMembers() as $member) { ?>
                                    <? if($member->subscription_canceled == 0) { ?>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p><?= $member->getName()?></p>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="d-flex jc-end">
                                                    <? if($member->getSplitTheBill()) { ?>
                                                        <input type="text" name="splitTheBillValue" class="input splittedAmountMember" data-member-id="<?= $member->id?>" value="<?= number_format($member->getSplitTheBill()->amount, 2, ".", ".")?>">
                                                    <? } else { ?>
                                                        <input type="text" name="splitTheBillValue" class="input splittedAmountMember" data-member-id="<?= $member->id?>" value="">
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <? } ?>
                            <? } ?>
                            <div class="col-sm-12">
                            <small class="splitError c-red"></small>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 m-t-30">
                                    <button type="button" class="btn btn-inno-cta btn-sm m-b-20 savePaymentSettings pull-right">Save payment settings</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <span class="thin f-14">By saving the payment settings you agree with using “split the bill” as payment method</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/team/teamPaymentSettings.js"></script>
@endsection
