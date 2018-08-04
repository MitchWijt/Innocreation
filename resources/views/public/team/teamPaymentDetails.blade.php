@extends("layouts.app")
@section("content")
    <script type="text/javascript" src="https://test.adyen.com/hpp/cse/js/8215323598983147.shtml"></script>
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
                <h1 class="sub-title-black">Team Payment details</h1>
            </div>
            <?
                $counterValidated = 0;
            ?>
            <div class="hr p-b-20 col-md-10"></div>
            <? if($team->split_the_bill == 1) { ?>
                <div class="row d-flex js-center m-t-20">
                    <div class="col-md-10">
                        <div class="card card-lg">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="m-l-10 m-t-10 f-18 m-b-10">Split the bill</p>
                                    </div>
                                </div>
                                <div class="hr p-b-20 col-md-12"></div>
                                <? foreach($splitTheBillDetails as $splitTheBillDetail) { ?>
                                    <div class="row text-center">
                                        <div class="col-sm-6">
                                            <p><?= $splitTheBillDetail->user->getName()?></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="d-flex fd-row js-center">
                                                <? if($splitTheBillDetail->accepted == 1) { ?>
                                                    <? $counterValidated++ ?>
                                                    <p class="c-green">Validated <i class="zmdi zmdi-check c-green"></i> </p>
                                                <? } else { ?>
                                                    <p>Waiting to be validated</p>
                                                <? } ?>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                                <div class="hr p-b-20 col-md-12"></div>
                                <div class="col-sm-12">
                                    <p>Payment will automatically pursue when all members have verified their payment details.</p>
                                    <p>Payment status: <? if ($counterValidated >= 4) echo "<span class='c-green'> Payment pursued</span>"; else echo " <span class='c-orange'> On hold</span>";?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
            <? if($teamPackage->change_package == 1) { ?>
                <? if($splitTheBillDetails->First()->reserved_changed_amount != null) { ?>
                    <div class="row d-flex js-center m-t-20">
                        <div class="col-md-10">
                            <div class="card card-lg">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="m-l-10 m-t-10 f-18 m-b-10">Change package validation</p>
                                        </div>
                                    </div>
                                    <div class="hr p-b-20 col-md-12"></div>
                                    <? foreach($splitTheBillDetails as $splitTheBillDetail) { ?>
                                        <div class="row text-center">
                                            <div class="col-sm-6">
                                                <p><?= $splitTheBillDetail->user->getName()?></p>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="d-flex fd-row js-center">
                                                    <? if($splitTheBillDetail->accepted_change == 1) { ?>
                                                        <p class="c-green">Validated <i class="zmdi zmdi-check c-green"></i> </p>
                                                    <? } else { ?>
                                                        <p>Waiting to be validated</p>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <? } ?>
                                    <div class="hr p-b-20 col-md-12"></div>
                                    <div class="col-sm-12">
                                        <p>You will be able to change the package once all the members have validated</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            <? } ?>
        </div>
    </div>
@endsection
