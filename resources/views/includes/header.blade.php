@section("header")
<header class="headerShow">
    <div class="header">
        <a class="td-none" href="/">
        <div class="main-title">
            <h1 class="title" style="color: #C9CCCF">Inn<img class="cartwheelLogo" src="/images/cartwheel.png" alt="">creation</h1>
            <p class="slogan">Help each other make <span id="dreams">Dreams</span> become a reality</p>
        </div>
        </a>
        <div class="social-media-header">
            <div class="circle">
                <a href="">
                <i style="font-size: 20px;" class="zmdi zmdi-facebook social-icon"></i>
                </a>
            </div>
            <div class="circle">
                <a href="">
                <i style="font-size: 20px;" class="zmdi zmdi-twitter social-icon"></i>
                </a>
            </div>
            <div class="circle">
                <a href="">
                <i style="font-size: 20px;" class="zmdi zmdi-instagram social-icon"></i>
                </a>
            </div>
        </div>
        <div class="loginRegister">
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
                    <a class="regular-link c-gray" href="/login">Login / Register</a>
                <? } ?>
            </div>
        </div>
    </div>
    <div class="lower-header">
        <ul class="main-navMenu">
            <li><a href="/">Home</a></li>
            <li><a href="/teams">Teams</a></li>
            <li><a href="">Roles</a></li>
            <li><a href="">About us</a></li>
            {{--<li><a href="">Shop</a></li>--}}
            <li><a href="">Pricing</a></li>
            <li><a href="/forum">Forum</a></li>
            <li><a id="last-child" href="">Crowd funding</a></li>
        </ul>
    </div>
</header>