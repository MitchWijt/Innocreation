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
                            <div class="hr col-md-10"></div>
                        @endtablet
                        <p class="m-t-10 slogan text-center @mobile f-13 @endmobile" style="color: #696969">Match with your ideal team and create your dream!</p>
                    </div>
                </div>
            </div>
            <form action="/create-my-account" method="post">
                <div class="row d-flex js-center">
                    <div class="col-md-5 d-flex js-center">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="email" required name="email" class="input pull-right col-sm-7 b-t-r-0 b-b-r-0" placeholder="Your email address...">
                        <button class="btn btn-inno col-sm-5 b-t-l-0 b-b-l-0" style="border-top-right-radius: 10px; border-bottom-right-radius: 10px;">Start collaborating!</button>
                    </div>
                </div>
            </form>
            {{--<div class="row p-absolute" style="bottom: 30px; left: 520px">--}}
                {{--<div class="col-md-12 d-flex js-center">--}}
                    {{--<div class="circle m-r-0" style="width: 80px !important; height: 80px !important;">--}}
                        {{--<i style="font-size: 65px; color: #FF6100; margin-left: 8px" class="zmdi zmdi-chevron-down social-icon-home scrollHomeBtn arrow"></i>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
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
                                        <p class="instructions-text m-0 allign-center f-17">Create an <a class="regular-link" href="/login">account</a> with your expertise(s)</p>
                                    @elsetablet
                                        <p class="instructions-text m-0 allign-center f-20">Create an <a class="regular-link" href="/login">account</a> with your expertise(s)</p>
                                    @endmobile
                                @elsedesktop
                                    <p class="instructions-text m-0 allign-center f-22">Create an <a class="regular-link" href="/login">account</a> with your expertise(s)</p>
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
                                            <p class="instructions-second-text m-0 f-15">Experience other people their ideas. And discuss ideas in the <a class="regular-link" href="/forum">forum</a></p>
                                        @elsetablet
                                            <p class="instructions-second-text m-0 f-20">Experience other people their ideas. And discuss ideas in the <a class="regular-link" href="/forum">forum</a></p>
                                        @endmobile
                                    @elsedesktop
                                        <p class="instructions-second-text m-0 f-22">Experience other people their ideas. And discuss ideas in the <a class="regular-link" href="/forum">forum</a></p>
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
                        <a href="/login?register=1" class="btn btn-inno">Start now!</a>
                    </div>
                </div>
            </div>
            <div class="instructions" style="border-bottom: 1px solid #FF6100">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center m-t-20">
                            <h1 class="sub-title col-sm-12">Start networking</h1>
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
                                <p class="instructions-text f-19 m-0 p-b-10">Instantly create a team and start working with like-minded and motivated people!</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Network and chat easliy with all users of Innocreation</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Find your ideal team and disucuss ideas/passions</p>
                            </li>
                            <li class="instructions-list-item">
                                <p class="instructions-text f-19 m-0 p-b-10">Get to know other like-minded people!</p>
                            </li>
                        </ul>
                    </div>
                    <div class="row d-flex js-center" style="margin-bottom: 50px !important">
                        <a href="/collaborate" class="btn btn-inno">Start networking!</a>
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