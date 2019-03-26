@extends("layouts.app")
@section("content")
    <div class="<?= \App\Services\UserAccount\UserAccount::getTheme()?>">
        <div class="d-flex grey-background vh85 <? \App\Services\UserAccount\UserAccount::getTheme()?>">
            <div class="container">
                <div class="sub-title-container p-t-20">
                    <h1 class="bold f-40 @mobile f-25 @endmobile">Innocreation pricing</h1>
                </div>
                <hr class="m-b-20">
                <div class="row" style="margin-bottom: 150px;">
                    <div class="col-sm-12 text-center m-t-35">
                        <a href="/create-my-account" class="bnt btn-inno-cta p-t-10 p-l-10 p-r-10 p-b-10 c-pointer td-none">Become a dreamer for free!</a>
                    </div>
                </div>

                <div class="row">
                    <? foreach($membershipPackages as $membershipPackage) { ?>
                        <div class="col-sm-4 @mobile p-l-15 @elsedesktop p-l-5 @enddesktop @tablet p-10 @endtablet">
                            <div class="card @desktop <? if($membershipPackage->id == 1 || $membershipPackage->id == 3) echo "card-small-price"; else echo "card-populair-price"?> @elsehandheld  @tablet<? if($membershipPackage->id == 1 || $membershipPackage->id == 3) echo "card-small-price-tablet"; else echo "card-populair-price-tablet"?>@elsemobile <?= "m-b-20"?>@endtablet @enddesktop no-hover">
                                <div class="card-block">
                                    <div class="text-center">
                                        <p class="<? if($membershipPackage->id == 2) echo "f-20"; else echo "f-15"?> m-t-15 bold m-b-5"><?= str_replace("-", " ", $membershipPackage->title) ?></p>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-sm-12">
                                        <p class="<? if($membershipPackage->id == 2) echo "f-31"; else echo "f-25"?> bold m-b-10 text-center"><?="&euro;".  $membershipPackage->getPrice()?>/Month</p>
                                    </div>
                                    <div class="col-sm-12 d-flex js-center fd-column @mobile m-t-10 m-b-20 @endmobile">
                                        <div class="d-flex js-center">
                                            <? if(isset($user)) { ?>
                                                <? if($user->team_id != null && $user->team->packageDetails()) { ?>
                                                        <? if($user->isMember() && $user->team->packageDetails()->membership_package_id == $membershipPackage->id && $user->team->packageDetails()->custom_team_package_id == null) { ?>
                                                            <button class="btn btn-inno @tablet btn-sm @endtablet" disabled>Your current package!</button>
                                                        <? } else { ?>
                                                            <button class="openModalChangePackage btn btn-inno-cta @tablet btn-sm @endtablet" data-user-id="<?= $user->id?>" data-membership-package-id="<?= $membershipPackage->id?>">Choose package</button>
                                                        <? } ?>
                                                    <? } else { ?>
                                                        <a href="/becoming-a-<?= lcfirst($membershipPackage->title)?>" class="btn btn-inno-cta @tablet btn-sm @endtablet">Choose package</a>
                                                    <? } ?>
                                            <? } else { ?>
                                                <a href="/becoming-a-<?= lcfirst($membershipPackage->title)?>" class="btn btn-inno-cta @tablet btn-sm @endtablet">Choose package</a>
                                            <? } ?>
                                        </div>
                                        <a class="text-center f-12 m-t-5"><span class="c-pointer thin openFunctionsModal" data-membership-package-id="<?= $membershipPackage->id?>">+ show functions</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                </div>
                <div class="row m-b-25" style="margin-top: 30px;">
                    <div class="col-sm-12 p-l-0">
                        <div class="card no-hover">
                            <div class="card-block">
                                <p class="f-30 bold">Split the bill with your members</p>
                                <div class="">
                                    <ul class="m-t-10 m-b-10">
                                        <li class="instructions-list-item">
                                            <p class="instructions-text f-13 m-0 p-b-10">Split the monthly/yearly bill with your team members</p>
                                        </li>
                                        <li class="instructions-list-item">
                                            <p class="instructions-text f-13 m-0 p-b-10">Choose how much each member pays</p>
                                        </li>
                                        <li class="instructions-list-item">
                                            <p class="instructions-text f-13 m-0 p-b-10">€11.00/Month will become a min of €2.20/Month for each member</p>
                                        </li>
                                        <li class="instructions-list-item">
                                            <p class="instructions-text f-13 m-0 p-b-10">Create and collaborate together!</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="<?= \App\Services\UserAccount\UserAccount::getTheme()?>">
                <div class="modal fade changePackageModal fade-scale" id="changePackageModal" tabindex="-1" role="dialog" aria-labelledby="changePackageModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content changePackageModalData">

                        </div>
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
    </div>
@endsection
@section('pagescript')
    <script src="/js/checkout/packages.js"></script>
@endsection