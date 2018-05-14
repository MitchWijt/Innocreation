@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Innocreation pricing</h1>
            </div>
            <hr class="m-b-20 col-sm-12">
            <div class="row">
                <div class="col-sm-12 d-flex p-0">
                    <? foreach($membershipPackages as $membershipPackage) { ?>
                        <? $descriptions = explode(",",$membershipPackage->description);
                        $counter = 0;
                        ?>
                        <? foreach($descriptions as $description) { ?>
                            <? $counter++?>
                        <? } ?>
                        <div class="col-sm-4 <? if($membershipPackage->id == 2) echo "m-r-15"?>">
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
                                        <p class="f-20 m-b-0"><?= $membershipPackage->getPrice()?>/Month</p>
                                        <div class="text-center">
                                        <small class="f-12">(<?= $membershipPackage->getPrice(true)?>/Year)</small>
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
            {{--<div class="d-flex js-center m-t-20">--}}
                {{--<div class="row">--}}
                    {{--<div class="card card-lg col-sm-12">--}}
                        {{--<div class="card-block">--}}
                            {{--<p>skfadfiadfu</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
@endsection