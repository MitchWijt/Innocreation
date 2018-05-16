@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Innocreation pricing</h1>
            </div>
            <hr class="m-b-20">
            <div class="row">
                <div class="col-sm-12 d-flex">
                    <? foreach($membershipPackages as $membershipPackage) { ?>
                        <? $descriptions = explode(",",$membershipPackage->description);
                        $counter = 0;
                        ?>
                        <? foreach($descriptions as $description) { ?>
                            <? $counter++?>
                        <? } ?>
                        <div class="col-sm-4 p-0 <? if($membershipPackage->id == 2) echo "m-r-10"?>">
                            <div class="card <? if($membershipPackage->id == 1 || $membershipPackage->id == 3) echo "card-small-price"; else echo "card-populair-price"?> no-hover p-relative">
                                <div class="card-block">
                                    <div class="text-center">
                                        <p class="f-20 m-t-15"><?= $membershipPackage->title?></p>
                                    </div>
                                    <hr>
                                    <ul class="instructions-list">
                                        <? for($i = 0; $i < $counter; $i++) { ?>
                                            <li class="instructions-list-item">
                                                <p class="instructions-text f-13 m-0 p-b-10"><?= $descriptions[$i]?></p>
                                            </li>
                                        <? } ?>
                                    </ul>
                                </div>
                                <div class="row p-absolute absolute-price">
                                    <div class="col-sm-12">
                                        <p class="f-20 m-b-0"><?="&euro;".  $membershipPackage->getPrice()?>/Month</p>
                                        <div class="text-center">
                                        <small class="f-12">(<?= "&euro;" . $membershipPackage->getPrice(true)?>/Year)</small>
                                        </div>
                                        <hr class="">
                                    </div>
                                </div>
                                <div class="text-center p-absolute absolute-button">
                                    <button class="btn btn-inno">Choose</button>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                </div>
            </div>
            <div class="row m-t-20">
                <div class="col-sm-12 d-flex p-l-0">
                    <div class="col-sm-8">
                        <div class="card col-sm-12 m-b-20">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12 d-flex js-between">
                                        <p class="f-20 m-b-5 m-t-5">Custom dreamer package</p>
                                    </div>
                                    <div class="hr"></div>
                                </div>
                                <div class="m-t-20">
                                    <? foreach($customMembershipPackageTypes as $customMembershipPackageType) { ?>
                                        <? if($customMembershipPackageType->title != "Create team newsletters") { ?>
                                            <div class="col-sm-12 d-flex  customSelect">
                                                <div class="col-sm-9">
                                                <select name="amount" class="input amount">
                                                    <option selected disabled="">Choose amount</option>
                                                    <? foreach($customMembershipPackageType->getCustomPackages() as $customPackage) { ?>
                                                        <option value="<?= $customPackage->option?>" data-price="<?= $customPackage->price?>"><?= $customPackage->option?></option>
                                                    <? } ?>
                                                </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="titleCustom"><?= $customMembershipPackageType->title?></p>
                                                </div>
                                            </div>
                                        <? } ?>
                                    <? } ?>
                                </div>
                                <div class="col-sm-12 d-flex customSelectNewsletter">
                                    <div class="col-sm-9">
                                        <select name="amount" class="input newsLetter">
                                            <option selected disabled="">Choose option</option>
                                            <option value="1" data-price="2">Yes</option>
                                            <option value="0" data-price="2">No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <p class="titleCustom">Create team newsletters</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 p-r-0 m-b-20">
                        <div class="card col-sm-12 ">
                            <div class="card-block p-relative">
                                <div class="recentChosen">
                                    <input type="hidden" class="recentMemberOption" data-recent-price="" value="">
                                    <input type="hidden" class="recentTaskOption" data-recent-price="" value="">
                                    <input type="hidden" class="recentMeetingOption" data-recent-price="" value="">
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="f-20 m-t-15 text-center">Custom</p>
                                    </div>
                                    <div class="hr"></div>
                                </div>
                                <div class="m-b-20"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 m-b-20">
                                    <p class="f-20 m-b-0 text-center price hidden">&euro;<span class="priceCustom"></span>/Month</p>
                                    <hr class="col-sm-4">
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-inno m-b-20">Choose</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/checkout/pricing.js"></script>
@endsection