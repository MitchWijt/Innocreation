@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
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
                <h1 class="sub-title-black">Team Payment settings</h1>
            </div>
            <?
                $counterValidated = 0;
            ?>
            <div class="hr p-b-20 col-md-10"></div>
            <? if(count($team->getMembers()) > 2) { ?>
                <div class="row d-flex js-center m-t-20">
                    <div class="col-md-10">
                        <div class="card card-lg">
                            <div class="card-block">
                                <form action="/my-team/savePaymentSettings" method="post" class="savePaymentSettingsForm">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <input type="hidden" class="team_id" name="team_id" value="<?= $team->id?>">
                                    <div class="row">
                                        <div class="col-sm-9 m-b-10">
                                            <p class="m-l-10 m-t-10 f-18 m-b-5">Split the bill settings</p>
                                            <small class="m-l-10 m-t-0">Total amount: <span>€</span><span class="totalAmount"><?= number_format($teamPackage->price, 2, ".", ".")?></span></small>

                                        </div>
                                        <div class="col-sm-3 m-t-10">
                                            <input class="m-r-5" <? if($team->split_the_bill == 1) echo "checked"?> type="checkbox" name="splitTheBillOnOff" value="1" id="splitTheBillOnOff"><label for="splitTheBillOnOff">Use split the bill</label>
                                            <button type="button" class="btn btn-inno btn-sm pull m-b-10 splitEqually">Split equally</button>
                                        </div>
                                    </div>
                                    <div class="hr p-b-5 col-md-12"></div>
                                    <div class="col-sm-12">
                                        <i class="c-dark-grey">Amount left to split: <span>€</span><i class="packagePrice totalPrice"><?= number_format($teamPackage->price, 2, ".", ".")?></i></i><br>
                                        <i class="c-orange amountExceeded hidden">Amount exceeded: <span>€</span><i class="exceededAmount"></i></i>
                                    </div>
                                    <? foreach($team->getMembers() as $member) { ?>
                                            <? if($member->subscription_canceled == 0) { ?>
                                                <div class="row text-center">
                                                    <div class="col-sm-6">
                                                        <p><?= $member->getName()?></p>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="d-flex fd-row js-center">
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
                                        <div class="col-sm-11">
                                            <button type="button" class="btn btn-inno btn-sm m-b-20 savePaymentSettings pull-right">Save payment settings</button>
                                        </div>
                                    </div>
                                    <div class="hr p-b-20 col-md-12"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/team/teamPaymentSettings.js"></script>
@endsection
