@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black @mobile f-20 @endmobile">Customer support reviews</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <? if(count($errors) > 0){ ?>
                        <? foreach($errors->all() as $error){ ?>
                            <p class="c-orange"><?=$error?></p>
                        <? } ?>
                    <? } ?>
                </div>
            </div>
            <hr class="m-b-20 col-md-10">
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
                                <hr class="col-md-11">
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
        </div>
    </div>
@endsection