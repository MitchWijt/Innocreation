@extends("layouts.app")
<link rel="stylesheet" href="/css/responsiveness/singleUserPage.css">
<link rel="stylesheet" href="/css/responsiveness//innocreativeFeed/index.css">
<link rel="stylesheet" href="/css/responsiveness/innocreativeFeed/feedResponsive.css">
@section("content")
    <div class="<?= \App\Services\UserAccount\UserAccount::getTheme()?>">
        <div class="grey-background <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <? if(count($errors) > 0){ ?>
                        <? foreach($errors->all() as $error){ ?>
                        <p class="c-orange"><?=$error?></p>
                        <? } ?>
                        <? } ?>
                    </div>
                </div>
                <div class="banner p-relative " style="background: url('<?= $user->getBanner()?>');">
                    <? if(isset($loggedIn) && $loggedIn == $user->id) { ?>
                    <form action="/user/editBannerImage" method="post" class="hidden bannerImgForm" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="user_id" value="<?= $user->id?>">
                        <input type="file" name="bannerImg" class="bannerImgInput">
                    </form>
                    <i class="zmdi zmdi-edit editBtn editBannerImage @handheld no-hover @endhandheld" @handheld style="display: block !important;"@endhandheld></i>
                    <? } ?>
                    <div class="avatar-med absolutePF p-absolute" style="background: url('<?= $user->getProfilePicture()?>'); z-index: 100 !important">
                        <? if(isset($loggedIn) && $loggedIn == $user->id) { ?>
                        <form action="/user/saveUserProfilePicture" method="post" class="hidden profileImageForm" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                            <input type="hidden" name="user_id" value="<?= $user->id?>">
                            <input type="file" name="profile_picture" class="profile_picture">
                        </form>
                        <i class="zmdi zmdi-edit editBtn shadow @handheld no-hover @endhandheld" id="editProfilePicture"></i>
                        <? } ?>
                    </div>
                </div>
                <div class="row <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
                    <div class="col-sm-4">
                        <div class="row d-flex userName" style="margin-top: 60px !important">
                            <div class="d-flex flexDivUsername" style="margin-left: 9%">
                                <? if(isset($loggedIn) && $loggedIn != $user->id) { ?> <i class="zmdi zmdi-chevron-down f-18 popoverSingleUser c-pointer m-t-10 m-r-5" data-toggle="popover" data-content='<?= view("/public/shared/_popoverSendMessage", compact("user", "loggedIn"))?>'></i> <? } ?>
                                <div class="p-0 o-hidden text-overflow" style="width: 100%;">
                                    <span class="wp-no-wrap f-25 m-b-0"> <?= $user->getName()?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-0 m-0 countryDiv">
                                <p class="m-t-0 f-12 m-b-0 c-dark-grey country" style="margin-left: 9%"><?= $user->country->country?></p>
                            </div>
                        </div>
                        <div class="m-l-15 m-b-5">
                            <?= \App\Services\UserConnections\ConnectionService::getSwitch($user->id)?>
                        </div>
                        <div class="row teamLinkDiv">
                            <div class="col-12 p-0 m-0 connectionsAmount">
                                <span><a class="regular-link c-dark-grey f-12 <? if(count($connections) > 0) echo "openConnectionsModal"; else echo "connectionsAmountText"?>" data-id="<?= $user->id?>" style="margin-left: 9%" ><?= count($connections)?> Connections</a></span>
                            </div>
                        </div>
                        <? if($user->team_id != null) { ?>
                        <div class="row teamLinkDiv">
                            <div class="p-0 m-0 teamName o-hidden text-overflow" style="width: 100%">
                                <span class="wp-no-wrap"><i class="zmdi zmdi-accounts-alt c-black" style="margin-left: 9%"></i> <a class="regular-link" target="_blank" href="<?= $user->team->getUrl()?>"><?= $user->team->team_name?></a></span>
                            </div>
                        </div>
                        <? } ?>
                    </div>
                    <div class="col-sm-8 <? if(!isset($loggedIn)) echo "m-t-65";?>">
                        <div class="row">
                            <? if(isset($loggedIn) && $loggedIn == $user->id) { ?>
                            <div class="col-sm-12 m-b-20 navbarBox">
                                <div class="navbar-user-desktop">
                                    <span><i class="zmdi zmdi-more f-25 c-pointer c-black pull-right popoverUserMenu" data-toggle="popover" data-content='<?= view("/includes/popovers/userAccountMenu", compact("user", "loggedIn"))?>'></i></span>
                                    <span class="iconCTA pull-right m-r-10 userPrivacySettings" data-id="<?= $user->id?>">Privacy settings</span>
                                    <span class="iconCTA pull-right m-r-10"><a href="/my-account/favorite-expertises" class="c-black td-none" target="_blank">Favorite expertises</a></span>
                                    <span class="iconCTA pull-right m-r-10"><a href="/my-account/favorite-teams" class="c-black td-none" target="_blank">Favorite teams</a></span>
                                </div>
                                <div class="navbar-user-mobile" style="display: none">
                                    <span><i class="zmdi zmdi-more f-25 c-pointer c-black pull-right popoverUserMenu" data-toggle="popover" data-content='<?= view("/includes/popovers/userAccountMenu", compact("user", "loggedIn"))?>'></i></span>
                                    <span class="iconCTA pull-right m-r-10 userPrivacySettings" data-id="<?= $user->id?>"><i class="zmdi zmdi-settings"></i></span>
                                    <span class="iconCTA pull-right m-r-10"><a href="/my-account/favorite-expertises" class="c-black td-none" target="_blank"><i class="zmdi zmdi-ticket-star"></i> Expertises</a></span>
                                    <span class="iconCTA pull-right m-r-10"><a href="/my-account/favorite-teams" class="c-black td-none" target="_blank"><i class="zmdi zmdi-ticket-star"></i> Teams</a></span>
                                </div>
                            </div>
                            <? } ?>
                        </div>
                        <p class="m-l-10 c-dark-grey"><?= $user->introduction?></p>
                        <p class="m-l-10 c-dark-grey"><?= $user->motivation?></p>
                    </div>
                </div>
                <div class="row <?= \App\Services\UserAccount\UserAccount::getTheme()?>" style="margin-bottom: 100px;">
                    <div class="col-md-12">
                        <div class="m-b-20" style="margin-top: 100px;">
                            <div class=" m-t-10">
                                <div class="col-sm-12">
                                    <div class="d-flex js-between ">
                                        <h3 class="bold f-31">Expertises</h3>
                                        <? if(isset($loggedIn) && $loggedIn == $user->id) { ?>
                                        <i  style="z-index: 2;" class="editBtn zmdi zmdi-plus f-20 p-r-15 p-l-15 p-b-10 p-t-10 editExpertise @handheld no-hover @endhandheld"></i>
                                        <? } else { ?>
                                        <? if($user->team_id == null) { ?>
                                            <? if($loggedIn) { ?>
                                                <? if($team) { ?>
                                                    <? if($team->checkInvite($team->id, $user->id) == false) { ?>
                                                        <? if(\App\Services\TeamServices\TeamPackage::checkPackageAndPayment($team->id, $expertise_linktable->First())) { ?>
                                                            <form action="/my-team/inviteUserForTeam" method="post" class="m-0">
                                                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                                <input type="hidden" name="invite" value="1">
                                                                <input type="hidden" name="team_id" value="<?= $team->id?>">
                                                                <input type="hidden" name="user_id" value="<?= $user->id?>">
                                                                <button class="btn btn-inno btn-sm">Invite creator to my team</button>
                                                            </form>
                                                        <? } else { ?>
                                                            <button class="btn btn-inno btn-sm  openTeamLimitModal">Invite creator to my team</button>
                                                        <? } ?>
                                                        <? } else { ?>
                                                            <p class="c-orange m-b-0 vertically-center">User invited</p>
                                                        <? } ?>
                                                    <? } ?>
                                                <? } ?>
                                            <? } ?>
                                        <? } ?>
                                    </div>
                                </div>
                                <? foreach($expertise_linktable as $expertise) { ?>
                                <div class="row p-l-30 p-r-30 m-b-30 m-t-10 expertise-<?= $expertise->id?>">
                                    <div class="col-xl-3">
                                        <div class="card">
                                            <div class="card-block expertiseCard p-relative" style="max-height: 150px !important">
                                                <div class="p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                                                    <a class="c-gray f-9 photographer" target="_blank" href="<?= $expertise->image_link?>">Photo</a><span class="c-gray f-9"> by </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="<?= $expertise->photographer_link?>"><?= $expertise->photographer_name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="https://unsplash.com">Unsplash</a>
                                                </div>
                                                <? if(isset($loggedIn) && $loggedIn == $user->id) { ?>
                                                <div class="p-absolute" style="z-index: 200; top: 5px; right: 5px">
                                                    <i data-expertise-id="<?= $expertise->expertise_id?>" class="zmdi zmdi-camera f-20 editBtn editImage"></i>
                                                </div>
                                                <? } ?>
                                                <div class="contentExpertiseUsers" style="background: url('<?= $expertise->image?>');"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-9 m-t-10">
                                        <div class="d-flex js-between align-start">
                                            <div class="d-flex align-start inviteDiv">
                                                <div class="d-flex fd-column" style="min-width: 140px">
                                                    <h3 class="m-r-10 m-b-0"><?= $expertise->expertises->First()->title?></h3>
                                                    <i class="c-dark-grey f-12">Skill level: <span style="color: <?= \App\Services\UserAccount\UserExpertises::getSkillLevel($expertise->skill_level_id)['color']?>"><?= ucfirst(\App\Services\UserAccount\UserExpertises::getSkillLevel($expertise->skill_level_id)['level'])?></span></i>
                                                </div>
                                            </div>
                                            <? if(isset($loggedIn) && $loggedIn == $user->id) { ?>
                                            <div style="z-index: 2;">
                                                <i class="editBtn zmdi zmdi-edit m-t-15 editExpertise @handheld no-hover @endhandheld" data-expertise-id="<?= $expertise->id?>"></i>
                                                <i class="editBtn zmdi zmdi-close m-t-15 removeExpertise @handheld no-hover @endhandheld" data-expertise-id="<?= $expertise->id?>"></i>
                                            </div>
                                            <? } ?>
                                        </div>
                                        <hr>
                                        <? if($expertise->description) { ?>
                                            <p class="wp-pre-wrap"><?= $expertise->description?></p>
                                        <? } else { ?>
                                            <i class="c-dark-grey f-12 text-center">No experience given yet</i>
                                        <? } ?>
                                    </div>
                                </div>
                                <? } ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="container feedPostsContainer">
                <? if($amountUserWorkPosts > 0) { ?>
                <div class="userworkData m-t-20 grid-container <?= \App\Services\UserAccount\UserAccount::getTheme()?>" data-page="userPage" data-user-id="<?= $user->id?>">

                </div>
                <? } else { ?>
                <div class="d-flex js-center m-t-20 m-b-20">
                    <div class="p-relative text-center">
                        {{--<p class="p-absolute f-20 textPlaceholder" style="top: 5%; left: 23%">No posts have been posted yet...</p>--}}
                        <img style="width: 60%" class="img-responsive imgPlaceholderPosts" src="/images/placeholder_text.png" alt="">
                    </div>
                </div>
                <? } ?>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script defer async src="/js/pages/singleUserPage.js"></script>
    <script defer async src="/js/userworkFeed/feed.js"></script>
@endsection