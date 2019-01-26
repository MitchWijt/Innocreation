@extends("layouts.app")
<link rel="stylesheet" href="/css/responsiveness/singleUserPage.css">
@section("content")
    <div class="d-flex grey-background">
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
                <? if(isset($loggedIn) && $loggedIn->id == $user->id) { ?>
                    <form action="/user/editBannerImage" method="post" class="hidden bannerImgForm" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="user_id" value="<?= $user->id?>">
                        <input type="file" name="bannerImg" class="bannerImgInput">
                    </form>
                    <i class="zmdi zmdi-edit editBtn editBannerImage @handheld no-hover @endhandheld" @handheld style="display: block !important;"@endhandheld></i>
                <? } ?>
                <div class="avatar-med absolutePF p-absolute" style="background: url('<?= $user->getProfilePicture()?>'); z-index: 100 !important">
                    <? if(isset($loggedIn) && $loggedIn->id == $user->id) { ?>
                        <form action="/user/saveUserProfilePicture" method="post" class="hidden profileImageForm" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                            <input type="hidden" name="user_id" value="<?= $user->id?>">
                            <input type="file" name="profile_picture" class="profile_picture">
                        </form>
                        <i class="zmdi zmdi-edit editBtn shadow @handheld no-hover @endhandheld" id="editProfilePicture"></i>
                    <? } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="row d-flex fd-column userName" style="margin-top: 60px !important">
                        <p class="f-25 m-b-0" style="margin-left: 9%"><?= $user->getName()?> <? if(isset($loggedIn) && $loggedIn->id != $user->id) { ?> <i class="zmdi zmdi-chevron-down f-18 popoverSingleUser c-pointer" data-toggle="popover" data-content='<?= view("/public/shared/_popoverSendMessage", compact("user", "loggedIn"))?>'></i> <? } ?></p>
                        <p class="m-t-0 f-12 m-b-0 c-dark-grey" style="margin-left: 9%"><?= $user->country->country?></p>
                    </div>
                    <? if(isset($loggedIn) && $loggedIn->id != $user->id) { ?>
                        <div class="row switchDiv">
                            <div class="col-6">
                                <label class="switch switch_type2 m-t-10" style="margin-left: 9%" role="switch">
                                    <input data-toggle="popover" <? if(isset($loggedIn) && $user->hasSwitched()) echo "checked disabled"; ?> data-content='<?= \App\Services\UserConnections\ConnectionService::getPopoverSwitchView($user)?>' type="checkbox" class="switch__toggle popoverSwitch">
                                    <span class="switch__label"></span>
                                </label>
                            </div>
                        </div>
                    <? } ?>
                    <div class="row teamLinkDiv">
                        <div class="col-12 p-0 m-0 connectionsAmount">
                            <span><a class="regular-link c-dark-grey f-12 openConnectionsModal" data-id="<?= $user->id?>" style="margin-left: 9%" href="#"><?= count($connections)?> Connections</a></span>
                        </div>
                    </div>
                    <? if($user->team_id != null) { ?>
                        <div class="row teamLinkDiv">
                            <div class="p-0 m-0 teamName o-hidden text-overflow" style="width: 100%">
                                <span class="wp-no-wrap"><i class="zmdi zmdi-accounts-alt" style="margin-left: 9%"></i> <a class="regular-link" target="_blank" href="<?= $user->team->getUrl()?>"><?= $user->team->team_name?></a></span>
                            </div>
                        </div>
                    <? } ?>
                </div>
                <div class="col-sm-8">
                    <div class="row">
                        <? if(isset($loggedIn) && $loggedIn->id == $user->id) { ?>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-lg m-t-20 m-b-20">
                        <div class="card-block m-t-10">
                            <div class="col-sm-12">
                                <div class="d-flex js-between">
                                    <h3>Expertises</h3>
                                    <? if(isset($loggedIn) && $loggedIn->id == $user->id) { ?>
                                        <i class="editBtn zmdi zmdi-plus f-20 p-r-15 p-l-15 p-b-10 p-t-10 editExpertise @handheld no-hover @endhandheld"></i>
                                    <? } ?>
                                </div>
                            </div>
                            <? foreach($expertise_linktable as $expertise) { ?>
                                <div class="row p-l-30 p-r-30 m-b-30 m-t-10 expertise-<?= $expertise->id?>">
                                    <div class="col-xl-3">
                                        <div class="card">
                                            <div class="card-block expertiseCard p-relative c-pointer" style="max-height: 150px !important">
                                                <div class="p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                                                    <a class="c-gray f-9 photographer" target="_blank" href="<?= $expertise->image_link?>">Photo</a><span class="c-gray f-9"> by </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="<?= $expertise->photographer_link?>"><?= $expertise->photographer_name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="https://unsplash.com">Unsplash</a>
                                                </div>
                                                <? if(isset($loggedIn) && $loggedIn->id == $user->id) { ?>
                                                    <div class="p-absolute" style="z-index: 200; top: 5px; right: 5px">
                                                        <i data-expertise-id="<?= $expertise->expertise_id?>" class="zmdi zmdi-camera f-20 editBtn editImage"></i>
                                                    </div>
                                                <? } ?>
                                                <div class="overlay">
                                                    <div class="contentExpertiseUsers" style="background: url('<?= $expertise->image?>');"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-9 m-t-10">
                                        <div class="d-flex js-between align-start">
                                            <div class="d-flex align-start">
                                                <div class="d-flex fd-column">
                                                    <h3 class="m-r-10 m-b-0"><?= $expertise->expertises->First()->title?></h3>
                                                    <i class="c-dark-grey f-12">Skill level: <span style="color: <?= \App\Services\UserAccount\UserExpertises::getSkillLevel($expertise->skill_level_id)['color']?>"><?= ucfirst(\App\Services\UserAccount\UserExpertises::getSkillLevel($expertise->skill_level_id)['level'])?></span></i>
                                                </div>
                                                <? if($user->team_id == null) { ?>
                                                    <? if($loggedIn) { ?>
                                                        <? if($team) { ?>
                                                            <? if($team->checkInvite($expertise->expertise_id, $team->id, $user->id) == false) { ?>
                                                                <? if(\App\Services\TeamServices\TeamPackage::checkPackageAndPayment($team->id, $expertise)) { ?>
                                                                    <form action="/my-team/inviteUserForTeam" method="post" class="m-0">
                                                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                                        <input type="hidden" name="invite" value="1">
                                                                        <input type="hidden" name="team_id" value="<?= $team->id?>">
                                                                        <input type="hidden" name="expertise_id" value="<?= $expertise->expertise_id?>">
                                                                        <input type="hidden" name="user_id" value="<?= $user->id?>">
                                                                        <button class="btn btn-inno btn-sm m-t-10">Invite user to my team</button>
                                                                    </form>
                                                                <? } else { ?>
                                                                    <button data-toggle="modal" data-target="#teamLimitNotification" class="btn btn-inno btn-sm m-t-10">Invite user to my team</button>
                                                                <? } ?>
                                                            <? } else { ?>
                                                                <p class="c-orange m-b-0 vertically-center">User invited</p>
                                                            <? } ?>
                                                        <? } ?>
                                                    <? } ?>
                                                <? } ?>
                                            </div>
                                            <? if(isset($loggedIn) && $loggedIn->id == $user->id) { ?>
                                                <div>
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
            <div class="row d-flex js-center">
                <div class="col-md-12">
                    <div class="card card-lg m-t-20 m-b-20">
                        <div class="card-block m-t-10" style="overflow: hidden !important">
                            <div class="row">
                                <div class="col-sm-12 m-l-20 m-b-5">
                                    <h3>My portfolio</h3>
                                </div>
                            </div>
                            <hr class="m-b-20">
                            <? $counter = 0?>
                            <? foreach($portfolios as $portfolio) { ?>
                                <div class="row" id="test">
                                    <div class="col-12 m-l-20">
                                        <h3 class="m-b-0 p-b-0"><?= $portfolio->title?></h3>
                                    </div>
                                    <? if(isset($portfolio->link)) { ?>
                                        <div class="col-12 m-l-20 p-t-0 ">
                                            <i class="c-dark-grey f-11"><a class="c-orange" href="<?= $portfolio->link?>">Referal link</a></i>
                                        </div>
                                    <? } ?>
                                </div>
                                <div class="carousel m-b-30 carousel-portfolio" id="carousel-default-<?= $counter?>" data-counter="<?= $counter?>">
                                    <ul class="p-l-0">
                                        <? foreach($portfolio->getFiles() as $file) { ?>
                                            <li class="td-none portfolioFileItem p-r-10 p-l-10" style="list-style-type: none; min-width: 350px !important; z-index: -1 !important">
                                                <? if($file->mimetype != \App\Services\Paths\PublicPaths::mimeType(false, true, false)) { ?>
                                                    <div class="card m-t-20 m-b-20 portfolioItemCard p-relative">
                                                        <div class="p-relative c-pointer contentContainerPortfolio" data-url="/" style="max-height: 180px">
                                                            <? if($file->mimetype ==  \App\Services\Paths\PublicPaths::mimeType(true, false, false) && $file->filename != null) { ?>
                                                                <? $backgroundImg = $file->getAudioCover() ?>
                                                            <? } else { ?>
                                                                 <? $backgroundImg = $file->getUrl() ?>
                                                            <? } ?>
                                                                <div class="@mobile contentPortfolioNoScale noScale-<?= $file->id?> @elsedesktop contentPortfolio lazyLoad @enddesktop" data-id="<?= $file->id?>" data-url="<?= $file->getUrl()?>" data-src="<?= $backgroundImg?>" style="z-index: -1 !important">
                                                                <div id="content" @notmobile style="display: none;" @endnotmobile>
                                                                    <div class="m-t-10 p-absolute cont-<?= $file->id?>" style="top: 40%; left: 52%; !important; transform: translate(-50%, -50%);">
                                                                        <p class="c-white f-9 p-t-40" style="width: 300px !important"><?= $file->description?></p>
                                                                    </div>
                                                                    <div class="p-t-40 p-absolute cont-<?= $file->id?>" style="top: 5%; left: 56%; width: 100%; transform: translate(-50%, -50%);">
                                                                        <p class="c-white f-12"><?= $file->title?></p>
                                                                    </div>
                                                                    <? if($file->title != null) { ?>
                                                                        <div class="p-absolute cont-<?= $file->id?>" style="top: 18%; left: 44%; width: 100%; transform: translate(-50%, -50%);">
                                                                            <hr class="col-8">
                                                                        </div>
                                                                    <? } ?>
                                                                    <? if($file->mimetype ==  \App\Services\Paths\PublicPaths::mimeType(true, false, false)) { ?>
                                                                        <div class="p-absolute" style="top: 80%; right: -1%; transform: translate(-50%, -50%);">
                                                                            <i class="zmdi zmdi-play editBtnDark f-15 p-b-0 p-t-0 p-r-10 p-l-10 playSong" data-counter="<?= $counter?>" data-id="<?= $file->id?>"></i>
                                                                            <i class="zmdi zmdi-pause editBtnDark f-15 p-b-0 p-t-0 p-r-10 p-l-10 pauseSong hidden" data-counter="<?= $counter?>" data-id="<?= $file->id?>"></i>
                                                                        </div>
                                                                        <div class="p-absolute" style="top: 80%; left: 13%; transform: translate(-50%, -50%);">
                                                                            <span class="currentTime f-12 cur-<?= $file->id?>"></span><span class="f-12">/</span><span class="duration f-12 dur-<?= $file->id?>" data-id="<?= $file->id?>"></span>
                                                                        </div>
                                                                        <div class="p-absolute p-l-5 p-r-5" style="top: 90%; left: 50%; width: 100%; transform: translate(-50%, -50%);">
                                                                            <input type="range" class=" p-l-0 p-r-0 music-progress-bar musicBar-<?= $file->id?>" data-counter="<?= $counter?>" data-id="<?= $file->id?>" value="0" name="" id="">
                                                                        </div>
                                                                        <audio id="player-<?= $file->id?>" ontimeupdate="getCurrentTime(this, $(this).data('id'))" class="lazyLoad" data-src="<?= $file->getAudio()?>" data-id="<?= $file->id?>"></audio>
                                                                    <? } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <? } else { ?>
                                                    <div class="card m-t-20 m-b-20 p-0 portfolioItemCard p-relative">
                                                        <div class="p-relative c-pointer contentContainerPortfolio" data-url="/" style="max-height: 180px">
                                                            <div class="@handheld @mobile contentPortfolioNoScale noScale videoContentMobile @elsetablet videoContentTablet contentPortfolio @endmobile @elsedesktop contentPortfolio videoContent videoContent-<?= $file->id?> @endhandheld" data-id="<?= $file->id?>" data-counter="<?= $counter?>"  style="z-index: 2 !important;">
                                                                <div class="m-t-10 p-absolute" style="top: 40%; left: 52%; !important; transform: translate(-50%, -50%);">
                                                                    <i class="zmdi zmdi-play playButtonVideo shadow play-<?= $file->id?>"></i>
                                                                </div>
                                                                <div class="p-absolute cont-<?= $file->id?>" style="bottom: 4%; left: 5%">
                                                                    <i class="zmdi zmdi-volume-off f-20 unmuteVideo unmute-<?=$file->id?>" data-id="<?= $file->id?>"></i>
                                                                    <i class="zmdi zmdi-volume-up f-20 muteVideo mute-<?= $file->id?> hidden" data-id="<?= $file->id?>"></i>
                                                                </div>
                                                                <video poster="<?= $file->getThumbnail()?>"  id="video-<?= $file->id?>" data-id="<?= $file->id?>" class="video video-<?= $file->id?> lazyLoad" data-src="<?= $file->getVideo()?>" style="min-width: 100% !important; max-width: 350px !important; min-height: 180px !important; max-height: 180px !important; z-index: 99;" muted></video>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <? } ?>
                                            </li>
                                        <? } ?>
                                    </ul>
                                </div>
                                <? $counter++?>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
            <? if($user->team_id != null) { ?>
                <div class="row d-flex js-center">
                    <div class="col-md-12 col-xs-12">
                        <div class="card card-lg m-t-20 m-b-20">
                            <div class="card-block m-t-10 ">
                                <div class="row">
                                    <div class="col-sm-12 m-l-20">
                                        <h3>My team - <a href="/team/<?= $user->team->slug?>" class="regular-link"><?= $user->team->team_name?></a></h3>
                                    </div>
                                </div>
                                <div class="d-flex fd-column">
                                    <div class="row d-flex js-center @mobile p-l-30 p-r-30 @endmobile">
                                        <div class="col-sm-11">
                                            <p class="f-21 m-0">Team introduction</p>
                                            <hr>
                                            <p><?= $user->team->team_introduction?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
            <div class="modal teamLimitNotification fade" id="teamLimitNotification" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body ">
                            <p>Your current team package has reached its max member capacity. If you wanna keep inviting users and make sure users are able to join your team. Than take a look at the available team package upgrades.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
@endsection
@section('pagescript')
    <script defer async src="/js/pages/singleUserPage.js"></script>
@endsection