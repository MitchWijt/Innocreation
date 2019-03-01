<div class="<?= \App\Services\UserAccount\UserAccount::getTheme();?>">
<footer>
        <div class="<?= \App\Services\UserAccount\UserAccount::getTheme();?>">
            <div class="col-sm-12 p-r-0">
                <div class="footer-title p-t-10">
                    @handheld
                        @tablet
                            <h1 class="title f-22 textFooter">Inn<img style="width: 30px; height: 30px;" src="/images/cartwheel.png" alt="">creation</h1>
                        @elsemobile
                            <h1 class="title f-40 textFooter text-center p-t-20">Inn<img style="width: 30px; height: 30px;" class="" src="/images/cartwheel.png" alt="">creation</h1>
                        @endtablet
                    @elsedesktop
                        <div class="col-sm-12 p-l-30">
                            <p class="textFooter m-b-5" style="font-size: 33px">Inn<img style="width: 30px; height: 30px;" src="/images/cartwheel.png" alt="">creation</p>
                        </div>
                    @endhandheld
                </div>
            @mobile
                <div class="col-md-8 p-t-20 p-b-20">
                    <div class="row d-flex js-center">
                        <div class="col-6">
                            <div class="d-flex">
                                <div class="d-flex list-links">
                                    <p class="td-none m-0 navTitle">Find us on:</p>
                                    <a class="td-none" href=""><span>Facebook</span></a>
                                    <a class="td-none" href=""><span>Instagram</span></a>
                                    <a class="td-none" href=""><span>Twitter</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex">
                                <div class="d-flex list-links">
                                    <p class="td-none m-0 navTitle">General info:</p>
                                    <a class="td-none" href="/contact-us"><span>Contact</span></a>
                                    <a class="td-none" href="/faq"><span>FAQ</span></a>
                                    <? if(\Illuminate\Support\Facades\Session::has("user_id")) { ?>
                                    <a class="td-none" href="/platform-idea"><span>Idea? Let us know!</span></a>
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
                                    <p class="td-none m-0 navTitle">The platform:</p>
                                    <a class="td-none" href="/what-is-innocreation"><span>What is Innocreation?</span></a>
                                    <a class="td-none" href="/page/terms-of-service"><span>Terms of service</span></a>
                                    <a class="td-none" href="/page/privacy-policy"><span>Privacy policy</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elsedesktop
                <div class="d-flex js-between">
                    <div class="@mobile col-4 @elsedesktop col-sm-4 @endmobile">
                        <div class="d-flex p-l-30">
                            <div class="d-flex list-links">
                                <p class="td-none m-0 navTitle">Find us on:</p>
                                <a class="td-none" href=""><span>Facebook</span></a>
                                <a class="td-none" href=""><span>Instagram</span></a>
                                <a class="td-none" href=""><span>Twitter</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="@mobile col-4 @elsedesktop col-sm-4 @endmobile">
                        <div class="d-flex js-center">
                            <div class="d-flex list-links">
                                <p class="td-none m-0 navTitle">General info:</p>
                                <a class="td-none" href="/contact-us"><span>Contact</span></a>
                                <a class="td-none" href="/faq"><span>FAQ</span></a>
                                <? if(\Illuminate\Support\Facades\Session::has("user_id")) { ?>
                                <a class="td-none" href="/platform-idea"><span>Idea? Let us know!</span></a>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                    <div class="@mobile col-4 @elsedesktop col-sm-4 p-b-20 p-r-0 @endmobile">
                        <div class="d-flex jc-end m-r-30">
                            <div class="d-flex list-links">
                                <p class="td-none m-0 navTitle">The platform:</p>
                                <a class="td-none" href="/what-is-innocreation"><span>What is Innocreation?</span></a>
                                <a class="td-none" href="/page/terms-of-service"><span>Terms of service</span></a>
                                <a class="td-none" href="/page/privacy-policy"><span>Privacy policy</span></a>
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
</div>
