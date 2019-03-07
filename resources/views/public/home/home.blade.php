@extends("layouts.app")
<link rel="stylesheet" href="/css/home/home.css">
@section("content")
<div class="p-relative home-background-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 d-flex js-center">
                @include("includes.flash")
            </div>
        </div>
        <div class="main-content">
            <? if(isset($loggedIn) && $loggedIn) { ?>
                <div class="row">
                    <div class="col-md-12 m-b-20">
                        <div class="title-home">
                            @mobile
                                <h1 style="font-weight: bold;" class="text-center col-md-12 f-40">Innocreation</h1>
                                <p class="text-center f-13">Have an idea? find team members, create your team and start building now!</p>
                            @elsedesktop
                                <h1 class="title-black text-center col-md-12">Innocreation</h1>
                                <p class="text-center">Have an idea? find team members, create your team and start building now!</p>
                            @endmobile
                            <div class="hr col-md-10"></div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex js-center <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
                    <div class="col-md-5 d-flex js-center">
                        <a id="collaborateNow" href="/innocreatives" class="btn btn-inno-cta startRegisterProcess @tablet p-l-8 @endtablet" style="border-radius: 10px;">@tablet Connect! @elsedesktop Start connecting! @endtablet</a>
                    </div>
                </div>
            <? } else { ?>
                <div class="row d-flex js-center <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
                    <div class="col-md-8 m-b-20 d-flex js-center">
                        <div class="title-home">
                            @mobile
                                <h1 style="font-weight: bold;" class="text-center col-md-12 f-40">Innocreation</h1>
                                <p class="f-13 text-center">Have an idea? find team members, create your team and start building now!</p>
                            @elsedesktop
                                <h1 class="title-black bold">Innocreation</h1>
                                <p class="m-b-0">Collaborate with creatives</p>
                                <div class="d-flex align-start">
                                    <p class="m-b-0">Active in various creative expertises </p> <i class="zmdi zmdi-accounts-outline f-22 m-l-10 c-black"></i>
                                </div>
                            @endmobile
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="hr col-md-6 m-b-20"></div>
                    </div>
                </div>
                <div class="row d-flex js-center <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
                    <div class="col-md-4 p-0">
                        <a id="collaborateNow" href="/what-is-innocreation" class="btn btn-inno-cta startRegisterProcess @tablet p-l-8 @endtablet">@tablet Collaborate! @elsedesktop I want to connect! @endtablet</a>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
</div>
    <div class="homepage-mainContent <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
        <div class="theme-background p-b-20">
            <div class="carousel carousel-default m-b-30" id="carousel-default">
                <ul class="p-l-0">
                   <? $counterExp = 0;?>
                    <? foreach($expertises1 as $expertise) { ?>
                        <? $counterExp++?>
                        <li class="<? if($counterExp % 2 == 0) echo "p-t-30"; else echo "p-b-30"?> p-r-20 " style="min-width: 350px !important; list-style-type: none">
                            <div class="card m-t-20 m-b-20 p-relative">
                                <div class="card-block expertiseCard p-relative c-pointer" data-url="/" style="max-height: 210px !important">
                                    <div class="p-t-40 p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                                        <a class="c-gray f-9 photographer" target="_blank" href="<?= $expertise->image_link?>">Photo</a><span class="c-gray f-9"> by </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="<?= $expertise->photographer_link?>"><?= $expertise->photographer_name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="https://unsplash.com">Unsplash</a>
                                    </div>
                                    <a href="/<?= $expertise->slug?>/users" style="z-index: 400;">
                                        <div class="p-t-40 p-absolute" style="z-index: 100; top: 45%; left: 50%; transform: translate(-50%, -50%);">
                                            <div class="hr-sm"></div>
                                        </div>
                                        <div class="p-t-40 p-absolute" style="z-index: 99; top: 35%; left: 50%; transform: translate(-50%, -50%);">
                                            <p class="c-white @tablet f-15 @elsedesktop f-20 @endtablet"><?= $expertise->title?></p>
                                        </div>
                                    </a>
                                    <div class="overlay"></div>
                                    <a href="/<?= $expertise->slug?>/users" style="z-index: 400;">
                                        <div class="contentExpertise lazyLoad" data-src="<?= $expertise->image?>"></div>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <? } ?>
                </ul>
            </div>
            <div class="carousel carousel-default" id="carousel-default2">
                <ul class="p-l-0">
                    <? $counterExp = 0;?>
                    <? foreach($expertises2 as $expertise) { ?>
                    <? $counterExp++?>
                    <li class="<? if($counterExp % 2 == 0) echo "p-t-30"; else echo "p-b-30"?> p-r-20" style="min-width: 350px !important; list-style-type: none">
                        <div class="card m-t-20 m-b-20">
                            <div class="card-block expertiseCard p-relative c-pointer" data-url="/" style="max-height: 210px !important">
                                <div class="p-t-40 p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                                    <a class="c-gray f-9 photographer" target="_blank" href="<?= $expertise->image_link?>">Photo</a><span class="c-gray f-9"> by </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="<?= $expertise->photographer_link?>"><?= $expertise->photographer_name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="https://unsplash.com">Unsplash</a>
                                </div>
                                <a href="/<?= $expertise->slug?>/users" style="z-index: 400;">
                                    <div class="p-t-40 p-absolute" style="z-index: 100; top: 45%; left: 50%; transform: translate(-50%, -50%);">
                                        <div class="hr-sm"></div>
                                    </div>
                                    <div class="p-t-40 p-absolute" style="z-index: 99; top: 35%; left: 50%; transform: translate(-50%, -50%);">
                                        <p class="c-white @tablet f-15 @elsedesktop f-20 @endtablet"><?= $expertise->title?></p>
                                    </div>
                                </a>
                                <div class="overlay"> </div>
                                <a href="/<?= $expertise->slug?>/users" style="z-index: 400;">
                                    <div class="contentExpertise lazyLoad" data-src="<?= $expertise->image?>"></div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <? } ?>
                </ul>
            </div>
        </div>
    </div>
<div class="footerView"></div>

<style>
    footer{
        display: none !important;
    }
    .footerView footer{
        display: block !important;
    }
</style>
<script>
    $(document).ready(function () {
        $(".footerView").load("/includes/footer");
    });
    $( function() {
        var availableTags = [
            <? foreach($expertises as $tag) { ?>
                "<?=$tag->title?>",
            <? } ?>
        ];
        $( "#tags" ).autocomplete({
            source: availableTags
        });
    } );
    $(".searchExpertisesHome").on("keyup", function () {
        $(".ui-menu").appendTo(".expertises");
    });
    $(document).ready(function () {
        $(".ui-menu").addClass("ui-menu-home");
    });
</script>
@endsection
@section('pagescript')
    <script defer async src="/js/home/home.js"></script>
    <script defer async src="/js/lazyLoader.js"></script>
@endsection