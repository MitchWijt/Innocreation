@section("header")
<header class="headerShow">
    <div class="p-t-10 m-b-10">
        <div class="row col-sm-12">
            <div class="col-md-4 m-t-15">
                <a class="td-none" href="/">
                    <div class="main-title">
                        <h1 class="title c-gray">Inn<img class="cartwheelLogo" src="/images/cartwheel.png" alt="">creation</h1>
                        <p class="slogan">Help each other make <span id="dreams">Dreams</span> become a reality</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4 m-t-50 p-0">
                <div class="d-flex js-center">
                    <div class="d-flex fd-row">
                        <div class="circle m-l-10 m-r-10" style="width: 40px !important; height: 40px !important">
                            <a href="">
                                <i style="font-size: 20px;" class="zmdi zmdi-facebook social-icon c-orange"></i>
                            </a>
                        </div>
                        <div class="circle m-l-10 m-r-10" style="width: 40px !important; height: 40px !important">
                            <a href="">
                                <i style="font-size: 20px;" class="zmdi zmdi-twitter social-icon c-orange"></i>
                            </a>
                        </div>
                        <div class="circle m-l-10 m-r-10" style="width: 40px !important; height: 40px !important">
                            <a href="">
                                <i style="font-size: 20px;" class="zmdi zmdi-instagram social-icon c-orange"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 p-0">
                <div class="d-flex jc-end m-t-20">
                    <div class="text-left col-sm-4">
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
                </div>
            </div>
        </div>
    </div>
    <div class="lower-header">
        @mobile
            <ul class="main-navMenu">
                <li><a href="/">Home</a></li>
                <li><a href="/teams">Teams</a></li>
                <li><a href="/expertises">Users / expertises</a></li>
                <li><a href="/page/what-is-innocreation">About us</a></li>
                <li><a href="">Shop</a></li>
                <li><a href="/pricing">Pricing</a></li>
                <li><a href="/forum" id="last-child">Forum</a></li>
                <li><a id="last-child" class="hidden" href="">Crowd funding</a></li>
            </ul>
        @elsedesktop
            <ul class="main-navMenu">
                <li><a href="/">Home</a></li>
                <li><a href="/teams">Teams</a></li>
                <li><a href="/expertises">Users / expertises</a></li>
                <li><a href="/page/what-is-innocreation">About us</a></li>
                <li><a href="">Shop</a></li>
                <li><a href="/pricing">Pricing</a></li>
                <li><a href="/forum" id="last-child">Forum</a></li>
                <li><a id="last-child" class="hidden" href="">Crowd funding</a></li>
            </ul>
        @endmobile
    </div>
</header>