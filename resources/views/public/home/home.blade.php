@extends("layouts.app")
<link rel="stylesheet" href="/css/home/home.css">
<script src="/js/floatingcarousel.min.js"></script>
@section("content")
<div class="home-background-wrapper vh85">
    <div class="container p-relative">
        <div class="row">
            <div class="col-sm-12 d-flex js-center">
                @include("includes.flash")
            </div>
        </div>
        <div class="main-content">
            <? if(isset($loggedIn) && $loggedIn) { ?>
                <div class="row" style="margin-top: 180px !important">
                    <div class="expertises col-12">
                        <div class="row">
                            <div class="col-1 p-r-0 m-r-0">
                                <button class="btn-inno btn btn-block b-t-r-0 b-b-r-0 searchBtnHome" style="border: none !important"><i class="zmdi zmdi-search f-30"></i></button>
                            </div>
                            <div class="col-10 p-l-0 m-l-0 p-r-0 m-r-0">
                                <input type="text" id="tags" placeholder="What expertise or knowledge do you need?" name="SearchExpertises" class="input-fat-home b-0 col-sm-12 searchExpertisesHome b-t-l-0 b-b-l-0 b-b-r-0 b-t-r-0 b-r-0">
                            </div>
                            <div class="col-1 clearInput btn-block b-l-0">
                                <i class="zmdi zmdi-close f-20 pull-right c-dark-grey m-t-10 clearCross hidden"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <? } else { ?>
                <div class="row" style="margin-top: 180px !important">
                    <div class="col-md-12 m-b-20">
                        <div class="title-home">
                            @mobile
                                <h1 style="font-weight: bold;" class="text-center col-md-12 f-40">Innocreation</h1>
                            @elsedesktop
                                <h1 class="title-black text-center col-md-12">Innocreation</h1>
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
                        <a id="collaborateNow" href="/create-my-account" class="btn btn-inno startRegisterProcess @tablet p-l-8 @endtablet" style="border-radius: 10px;">@tablet Collaborate! @elsedesktop Start collaborating! @endtablet</a>
                    </div>
                </div>
            <? } ?>
            <div id="carouselExampleIndicators" class="carousel slide p-relative" @desktop style="margin-top: 180px !important" @enddesktop @tablet  style="margin-top: 130px !important" @endtablet data-ride="carousel">
                <div class="carousel-inner">
                    <? $counter = 0;?>
                        @handheld
                            <? $modulo = 1?>
                            <? $result1 = 0 ?>
                            <? $result2 = 0?>
                        @elsedesktop
                        <? $modulo = 3?>
                        <? $result1 = 0?>
                        <? $result2 = 2?>
                        @endhandheld
                    <? foreach($carouselUserWorks as $carouselUserWork) { ?>
                            <? if($counter % $modulo == $result1) { ?>
                            <div class="carousel-item <? if($counter == 0) echo "active"?>">
                                <div class="row @handheld d-flex js-center @endhandheld">
                            <? } ?>
                                <div class="@handheld col-12 @elsedesktop col-md-4 @endhandheld carouselItem">
                                    <a class="td-none" href="<?= $carouselUserWork->getUrl()?>">
                                    <div class="card-sm m-t-20 m-b-20 @tablet p-10 @endtablet">
                                        <div class="card-block m-t-10 " @notmobile style="max-height: 165px !important;" @endnotmobile data-user-id="<?= $carouselUserWork->user_id?>">
                                            <div class="row">
                                                <div class="col-sm-4 p-l-20 @notmobile p-r-0 @endnotmobile text-center">
                                                    <div class="d-flex js-center">
                                                        <div class="avatar" style="background: url('<?= $carouselUserWork->user->getProfilePicture()?>')"></div>
                                                    </div>
                                                    <p style="word-break: break-all"><?= $carouselUserWork->user->firstname?></p>
                                                </div>
                                                <div class="col-sm-8 p-l-25 p-b-10">
                                                    <p class="underline m-b-5">Introduction:</p>
                                                    <p class="m-0" style="word-break: break-all"><?= substr($carouselUserWork->description, 0, 40) . "... <span class='c-orange underline c-pointer' data-user-id='$carouselUserWork->user_id'>read more</span>";?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            <? if($counter % $modulo == $result2) { ?>
                                </div>
                            </div>
                            <? } ?>
                        <? $counter++;?>
                    <? } ?>
                </div>
        <? if(count($carouselUserWorks) % $modulo == 1 || count($carouselUserWorks) % $modulo == 2) { ?>
            </div>
        </div>
        <? } ?>
                @handheld
                    @mobile
                        <i class="zmdi zmdi-chevron-left p-absolute c-orange carousel-control-prev c-pointer" style="top: 85px; left: -15px; font-size: 40px !important;"></i>
                        <i class="zmdi zmdi-chevron-right p-absolute c-orange carousel-control-next c-pointer" style="top: 85px; right: -15px; font-size: 40px !important;"></i>
                    @elsetablet
                        <i class="zmdi zmdi-chevron-left p-absolute c-orange carousel-control-prev c-pointer" style="top: 70px; left: -30px; font-size: 40px !important;"></i>
                        <i class="zmdi zmdi-chevron-right p-absolute c-orange carousel-control-next c-pointer" style="top: 70px; right: -30px; font-size: 40px !important;"></i>
                    @endmobile
                @elsedesktop
                    <i class="zmdi zmdi-chevron-left p-absolute c-orange carousel-control-prev c-pointer" style="top: 55px; left: -120px; font-size: 40px !important;"></i>
                    <i class="zmdi zmdi-chevron-right p-absolute c-orange carousel-control-next c-pointer" style="top: 55px; right: -120px; font-size: 40px !important;"></i>
                @endhandheld
            </div>
        </div>
    </div>
        <div class="homepage-mainContent">
            <div class="instructions">
                <div class="carousel carousel-default m-b-30" id="carousel-default">
                    <ul class="p-l-0">
                       <? $counterExp = 0;?>
                        <? foreach($expertises1 as $expertise) { ?>
                            <? $counterExp++?>
                            <li class="@desktop col-2 @elsehandheld col-4 @enddesktop <? if($counterExp % 2 == 0) echo "p-t-30"; else echo "p-b-30"?>">
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
                        <li class="@desktop col-2 @elsehandheld col-4 @enddesktop  <? if($counterExp % 2 == 0) echo "p-t-30"; else echo "p-b-30"?>">
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
                            <img class="img-responsive" src="/images/icons/network_black.png" alt="">
                        </div>
                    </div>
                    <div class="row d-flex js-center m-t-40 m-b-20">
                        <ul class="instructions-list">
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10 c-black">Discover and engage on other people their work</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10 c-black">Share your own best work that you are most proud of</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10 c-black">Get a place in the spotlight on the homepage!</p>
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
    $(document).ready(function () {
        $(".ui-menu").appendTo(".expertises");
        $(".ui-menu").addClass("ui-menu-home");
    });
</script>
@endsection
@section('pagescript')
    <script src="/js/home/home.js"></script>
@endsection