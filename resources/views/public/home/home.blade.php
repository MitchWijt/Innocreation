@extends("layouts.app")
@section("content")
<div class="home-background-wrapper vh85">
    <div class="container p-relative">
        <div class="row">
            <div class="col-sm-12 d-flex js-center">
                @include("includes.flash")
            </div>
        </div>
        <div class="main-content">
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
                    <a href="/create-my-account" class="btn btn-inno col-sm-5 startRegisterProcess @tablet p-l-8 @endtablet" style="border-radius: 10px;">@tablet Collaborate! @elsedesktop Start collaborating! @endtablet</a>
                </div>
            </div>
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
                                <div class="@handheld col-10 @elsedesktop col-md-4 @endhandheld carouselItem">
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
                <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center m-t-20">
                                <h1 id="scrollToHome" class="sub-title col-sm-12">How it works</h1>
                            </div>
                        </div>
                        <div class="hr col-md-8"></div>
                        <div class="row">
                            <div class="@mobile col-2 m-t-15 @elsedesktop col-md-2 d-flex jc-end @endmobile">
                                <div class="@mobile circle-instructions-mobile @elsedesktop circle-instructions @endmobile">
                                    <i style="color: #C9CCCF; padding-left: 1px;" class="zmdi zmdi-accounts-outline @mobile f-30 social-icon-instructions-mobile @elsedesktop f-50  social-icon-instructions @endmobile"></i>
                                </div>
                            </div>
                            <div class="@mobile col-10 @elsedesktop col-md-10 @endmobile m-t-15">
                                @handheld
                                    @mobile
                                        <p class="instructions-text m-0 allign-center f-17">Create an <a class="regular-link" href="/create-my-account">account</a> with your expertise(s)</p>
                                    @elsetablet
                                        <p class="instructions-text m-0 allign-center f-20">Create an <a class="regular-link" href="/create-my-account">account</a> with your expertise(s)</p>
                                    @endmobile
                                @elsedesktop
                                    <p class="instructions-text m-0 allign-center f-22">Create an <a class="regular-link" href="/create-my-account">account</a> with your expertise(s)</p>
                                @endhandheld
                            </div>
                        </div>
                        <div class="row">
                            <div class="@mobile col-10 p-r-0 @elsedesktop col-md-10 d-flex jc-end @endmobile">
                                @handheld
                                    @mobile
                                        <p class="c-gray m-b-0 m-t-15 f-17">Have an idea or product you want to create</p>
                                    @elsetablet
                                        <p class="c-gray m-b-0 m-r-20 m-t-15 f-20">Have an idea or product you want to create</p>
                                    @endmobile
                                @elsedesktop
                                    <p class="c-gray m-b-0 m-r-20 m-t-15 f-22">Have an idea or product you want to create</p>
                                @endhandheld
                            </div>
                            <div class="@mobile col-2 p-l-0 @elsedesktop col-md-2 @endmobile">
                                <div class="@mobile circle-instructions-mobile @elsedesktop circle-instructions @endmobile">
                                    <i style="font-size: 50px; color: #C9CCCF; padding-top: 9px; padding-left: 3px;" class="zmdi zmdi-developer-board @mobile f-30 social-icon-instructions-mobile @elsedesktop f-50 social-icon-instructions @endmobile"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row @mobile m-t-20 @endmobile">
                            <div class="@mobile col-2 m-t-0 @elsedesktop col-md-2 d-flex jc-end @endmobile">
                                <div class="@mobile circle-instructions-mobile @elsedesktop circle-instructions @endmobile">
                                    <i style="font-size: 50px; color: #C9CCCF; padding-left: 1px;" class="zmdi zmdi-pin-drop @mobile f-30 social-icon-instructions-mobile @elsedesktop f-50  social-icon-instructions @endmobile"></i>
                                </div>
                            </div>
                            <div class="@mobile col-10 @elsedesktop col-md-10 m-t-15 @endmobile ">
                                @handheld
                                    @mobile
                                        <p class="instructions-text m-0 f-17">Offer yourself as a service or ask for a service</p>
                                    @elsetablet
                                        <p class="instructions-text m-0 f-20">Offer yourself as a service or ask for a service</p>
                                    @endmobile
                                @elsedesktop
                                    <p class="instructions-text m-0 f-22">Offer yourself as a service or ask for a service</p>
                                @endhandheld
                            </div>
                        </div>
                        <div class="row @mobile p-b-20 @endmobile">
                            <div class="@mobile col-10 @elsedesktop col-md-10 jc-end d-flex @endmobile ">
                                @handheld
                                    @mobile
                                        <p class="instructions-text m-b-0 m-t-15 f-17">Create or join a <a class="regular-link" href="/teams">team</a> and enjoy working together!</p>
                                    @elsetablet
                                        <p class="instructions-text m-b-0 m-r-20 m-t-15 f-20">Create or join a <a class="regular-link" href="/teams">team</a> and enjoy working together!</p>
                                    @endmobile
                                @elsedesktop
                                    <p class="instructions-text m-b-0 m-r-20 m-t-15 f-22">Create or join a <a class="regular-link" href="/teams">team</a> and enjoy working together!</p>
                                @endhandheld
                            </div>
                            <div class="@mobile col-2 p-l-0 m-t-10 @elsedesktop col-md-2 m-b-20 @endmobile">
                                <div class="@mobile circle-instructions-mobile @elsedesktop circle-instructions @endmobile">
                                    <i style="font-size: 50px; color: #C9CCCF; padding-top: 12px; padding-left: 0;" class="zmdi zmdi-badge-check @mobile f-30 social-icon-instructions-mobile @elsedesktop f-50 social-icon-instructions @endmobile"></i>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="instructions-second">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 m-t-20">
                            <div class="row">
                                <div class="@mobile col-2 m-t-15 @elsedesktop col-sm-2 d-flex jc-end @endmobile">
                                    <div class="@mobile circle-instructions-mobile @elsedesktop circle-instructions @endmobile">
                                        <i style="font-size: 50px; padding-left: 1px;" class="material-icons @mobile f-30 social-icon-instructions-mobile @elsedesktop f-50  social-icon-instructions @endmobile">lightbulb_outline</i>
                                    </div>
                                </div>
                                <div class="@mobile col-10 m-t-15 @elsedesktop col-sm-10 m-t-15 @endmobile ">
                                    @handheld
                                        @mobile
                                            <p class="instructions-second-text m-0 f-15">Network with various artists and come up with new ideas in the <a class="regular-link" href="/innocreatives">Innocreatives feed</a></p>
                                        @elsetablet
                                            <p class="instructions-second-text m-0 f-20">Network with various artists and come up with new ideas in the <a class="regular-link" href="/innocreatives">Innocreatives feed</a></p>
                                        @endmobile
                                    @elsedesktop
                                        <p class="instructions-second-text m-0 f-22">Network with various artists and come up with new ideas in the <a class="regular-link" href="/innocreatives">Innocreatives feed</a></p>
                                    @endhandheld
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="@mobile col-10 p-r-0 @elsedesktop col-sm-10 d-flex jc-end @endmobile ">
                                    @handheld
                                        @mobile
                                            <p class="instructions-second-text m-b-0 m-t-15 m-r-20 f-17">Communicate easily with your team through the <a class="regular-link" href="/login">chat system</a></p>
                                        @elsetablet
                                            <p class="instructions-second-text m-b-0 m-t-15 m-r-20 f-20">Communicate easily with your team through the <a class="regular-link" href="/login">chat system</a></p>
                                        @endmobile
                                    @elsedesktop
                                        <p class="instructions-second-text m-b-0 m-t-15 m-r-20 f-22">Communicate easily with your team through the <a class="regular-link" href="/login">chat system</a></p>
                                    @endhandheld
                                </div>
                                <div class="@mobile col-2 p-l-0 m-t-10 @elsedesktop col-sm-2 @endmobile">
                                    <div class="@mobile circle-instructions-mobile @elsedesktop circle-instructions @endmobile">
                                        <i style="font-size: 50px; padding-left: 1px; padding-top: 10px;" class="material-icons @mobile f-30 social-icon-instructions-mobile @elsedesktop f-50  social-icon-instructions @endmobile">chat</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row @mobile p-t-20 @endmobile">
                                <div class="@mobile col-2 @elsedesktop col-md-2 d-flex jc-end @endmobile">
                                    <div class="@mobile circle-instructions-mobile @elsedesktop circle-instructions @endmobile">
                                        <i style="font-size: 50px; color: #000; padding-left: 1px;" class="zmdi zmdi-globe @mobile f-30 social-icon-instructions-mobile @elsedesktop f-50  social-icon-instructions @endmobile"></i>
                                    </div>
                                </div>
                                <div class="@mobile col-10 p-r-0 @elsedesktop col-sm-10 m-t-15 @endmobile ">
                                    @handheld
                                        @mobile
                                            <p class="instructions-second-text m-0 f-17">Get your idea/product known to the open world!</p>
                                        @elsetablet
                                            <p class="instructions-second-text m-0 f-20">Get your idea/product known to the open world!</p>
                                        @endmobile
                                    @elsedesktop
                                        <p class="instructions-second-text m-0 f-22">Get your idea/product known to the open world!</p>
                                    @endhandheld
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="@mobile col-10 p-r-0 @elsedesktop col-sm-10 d-flex jc-end @endmobile ">
                                    @handheld
                                        @mobile
                                            <p class="instructions-second-text m-b-0 m-t-15 f-17">Post your finished products on the live  <a class="regular-link" href="/team-products">feed</a></p>
                                        @elsetablet
                                            <p class="instructions-second-text m-b-0 m-r-20 m-t-15 f-20">Post your finished products on the live  <a class="regular-link" href="/team-products">feed</a></p>
                                        @endmobile
                                    @elsedesktop
                                        <p class="instructions-second-text m-b-0 m-r-20 m-t-15 f-22">Post your finished products on the live  <a class="regular-link" href="/team-products">feed</a></p>
                                    @endhandheld
                                </div>
                                <div class="@mobile col-2 p-l-0 m-t-10 @elsedesktop col-sm-2 @endmobile">
                                    <div class="@mobile circle-instructions-mobile @elsedesktop circle-instructions @endmobile">
                                        <i style="font-size: 50px; padding-right: 5px; padding-top: 8px;" class="zmdi zmdi-share @mobile f-30 social-icon-instructions-mobile @elsedesktop f-50  social-icon-instructions @endmobile"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row @mobile p-t-20 p-b-20 @endmobile">
                                <div class="@mobile col-2 @elsedesktop col-sm-2 d-flex jc-end @endmobile">
                                    <div class="@mobile circle-instructions-mobile @elsedesktop circle-instructions @endmobile">
                                        <i style="font-size: 50px; padding-right: 4px;padding-top: 8px;" class="zmdi zmdi-mood @mobile f-30 social-icon-instructions-mobile @elsedesktop f-50  social-icon-instructions @endmobile"></i>
                                    </div>
                                </div>
                                <div class="@mobile col-10 @elsedesktop col-sm-10 m-t-15 @endmobile ">
                                    @handheld
                                        @mobile
                                            <p class="instructions-second-text m-0 f-17">Have fun, be creative and innovative</p>
                                        @elsetablet
                                            <p class="instructions-second-text m-0 f-20">Have fun, be creative and innovative</p>
                                        @endmobile
                                    @elsedesktop
                                        <p class="instructions-second-text m-0 f-22">Have fun, be creative and innovative!</p>
                                    @endhandheld
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex js-center p-b-25">
                        <a href="/create-my-account" class="btn btn-inno">Start now!</a>
                    </div>
                </div>
            </div>
            <div class="instructions" style="border-bottom: 1px solid #FF6100">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center m-t-20">
                            <h1 class="sub-title col-sm-12">Share your work!</h1>
                        </div>
                    </div>
                    <div class="hr col-md-8"></div>
                    <div class="row">
                        <div class="col-sm-12 d-flex js-center m-t-20">
                            <img class="img-responsive" src="/images/icons/network_gray.png" alt="">
                        </div>
                    </div>
                    <div class="row d-flex js-center m-t-40 m-b-20">
                        <ul class="instructions-list">
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Discover and engage on other people their work</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Share your own best work that you are most proud of</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Get a place in the spotlight on the homepage!</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Send a request to create a team together</p>
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

    $(".scrollHomeBtn").click(function() {
        setTimeout(function(){
            $('html, body').animate({
                scrollTop: $("#scrollToHome").offset().top - 120
            }, 2000);
        }, 500);
    })
</script>
@endsection
@section('pagescript')
    <script src="/js/home/home.js"></script>
@endsection