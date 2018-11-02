@extends("layouts.app")
@section("content")
<div class="d-flex grey-background">
    @notmobile
        @include("includes.userAccount_sidebar")
    @endnotmobile
    <div class="container">
        @mobile
            @include("includes.userAccount_sidebar")
        @endmobile
        <div class="row m-b-20">
            <div class="col-sm-12 d-flex js-center">
                @include("includes.flash")
            </div>
        </div>
        <div class="sub-title-container p-t-20">
            <h1 class="sub-title-black">My profile</h1>
        </div>
        <hr class="col-xs-12">
        <form action="/my-account/saveUserProfilePicture" enctype="multipart/form-data" method="post" class="saveUserProfilePicture">
            <input type="hidden" name="_token" value="<?= csrf_token()?>">
            <input type="hidden" name="user_id" value="<? if(isset($user)) echo $user->id ?>">
            <div class="form-group d-flex js-center m-b-0 ">
                <div class="d-flex fd-column col-sm-9 m-t-20">
                    <div class="row text-center d-flex js-center">
                        <input type="file" name="profile_picture" class="hidden uploadFile">
                        <div class="d-flex js-center ">
                            <div class="avatar-lg" style="background: url('<?=$user->getProfilePicture()?>')"></div>
                        </div>
                    </div>
                    <div class="row text-center m-t-20 d-flex js-center">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-inno editProfilePicture">Edit profile picture <img class="hidden loadingGear" src="/images/icons/loadingGear.gif" width="20" alt=""></button>
                        </div>
                    </div>
                    <div class="row text-center m-t-20 m-b-20 d-flex js-center toLivePage">
                        <div class="col-md-6">
                            <a href="<?=$user->getUrl()?>" class="btn btn-sm btn-inno">Go to live page</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="row d-flex js-center @mobile p-20 @endmobile">
            <div class="col-md-10 p-0">
                <div class="card card-lg m-t-20 m-b-20">
                    <div class="card-block @mobile p-15 @endmobile">
                        <div class="row">
                            <div class="p-t-5 col-sm-6 @mobile p-b-15 @endmobile p-r-0 p-l-0 c-pointer" @mobile style="border-bottom: 1px solid #FF6100 !important" @elsedesktop style="border-right: 1px solid #FF6100 !important" @endmobile>
                                <h3 class="f-20 text-center activeItem toConnections">My connections</h3>
                            </div>
                            <div class="p-t-5 col-sm-6 @mobile m-t-15 @endmobile c-pointer">
                                <h3 class="f-20 text-center c-dark-grey toConnectionRequests">Connection requests</h3>
                            </div>
                        </div>
                    </div>
                    <div class="hr" style="width: 100%!important"></div>
                    <div class="connections o-scroll-with" style="max-height: 400px; min-height: 400px; overflow-x: hidden !important;">
                        <? $counter1 = 0;?>
                        <? foreach($connections as $connection) { ?>
                            <? if($connection->accepted == 1 || $connection->sender_user_id == $user->id) { ?>
                                <? if($connection->user->id == $user->id) { ?>
                                    <? $userSwitch = $connection->sender?>
                                <? } else { ?>
                                    <? $userSwitch = $connection->user?>
                                <? } ?>
                                <div class="row m-t-20">
                                    <div class="@mobile col-4 @elsedesktop col-sm-4 @endmobile">
                                        <div class="row m-l-25">
                                            <div class="avatar" style="background: url('<?= $userSwitch->getProfilePicture()?>')"></div>
                                        </div>
                                        <p class="col-sm-12 m-l-15"><?= $userSwitch->firstname?></p>
                                    </div>
                                    <div class="@mobile col-4 @elsedesktop col-sm-4 @endmobile text-center">
                                        <? foreach($userSwitch->getExpertises() as $expertise) { ?>
                                            <p><?= $expertise->title?></p>
                                        <? } ?>
                                    </div>
                                    <div class="@mobile col-4 @elsedesktop col-sm-4 @endmobile text-center">
                                        <? if($connection->accepted == 0) { ?>
                                            <p class="c-orange">On hold</p>
                                        <? } else { ?>
                                            <p class="c-green">Connected</p>
                                        <? } ?>
                                    </div>
                                </div>
                            <hr>
                            <? $counter1++?>
                            <? } ?>
                        <? } ?>
                        <? if($counter1 < 1) { ?>
                            <div class="row d-flex js-center m-t-20">
                                <div class="col-sm-12">
                                    <i class="c-dark-grey f-14">No connections create connection at the <a class="regular-link" href="/innocreatives">feed</a></i>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                    <div class="connections-received o-scroll-with hidden" style="max-height: 400px; min-height: 400px; overflow-x: hidden !important;">
                        <? $counter2 = 0;?>
                        <? foreach($connections as $connection) { ?>
                            <? if($connection->accepted == 0 && $connection->sender_user_id != $user->id) { ?>
                            @handheld
                                <div class="row m-t-20">
                                    <div class="col-6">
                                        <div class="row m-l-25">
                                            <div class="avatar" style="background: url('<?= $connection->sender->getProfilePicture()?>')"></div>
                                        </div>
                                        <p class="col-sm-12 m-l-15"><?= $connection->sender->firstname?></p>
                                    </div>
                                    <div class="col-6 text-center m-t-30">
                                        <a class="c-orange underline-link messagePopover" data-toggle="popover" data-content='<p><?= $connection->message?></p>'>Show message</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="switch switch_type2 m-t-10  m-l-15" role="switch">
                                            <input data-toggle="popover" type="checkbox" class="switch__toggle">
                                            <span class="switch__label"></span>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <form action="/user/acceptConnection" method="post" class="acceptConnection">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="connection_id" value="<?= $connection->id?>">
                                        </form>
                                        <form action="/user/declineConnection" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="connection_id" value="<?= $connection->id?>">
                                            <div class="row d-flex js-center">
                                                <button class="btn btn-inno btn-sm m-t-10">Decline</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @elsedesktop
                                <div class="row m-t-20">
                                    <div class="@mobile col-4 @elsedesktop col-sm-4 @endmobile">
                                        <div class="row m-l-25">
                                            <div class="avatar" style="background: url('<?= $connection->sender->getProfilePicture()?>')"></div>
                                        </div>
                                        <p class="col-sm-12 m-l-15"><?= $connection->sender->firstname?></p>
                                    </div>
                                    <div class="@mobile col-4 @elsedesktop col-sm-4 @endmobile text-center m-t-30">
                                        <a class="c-orange underline-link messagePopover" data-toggle="popover" data-content='<p><?= $connection->message?></p>'>Show message</a>
                                    </div>
                                    <div class="@mobile col-4 @elsedesktop col-sm-4 @endmobile text-center ">
                                        <label class="switch switch_type2 m-t-10  m-l-15" role="switch">
                                            <input data-toggle="popover" type="checkbox" class="switch__toggle">
                                            <span class="switch__label"></span>
                                        </label>
                                        <form action="/user/acceptConnection" method="post" class="acceptConnection">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="connection_id" value="<?= $connection->id?>">
                                        </form>
                                        <form action="/user/declineConnection" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="connection_id" value="<?= $connection->id?>">
                                            <div class="row d-flex js-center">
                                                <button class="btn btn-inno btn-sm">Decline</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endhandheld
                                <hr>
                                <? $counter2++?>
                            <? } ?>
                        <? } ?>
                        <? if($counter2 < 1) { ?>
                            <div class="row d-flex js-center m-t-20 @mobile p-10 @endmobile">
                                <div class="col-sm-12">
                                <i class="c-dark-grey f-14">No connection requests, create connections at the <a class="regular-link" href="/innocreatives">feed!</a></i>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $('.messagePopover').popover({ trigger: "click" , html: true, animation:false, placement: 'left'});
</script>
@endsection
@section('pagescript')
    <script src="/js/user/userAccountCredentials.js"></script>
@endsection