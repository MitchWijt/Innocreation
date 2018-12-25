@extends("layouts.app")
<link rel="stylesheet" href="/css/home/home.css">
<script src="/js/floatingcarousel.min.js"></script>
@section("content")
<div class="home-background-wrapper vh80">
    <div class="container p-relative">
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
                            @tablet
                            <div class="hr col-md-10"></div>
                            @elsedesktop
                            <div class="hr col-md-10"></div>
                            @endtablet
                        </div>
                    </div>
                </div>
                <div class="row d-flex js-center">
                    <div class="col-md-5 d-flex js-center">
                        <a id="collaborateNow" href="/innocreatives" class="btn btn-inno startRegisterProcess @tablet p-l-8 @endtablet" style="border-radius: 10px;">@tablet Connect! @elsedesktop Start connecting! @endtablet</a>
                    </div>
                </div>
            <? } else { ?>
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
                            @tablet
                                <div class="hr col-md-10"></div>
                            @elsedesktop
                                <div class="hr col-md-10"></div>
                            @endtablet
                        </div>
                    </div>
                </div>
                <div class="row d-flex js-center">
                    <div class="col-md-5 d-flex js-center">
                        <a id="collaborateNow" href="/what-is-innocreation" class="btn btn-inno startRegisterProcess @tablet p-l-8 @endtablet" style="border-radius: 10px;">@tablet Collaborate! @elsedesktop Start collaborating! @endtablet</a>
                    </div>
                </div>
            <? } ?>
            </div>
        </div>

        <div class="homepage-mainContent">
            <div class="instructions">
                <div class="carousel carousel-default m-b-30" id="carousel-default">
                    <ul class="p-l-0">
                       <? $counterExp = 0;?>
                        <? foreach($expertises1 as $expertise) { ?>
                            <? $counterExp++?>
                            <li class="<? if($counterExp % 2 == 0) echo "p-t-30"; else echo "p-b-30"?> p-r-20" style="min-width: 350px !important;">
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
                                        <div class="overlay">
                                            <a href="/<?= $expertise->slug?>/users" style="z-index: 400;">
                                                <div class="contentExpertise" style="background: url('<?= $expertise->image?>');"></div>
                                            </a>
                                        </div>
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
                        <li class="<? if($counterExp % 2 == 0) echo "p-t-30"; else echo "p-b-30"?> p-r-20" style="min-width: 350px !important;">
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
                                    <div class="overlay">
                                        <a href="/<?= $expertise->slug?>/users" style="z-index: 400;">
                                            <div class="contentExpertise" style="background: url('<?= $expertise->image?>');"></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <? } ?>
                    </ul>
                </div>
            </div>
            <div class="instructions-second" style="border-bottom: 1px solid #FF6100">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center m-t-20">
                            <h1 class="sub-title col-sm-12 c-black">Share your work!</h1>
                        </div>
                    </div>
                    <div class="hr col-md-8"></div>
                    <div class="row">
                        <div class="col-sm-12 d-flex js-center m-t-20">
                            <img class="img-responsive" src="/images/icons/network_black_small.png" alt="">
                        </div>
                    </div>
                    <div class="row d-flex js-center m-t-40 m-b-20">
                        <ul class="instructions-list">
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10 c-black">Discover and engage on other people their work</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10 c-black">Share your own best work/story that you are most proud of</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10 c-black">Request to work together and connect</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10 c-black">Send a request to create a team together</p>
                            </li>
                        </ul>
                    </div>
                    <div class="row d-flex js-center" style="margin-bottom: 50px !important">
                        <a href="/innocreatives" class="btn btn-inno">Start networking!</a>
                    </div>
                    <div class="modal fade carouselUserModal" id="carouselUserModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content carouselUserModalData">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="footerView"></div>
</div>

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
    <script src="/js/home/home.js"></script>
@endsection