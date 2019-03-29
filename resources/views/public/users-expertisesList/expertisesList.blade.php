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
                                <h3 class="m-b-10 bold"><?= $expertise->title?></h3>
                                <p class="m-b-0">Collaborate and connect with <?= count($expertise->getActiveUsers())?> different creatives active in <?= $expertise->title ?> for your project! </p>
                                <a class="regular-link" href="/<?= $expertise->slug?>/users">Discover more creatives in <?= $expertise->title?></a>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 100px;">
                            <? foreach($expertise->getTop3ActiveUsers() as $linktable) { ?>
                                <div class="col-sm-4 m-t-10">
                                    <div class="card userCard m-t-20 m-b-20">
                                        <div class="card-block p-relative c-pointer" data-url="/" style="max-height: 210px !important">
                                            <div class="p-t-40 p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                                                <a class="c-gray f-9 photographer" target="_blank" href="<?= $linktable->image_link?>">Photo</a><span class="c-gray f-9"> by </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="<?= $linktable->photographer_link?>"><?= $linktable->photographer_name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="https://unsplash.com">Unsplash</a>
                                            </div>
                                            <? if($linktable->users->First()) { ?>
                                                <a href="<?= $linktable->users->First()->getUrl()?>">
                                                    <div class="overlay-expertise-user"></div>
                                                </a>
                                                <a class="userCardContent" href="<?= $linktable->users->First()->getUrl()?>">
                                                    <div class="p-absolute" style="z-index: 2000000; opacity: 1 !important; top: 39%; left: 50%; transform: translate(-50%, -50%)">
                                                        <div class="avatar" style="background: url('<?= $linktable->users->First()->getProfilePicture()?>'); z-index: 2000000; opacity: 1 !important"></div>
                                                    </div>
                                                    <div class="p-absolute" style="z-index: 2000000; opacity: 1 !important; top: 66%; left: 50%; transform: translate(-50%, -50%)">
                                                        <p class="c-white f-16"><?= $linktable->users->First()->getName()?></p>
                                                    </div>
                                                    <div class="p-absolute" style="z-index: 2000000; opacity: 1 !important; top: 77%; left: 50%; transform: translate(-50%, -50%)">
                                                        <p class="c-orange f-11">@<?= $linktable->users->First()->slug?></p>
                                                    </div>
                                                </a>
                                                <a href="<?= $linktable->users->First()->getUrl()?>" style="z-index: 400;">
                                                    <div class="userCardContent lazyLoad" data-src="<?= $linktable->image?>"></div>
                                                </a>
                                            <? } ?>
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