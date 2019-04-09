@extends("layouts.app")
@section("content")
    <div class="grey-background <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
        <div class="container">
            <div class="sub-title-container p-t-20" style="margin-bottom: 20px;">
                <h1 class="f-31 bold text-center">Congratulations with becoming a <?= str_replace("-", " ", ucfirst($teamPackage->title))?>!</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
        </div>
        <div class="row desktopView" style="display: flex">
            <div class="col-sm-3">
                <div class="slideImage1"></div>
            </div>
            <div class="col-sm-6 text-center" style="margin-top: 120px;">
                <p class="m-b-5 f-15">We can’t wait to see the awesome projects you and your team will build!</p>
                <p class="f-15">We are sure you will surprise us and other creatives! Show everyone your creative power and help others!</p>
                <a target="_blank" href="<?= $teamPackage->team->getUrl()?>" class="btn btn-inno-cta m-t-30">Lets start creating!</a>
            </div>
            <div class="col-sm-3">
                <div class="slideImage2"></div>
            </div>
        </div>

        <div class="mobileView" style="display: none">
            <div class="">
                <div>
                    <div class="text-center" style="margin-top: 150px;">
                        <p class="m-b-5 f-15">We can’t wait to see the awesome projects you and your team will build!</p>
                        <p class="f-15">We are sure you will surprise us and other creatives! Show everyone your creative power and help others!</p>
                        <a target="_blank" href="<?= $teamPackage->team->getUrl()?>" class="btn btn-inno-cta m-t-30">Lets start creating!</a>
                    </div>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-4 p-l-0">
                    <div class="slideImage1"></div>
                </div>
                <div class="col-4 p-0"></div>
                <div class="col-4 p-r-0">
                    <div class="slideImage2"></div>
                </div>
            </div>
        </div>
    </div>
@endsection