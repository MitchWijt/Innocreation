@extends("layouts.app")
@section("content")
    <script type="text/javascript" src="https://test.adyen.com/hpp/cse/js/8215323598983147.shtml"></script>
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.userAccount_sidebar")
        @endnotmobile
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            @mobile
                @include("includes.userAccount_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Package details</h1>
            </div>
            <div class="hr p-b-20 col-md-10"></div>
            <? foreach($splitTheBillDetails as $splitTheBillDetail) { ?>
                <? if($user->team->split_the_bill == 1) { ?>
                    <div class="row d-flex js-center p-b-20">
                        <div class="col-md-10">
                            <div class="card card-lg">
                                <div class="card-block">
                                    <div class="row m-t-20 m-b-20">
                                        <div class="col-sm-9">
                                            <? if($splitTheBillDetail->allAccepted($user->team_id)) { ?>
                                                <p class="m-l-10">Everyone in your team <?= $user->team->team_name?> has validated the split the bill. Make your payment for the package to enjoy the package asap!</p>
                                            <? } else { ?>
                                                <? if($user->payment_refused == 0) { ?>
                                                    <p class="m-l-10"><a target="_blank" href="<?= $splitTheBillDetail->team->getUrl()?>" class="regular-link"><?= $splitTheBillDetail->team->team_name?></a> has asked you to accept and validate the "split the bill". Since you are a member of this team. Validate as soon as possible to enjoy the benefits of your package even quiker!</p>
                                                <? } else { ?>
                                                    <p class="m-l-10">Your recurring payment for team <?= $user->team->team_name?> has been refused. Please validate your credit card to pursue the payment</p>
                                                <? } ?>
                                            <? } ?>
                                        </div>
                                        <div class="col-sm-3 m-t-10">
                                            <? if($splitTheBillDetail->allAccepted($user->team_id)) { ?>
                                                <a href="<?= $splitTheBillDetail->getPaymentUrl()?>" class="btn btn-inno">Pay package</a>
                                            <? } else { ?>
                                                <? if($splitTheBillDetail->accepted == 1 && $splitTheBillDetail->user->payment_refused == 0) { ?>
                                                    <p class="c-green">Validated <i class="zmdi zmdi-check c-green"></i> </p>
                                                <? } else { ?>
                                                    <button data-toggle="collapse" href="#collapse-<?= $splitTheBillDetail->id?>" class="btn btn-inno pull">Validate</button>
                                                <? } ?>
                                            <? } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?
                                $date = date("Y-m-d");
                                $time = date("H:i:s");
                            ?>
                            <div id="collapse-<?= $splitTheBillDetail->id?>" class="collapse">
                                <div class="card card-lg">
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-sm-8 m-t-20 text-center">
                                                <? if(isset($teamPackage)) { ?>
                                                <? if($teamPackage->custom_team_package_id != null) { ?>
                                                    <p class="f-20 m-t-0">Innovator(custom package)</p>
                                                <? } else { ?>
                                                    <p class="f-20 m-t-0"><?= str_replace("-", " ", ucfirst($teamPackage->title))?></p>
                                                <? } ?>
                                                    <p style="letter-spacing: 1px;"><?= "&euro;" . number_format($splitTheBillDetail->amount, 2, ".", ".")?><span style="letter-spacing: 0px;"><? if($teamPackage->payment_preference == "monthly") echo "/Month"; else echo "/Year";?></span></p>
                                                <?} ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <form method="POST" class="m-t-30" action="/user/validateSplitTheBill" id="adyen-encrypted-form">
                                                    <input type="hidden" name="user_id" value="<?= $splitTheBillDetail->user_id?>">
                                                    <input type="hidden" name="split_the_bill_linktable_id" value="<?= $splitTheBillDetail->id?>">
                                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                    <input type="hidden" name="team_id" value="<?= $splitTheBillDetail->team_id?>">
                                                    <div class="row m-t-10 m-b-20">
                                                        <div class="col-sm-12 m-b-10">
                                                            <input type="button" class="btn btn-inno btn-sm btn-danger m-r-10 rejectSplitTheBillBtn" value="Reject"/>
                                                            <input type="submit" class="btn btn-inno btn-sm" value="Validate"/>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input type="checkbox" class="input m-r-5" name="paymentTermsCheck" value="1" id="paymentTermsCheck"><label for="paymentTermsCheck">I agree with the terms of service</label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input type="checkbox" class="input m-r-5" name="privacyTermsCheck" value="1" id="privacyTermsCheck"><label for="privacyTermsCheck">I agree with the privacy policy</label>
                                                        </div>
                                                    </div>
                                                </form>
                                                <form action="/user/rejectSplitTheBill" method="post" class="hidden rejectSplitTheBillForm">
                                                    <input type="hidden" name="user_id" value="<?= $splitTheBillDetail->user_id?>">
                                                    <input type="hidden" name="split_the_bill_linktable_id" value="<?= $splitTheBillDetail->id?>">
                                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                    <input type="hidden" name="team_id" value="<?= $splitTheBillDetail->team_id?>">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            <? } ?>
            <? if(isset($teamPackage)) { ?>
                <? if($teamPackage->change_package == 1) { ?>
                    <? foreach($splitTheBillDetails as $splitTheBillDetail) { ?>
                        <? if($splitTheBillDetail->reserved_changed_amount != null) { ?>
                            <div class="row d-flex js-center p-b-20">
                                <div class="col-md-10">
                                    <div class="card card-lg">
                                        <div class="card-block">
                                            <div class="row m-t-20 m-b-20">
                                                <div class="col-sm-10">
                                                    <p class="m-l-10"><a target="_blank" href="<?= $splitTheBillDetail->team->getUrl()?>" class="regular-link"><?= $splitTheBillDetail->team->team_name?></a> has asked you to accept and validate the change of your team package. Since you are a member of this team. Validate as soon as possible to enjoy the benefits of your new package even quiker!</p>
                                                </div>
                                                <div class="col-sm-2 m-t-10">
                                                    <? if($splitTheBillDetail->accepted_change== 1) { ?>
                                                        <p class="c-green">Validated <i class="zmdi zmdi-check c-green"></i> </p>
                                                    <? } else { ?>
                                                        <button data-toggle="collapse" href="#collapse-<?= $splitTheBillDetail->id?><?= $splitTheBillDetail->user_id?>" class="btn btn-inno pull">Validate</button>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                    $date = date("Y-m-d");
                                    $time = date("H:i:s");
                                    ?>
                                    <div id="collapse-<?= $splitTheBillDetail->id?><?= $splitTheBillDetail->user_id?>" class="collapse">
                                        <div class="card card-lg">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col-sm-12 m-t-20 text-center">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <? if($teamPackage->custom_team_package_id != null) { ?>
                                                                    <p class="f-20 m-t-0">Innovator (custom package)</p>
                                                                <? } else { ?>
                                                                    <p class="f-20 m-t-0"><?= str_replace("-", " ", ucfirst($splitTheBillDetail->reservedMembershipPackage->title))?></p>
                                                                <? } ?>
                                                                <p style="letter-spacing: 1px;"><?= "&euro;" . number_format($splitTheBillDetail->amount, 2, ".", ".")?><span style="letter-spacing: 0px;"><? if($teamPackage->payment_preference == "monthly") echo "/Month"; else echo "/Year";?></span></p>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <i class="zmdi zmdi-long-arrow-right m-t-15" style="font-size: 50px;"></i>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <? if($teamPackage->custom_team_package_id != null) { ?>
                                                                    <p class="f-20 m-t-0">Innovator (custom package)</p>
                                                                <? } else { ?>
                                                                    <p class="f-20 m-t-0"><?= str_replace("-", " ", ucfirst($splitTheBillDetail->membershipPackage->title))?></p>
                                                                <? } ?>
                                                                <p style="letter-spacing: 1px;"><?= "&euro;" . number_format($splitTheBillDetail->reserved_changed_amount, 2, ".", ".")?><span style="letter-spacing: 0px;"><? if($teamPackage->payment_preference == "monthly") echo "/Month"; else echo "/Year";?></span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <form method="POST" class="m-t-20 pull-right m-r-20 m-b-20" action="/user/validateChange">
                                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                            <input type="hidden" name="user_id" value="<?= $splitTheBillDetail->user_id?>">
                                                            <input type="hidden" name="split_the_bill_linktable_id" value="<?= $splitTheBillDetail->id?>">
                                                            <input type="hidden" name="team_id" value="<?= $splitTheBillDetail->team_id?>">
                                                            <input type="hidden" value="<?=$date?>T<?=$time?>Z" data-encrypted-name="generationtime"/>
                                                            <input type="submit" class="btn btn-inno btn-sm pull-right" value="Validate"/>
                                                        </form>
                                                        <form method="POST" class="m-t-20 pull-right m-r-20 m-b-20" action="/user/rejectChange">
                                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                            <input type="hidden" name="user_id" value="<?= $splitTheBillDetail->user_id?>">
                                                            <input type="hidden" name="split_the_bill_linktable_id" value="<?= $splitTheBillDetail->id?>">
                                                            <input type="hidden" name="team_id" value="<?= $splitTheBillDetail->team_id?>">
                                                            <input type="hidden" value="<?=$date?>T<?=$time?>Z" data-encrypted-name="generationtime"/>
                                                            <input type="submit" class="btn btn-inno btn-sm btn-danger pull-right" value="Reject"/>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <? } ?>
                    <? } ?>
                <? } ?>
                <? if($teamPackage->changed_payment_settings == 1) { ?>
                    <? foreach($splitTheBillDetails as $splitTheBillDetail) { ?>
                        <? if($splitTheBillDetail->reserved_changed_amount != null) { ?>
                            <div class="row d-flex js-center p-b-20">
                                <div class="col-md-10">
                                    <div class="card card-lg">
                                        <div class="card-block">
                                            <div class="row m-t-20 m-b-20">
                                                <div class="col-sm-10">
                                                    <p class="m-l-10"><a target="_blank" href="<?= $splitTheBillDetail->team->getUrl()?>" class="regular-link"><?= $splitTheBillDetail->team->team_name?></a> has altered the prices for the split the bill. verify the change if you agree with it</p>
                                                </div>
                                                <div class="col-sm-2 m-t-10">
                                                    <? if($splitTheBillDetail->accepted_change == 1) { ?>
                                                        <p class="c-green">Validated <i class="zmdi zmdi-check c-green"></i> </p>
                                                    <? } else { ?>
                                                        <button data-toggle="collapse" href="#collapse-<?= $splitTheBillDetail->id?><?= $splitTheBillDetail->user_id?><?= $splitTheBillDetail->team_id?>" class="btn btn-inno pull">Validate</button>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                    $date = date("Y-m-d");
                                    $time = date("H:i:s");
                                    ?>
                                    <div id="collapse-<?= $splitTheBillDetail->id?><?= $splitTheBillDetail->user_id?><?= $splitTheBillDetail->team_id?>" class="collapse">
                                        <div class="card card-lg">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col-sm-12 m-t-20 text-center">
                                                        <div class="row">
                                                            <div class="col-sm-5 m-t-10">
                                                                <p style="letter-spacing: 1px;"><?= "&euro;" . number_format($splitTheBillDetail->amount, 2, ".", ".")?><span style="letter-spacing: 0px;"><? if($teamPackage->payment_preference == "monthly") echo "/Month"; else echo "/Year";?></span></p>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <i class="zmdi zmdi-long-arrow-right" style="font-size: 50px;"></i>
                                                            </div>
                                                            <div class="col-sm-5 m-t-10">
                                                                <p style="letter-spacing: 1px;"><?= "&euro;" . number_format($splitTheBillDetail->reserved_changed_amount, 2, ".", ".")?><span style="letter-spacing: 0px;"><? if($teamPackage->payment_preference == "monthly") echo "/Month"; else echo "/Year";?></span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <form method="POST" class="m-t-20 pull-right m-r-20 m-b-20" action="/user/validateChange">
                                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                            <input type="hidden" name="user_id" value="<?= $splitTheBillDetail->user_id?>">
                                                            <input type="hidden" name="split_the_bill_linktable_id" value="<?= $splitTheBillDetail->id?>">
                                                            <input type="hidden" name="team_id" value="<?= $splitTheBillDetail->team_id?>">
                                                            <input type="submit" class="btn btn-inno btn-sm pull-right" value="Validate"/>
                                                        </form>
                                                        <form method="POST" class="m-t-20 pull-right m-r-20 m-b-20" action="/user/rejectChange">
                                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                            <input type="hidden" name="user_id" value="<?= $splitTheBillDetail->user_id?>">
                                                            <input type="hidden" name="split_the_bill_linktable_id" value="<?= $splitTheBillDetail->id?>">
                                                            <input type="hidden" name="team_id" value="<?= $splitTheBillDetail->team_id?>">
                                                            <input type="submit" class="btn btn-inno btn-sm btn-danger pull-right" value="Reject"/>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <? } ?>
                    <? } ?>
                <? } ?>
            <? } ?>
        </div>
    </div>
    <script>
        // The form element to encrypt.
        var form = document.getElementById('adyen-encrypted-form');
        // See https://github.com/Adyen/CSE-JS/blob/master/Options.md for details on the options to use.
        var options = {};
        // Bind encryption options to the form.
        adyen.createEncryptedForm(form, options);
    </script>
@endsection
@section('pagescript')
    <script src="/js/user/userPaymentDetails.js"></script>
@endsection