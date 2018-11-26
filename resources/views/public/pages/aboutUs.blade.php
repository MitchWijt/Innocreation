@extends('layouts.app')
@section('content')
<div class="d-flex grey-background">
    <div class="container">
        <div class="sub-title-container p-t-20">
            <h1 class="sub-title-black @mobile f-25 @endmobile">Welcome</h1>
        </div>
        <hr class="m-b-0">
        <div class="card m-t-20 m-b-20 col-sm-12">
            <div class="card-block m-t-10">
                <div class="col-sm-12 c-gray">
                    <p>Welcome to Innocreation! We are excited for you and your ideas and hope you can come far with your innovative idea and/or product!. But what actually is Innocreation and what do we provide?</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="instructions">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center m-t-20">
                <h1 id="scrollToHome" class="sub-title col-sm-12">How it works</h1>
            </div>
        </div>
        <div class="hr col-md-8"></div>
        <div class="row">
            <div class="@mobile col-2 m-t-15 @elsedesktop col-sm-2 d-flex jc-end @endmobile">
                <div class="@mobile circle-instructions-mobile @elsedesktop circle-instructions @endmobile">
                    <i style="color: #C9CCCF; padding-left: 1px;" class="zmdi zmdi-accounts-outline @mobile f-30 social-icon-instructions-mobile @elsedesktop f-50  social-icon-instructions @endmobile"></i>
                </div>
            </div>
            <div class="@mobile col-10 @elsedesktop col-sm-10 @endmobile m-t-15">
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
                        <p class="instructions-second-text m-b-0 m-t-15 f-17">Post your project/story on the inno  <a class="regular-link" href="/innocreatives">feed</a></p>
                        @elsetablet
                        <p class="instructions-second-text m-b-0 m-r-20 m-t-15 f-20">Post your project/story on the inno  <a class="regular-link" href="/innocreatives">feed</a></p>
                        @endmobile
                        @elsedesktop
                        <p class="instructions-second-text m-b-0 m-r-20 m-t-15 f-22">Post your project/story on the inno  <a class="regular-link" href="/innocreatives">feed</a></p>
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
@endsection