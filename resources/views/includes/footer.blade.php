 <footer>
        <div class="row col-sm-12">
            <div class="col-md-4 m-t-10">
                <div class="row">
                    <div class="col-sm-10">
                        <div class="footer-title text-center">
                            @handheld
                                @tablet
                                    <h1 class="title f-22 textFooter" style="color: #C9CCCF">Inn<img class="cartwheelLogo" src="/images/cartwheel.png" alt="">creation</h1>
                                    <div class="d-flex js-center">
                                        <a class="td-none" href="/create-my-account"><p class="instructions-text create-account f-16" style="padding-left: 10px; padding-right: 10px;">Create your account</p></a>
                                    </div>
                                @elsemobile
                                    <h1 class="title f-40 textFooter" style="color: #C9CCCF">Inn<img class="cartwheelLogo" src="/images/cartwheel.png" alt="">creation</h1>
                                    <div class="d-flex js-center">
                                        <a class="td-none" href="/create-my-account"><p class="instructions-text create-account f-20" style="padding-left: 10px; padding-right: 10px;">Create your account</p></a>
                                    </div>
                                @endtablet
                            @elsedesktop
                                <h1 class="title textFooter" style="color: #C9CCCF">Inn<img class="cartwheelLogo" src="/images/cartwheel.png" alt="">creation</h1>
                                <div class="d-flex js-center">
                                    <a class="td-none" href="/create-my-account"><p class="instructions-text create-account" style="padding-left: 10px; padding-right: 10px;">Create your account</p></a>
                                </div>
                            @endhandheld
                        </div>
                    </div>
                </div>
            </div>
            @mobile
                <div class="col-md-8 p-t-20 p-b-20 m-l-30">
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
                <div class="col-md-8 m-l-30">
                    <div class="row p-b-20">
                        <div class="col-12">
                            <div class="d-flex">
                                <div class="d-flex list-links">
                                    <p class="regular-link td-none m-0">The platform:</p>
                                    <a class="regular-link c-gray" href="/page/what-is-innocreation">What is Innocreation?</a>
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
                <div class="col-md-8 p-t-20 p-b-20">
                    <div class="row d-flex js-center">
                        <div class="@mobile col-4 @elsedesktop col-sm-4 @endmobile">
                            <div class="d-flex">
                                <div class="d-flex list-links">
                                    <p class="regular-link td-none m-0">Find us on:</p>
                                    <a class="regular-link c-gray" href="">Facebook</a>
                                    <a class="regular-link c-gray" href="">Instagram</a>
                                    <a class="regular-link c-gray" href="">Twitter</a>
                                </div>
                            </div>
                        </div>
                        <div class="@mobile col-4 @elsedesktop col-sm-4 @endmobile">
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
                        <div class="@mobile col-4 @elsedesktop col-sm-4 @endmobile">
                            <div class="d-flex">
                                <div class="d-flex list-links">
                                    <p class="regular-link td-none m-0">The platform:</p>
                                    <a class="regular-link c-gray" href="/page/what-is-innocreation">What is Innocreation?</a>
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
            @endmobile
        </div>
     <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/getstream/dist/js_min/getstream.js"></script>
     <script>
            <?
                if(\Illuminate\Support\Facades\Session::has("user_id")){
                    $user = \App\User::select("*")->where("id", \Illuminate\Support\Facades\Session::get("user_id"))->first();
                    $user->online_timestamp = date("Y-m-d H:i:s");
                    $user->active_status = "online";
                    $user->save(); ?>
                <? }
            ?>

            <? if(\Illuminate\Support\Facades\Session::has("user_id")) { ?>
                <? $user_id = \Illuminate\Support\Facades\Session::get("user_id")?>
                <? $user = \App\User::select("*")->where("id", $user_id)->first();?>
            var client = stream.connect('ujpcaxtcmvav', null, '40873');
            var user1 = client.feed('user', '<?= $user_id?>', '<?= $user->stream_token?>');

            function callback(data) {
                $(".notificationIdicator").removeClass("hidden");
            }

            function successCallback() {
            }

            function failCallback(data) {
                alert('something went wrong, check the console logs');
            }
            user1.subscribe(callback).then(successCallback, failCallback);
            <? } ?>
        </script>
    </footer>
