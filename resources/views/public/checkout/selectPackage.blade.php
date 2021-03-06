@extends("layouts.app")
@section("content")
    <div class="<?= \App\Services\UserAccount\UserAccount::getTheme()?>">
    <div class="d-flex grey-background vh100 <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black @handheld f-25 @endhandheld">@notmobile You're team is almost a <? if(\Illuminate\Support\Facades\Session::has("customPackagesArray")) echo "innovator"; else echo str_replace("-", " ", lcfirst($membershipPackage->title))?> @elsemobile almost a <? if(\Illuminate\Support\Facades\Session::has("customPackagesArray")) echo "innovator"; else echo str_replace("-", " ", lcfirst($membershipPackage->title))?> @endnotmobile</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <hr class="m-b-20">
            <div class="row">
                <div class="col-sm-5 m-t-20 @mobile p-l-15 @elsedesktop p-l-5 @enddesktop @tablet p-10 @endtablet">
                    <div class="text-center">
                        <p class="<? if($membershipPackage->id == 2) echo "f-20"; else echo "f-15"?> m-t-15 bold m-b-5"><?= str_replace("-", " ", $membershipPackage->title) ?></p>
                    </div>

                    <div class="row ">
                        <div class="col-sm-12">
                            <p class="<? if($membershipPackage->id == 2) echo "f-31"; else echo "f-25"?> bold m-b-0 text-center"><?="&euro;"?><span class="packagePrice bold"><?= $membershipPackage->getPrice()?></span><span class="packagePreference bold">/Month</span></p>
                        </div>
                        <div class="col-sm-12 d-flex js-center fd-column @mobile m-t-5 m-b-20 @endmobile">
                            <a class="text-center f-12 m-t-5"><span class="c-pointer thin openFunctionsModal" data-membership-package-id="<?= $membershipPackage->id?>">+ show functions</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 m-t-40 p-relative @mobile p-30 @endmobile">
                    <div class="row" style="margin-bottom: 50px;">
                        <? if(isset($teamPackage) && $team->split_the_bill == 1) { ?>
                            <div class="line d-flex js-between p-relative" style="border-bottom: 2px solid black; width: 100%"></div>
                            <div class="p-absolute d-flex js-between" style="top: -12%; width: 100%; z-index: 20">
                                <div class="circle m-r-0 p-relative bcg-cover <? if($step == 1) echo "actionBorder" ;?>" style="width: 50px; height: 50px;">
                                    <p class="p-absolute absolute-center m-0">1</p>
                                </div>
                                <div class="circle m-r-0 p-relative bcg-cover <? if($step == 1) echo "actionBorder" ;?>" style="width: 50px; height: 50px;">
                                    <p class="p-absolute absolute-center m-0">2</p>
                                </div>
                            </div>
                        <? } else { ?>
                            <div class="line d-flex js-between p-relative" style="border-bottom: 2px solid black; width: 100%"></div>
                            <div class="p-absolute d-flex js-between" style="top: -23px; width: 100%; z-index: 20">
                                <div class="circle m-r-0 p-relative bcg-cover <? if($step == 1) echo "actionBorder" ;?>" style="width: 50px; height: 50px; ">
                                    <p class="p-absolute absolute-center m-0">1</p>
                                </div>
                                <div class="circle m-r-0 p-relative bcg-cover <? if($step == 2) echo "actionBorder" ;?>" style="width: 50px; height: 50px;">
                                    <p class="p-absolute absolute-center m-0">2</p>
                                </div>
                                <div class="circle m-r-0 p-relative bcg-cover <? if($step == 3) echo "actionBorder" ;?>" style="width: 50px; height: 50px;">
                                    <p class="p-absolute absolute-center m-0">3</p>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                    <div class="row m-t-0">
                        <div class="card no-hover col-sm-12 m-t-0" style="border: 1px solid #000; border-radius: 10px;">
                            <div class="card-block">
                                <? if($step == 1) { ?>
                                    <div class="m-t-10">
                                        <p class="bold f-25">Your credentials</p>
                                    </div>
                                    <? if(!isset($user)){ ?>
                                        <div class="text-center m-t-20 m-b-20">
                                            <p class="m-b-0">It seems that you aren't logged in or don't have an account. </p>
                                            <p>you can <span class="regular-link accountCardToggle login">login</span> or <span class="regular-link register accountCardToggle">create an account</span> to continue</p>
                                        </div>
                                    <? } else { ?>
                                        <?= view("/public/checkout/shared/_saveUserFromCheckout", compact('countries', 'expertises', 'user', 'backlink'))?>
                                    <? } ?>
                                <? } else if($step == 2) { ?>
                                    <form action="/checkout/savePaymentInfo" method="post" class="savePaymentInfoForm">
                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                        <input type="hidden" name="team_id" value="<?= $team->id?>">
                                        <input type="hidden" name="change_package" value="0">
                                        <? if(isset($teamPackage)) { ?>
                                            <input type="hidden" class="changedPackage" name="change_package" value="1">
                                        <? } ?>
                                        <? if(isset($teamPackage) && $team->split_the_bill == 1) { ?>
                                            <input type="hidden" class="split" name="splitTheBill" value="1">
                                        <? } ?>
                                        <? if(isset($teamPackage) && $team->split_the_bill == 0) { ?>
                                            <input type="hidden" class="split" name="splitTheBill" value="0">
                                        <? } ?>
                                        <? if(!\Illuminate\Support\Facades\Session::has("customPackagesArray")) { ?>
                                            <input type="hidden" name="membership_package_id" value="<?= $membershipPackage->id?>">
                                        <? } else { ?>
                                            <input type="hidden" name="membership_package_id" value="custom">
                                        <? } ?>
                                        <input type="hidden" name="backlink" value="<?= $backlink?>">
                                        <div class="m-t-10">
                                            <p class="bold f-25">Payment info</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label for="">Payment preference:</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="pull-right">
                                                    <? if(!isset($teamPackage)) { ?>
                                                        <? if(!\Illuminate\Support\Facades\Session::has("customPackagesArray")) { ?>
                                                            <input type="radio" class="paymentPreference"  data-package-id="<? if(\Illuminate\Support\Facades\Session::has("customPackagesArray")) echo  "custom"; else echo $membershipPackage->id?>" data-preference="yearly" name="paymentPreference" value="yearly" id="preferenceYearly">
                                                            <label class="m-r-20" for="preferenceYearly">Yearly</label>
                                                        <? } ?>
                                                        <input type="radio" class="paymentPreference" data-package-id="<? if(\Illuminate\Support\Facades\Session::has("customPackagesArray")) echo  "custom"; else echo $membershipPackage->id?>" data-preference="monthly" checked name="paymentPreference" value="monthly" id="preferenceMonthly">
                                                        <label for="preferenceMonthly">Monthly</label>
                                                    <? } else { ?>
                                                        <p>You have chosen to pay <?= $teamPackage->payment_preference?> for your teams package. This cannot be changed anymore.</p>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <? if(count($team->getMembers()) > 1) { ?>
                                            <? if(!isset($teamPackage)) { ?>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="pull-right">
                                                            <input type="checkbox" class="splitTheBill" name="splitTheBill" value="1" id="splitTheBill">
                                                            <label class="m-r-10" for="splitTheBill">Split the bill</label><span><i class="zmdi zmdi-info-outline c-dark-grey c-pointer" data-toggle="modal" data-target="#splitTheBillInfoModal"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <? } ?>
                                        <? } ?>
                                        <div class="row">
                                            <div class="col-sm-12 m-t-10 m-b-15">
                                                <button class="btn btn-inno-cta btn-sm pull-right toStep3" type="button">Next step</button>
                                            </div>
                                        </div>
                                    </form>
                                <? } else if($step == 3) { ?>
                                    <?
                                        $date = date("Y-m-d");
                                        $time = date("H:i:s");
                                    ?>
                                    <div class="text-center m-t-10">
                                        <h5>Payment method</h5>
                                        <i class="m-l-10 m-t-10 f-11 c-dark-grey">Card will be charged monthly for packages purchased. All major credit cards accepted.</i>
                                        <form method="POST" action="/checkout/authorisePaymentRequest">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="team_id" value="<?= $team->id?>">
                                            <div class="row m-t-20 m-b-20">
                                                <div class="col-sm-12">
                                                    <input type="submit" class="btn btn-inno btn-sm pull-right" value="Become a <? if(\Illuminate\Support\Facades\Session::has("customPackagesArray")) echo "innovator"; else echo str_replace("-", " ", lcfirst($membershipPackage->title))?>"/>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                        <? if(isset($team) && isset($user) && count($team->getMembers()) > 1 && $step == 2) { ?>
                            <? if(isset($teamPackage) && $step == 2 && $team->split_the_bill == 1) { ?>
                                <div id="splitTheBillCollapse" class="collapsed collapseExample card col-sm-12 m-t-0 splitTheBillCard" style="border: 1px solid #000; border-radius: 10px;">
                            <? } else { ?>
                                <div id="splitTheBillCollapse" class="collapse collapseExample card col-sm-12 m-t-0 splitTheBillCard" style="border: 1px solid #000; border-radius: 10px;">
                            <? } ?>
                                <div class="card-block">
                                    <div class="m-t-15">
                                        <p class="bold f-25">Split the bill</p>
                                    </div>
                                    <i class="c-black">Amount left to split: <i class="packagePrice totalPrice c-black"><? echo $membershipPackage->getPrice()?></i></i><br>
                                    <i class="c-orange amountExceeded hidden">Amount exceeded: <i class="exceededAmount"></i></i>
                                    <button class="btn btn-sm btn-inno pull-right m-b-20 m-t-5 splitEqually">Split equally</button>
                                    <? foreach($team->getMembers() as $member) { ?>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="@mobile m-0 @endmobile"><?= $member->firstname?></p>
                                            </div>
                                            <div class="col-sm-6 @mobile m-b-10 @endmobile">
                                                <div class="row">
                                                    <div class="@mobile col-xs-6 m-l-15 @elsedesktop col-sm-6 @enddesktop p-r-0">
                                                        <input type="hidden" name="team_id" class="team_id" value="<?= $team->id?>">
                                                        <input class="input pull-right splittedAmountMember col-sm-12" type="text" data-member-id="<?= $member->id?>" name="splittedAmount" value="">
                                                    </div>
                                                    <div class="@mobile col-xs-6 @elsedesktop col-sm-6 @enddesktop">
                                                        <span class="packagePreference">/Monthly</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <? } ?>
                                    <span class="c-red splitError"></span>
                                </div>
                            </div>
                        <? } ?>
                        <? if(!isset($user) && $step == 1){ ?>
                                <div class="<?= \App\Services\UserAccount\UserAccount::getTheme()?>">
                                    <div id="accountCollapse" class="collapse collapseExample card shadow no-hover col-sm-12 m-t-0 accountCard">
                                        <div class="card-block">

                                        </div>
                                    </div>
                                </div>
                        <? } ?>
                    </div>
                </div>
            </div>
            <div class="modal fade splitTheBillInfoModal fade-scale" id="splitTheBillInfoModal" tabindex="-1" role="dialog" aria-labelledby="splitTheBillInfoModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body ">
                            <p>Split the bill allows you to split the monthly/yearly recurring bill with your team members if they allow to.</p>
                            <i class="c-dark-grey f-14">You can always change this later in your account.</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade companyDetails" id="companyDetails" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body ">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="text-center">
                                    <h2>Innocreation</h2>
                                    <p class="m-0">Chamber of commerce number: 72024992</p>
                                    <p class="m-0">Location: Dagpauwoog 81, 4814VG BREDA, Netherlands</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
        <? if(!isset($user) && $step == 1){ ?>
            <div class="modal fade fade-scale loginRegisterModal" id="loginRegisterModal" tabindex="-1" role="dialog" aria-labelledby="loginRegisterModal" aria-hidden="true">
                <div class="modal-dialog-centered modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body ">
                            <div class="m-b-20 <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
                                <div class="loginForm hidden ">
                                    <?= view("/public/shared/_loginRegister", compact("countries", "expertises", "pageType", "backlink"));?>
                                </div>
                                <div class="registerForm hidden">
                                    <?= view("/public/shared/_register", compact('countries', 'expertises', 'pageType', 'backlink'))?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <? } ?>
    </div>
    <script>
        $('#tokenfield').tokenfield({
            autocomplete: {
                source: [
                    <? foreach($expertises as $expertise) { ?>
                    <? $title = $expertise->title?>
                    <? if(strpos($expertise->title,"-") !== false) {
                    $title = str_replace("-"," ",$title);
                } ?>
                    <?= "'$title'"?>,
                    <? } ?>
                ],
                delay: 100
            },
            showAutocompleteOnFocus: true,
            createTokensOnBlur: true
        });
    </script>
@endsection
@section('pagescript')
    <script src="/js/checkout/selectPackage.js"></script>
    <script src="/js/checkout/packages.js"></script>
    <script src="/js/register/index.js"></script>
@endsection