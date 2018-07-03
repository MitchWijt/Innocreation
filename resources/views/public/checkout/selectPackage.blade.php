@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">You're team is almost a </h1>
            </div>
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <hr class="m-b-20">
            <div class="row">
                <? if(!\Illuminate\Support\Facades\Session::has("customPackagesArray")) { ?>
                    <div class="col-sm-5">
                        <div class="row">
                            <? $descriptions = explode(",",$membershipPackage->description);
                                $counter = 0;
                            ?>
                            <? foreach($descriptions as $description) { ?>
                                <? $counter++?>
                            <? } ?>
                            <div class="card m-t-0 p-10 @desktop <? if($membershipPackage->id == 1 || $membershipPackage->id == 3) echo "card-small-price"; else echo "card-populair-price"?> @elsehandheld  @tablet<? if($membershipPackage->id == 1 || $membershipPackage->id == 3) echo "card-small-price-tablet"; else echo "card-populair-price-tablet"?>@elsemobile <?= "m-b-20"?>@endtablet @enddesktop no-hover">
                                <div class="card-block">
                                    <div class="text-center">
                                        <p class="f-20 m-t-15"><?= str_replace("-", " ", $membershipPackage->title)?></p>
                                    </div>
                                    <hr>
                                    <ul class="instructions-list @tablet <? if($membershipPackage->id == 3) echo "m-b-0"?> @endtablet">
                                        <? for($i = 0; $i < $counter; $i++) { ?>
                                        <li class="instructions-list-item">
                                            <p class="instructions-text f-13 m-0 p-b-10"><?= $descriptions[$i]?></p>
                                        </li>
                                        <? } ?>
                                    </ul>
                                </div>
                                <div class="row @notmobile @desktop <? if($membershipPackage->id == 1 || $membershipPackage->id == 2) echo "m-t-70"?> @elsetablet  <? if($membershipPackage->id == 1 || $membershipPackage->id == 2) echo "m-t-50"?> @enddesktop @endnotmobile">
                                    <div class="col-sm-12">
                                        <p class="f-20 m-b-0 text-center"><?= "&euro;"?><span class="packagePrice"><?= $membershipPackage->getPrice()?></span><span class="packagePreference">/Month</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } else { ?>
                    <div class="col-sm-5">
                        <div class="row">
                            <div class="card card-small-price-tablet m-t-0 p-10 no-hover">
                                <div class="card-block">
                                    <div class="text-center">
                                        <p class="f-20 m-t-15">Custom package</p>
                                    </div>
                                    <hr>
                                    <ul class="instructions-list">
                                        <? foreach(Illuminate\Support\Facades\Session::get("customPackagesArray")["options"] as $key => $value) { ?>
                                            <li class="instructions-list-item">
                                                <p class="instructions-text f-13 m-0 p-b-10"><?=$value?><?= $key?></p>
                                            </li>
                                        <? } ?>
                                    </ul>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="f-20 m-b-0 text-center"><?= "&euro;"?><span class="packagePrice"><?= \Illuminate\Support\Facades\Session::get("customPackagesArray")["price"] ?></span><span class="packagePreference">/Month</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
                <? if(!\Illuminate\Support\Facades\Session::has("customPackagesArray")) { ?>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-4 m-0 p-0">
                            <p class="bcg-black <? if($step == 1) echo "c-gray"; else echo "c-dark-grey"?> text-center m-b-0">Credentials (1/3)</p>
                        </div>
                        <div class="col-sm-4 m-0 p-0">
                            <p class="bcg-black <? if($step == 2) echo "c-gray"; else echo "c-dark-grey"?> text-center border-sides m-b-0">Payment info (2/3)</p>
                        </div>
                        <div class="col-sm-4 m-0 p-0">
                            <p class="bcg-black <? if($step == 3) echo "c-gray"; else echo "c-dark-grey"?> text-center m-b-0">Method (3/3)</p>
                        </div>
                    </div>
                    <div class="row m-t-0">
                        <div class="card shadow no-hover col-sm-12 m-t-0">
                            <div class="card-block">
                                <? if($step == 1) { ?>
                                    <div class="text-center m-t-10">
                                        <h5>Your credentials</h5>
                                        <hr>
                                    </div>
                                    <? if(!isset($user)){ ?>
                                        <div class="text-center m-t-20 m-b-20">
                                            <p class="m-b-0">It seems that you aren't logged in or don't have an account. </p>
                                            <p>you can <span class="regular-link accountCardToggle login">login</span> or <span class="regular-link register accountCardToggle">create an account</span> to continue</p>
                                        </div>
                                    <? } else { ?>
                                        <form action="checkout/saveUserFromCheckout" method="POST" class="m-t-20">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="user_id" value="<?= $user->id?>">
                                            <input type="hidden" name="backlink" value="<?= $backlink?>">
                                            <div class="form-group d-flex js-center m-b-10">
                                                <div class="row d-flex js-center col-sm-12">
                                                    <div class="col-sm-3 @desktop p-l-0 @elsemobile p-0 @enddesktop">
                                                        <label class="m-0">First name</label>
                                                        <input type="text" name="firstname" class="firstname input col-sm-12" value="<? if(isset($user->firstname)) echo $user->firstname?>">
                                                    </div>
                                                    <div class="col-sm-3 @desktop p-l-0 @elsemobile p-0 @enddesktop">
                                                        <label class="m-0">Middle name</label>
                                                        <input type="text" name="middlename" class="middlename input col-sm-12" value="<? if(isset($user->middlename)) echo $user->middlename?>">
                                                    </div>
                                                    <div class="col-sm-3 @desktop p-r-0 @elsemobile p-0 @enddesktop">
                                                        <label class="m-0">Last name</label>
                                                        <input type="text" name="lastname" class="lastname input col-sm-12" value="<? if(isset($user->lastname)) echo $user->lastname?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-b-10 d-flex js-center">
                                                <div class="row d-flex js-center col-sm-9">
                                                    <label class="m-0 col-sm-12 p-0">Email</label>
                                                    <input type="email" name="email" class="email input col-sm-12" value="<? if(isset($user->email)) echo $user->email?>">
                                                </div>
                                            </div>
                                            <div class="form-group d-flex js-center m-b-10 ">
                                                <div class="row d-flex js-center col-sm-12">
                                                    <div class="col-sm-3 @desktop p-l-0 @elsemobile p-0 @enddesktop">
                                                        <label class="m-0">City</label>
                                                        <input type="text" name="city" class="city input col-sm-12" value="<? if(isset($user->city)) echo $user->city?>">
                                                    </div>
                                                    <div class="col-sm-3 @desktop p-l-0 @elsemobile p-0 @enddesktop">
                                                        <label class="m-0">Postcode</label>
                                                        <input type="text" name="postcode" class="postcode input col-sm-12" value="<? if(isset($user->postcode)) echo $user->postcode?>">
                                                    </div>
                                                    <div class="col-sm-3 @desktop p-r-0 @elsemobile p-0 @enddesktop">
                                                        <label class="m-0">State</label>
                                                        <input type="text" name="state" class="state input col-sm-12" value="<? if(isset($user->state)) echo $user->state?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-b-0 d-flex js-center m-b-10">
                                                <div class="row d-flex js-center col-sm-9">
                                                    <label class="m-0 col-sm-12 p-0">Country</label>
                                                    <select name="country" class="input col-sm-12">
                                                        <? foreach($countries as $country) { ?>
                                                            <option <? if(isset($user->country) && $user->country == $country->country) echo "selected"?> data-country-code="<?= $country->country_code?>" value="<?= $country->country?>"><?= $country->country?></option>
                                                        <? } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group m-b-0 d-flex js-center">
                                                <div class="row d-flex js-center col-sm-9">
                                                    <label class="m-0 col-sm-12 p-0">Phonenumber</label>
                                                    <input type="text" name="phonenumber" class="phonenumber input col-sm-12" value="<? if(isset($user->phonenumber)) echo $user->phonenumber?>">
                                                </div>
                                            </div>
                                            <? if(isset($user) && $user->team_id == null) { ?>
                                                <div class="form-group m-b-0 d-flex js-center m-t-15">
                                                    <div class="row d-flex js-center col-sm-9">
                                                        <p class="m-b-10">Your account isn't connected to a team yet. <br> But luckily you can create one here</p>
                                                        <label class="m-0 col-sm-12 p-0">Team name</label>
                                                        <input type="text" name="team_name" class="team_name input col-sm-12" value="">
                                                    </div>
                                                </div>
                                            <? } ?>
                                            <div class="row m-t-20 d-flex js-center">
                                                <div class="col-sm-8 m-b-20 ">
                                                    <button class="btn btn-inno pull-right">Next step</button>
                                                </div>
                                            </div>
                                        </form>
                                    <? } ?>
                                <? } else if($step == 2) { ?>
                                    <form action="/checkout/savePaymentInfo" method="post" class="savePaymentInfoForm">
                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                        <input type="hidden" name="team_id" value="<?= $team->id?>">
                                        <input type="hidden" name="membership_package_id" value="<?= $membershipPackage->id?>">
                                        <input type="hidden" name="backlink" value="<?= $backlink?>">
                                        <div class="text-center m-t-10">
                                            <h5>Payment info</h5>
                                            <hr>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label for="">Payment preference:</label>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="pull-right">
                                                    <input type="radio" class="paymentPreference" data-package-id="<?= $membershipPackage->id?>" data-preference="yearly" name="paymentPreference" value="yearly" id="preferenceYearly">
                                                    <label class="m-r-20" for="preferenceYearly">Yearly</label>
                                                    <input type="radio" class="paymentPreference" data-package-id="<?= $membershipPackage->id?>" data-preference="monthly" checked name="paymentPreference" value="monthly" id="preferenceMonthly">
                                                    <label for="preferenceMonthly">Monthly</label>
                                                </div>
                                            </div>
                                        </div>
                                        <? if(count($team->getMembers()) > 1) { ?>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="pull-right">
                                                        <input type="checkbox" class="splitTheBill" name="splitTheBill" value="1" id="splitTheBill">
                                                        <label class="m-r-10" for="splitTheBill">Split the bill</label><span><i class="zmdi zmdi-info-outline c-dark-grey c-pointer" data-toggle="modal" data-target="#splitTheBillInfoModal"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <? } ?>
                                        <div class="row">
                                            <div class="col-sm-12 m-t-10 m-b-15">
                                                <button class="btn btn-inno btn-sm pull-right toStep3" type="button">Next step</button>
                                            </div>
                                        </div>
                                    </form>
                                <? } else if($step == 3) { ?>
                                    <div class="text-center m-t-10">
                                        <h5>Payment method</h5>
                                        <hr>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                        <? if(isset($team) && isset($user) && count($team->getMembers()) > 1 && $step == 2) { ?>
                            <div id="splitTheBillCollapse" class="collapse collapseExample card-sm shadow no-hover col-sm-12 m-t-0 splitTheBillCard">
                                <div class="card-block">
                                    <div class="text-center m-t-15">
                                        <h5>Split the bill</h5>
                                        <hr>
                                    </div>
                                    <i class="c-dark-grey">Amount left to split: <i class="packagePrice totalPrice"><?= $membershipPackage->getPrice()?></i></i><br>
                                    <i class="c-orange amountExceeded hidden">Amount exceeded: <i class="exceededAmount"></i></i>
                                    <button class="btn btn-sm btn-inno pull-right m-b-20 m-t-5 splitEqually">Split equally</button>
                                    <? foreach($team->getMembers() as $member) { ?>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p><?= $member->firstname?></p>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-6 p-r-0">
                                                        <input type="hidden" name="team_id" class="team_id" value="<?= $team->id?>">
                                                        <input class="input pull-right splittedAmountMember col-sm-12" type="text" data-member-id="<?= $member->id?>" name="splittedAmount" value="">
                                                    </div>
                                                    <div class="col-sm-6">
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
                            <div id="accountCollapse" class="collapse collapseExample card-sm shadow no-hover col-sm-12 m-t-0 accountCard">
                                <div class="card-block">
                                    <div class="m-b-20">
                                        <?= view("/public/shared/_loginRegister", compact("countries", "expertises", "pageType", "backlink"));?>
                                    </div>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
                <? } ?>
            </div>
            <div class="modal fade splitTheBillInfoModal" id="splitTheBillInfoModal" tabindex="-1" role="dialog" aria-labelledby="splitTheBillInfoModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body ">
                            <p>Split the bill allows you to split the monthly/yearly recurring bill with your team members if they allow to.</p>
                            <i class="c-dark-grey f-14">You can always change this later in your account.</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
            showAutocompleteOnFocus: true
        });
    </script>
@endsection
@section('pagescript')
    <script src="/js/checkout/selectPackage.js"></script>
@endsection