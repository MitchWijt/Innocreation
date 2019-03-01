@extends("layouts.app")
@section("content")
    <div class="<?= \App\Services\UserAccount\UserAccount::getTheme()?>">
        <div class="d-flex grey-background vh85">
            <div class="container">
                <div class="sub-title-container p-t-20">
                    <h1 class="sub-title-black">Explore all expertises</h1>
                </div>
                <hr class="m-b-0">
                <? if(isset($searchedExpertises)) {
                    $expertises = $searchedExpertises;
                } else {
                    $expertises = $expertises;
                }
                ?>
                <? foreach($expertises as $expertise) { ?>
                    <? if(count($expertise->getActiveUsers()) > 0) { ?>
                        <div class="row m-t-20">
                            <div class="col-sm-12 <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
                                <h3 class="m-b-30"><strong><?= $expertise->title?></strong></h3>
                                <p class="m-b-0">Collaborate and connect with <?= count($expertise->getActiveUsers())?> different creatives active in <?= $expertise->title ?> for your project! </p>
                                <a class="regular-link" href="">Discover more creatives in <?= $expertise->title?></a>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 100px;">
                            <? foreach($expertise->getTop3ActiveUsers() as $linktable) { ?>
                                <div class="col-sm-4 m-t-10">
                                    <div class="card m-t-20 m-b-20">
                                        <div class="card-block expertiseCard p-relative c-pointer" data-url="/" style="max-height: 210px !important">
                                            <div class="p-t-40 p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                                                <a class="c-gray f-9 photographer" target="_blank" href="<?= $linktable->image_link?>">Photo</a><span class="c-gray f-9"> by </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="<?= $linktable->photographer_link?>"><?= $linktable->photographer_name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="https://unsplash.com">Unsplash</a>
                                            </div>
                                            <div class="overlay-test p-relative"></div>
                                                <div class="p-absolute" style="z-index: 2000000; opacity: 1 !important; top: 39%; left: 50%; transform: translate(-50%, -50%)">
                                                    <? if($linktable->users->First()) { ?>
                                                        <div class="avatar" style="background: url('<?= $linktable->users->First()->getProfilePicture()?>'); z-index: 2000000; opacity: 1 !important"></div>
                                                    <? } ?>
                                                </div>
                                                <div class="p-absolute" style="z-index: 2000000; opacity: 1 !important; top: 66%; left: 50%; transform: translate(-50%, -50%)">
                                                    <? if($linktable->users->First()) { ?>
                                                        <p class="c-white f-16"><?= $linktable->users->First()->getName()?></p>
                                                    <? } ?>
                                                </div>
                                                <div class="p-absolute" style="z-index: 2000000; opacity: 1 !important; top: 77%; left: 50%; transform: translate(-50%, -50%)">
                                                    <? if($linktable->users->First()) { ?>
                                                        <p class="c-orange f-11">@<?= $linktable->users->First()->slug?></p>
                                                    <? } ?>
                                                </div>
                                            <a href="/<?= $expertise->slug?>/users" style="z-index: 400;">
                                                <div class="contentExpertise lazyLoad" data-src="<?= $linktable->image?>"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <? } ?>
                        </div>
                    <? } ?>
                <? } ?>
            </div>
        </div>
    </div>
    <style>
        .overlay-test {
            background: #000 !important;
            z-index: 1 !important;
            opacity: 0.7 !important;
            top: 20%;
            left: 0;
            width: 100%;
            height: 65%;
            position: absolute;
        }
    </style>
    <script>
        $( function() {
            var availableTags = [
                <? foreach($allTags as $tag) { ?>
                    "<?=$tag?>",
                <? } ?>
            ];
            $( "#tags" ).autocomplete({
                source: availableTags
            });
        } );
        $(document).ready(function () {
            $(".ui-menu").appendTo(".expertises");
        });
    </script>
@endsection
@section('pagescript')
    <script src="/js/expertisesList/expertisesList.js"></script>
    <script defer async src="/js/lazyLoader.js"></script>
@endsection