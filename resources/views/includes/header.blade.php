<header class="headerShow no-select">
        @handheld
            <div class="p-t-10 container">
        @elsedesktop
            <div class="p-t-5 container-fluid">
        @endhandheld
        <div class="row desktopNav">
            <div class="col-sm-12">
                <div class="pull-left d-flex m-t-20">
                    <div class="logoDiv">
                        <a class="td-none" href="/">
                            <img class="cartwheelLogo m-r-10" src="/images/cartwheel.png" alt="" style="width: 50px !important; height: 50px !important;">
                        </a>
                    </div>
                    <div class="m-b-20 m-t-5 searchBarBox" style="min-width: 100px !important">
                        <div class="input-group mb-3 expertisesHeader no-focus">
                            <div class="input-group-prepend no-focus">
                                <span class="input-group-text no-focus c-pointer" id="basic-addon1"><i class="zmdi zmdi-search f-20"></i></span>
                            </div>
                            <input style="outline: none !important; -webkit-appearance:none !important; width: 30vw !important" type="search" id="tagsHeader" class="form-control no-focus form-control-inno tagsHeader" placeholder="What expertise or knowledge do you need?" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>
                <div class="pull-right navBtns ">
                    <div class="pull-right">
                        <? if(\Illuminate\Support\Facades\Session::has("user_name")) { ?>
                                <div class="m-t-20 pull-right m-r-30 c-gray">
                                        <a class="btn btn-inno" href="/expertises">Collaborate</a>
                                    <? if($user->team_id != null) { ?>
                                        <a class="btn btn-inno" href="/my-team">Team</a>
                                    <? } else { ?>
                                        <a class="btn btn-inno" href="/my-account/teamInfo">Create team</a>
                                    <? } ?>
                                    <a class="btn btn-inno" href="/innocreatives">Share</a>
                                    <i class="popoverHeader zmdi zmdi-chevron-down c-gray f-25 m-l-15 m-t-5 c-pointer moreChev" data-toggle="popover" data-content='<?= view("/public/shared/_popoverHeaderMenu")?>'></i>
                                    <div class="pull-right">
                                        <a href="/my-account">
                                            <div class="avatar-header img m-t-0 p-t-0 m-l-15" style="background: url('<?= $user->getProfilePicture()?>')"></div>
                                        </a>
                                    </div>
                                </div>
                            <? } else { ?>
                            <div class="m-t-20 pull-right m-r-30 c-gray" style="width: 100%">
                                <a class="btn btn-inno btn-sm m-r-5 usersHeader" href="/expertises">Users</a>
                                <a class="btn btn-inno btn-sm feedHeader" href="/innocreatives">Feed</a>
                                <i class="popoverHeader zmdi zmdi-chevron-down c-gray f-20 m-l-15 m-t-5 c-pointer moreChev" data-toggle="popover" data-content='<?= view("/public/shared/_popoverHeaderMenu")?>'></i>
                                <span class="btn-seperator m-l-15 m-r-10"></span>
                                <a class="td-none m-l-10 m-r-10 loginBtn" href="/login"><span class="c-gray">Login</span></a>
                                <a class="btn btn-inno btn-success joinBtn" href="/create-my-account">Join for free</a>
                            </div>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <? if(!\Illuminate\Support\Facades\Session::has("user_name")) { ?>
                <div class="row m-t-20 navMobile">
                    <div class="col-3 text-center">
                        <a href="/">
                            <img class="cartwheelLogo" src="/images/cartwheel.png" alt="" style="width: 30px !important; height: 30px !important;">
                        </a>
                    </div>
                    <div class="col-3 text-center">
                        <i class="zmdi zmdi-search searchBtnHomeMobile c-gray f-30"></i>
                    </div>
                    <div class="col-3 text-center">
                        <a href="/innocreatives">
                            <i class="zmdi zmdi-share c-gray f-30"></i>
                        </a>
                    </div>
                    <div class="col-3 text-center">
                        <a href="/expertises">
                            <i class="zmdi zmdi-accounts-alt c-gray f-30"></i>
                        </a>
                    </div>
                </div>
                    <div class="m-b-20 m-t-5 searchBarBox hidden p-15 expertisesHeader" style="min-width: 100px !important;">
                        <div class="input-group mb-3 no-focus">
                            <div class="input-group-prepend no-focus">
                                <span class="input-group-text no-focus c-pointer" id="basic-addon1"><i class="zmdi zmdi-search f-20"></i></span>
                            </div>
                            <input style="outline: none !important; -webkit-appearance:none !important; width: 30vw !important" type="search" id="tagsHeader" class="form-control no-focus form-control-inno tagsHeader" placeholder="What expertise or knowledge do you need?" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>
                <div class="row m-t-20 p-r-10 p-b-15 registerBtnsMobile" style="display: none;">
                    <div class="col-6">
                        <a class="btn btn-normal td-none m-l-10 m-r-10 loginBtn btn-block" href="/login"><span class="c-gray">Login</span></a>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-inno btn-success joinBtn btn-block" href="/create-my-account">Join for free</a>
                    </div>
                </div>
            <? } else { ?>
                <div class="row m-t-20 navMobile m-r-0 m-l-0">
                    <div class="col-3 text-center">
                        <a href="/">
                            <img class="cartwheelLogo" src="/images/cartwheel.png" alt="" style="width: 30px !important; height: 30px !important;">
                        </a>
                    </div>
                    <div class="col-3 text-center">
                        <i class="zmdi zmdi-search searchBtnHomeMobile c-gray f-30"></i>
                    </div>
                    <div class="col-3 text-center">
                        <a href="/innocreatives">
                            <i class="zmdi zmdi-share c-gray f-30"></i>
                        </a>
                    </div>
                    <div class="col-3 text-center">
                        <i class="popoverHeader zmdi zmdi-chevron-down c-gray f-20 c-pointer m-t-10" data-toggle="popover" data-content='<?= view("/public/shared/_popoverHeaderMenu")?>'></i>
                        <a href="/my-account">
                            <div class="avatar-header img m-t-0 p-t-0 m-l-15" style="background: url('<?= $user->getProfilePicture()?>')"></div>
                        </a>
                    </div>
                </div>
            <? } ?>
        </div>
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
        $( ".tagsHeader" ).autocomplete({
            source: availableTags
        });
    } );
    $(".tagsHeader").on("keyup", function () {
        $(".ui-menu").appendTo(".expertisesHeader");
    });
    $(document).ready(function () {
        $(".ui-menu").addClass("ui-menu-home");
    });
</script>