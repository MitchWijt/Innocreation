@extends("layouts.app")
@section("content")
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
                <h1 class="sub-title-black"><?= $userPortfolio->title?></h1>
            </div>
            <div class="hr col-md-12"></div>
            <div class="row">
                <? foreach($userPortfolioFiles as $file) { ?>
                    <div class="td-none portfolioFileItem p-r-10 p-l-10 col-sm-4">
                        <div class="card m-t-20 m-b-20 portfolioItemCard p-relative">
                            <div class="p-relative c-pointer contentContainerPortfolio" data-url="/" style="max-height: 180px">
                                <div class="contentPortfolio" data-id="<?= $file->id?>" style="background: url('<?= $file->getUrl()?>'); z-index: -1 !important">
                                    <? if($file->title != null ) { ?>
                                        <div id="content" style="display: none;">
                                            <div class="p-t-40 p-absolute cont-<?= $file->id?>" style="top: 75%; left: 52%; !important; transform: translate(-50%, -50%);">
                                                <p class="c-white f-9" style="width: 300px !important"><?= $file->description?></p>
                                            </div>
                                            <div class="p-t-40 p-absolute cont-<?= $file->id?>" style="top: 50%; left: 56%; width: 100%; transform: translate(-50%, -50%);">
                                                <p class="c-white f-12"><?= $file->title?></p>
                                            </div>
                                            <div class="p-t-40 p-absolute cont-<?= $file->id?>" style="top: 55%; left: 44%; width: 100%; transform: translate(-50%, -50%);">
                                                <hr class="col-8">
                                            </div>
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
@endsection