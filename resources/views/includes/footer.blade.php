@section("footer")
    <script src="/js/home/general.js"></script>
    <footer>
        <div class="row col-sm-12">
            <div class="col-md-4 m-t-10">
                <div class="row">
                    <div class="col-sm-10">
                        <div class="footer-title text-center">
                            @handheld
                                @tablet
                                    <h1 class="title f-22" style="color: #C9CCCF">In<img class="cartwheelLogo" src="/images/cartwheel.png" alt="">creation</h1>
                                    <a class="td-none" style="width: 80% !important" href="/login?register=1"><p class="instructions-text create-account f-16">Create your account</p></a>
                                @elsemobile
                                    <h1 class="title f-40" style="color: #C9CCCF">In<img class="cartwheelLogo" src="/images/cartwheel.png" alt="">creation</h1>
                                    <a class="td-none" style="width: 80% !important" href="/login?register=1"><p class="instructions-text create-account">Create your account</p></a>
                                @endtablet
                            @elsedesktop
                                <h1 class="title" style="color: #C9CCCF">Inn<img class="cartwheelLogo" src="/images/cartwheel.png" alt="">creation</h1>
                                <a class="td-none" style="width: 80% !important" href="/login?register=1"><p class="instructions-text create-account" style="width: 75%; margin-left: 12%;">Create your account</p></a>
                            @endhandheld
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 p-t-20 p-b-20">
                <div class="row d-flex js-center">
                    <div class="col-sm-4 ">
                        <div class="d-flex">
                            <div class="d-flex list-links">
                                <p class="regular-link td-none m-0">Find us on:</p>
                                <a class="regular-link c-gray" href="">Facebook</a>
                                <a class="regular-link c-gray" href="">Instagram</a>
                                <a class="regular-link c-gray" href="">Twitter</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d-flex">
                            <div class="d-flex list-links">
                                <p class="regular-link td-none m-0">General info:</p>
                                <a class="regular-link c-gray" href="/contact-us">Contact</a>
                                <a class="regular-link c-gray" href="/faq">FAQ</a>
                                <a class="regular-link c-gray" href="">Terms of agreement</a>
                                <? if(\Illuminate\Support\Facades\Session::has("user_id")) { ?>
                                <a class="regular-link c-gray" href="/platform-idea">Idea? Let us know!</a>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d-flex">
                            <div class="d-flex list-links">
                                <p class="regular-link td-none m-0">The platform:</p>
                                <a class="regular-link c-gray" href="/page/what-is-innocreation">What is Innocreation?</a>
                                {{--<a class="regular-link c-gray" href="">People behind Innocreation</a>--}}
                                <a class="regular-link c-gray" href="/pricing">Pricing</a>
                                <a class="regular-link c-gray" href="/page/our-motivation">Our motivation</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>