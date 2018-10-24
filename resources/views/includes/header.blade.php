<header class="headerShow">
        @handheld
            <div class="p-t-10 container">
        @elsedesktop
            <div class="p-t-5 container-fluid">
        @endhandheld
        <div class="row">
            <div class="col-md-4 m-t-5 p-0">
                <a class="td-none" href="/">
                    @handheld
                        @tablet
                            <div class="main-title">
                                <h1 class="title c-gray f-31">Inn<img class="cartwheelLogo-tablet" src="/images/cartwheel.png" alt="">creation</h1>
                                <p class="slogan f-9">Help each other make <span id="dreams">Dreams</span> become a reality</p>
                            </div>
                        @elsemobile
                            <div class="main-title">
                                <h1 class="title c-gray f-40">Inn<img class="cartwheelLogo" src="/images/cartwheel.png" alt="">creation</h1>
                                <p class="slogan f-12">Help each other make <span id="dreams">Dreams</span> become a reality</p>
                            </div>
                        @endtablet
                    @elsedesktop
                        <div class="main-title">
                            <h1 class="title c-gray">Inn<img class="cartwheelLogo" src="/images/cartwheel.png" alt="">creation</h1>
                            <p class="slogan">Help each other make <span id="dreams">Dreams</span> become a reality</p>
                        </div>
                    @endhandheld
                </a>
            </div>
            @desktop
                <div class="col-md-4 m-t-35 p-0">
            @elsemobile
                <div class="col-md-4 m-t-10 p-0">
            @enddesktop
                <div class="d-flex js-center">
                    <div class="d-flex fd-row">
                        <div class="circle m-l-10 m-r-10" style="width: 40px !important; height: 40px !important">
                            <a href="https://www.facebook.com/innocreationOfficial/">
                                <i style="font-size: 20px;" class="zmdi zmdi-facebook social-icon c-orange"></i>
                            </a>
                        </div>
                        <div class="circle m-l-10 m-r-10" style="width: 40px !important; height: 40px !important">
                            <a href="https://twitter.com/Innocreation_">
                                <i style="font-size: 20px;" class="zmdi zmdi-twitter social-icon c-orange"></i>
                            </a>
                        </div>
                        <div class="circle m-l-10 m-r-10" style="width: 40px !important; height: 40px !important">
                            <a href="https://www.instagram.com/innocreation_/">
                                <i style="font-size: 20px;" class="zmdi zmdi-instagram social-icon c-orange"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @mobile
                <div class="col-md-6">
                    <div class="d-flex jc-end m-t-20">
                        <div class="text-left col-sm-10">
                            <? if(\Illuminate\Support\Facades\Session::has("user_name")) { ?>
                            <? $user = \App\User::select("*")->where("id", \Illuminate\Support\Facades\Session::get("user_id"))->first();?>
                            <? if(\Illuminate\Support\Facades\Session::get("user_role") == 1) { ?>
                            <div class="admin">
                                <a class="regular-link c-gray" href="/admin/statistics">Admin panel</a>
                            </div>
                            <? } ?>
                            <? } ?>
                            <div class="accounts">
                                <? if(\Illuminate\Support\Facades\Session::has("user_name")) { ?>
                                <a class="regular-link c-gray m-b-5" href="/account">My account</a>
                                <? } ?>
                                <? if(\Illuminate\Support\Facades\Session::has("team_id")) { ?>
                                <a class="regular-link" href="/my-team"><p id="teamLink" class="m-b-0">My team</p></a>
                                <? } ?>
                            </div>
                            <div class="login">
                                <? if(\Illuminate\Support\Facades\Session::has("user_name")) { ?>
                                <a class="regular-link c-gray" href="/logout">Logout</a>
                                <? } else { ?>
                                <a class="regular-link c-gray m-t-35" href="/login">Login / Register</a>
                                <? } ?>
                            </div>
                        </div>
                        <div class="col-sm-2 m-b-10">
                            <i class="zmdi zmdi-menu pull-right f-25 c-orange toggleNavMenu"></i>
                        </div>
                    </div>
                </div>
            @elsedesktop
                <div class="col-md-4 p-0">
                    @tablet
                        <div class="d-flex jc-end">
                    @elsedesktop
                        <div class="d-flex jc-end m-t-10">
                    @endtablet
                        <div class="text-left col-sm-12 p-r-0 text-center ">
                            <? if(\Illuminate\Support\Facades\Session::has("user_name")) { ?>
                            <? $user = \App\User::select("*")->where("id", \Illuminate\Support\Facades\Session::get("user_id"))->first();?>
                            <? if(\Illuminate\Support\Facades\Session::get("user_role") == 1) { ?>
                            <div class="admin">
                                <a class="regular-link c-gray" href="/admin/statistics">Admin panel</a>
                            </div>
                            <? } ?>
                            <? } ?>
                            <div class="accounts text-center ">
                                <? if(\Illuminate\Support\Facades\Session::has("user_name")) { ?>
                                    <a class="regular-link c-gray m-b-5" href="/account">My account</a>
                                <? } ?>
                                <? if(\Illuminate\Support\Facades\Session::has("team_id")) { ?>
                                    <a class="regular-link" href="/my-team"><p id="teamLink" class="m-b-0">My team</p></a>
                                <? } ?>
                            </div>
                            <div class="login text-center">
                                <? if(\Illuminate\Support\Facades\Session::has("user_name")) { ?>
                                        <a class="regular-link c-gray" href="/logout">Logout</a>
                                <? } else { ?>
                                    @tablet
                                        <div class="m-t-15">
                                            <a class="regular-link c-gray" href="/login">Login / Register</a>
                                        </div>
                                    @elsedesktop
                                        <div class="m-t-30">
                                            <a class="regular-link c-gray " href="/login">Login / Register</a>
                                        </div>
                                    @endtablet
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            @endmobile
        </div>
    </div>
    @mobile
        <div class="lower-header d-flex js-center">
            <ul class="main-navMenu-mobile p-t-10 p-b-10 hidden">
                <li><a href="/">Home</a></li>
                <li><a href="/teams">Teams</a></li>
                <li><a href="/expertises">Users / expertises</a></li>
                <li><a href="/page/what-is-innocreation">About us</a></li>
                {{--<li><a href="">Shop</a></li>--}}
                <li><a href="/pricing">Pricing</a></li>
                <li><a href="/innocreatives">Innocreatives</a></li>
                <li><a href="/forum" id="last-child">Forum</a></li>
                {{--<li><a id="last-child" class="hidden" href="">Crowd funding</a></li>--}}
            </ul>
        </div>
        <div class="border-black navBorder"></div>
    @elsedesktop
        <div class="lower-header d-flex js-center">
            <ul class="main-navMenu @tablet f-13 @endtablet">
                <li><a href="/">Home</a></li>
                <li><a href="/teams">Teams</a></li>
                <li><a href="/page/what-is-innocreation">About us</a></li>
                <li><a href="/innocreatives">Innocreatives</a></li>
                {{--<li><a href="">Shop</a></li>--}}
                <li><a href="/pricing">Pricing</a></li>
                <li><a href="/expertises">Users / expertises</a></li>
                <li><a href="/forum" id="last-child">Forum</a></li>

                {{--<li><a id="last-child" class="hidden" href="">Crowd funding</a></li>--}}
            </ul>
        </div>
        <div class="border-black navBorder"></div>
    @endmobile
    </div>
</header>