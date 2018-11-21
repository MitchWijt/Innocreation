<header class="headerShow no-select">
        @handheld
            <div class="p-t-10 container">
        @elsedesktop
            <div class="p-t-5 container-fluid">
        @endhandheld
        <div class="row">
            <div class="col-md-6 m-t-5 p-l-30 p-t-20">
                <div class="row">
                    <div class="col-sm-1">
                        <a class="td-none" href="/">
                            @handheld
                            @tablet
                                <img class="cartwheelLogo-tablet" src="/images/cartwheel.png" alt="">
                            @elsemobile
                                <img class="cartwheelLogo" src="/images/cartwheel.png" alt="">
                            @endtablet
                            @elsedesktop
                                <img class="cartwheelLogo" src="/images/cartwheel.png" alt="">
                            @endhandheld
                        </a>
                    </div>
                    <div class="col-sm-11 m-b-20">
                        <div class="row">
                            <div class="col-sm-1 p-r-0">
                                <div class="input-fat-home b-l-0 b-t-r-0 b-b-r-0 c-pointer no-select">
                                    <i class="zmdi zmdi-search c-black f-30 col-sm-12 m-t-5 searchBtn no-select"></i>
                                </div>
                            </div>
                            <div class="col-sm-11 p-l-0 expertisesHeader">
                                <input type="search" id="tagsHeader" placeholder="What expertise or knowledge do you need?" class="input-fat-home col-sm-12 b-t-l-0 b-b-l-0 b-0 no-focus">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @mobile
                <div class="col-md-6">
                    <div class="d-flex jc-end m-t-20">
                        <div class="text-left col-sm-10">
                            <? if(\Illuminate\Support\Facades\Session::has("user_name")) { ?>
                            <? $user = \App\User::select("*")->where("id", \Illuminate\Support\Facades\Session::get("user_id"))->first();
                            if($user->team_id != null){
                                $team_id = $user->team_id;
                                $userJoinRequests = \App\JoinRequestLinktable::select("*")->where("team_id", $team_id)->where("accepted", 0)->get();
                                $teamJoinRequestsCounter = count($userJoinRequests);
                            }
                            ?>

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
                                    <a class="regular-link" href="/my-team"><p id="teamLink" class="m-b-0">My team <? if($teamJoinRequestsCounter > 0) echo "<i class='zmdi zmdi-circle c-orange f-9'></i>"?></p></a>
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
                <? if(\Illuminate\Support\Facades\Session::has("user_name")) { ?>
                    <div class="col-md-6 p-0">
                        @tablet
                            <div class="d-flex jc-end">
                        @elsedesktop
                            <div class="m-t-20 pull-right m-r-30 c-gray">
                        @endtablet
                            <a class="btn btn-inno" href="/expertises">Collaborate</a>
                            <? if($user->team_id != null) { ?>
                                <a class="btn btn-inno" href="/my-team">Team</a>
                            <? } else { ?>
                                <a class="btn btn-inno" href="/my-account/teamInfo">Create team</a>
                            <? } ?>
                            <a class="btn btn-inno" href="/innocreatives">Share</a>
                            <i class="popoverHeader zmdi zmdi-chevron-down c-gray f-25 m-l-15 m-t-5 c-pointer" data-toggle="popover" data-content='<?= view("/public/shared/_popoverHeaderMenu")?>'></i>
                            <div class="pull-right">
                                <a href="/my-account">
                                    <div class="avatar-header img m-t-0 p-t-0 m-l-15" style="background: url('<?= $user->getProfilePicture()?>')"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                <? } else { ?>
                    <div class="col-md-6 p-0">
                        @tablet
                            <div class="d-flex jc-end">
                        @elsedesktop
                            <div class="m-t-20 pull-right m-r-30 c-gray">
                        @endtablet
                            <a class="btn btn-inno btn-sm m-r-5" href="/expertises">Users</a>
                            <a class="btn btn-inno btn-sm" href="/innocreatives">Feed</a>
                            <i class="popoverHeader zmdi zmdi-chevron-down c-gray f-20 m-l-15 m-t-5 c-pointer" data-toggle="popover" data-content='<?= view("/public/shared/_popoverHeaderMenu")?>'></i>
                            <span class="btn-seperator m-l-15 m-r-10"></span>
                            <a class="td-none m-l-10 m-r-10" href="/login"><span class="c-gray">Login</span></a>
                            <a class="btn btn-inno btn-success" href="/create-my-account">Join for free</a>
                        </div>
                    </div>
                <? } ?>
            @endmobile
        </div>
    </div>
    @mobile
        <div class="lower-header d-flex js-center">
            <ul class="main-navMenu-mobile p-t-10 p-b-10 hidden">
                <li><a href="/">Home</a></li>
                <li><a href="/teams">Teams</a></li>
                <li><a href="/expertises">Users / expertises</a></li>
                <li><a href=/what-is-innocreation">About us</a></li>
                {{--<li><a href="">Shop</a></li>--}}
                <li><a href="/pricing">Pricing</a></li>
                <li><a id="last-child" href="/innocreatives">Innocreatives</a></li>
                {{--<li><a href="/forum" id="last-child">Forum</a></li>--}}
                {{--<li><a id="last-child" class="hidden" href="">Crowd funding</a></li>--}}
            </ul>
        </div>
        <div class="border-black navBorder"></div>
    @elsedesktop

    @endmobile
    </div>
</header>
<? $expertises = \App\Expertises::select("*")->get();?>
<script>
    $( function() {
        var availableTags = [
            <? foreach($expertises as $tag) { ?>
                "<?=$tag->title?>",
            <? } ?>
        ];
        $( "#tagsHeader" ).autocomplete({
            source: availableTags
        });
    } );
    $("#tagsHeader").on("keyup", function () {
        $(".ui-menu").appendTo(".expertisesHeader");
    });
    $(document).ready(function () {
        $(".ui-menu").addClass("ui-menu-home");
    });
</script>