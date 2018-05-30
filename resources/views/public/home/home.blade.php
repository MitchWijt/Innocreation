@extends("layouts.app")
@section("content")
<div class="home-background-wrapper">
    <div class="container">
        <div class="main-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-home">
                        @mobile
                            <h1 style="font-weight: bold;" class="text-center col-md-12 f-40">Innocreation</h1>
                        @elsedesktop
                            <h1 class="title-black text-center col-md-12">Innocreation</h1>
                        @endmobile
                        @tablet
                            <div class="hr col-md-10"></div>
                        @elsedesktop
                            <div class="hr col-md-5"></div>
                        @endtablet
                        <p class="m-t-10 slogan text-center" style="color: #696969">Help each other make DREAMS become a reality</p>
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
    </div>
        <div class="homepage-mainContent hidden">
            <div class="instructions">
                <div class="container">
                    {{--<div class="row">--}}
                        <div class="row">
                            <div class="col-md-12 text-center m-t-20">
                                <h1 id="scrollToHome" class="sub-title col-sm-12">How it works</h1>
                            </div>
                        </div>
                        <div class="hr col-md-8"></div>
                        <div class="row">
                            <div class="col-md-2 d-flex jc-end">
                                <div class="circle-instructions">
                                    <i style="font-size: 50px; color: #C9CCCF; padding-left: 1px;" class="zmdi zmdi-accounts-outline social-icon-instructions"></i>
                                </div>
                            </div>
                            <div class="col-md-10 m-t-15">
                                @handheld
                                    @mobile
                                        <p class="instructions-text m-0 allign-center f-17">Create an <a class="regular-link" href="/">account</a> with your expertise(s)</p>
                                    @elsetablet
                                        <p class="instructions-text m-0 allign-center f-20">Create an <a class="regular-link" href="/">account</a> with your expertise(s)</p>
                                    @endmobile
                                @elsedesktop
                                    <p class="instructions-text m-0 allign-center">Create an <a class="regular-link" href="/">account</a> with your expertise(s)</p>
                                @endhandheld
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 d-flex jc-end">
                                @handheld
                                    @mobile
                                        <p class="c-gray m-b-0 m-r-20 m-t-15 f-17">Have an idea or product you want to develop</p>
                                    @elsetablet
                                        <p class="c-gray m-b-0 m-r-20 m-t-15 f-20">Have an idea or product you want to develop</p>
                                    @endmobile
                                @elsedesktop
                                    <p class="c-gray f-25 m-b-0 m-r-20  m-t-15">Have an idea or product you want to develop</p>
                                @endhandheld
                            </div>
                            <div class="col-xs-2">
                                <div class="circle-instructions">
                                    <i style="font-size: 50px; color: #C9CCCF; padding-top: 9px; padding-left: 3px;" class="zmdi zmdi-developer-board social-icon-instructions"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2 d-flex jc-end">
                                <div class="circle-instructions">
                                    <i style="font-size: 50px; color: #C9CCCF; padding-left: 1px;" class="zmdi zmdi-pin-drop social-icon-instructions"></i>
                                </div>
                            </div>
                            <div class="col-xs-10 m-t-15">
                                @handheld
                                    @mobile
                                        <p class="instructions-text m-0 f-17">Offer yourself as a service or ask for a service</p>
                                    @elsetablet
                                        <p class="instructions-text m-0 f-20">Offer yourself as a service or ask for a service</p>
                                    @endmobile
                                @elsedesktop
                                    <p class="instructions-text m-0">Offer yourself as a service or ask for a service</p>
                                @endhandheld
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-10 jc-end d-flex">
                                @handheld
                                    @mobile
                                        <p class="instructions-text m-b-0 m-r-20 m-t-15 f-17">Create or join a <a class="regular-link" href="/">team</a> and enjoy working together!</p>
                                    @elsetablet
                                        <p class="instructions-text m-b-0 m-r-20 m-t-15 f-20">Create or join a <a class="regular-link" href="/">team</a> and enjoy working together!</p>
                                    @endmobile
                                @elsedesktop
                                    <p class="instructions-text m-b-0 m-r-20 m-t-15">Create or join a <a class="regular-link" href="/">team</a> and enjoy working together!</p>
                                @endhandheld
                            </div>
                            <div class="col-xs-2">
                                <div class="circle-instructions">
                                    <i style="font-size: 50px; color: #C9CCCF; padding-top: 12px; padding-left: 0;" class="zmdi zmdi-badge-check social-icon-instructions"></i>
                                </div>
                            </div>
                        </div>
                    {{--</div>--}}
                </div>
            </div>
            <div class="instructions-second">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 m-t-20">
                            <div class="row">
                                <div class="col-sm-2 d-flex jc-end">
                                    <div class="circle-instructions">
                                        <i style="font-size: 50px; padding-left: 1px;" class="material-icons social-icon-instructions">lightbulb_outline</i>
                                    </div>
                                </div>
                                <div class="col-sm-10 m-t-15">
                                    @handheld
                                        @mobile
                                            <p class="instructions-second-text m-0 f-17">Experience other people their ideas. And discuss ideas in the <a class="regular-link" href="/">forum</a></p>
                                        @elsetablet
                                            <p class="instructions-second-text m-0 f-20">Experience other people their ideas. And discuss ideas in the <a class="regular-link" href="/">forum</a></p>
                                        @endmobile
                                    @elsedesktop
                                        <p class="instructions-second-text m-0">Experience other people their ideas. And discuss ideas in the <a class="regular-link" href="/">forum</a></p>
                                    @endhandheld
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-10 d-flex jc-end">
                                    @handheld
                                        @mobile
                                            <p class="instructions-second-text m-b-0 m-t-15 m-r-20 f-17">Communicate easily with your team through the <a class="regular-link" href="/">chat system</a></p>
                                        @elsetablet
                                            <p class="instructions-second-text m-b-0 m-t-15 m-r-20 f-20">Communicate easily with your team through the <a class="regular-link" href="/">chat system</a></p>
                                        @endmobile
                                    @elsedesktop
                                        <p class="instructions-second-text m-b-0 m-t-15 m-r-20">Communicate easily with your team through the <a class="regular-link" href="/">chat system</a></p>
                                    @endhandheld
                                </div>
                                <div class="col-sm-2">
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
                                    @handheld
                                        @mobile
                                            <p class="instructions-second-text m-0 f-17">Pay all your team members with one push on a button</p>
                                        @elsetablet
                                            <p class="instructions-second-text m-0 f-20">Pay all your team members with one push on a button</p>
                                        @endmobile
                                    @elsedesktop
                                        <p class="instructions-second-text m-0">Pay all your team members with one push on a button</p>
                                    @endhandheld
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-10 d-flex jc-end">
                                    @handheld
                                        @mobile
                                            <p class="instructions-second-text m-b-0 m-r-20 m-t-15 f-17">Sell your own team products in our <a class="regular-link" href="/">shop</a></p>
                                        @elsetablet
                                            <p class="instructions-second-text m-b-0 m-r-20 m-t-15 f-20">Sell your own team products in our <a class="regular-link" href="/">shop</a></p>
                                        @endmobile
                                    @elsedesktop
                                        <p class="instructions-second-text m-b-0 m-r-20 m-t-15">Sell your own team products in our <a class="regular-link" href="/">shop</a></p>
                                    @endhandheld
                                </div>
                                <div class="col-sm-2">
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
                                    @handheld
                                        @mobile
                                            <p class="instructions-second-text m-0 f-17">We support bitcoin and other cryptocurrencies</p>
                                        @elsetablet
                                            <p class="instructions-second-text m-0 f-20">We support bitcoin and other cryptocurrencies</p>
                                        @endmobile
                                    @elsedesktop
                                        <p class="instructions-second-text m-0">We support bitcoin and other cryptocurrencies</p>
                                    @endhandheld
                                </div>
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
    var position = $(window).scrollTop();
    $(document).scroll(function(event) {
        var scroll = $(window).scrollTop();
        if(scroll > position) {
            $(".headerShow").fadeIn();
            $(".home-background-wrapper").css("height","85vh");
            $(".homepage-mainContent").removeClass("hidden");
            $(".footerView").load("/includes/footer");
            $(".footerView").attr("style", "display: block !important");
        }
        position = scroll;
//        if( event.originalEvent.detail > 0 || event.originalEvent.wheelDelta < 0 ) {

//        }
    });

    $(document).ready(function () {
        $('.headerShow').hide();
    });

    $(".scrollHomeBtn").click(function() {
        $(".headerShow").fadeIn();
        $(".home-background-wrapper").css("height","85vh");
        $(".homepage-mainContent").removeClass("hidden");
        $(".footerView").load("/includes/footer");
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