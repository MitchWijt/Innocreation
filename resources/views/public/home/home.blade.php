@extends("layouts.app")
@section("content")
<div class="home-background-wrapper">
    <div class="main-content">
        <div class="row">
            <div class="col-md-12">
                <div class="title-home">
                    <h1 class="title-black text-center col-sm-12">Innocreation</h1>
                    @tablet
                        <div class="hr col-md-10"></div>
                    @elsedesktop
                        <div class="hr col-md-5"></div>
                    @endtablet
                    <p class="m-t-10 slogan text-center col-sm-12" style="color: #696969">Help each other make DREAMS become a reality</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex js-center">
                <div class="circle" style="width: 65px !important; height: 65px !important;">
                    <i style="font-size: 50px; color: #FF6100" class="zmdi zmdi-chevron-down social-icon-home scrollHomeBtn"></i>
                </div>
            </div>
        </div>
    </div>
    @desktop
        <div class="homepage-mainContent hidden">
            <div class="instructions">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1 id="scrollToHome" class="sub-title col-sm-12">How it works</h1>
                        </div>
                        <div class="hr col-md-8"></div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-2 d-flex jc-end">
                                    <div class="circle-instructions">
                                        <i style="font-size: 50px; color: #C9CCCF; padding-left: 1px;" class="zmdi zmdi-accounts-outline social-icon-instructions"></i>
                                    </div>
                                </div>
                                <div class="col-sm-10 m-t-15">
                                    <p class="instructions-text m-0 allign-center">Create an <a class="regular-link" href="/">account</a> with your expertise(s)</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-10 d-flex jc-end">
                                    <p class="c-gray f-25 m-b-0 m-r-20  m-t-15">Have an idea or product you want to develop</p>
                                </div>
                                <div class="col-md-2">
                                    <div class="circle-instructions">
                                        <i style="font-size: 50px; color: #C9CCCF; padding-top: 9px; padding-left: 3px;" class="zmdi zmdi-developer-board social-icon-instructions"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-2 d-flex jc-end">
                                    <div class="circle-instructions">
                                        <i style="font-size: 50px; color: #C9CCCF; padding-left: 1px;" class="zmdi zmdi-pin-drop social-icon-instructions"></i>
                                    </div>
                                </div>
                                <div class="col-sm-10 m-t-15">
                                    <p class="instructions-text m-0">Offer yourself as a service or ask for a service</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-b-20">
                            <div class="row">
                                <div class="col-md-10 jc-end d-flex">
                                    <p class="instructions-text m-b-0 m-r-20 m-t-15">Create or join a <a class="regular-link" href="/">team</a> and enjoy working together!</p>
                                </div>
                                <div class="col-md-2">
                                    <div class="circle-instructions">
                                        <i style="font-size: 50px; color: #C9CCCF; padding-top: 12px; padding-left: 0;" class="zmdi zmdi-badge-check social-icon-instructions"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="instructions-second">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-2 d-flex jc-end">
                                    <div class="circle-instructions">
                                        <i style="font-size: 50px; padding-left: 1px;" class="material-icons social-icon-instructions">lightbulb_outline</i>
                                    </div>
                                </div>
                                <div class="col-sm-10 m-t-15">
                                    <p class="instructions-second-text m-0">Experience other people their ideas. And discuss ideas in the <a class="regular-link" href="/">forum</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-10 d-flex jc-end">
                                    <p class="instructions-second-text m-b-0 m-t-15 m-r-20">Communicate easily with your team through the <a class="regular-link" href="/">chat system</a></p>
                                </div>
                                <div class="col-md-2">
                                    <div class="circle-instructions">
                                        <i style="font-size: 50px; padding-left: 1px; padding-top: 10px;" class="material-icons social-icon-instructions">chat</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-2 d-flex jc-end">
                                    <div class="circle-instructions">
                                        <i style="font-size: 50px; padding-left: 1px;" class="material-icons social-icon-instructions">attach_money</i>
                                    </div>
                                </div>
                                <div class="col-sm-10 m-t-15">
                                    <p class="instructions-second-text m-0">Pay all your team members with one push on a button</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-10 d-flex jc-end">
                                    <p class="instructions-second-text m-b-0 m-r-20 m-t-15">Sell your own team products in our <a class="regular-link" href="/">shop</a></p>
                                </div>
                                <div class="col-md-2">
                                    <div class="circle-instructions">
                                        <i style="font-size: 50px; padding-left: 1px; padding-top: 10px;" class="material-icons social-icon-instructions">shopping_basket</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-b-20">
                            <div class="row ">
                                <div class="col-sm-2 d-flex jc-end">
                                    <div class="circle-instructions">
                                        <img class="circle social-icon-instructions  m-r-0" style="height: 65px !important; width: 65px !important;" src="/images/BTC-alt.svg" alt="Bitcoin">
                                    </div>
                                </div>
                                <div class="col-sm-10 m-t-15">
                                    <p class="instructions-second-text m-0">We support bitcoin and other cryptocurrencies</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elsemobile
        <div class="homepage-mainContent hidden">
            <div class="instructions">
                <div class="container">
                    <div class="row col-sm-12">
                        <div class="col-md-12 text-center">
                            <h1 id="scrollToHome" class="sub-title col-sm-12 f-20">How it works</h1>
                        </div>
                        <div class="hr col-md-8"></div>
                            <div class="row text center d-flex">
                                <div class="col-sm-2 m-t-20 d-flex">
                                    <div class="circle-instructions-mobile">
                                        <i style="font-size: 25px; color: #C9CCCF; padding-left: 0; padding-right: 32px;" class="zmdi zmdi-accounts-outline social-icon-instructions"></i>
                                    </div>
                                </div>
                                <div class="col-sm-10 m-t-15">
                                    <p class="instructions-text m-0 allign-center f-15">Create an <a class="regular-link" href="/">account</a> with your expertise(s)</p>
                                </div>
                            </div>
                        <div class="col-md-5">
                            <div class="row text-center">
                                <div class="col-md-10">
                                    <p class="c-gray f-25 m-b-0 m-r-20 f-15 m-t-15">Have an idea or product you want to develop</p>
                                </div>
                                <div class="col-md-2">
                                    <div class="circle-instructions">
                                        <i style="font-size: 50px; color: #C9CCCF; padding-top: 9px; padding-left: 3px;" class="zmdi zmdi-developer-board social-icon-instructions"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row text-center">
                                <div class="col-sm-2">
                                    <div class="circle-instructions">
                                        <i style="font-size: 50px; color: #C9CCCF; padding-left: 1px;" class="zmdi zmdi-pin-drop social-icon-instructions"></i>
                                    </div>
                                </div>
                                <div class="col-sm-10 m-t-15">
                                    <p class="instructions-text m-0 f-15">Offer yourself as a service or ask for a service</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-b-20">
                            <div class="row">
                                <div class="col-md-10 jc-end d-flex">
                                    <p class="instructions-text m-b-0 m-r-20 m-t-15">Create or join a <a class="regular-link" href="/">team</a> and enjoy working together!</p>
                                </div>
                                <div class="col-md-2">
                                    <div class="circle-instructions">
                                        <i style="font-size: 50px; color: #C9CCCF; padding-top: 12px; padding-left: 0;" class="zmdi zmdi-badge-check social-icon-instructions"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="instructions-second">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row text-center">
                                <div class="col-sm-2">
                                    <div class="circle-instructions">
                                        <i style="font-size: 50px; padding-left: 1px;" class="material-icons social-icon-instructions">lightbulb_outline</i>
                                    </div>
                                </div>
                                <div class="col-sm-10 m-t-15">
                                    <p class="instructions-second-text m-0 f-15">Experience other people their ideas. And discuss ideas in the <a class="regular-link" href="/">forum</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row text-center">
                                <div class="col-md-10">
                                    <p class="instructions-second-text m-b-0 m-t-15 m-r-20 f-15">Communicate easily with your team through the <a class="regular-link" href="/">chat system</a></p>
                                </div>
                                <div class="col-md-2">
                                    <div class="circle-instructions">
                                        <i style="font-size: 50px; padding-left: 1px; padding-top: 10px;" class="material-icons social-icon-instructions">chat</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row text-center">
                                <div class="col-sm-2">
                                    <div class="circle-instructions">
                                        <i style="font-size: 50px; padding-left: 1px;" class="material-icons social-icon-instructions">attach_money</i>
                                    </div>
                                </div>
                                <div class="col-sm-10 m-t-15">
                                    <p class="instructions-second-text m-0 f-15">Pay all your team members with one push on a button</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row text-center">
                                <div class="col-md-10">
                                    <p class="instructions-second-text m-b-0 m-r-20 m-t-15 f-15">Sell your own team products in our <a class="regular-link" href="/">shop</a></p>
                                </div>
                                <div class="col-md-2">
                                    <div class="circle-instructions">
                                        <i style="font-size: 50px; padding-left: 1px; padding-top: 10px;" class="material-icons social-icon-instructions">shopping_basket</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-b-20">
                            <div class="row text-center">
                                <div class="col-sm-2">
                                    <div class="circle-instructions">
                                        <img class="circle social-icon-instructions m-r-0" style="height: 65px !important; width: 65px !important;" src="/images/BTC-alt.svg" alt="Bitcoin">
                                    </div>
                                </div>
                                <div class="col-sm-10 m-t-15 f-15">
                                    <p class="instructions-second-text m-0">We support bitcoin and other cryptocurrencies</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @enddesktop

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
    $(document).on( 'DOMMouseScroll mousewheel', function ( event ) {
        if( event.originalEvent.detail > 0 || event.originalEvent.wheelDelta < 0 ) {
            $(".headerShow").fadeIn();
            $(".home-background-wrapper").css("height","85vh");
            $(".homepage-mainContent").removeClass("hidden");
            $(".footerView").load("/includes/footer");
            $(".footerView").attr("style", "display: block !important");
        }
    });

    $(document).ready(function () {
        $('.headerShow').hide();
    });

    $(".scrollHomeBtn").click(function() {
        $(".headerShow").fadeIn();
        $(".home-background-wrapper").css("height","85vh");
        $(".homepage-mainContent").removeClass("hidden");
        $(".footerView").load("/includes/footer");
        $(".footerView").attr("style", "display: block !important");

        $('html, body').animate({
            scrollTop: $("#scrollToHome").offset().top - 120
        }, 2000);
    })
</script>
@endsection
@section('pagescript')
    <script src="/js/home/home.js"></script>
@endsection