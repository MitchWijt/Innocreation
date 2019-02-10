 <footer>
        <div class="">
            <div class="col-sm-12 p-r-0">
                <div class="footer-title p-t-20">
                    @handheld
                        @tablet
                            <h1 class="title f-22 textFooter" style="color: #C9CCCF">Inn<img style="width: 30px; height: 30px;" src="/images/cartwheel.png" alt="">creation</h1>
                        @elsemobile
                            <h1 class="title f-40 textFooter text-center p-t-20" style="color: #C9CCCF">Inn<img style="width: 30px; height: 30px;" class="" src="/images/cartwheel.png" alt="">creation</h1>
                        @endtablet
                    @elsedesktop
                        <div class="col-sm-12 p-l-30">
                            <p class="textFooter m-b-5" style="color: #C9CCCF; font-size: 33px">Inn<img style="width: 30px; height: 30px;" src="/images/cartwheel.png" alt="">creation</p>
                        </div>
                    @endhandheld
                </div>
            @mobile
                <div class="col-md-8 p-t-20 p-b-20">
                    <div class="row d-flex js-center">
                        <div class="col-6">
                            <div class="d-flex">
                                <div class="d-flex list-links">
                                    <p class="regular-link td-none m-0">Find us on:</p>
                                    <a class="regular-link c-gray" href="">Facebook</a>
                                    <a class="regular-link c-gray" href="">Instagram</a>
                                    <a class="regular-link c-gray" href="">Twitter</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex">
                                <div class="d-flex list-links">
                                    <p class="regular-link td-none m-0">General info:</p>
                                    <a class="regular-link c-gray" href="/contact-us">Contact</a>
                                    <a class="regular-link c-gray" href="/faq">FAQ</a>
                                    <? if(\Illuminate\Support\Facades\Session::has("user_id")) { ?>
                                    <a class="regular-link c-gray" href="/platform-idea">Idea? Let us know!</a>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row p-b-20">
                        <div class="col-12">
                            <div class="d-flex">
                                <div class="d-flex list-links">
                                    <p class="regular-link td-none m-0">The platform:</p>
                                    <a class="regular-link c-gray" href="/what-is-innocreation">What is Innocreation?</a>
                                    {{--<a class="regular-link c-gray" href="">People behind Innocreation</a>--}}
                                    <a class="regular-link c-gray" href="/pricing">Pricing</a>
                                    <a class="regular-link c-gray" href="/page/our-motivation">Our motivation</a>
                                    <a class="regular-link c-gray" href="/page/terms-of-service">Terms of service</a>
                                    <a class="regular-link c-gray" href="/page/privacy-policy">Privacy policy</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elsedesktop
                <div class="row">
                    <div class="@mobile col-4 @elsedesktop col-sm-4 @endmobile">
                        <div class="d-flex p-l-30">
                            <div class="d-flex list-links">
                                <p class="regular-link td-none m-0">Find us on:</p>
                                <a class="regular-link c-gray" href="">Facebook</a>
                                <a class="regular-link c-gray" href="">Instagram</a>
                                <a class="regular-link c-gray" href="">Twitter</a>
                            </div>
                        </div>
                    </div>
                    <div class="@mobile col-4 @elsedesktop col-sm-4 @endmobile">
                        <div class="d-flex js-center">
                            <div class="d-flex list-links">
                                <p class="regular-link td-none m-0">General info:</p>
                                <a class="regular-link c-gray" href="/contact-us">Contact</a>
                                <a class="regular-link c-gray" href="/faq">FAQ</a>
                                <? if(\Illuminate\Support\Facades\Session::has("user_id")) { ?>
                                <a class="regular-link c-gray" href="/platform-idea">Idea? Let us know!</a>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                    <div class="@mobile col-4 @elsedesktop col-sm-4 p-b-20 @endmobile">
                        <div class="d-flex jc-end m-r-30">
                            <div class="d-flex list-links">
                                <p class="regular-link td-none m-0">The platform:</p>
                                <a class="regular-link c-gray" href="/what-is-innocreation">What is Innocreation?</a>
                                {{--<a class="regular-link c-gray" href="">People behind Innocreation</a>--}}
                                <a class="regular-link c-gray" href="/pricing">Pricing</a>
                                <a class="regular-link c-gray" href="/page/our-motivation">Our motivation</a>
                                <a class="regular-link c-gray" href="/page/terms-of-service">Terms of service</a>
                                <a class="regular-link c-gray" href="/page/privacy-policy">Privacy policy</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endmobile
            </div>
        </div>
     <?
     ?>
    </footer>
