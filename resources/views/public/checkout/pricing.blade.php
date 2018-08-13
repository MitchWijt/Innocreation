@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black @mobile f-25 @endmobile">Innocreation pricing</h1>
            </div>
            <hr class="m-b-20">
            <div class="row">
                <? foreach($membershipPackages as $membershipPackage) { ?>
                    <? $descriptions = explode(",",$membershipPackage->description);
                    $counter = 0;
                    ?>
                    <? foreach($descriptions as $description) { ?>
                        <? $counter++?>
                    <? } ?>
                    <div class="col-sm-4 @mobile p-l-15 @elsedesktop p-l-5 @enddesktop @tablet p-10 @endtablet">
                        <div class="card @desktop <? if($membershipPackage->id == 1 || $membershipPackage->id == 3) echo "card-small-price"; else echo "card-populair-price"?> @elsehandheld  @tablet<? if($membershipPackage->id == 1 || $membershipPackage->id == 3) echo "card-small-price-tablet"; else echo "card-populair-price-tablet"?>@elsemobile <?= "m-b-20"?>@endtablet @enddesktop no-hover">
                            <div class="card-block">
                                <div class="text-center">
                                    <p class="f-20 m-t-15"><?= str_replace("-", " ", $membershipPackage->title) ?></p>
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
                                        <p class="f-20 m-b-0 text-center"><?="&euro;".  $membershipPackage->getPrice()?>/Month</p>
                                    <div class="text-center">
                                        <small class="f-12">(<?= "&euro;" . $membershipPackage->getPrice(true)?>/Year)</small>
                                    </div>
                                    @notmobile
                                        <hr class="col-sm-4">
                                    @elsemobile
                                        <hr class="col-xs-4">
                                    @endnotmobile
                                </div>
                                <div class="col-sm-12 @mobile m-t-10 m-b-20 @endmobile">
                                    <div class="text-center">
                                        <? if(isset($user)) { ?>
                                            <? if($user->team_id != null && $user->team->packageDetails()) { ?>
                                                <? if($user->isMember() && $user->team->packageDetails()->membership_package_id == $membershipPackage->id &&  $user->team->packageDetails()->custom_team_package_id == null) { ?>
                                                    <button class="btn btn-inno @tablet btn-sm @endtablet" disabled>Your current package!</button>
                                                <? } else { ?>
                                                    <button class="openModalChangePackage btn btn-inno @tablet btn-sm @endtablet" data-user-id="<?= $user->id?>" data-membership-package-id="<?= $membershipPackage->id?>">Choose</button>
                                                <? } ?>
                                                <? } else { ?>
                                                    <a href="/becoming-a-<?= lcfirst($membershipPackage->title)?>" class="btn btn-inno @tablet btn-sm @endtablet">Choose</a>
                                                <? } ?>
                                        <? } else { ?>
                                            <a href="/becoming-a-<?= lcfirst($membershipPackage->title)?>" class="btn btn-inno @tablet btn-sm @endtablet">Choose</a>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
            <form action="/checkout/setDataCustomPackage" method="post" class="customPackageForm">
                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                <? if(isset($user) && $user->team_id != null && $user->team->packageDetails() && $user->isMember()) { ?>
                    <input type="hidden" name="changePackage" value="1">
                <? } else { ?>
                    <input type="hidden" name="changePackage" value="0">
                <? } ?>
                <div class="row m-t-20 d-flex">
                    <div class="col-sm-8 @notmobile p-l-0 @endnotmobile ">
                        <div class="card col-sm-12 m-b-20">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12 d-flex js-between">
                                        <p class="f-20 m-b-5 m-t-5">Custom dreamer package</p>
                                    </div>
                                    <div class="hr"></div>
                                </div>
                                <div class="m-t-20">
                                    <? if(isset($user) && $user->team_id != null) { ?>
                                        <input type="hidden" class="teamMembers" value="<?= count($user->team->getMembers())?>">
                                    <? } ?>
                                    <? foreach($customMembershipPackageTypes as $customMembershipPackageType) { ?>
                                        <? if($customMembershipPackageType->title != "Create team newsletters") { ?>
                                            <div class="col-sm-12 d-flex  customSelect">
                                                <div class="col-sm-9">
                                                    <input type="hidden" name="types[]" value="<?= $customMembershipPackageType->id?>">
                                                    <select name="amountValues[]" class="input amount">
                                                        <option selected disabled="">Choose amount</option>
                                                        <? foreach($customMembershipPackageType->getCustomPackages() as $customPackage) { ?>
                                                            <option value="<?= $customPackage->option?>" data-price="<?= $customPackage->price?>" ><?= $customPackage->option?></option>
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
                                        <input type="hidden" name="types[]" value="4">
                                        <select name="amountValues[]" class="input newsLetter">
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
                    <div class="col-sm-4 @notmobile p-l-0 @endnotmobile m-b-20">
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
                            <div class="col-sm-12 m-b-20">
                                <p class="f-20 m-b-0 text-center price hidden">&euro;<span class="priceCustom"></span>/Month</p>
                                <hr class="col-xs-12">
                            </div>
                            <div class="text-center">
                                <? if(isset($user)) { ?>
                                    <? if($user->team_id != null && $user->team->packageDetails()) { ?>
                                        <? if($user->isMember() && $user->team->packageDetails()->custom_team_package_id != null) { ?>
                                            <button class="btn btn-inno @tablet btn-sm @endtablet" disabled>Your current package!</button>
                                        <? } else {  ?>
                                            <button type="button" class="btn btn-inno m-b-20 openModalChangePackage customBtn" data-user-id="<?= $user->id?>" data-membership-package-id="custom">Choose</button>
                                        <? } ?>
                                    <? } else { ?>
                                        <button type="submit" class="btn btn-inno m-b-20 customBtn">Choose</button>
                                    <? } ?>
                                <? } else { ?>
                                    <button type="submit" class="btn btn-inno m-b-20 customBtn">Choose</button>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="sub-title-container p-t-20 m-t-20">
                <h1 class="sub-title-black @mobile f-25 @endmobile">Reviews</h1>
            </div>
            <div class="hr col-md-12 m-b-20"></div>
            <? foreach($serviceReviews as $serviceReview) { ?>
                <div class="row d-flex js-center m-b-20">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-block">
                                <div class="row text-center d-flex js-center m-t-20">
                                    <div class="circle circleImage m-r-0">
                                        <p class="text-center c-orange f-23 m-t-10"><?= $serviceReview->rating?></p>
                                    </div>
                                </div>
                                <div class="row d-flex js-center m-t-10">
                                    <p><?= $serviceReview->users->getName()?> had a <?= strtolower($serviceReview->review)?> experience</p>
                                </div>
                                @notmobile
                                    <hr class="col-md-11">
                                @elsemobile
                                    <hr class="col-xs-12">
                                @endnotmobile
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="col-sm-12"><?= $serviceReview->review_description?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
            <div class="modal fade changePackageModal" id="changePackageModal" tabindex="-1" role="dialog" aria-labelledby="changePackageModal" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content changePackageModalData">

                    </div>
                </div>
            </div>
            <div class="modal fade limitMembersCustom" id="limitMembersCustom" tabindex="-1" role="dialog" aria-labelledby="limitMembersCustom" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body ">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>You are trying to downgrade to a package with less member capacity than you have at the moment.</p>
                                    <p>To pursue this downgrade make sure to have the same amount of members or less than the package.</p>
                                </div>
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