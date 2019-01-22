<header class="headerShow no-select">
        @handheld
            <div class="p-t-10 container">
        @elsedesktop
            <div class="p-t-5 container-fluid">
        @endhandheld
        <div class="row desktopNav">
            <div class="col-sm-12">
                <div class="pull-left d-flex m-t-20 m-l-35">
                    <div class="logoDiv">
                        <a class="td-none" href="/">
                            <img class="cartwheelLogo m-r-10" src="/images/cartwheel.png" alt="" style="width: 50px !important; height: 50px !important;">
                        </a>
                    </div>
                    <div class="m-b-20 m-t-5 searchBarBox" style="min-width: 100px !important">
                        <div class="input-group mb-3 no-focus expertisesHeader">
                            <div class="input-group-prepend no-focus">
                                <span class="input-group-text no-focus c-pointer" id="basic-addon1"><i class="zmdi zmdi-search f-20"></i></span>
                            </div>
                            <input style="outline: none !important; -webkit-appearance:none !important; width: 30vw !important" type="search" id="tagsHeader" class="form-control no-focus form-control-inno" placeholder="What expertise or knowledge do you need?" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>
                <div class="pull-right navBtns">
                    <div class="pull-right">
                        <? if(\Illuminate\Support\Facades\Session::has("user_name")) { ?>
                                <div class="m-t-20 pull-right m-r-30 c-gray p-relative">
                                    <i class="@mobile popoverNotificationsMob @elsenotmobile popoverNotifications @endmobile zmdi zmdi-notifications c-gray f-25 c-pointer moreChev p-absolute" data-toggle="popover" data-content='<?= view("/public/shared/_popoverNotificationBox")?>' style="top: 23% !important; left: -32%"></i>
                                    <i class="zmdi zmdi-circle c-orange f-13 p-absolute z-index <? if($counterMessages < 1) echo "hidden";?> notificationIdicator" style="top: 22%; left: -18.5%;"></i>
                                    <i class="zmdi zmdi-comment-text f-20 c-pointer p-absolute popoverMessages" data-toggle="popover" data-content='<?= view("/public/shared/messagesHeaderBox/_popoverBox")?>' style="top: 30% !important; left: -22%"></i>
                                    <i class="zmdi zmdi-accounts-add f-20 c-pointer popoverRequests c-gray p-absolute" data-user-id="<?= $user->id?>" data-toggle="popover" data-content='<?= view("/public/shared/teamInvitesHeaderBox/_popoverBox")?>' style="top: 30% !important; left: -12%"></i>

                                    <a class="btn btn-inno btn-sm" href="/expertises">Collaborate</a>
                                    <? if($user->team_id != null) { ?>
                                        <a class="btn btn-inno btn-sm" href="/my-team">Team</a>
                                    <? } else { ?>
                                        <a class="btn btn-inno btn-sm" href="/my-account/teamInfo">Create team</a>
                                    <? } ?>
                                    <a class="btn btn-inno btn-sm" href="/innocreatives">Share</a>
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
                        <a href="/expertises">
                            <i class="zmdi zmdi-accounts-alt c-gray f-30"></i>
                        </a>
                    </div>
                </div>
                <div class="m-b-20 m-t-5 searchBarBox hidden p-15" id="expertisesHeaderMob" style="min-width: 100px !important;">
                    <i class="zmdi zmdi-long-arrow-left c-orange f-22 pull-right m-r-5 closeSearchBar"></i>
                    <div class="input-group mb-3 no-focus">
                        <div class="input-group-prepend no-focus">
                            <span class="input-group-text no-focus c-pointer" id="basic-addon1"><i class="zmdi zmdi-search f-20"></i></span>
                        </div>
                        <input style="outline: none !important; -webkit-appearance:none !important; width: 30vw !important" type="search" id="tagsHeaderMobile" class="form-control no-focus form-control-inno" placeholder="What expertise or knowledge do you need?" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="m-t-20 p-r-10 p-b-15 registerBtnsMobile" style="display: none;">
                    <div class="col-6">
                        <a class="btn btn-normal td-none m-l-10 m-r-10 loginBtn btn-block" href="/login"><span class="c-gray">Login</span></a>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-inno btn-success joinBtn btn-block" href="/create-my-account">Join for free</a>
                    </div>
                </div>
            <? } else { ?>
                <div class="row m-t-10 navMobile m-r-0 m-l-0 p-l-30">

                        <a href="/" style="width: 16% !important;">
                            <img class="cartwheelLogo" src="/images/cartwheel.png" alt="" style="width: 30px !important; height: 30px !important;">
                        </a>


                        <i class="@mobile popoverNotificationsMob @elsenotmobile popoverNotifications @endmobile zmdi zmdi-notifications c-gray f-22 m-r-5 c-pointer moreChev m-t-5" style="width: 16% !important;" data-toggle="popover" data-content='<?= view("/public/shared/_popoverNotificationBox")?>'></i>

                        <div style="width: 16%;">
                            <i class="zmdi zmdi-comment-text f-22 c-pointer popoverMessagesMob c-gray m-t-5 p-relative"  data-toggle="popover" data-content='<?= view("/public/shared/messagesHeaderBox/_popoverBox")?>'>
                                <i class="zmdi zmdi-circle c-orange f-13 p-absolute <? if($counterMessages < 1) echo "hidden";?> notificationIdicator" style="top: -20%; left: 70%;"></i>
                            </i>
                        </div>


                        <i class="zmdi zmdi-accounts-add f-22 m-t-5 c-pointer popoverRequestsMob c-gray" data-user-id="<?= \Illuminate\Support\Facades\Session::get("user_id")?>" data-toggle="popover" data-content='<?= view("/public/shared/teamInvitesHeaderBox/_popoverBox")?>' style="width: 16%;"></i>

                        <a href="/innocreatives" style="width: 16% !important;">
                            <i class="zmdi zmdi-share c-gray f-22 m-t-5"></i>
                        </a>

                        <div class="d-flex" style="width: 16% !important;">
                            <a href="/my-account" class="m-r-5">
                                <div class="avatar-header img m-b-10 p-t-0" style="background: url('<?= $user->getProfilePicture()?>')"></div>
                            </a>
                            <i class="popoverHeader zmdi zmdi-chevron-down c-gray f-20 c-pointer m-t-10" data-toggle="popover" data-content='<?= view("/public/shared/_popoverHeaderMenu")?>'></i>
                        </div>
                </div>
                <div class="m-t-5 searchBarBox hidden p-15" id="expertisesHeaderMob" style="min-width: 100px !important;">
                    <i class="zmdi zmdi-long-arrow-left c-orange f-22 pull-right m-r-5 closeSearchBar"></i>
                    <div class="input-group mb-3 no-focus">
                        <div class="input-group-prepend no-focus">
                            <span class="input-group-text no-focus c-pointer" id="basic-addon1"><i class="zmdi zmdi-search f-20"></i></span>
                        </div>
                        <input style="outline: none !important; -webkit-appearance:none !important; width: 30vw !important" type="search" id="tagsHeaderMobile" class="form-control no-focus form-control-inno" placeholder="What expertise or knowledge do you need?" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
</header>
