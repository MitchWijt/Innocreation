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
                        <div class="col-md-6">
                            <input type="file" name="profile_picture" class="hidden uploadFile">
                            <img class="circle m-0 circleImgLg" src="<?=$user->getProfilePicture()?>" alt="Profile picture">
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
        <form action="/my-account/saveUserAccount" method="post">
            <input type="hidden" name="_token" value="<?= csrf_token()?>">
            <input type="hidden" name="user_id" value="<? if(isset($user)) echo $user->id ?>">
            <div class="form-group d-flex js-center m-b-0 row">
                <div class="m-t-20 col-md-12">
                    <div class="row text-center">
                        <div class="col-sm-6">
                            <p class="m-0">First name:</p>
                        </div>
                        <div class="col-sm-6">
                           <p><? if(isset($user->firstname)) echo $user->firstname?></p>
                        </div>
                    </div>
                    <? if($user->middlename != null) { ?>
                    <div class="row text-center">
                        <div class="col-sm-6">
                            <p class="m-0">middle name:</p>
                        </div>
                        <div class="col-sm-6">
                            <p><? if(isset($user->middlename)) echo $user->middlename?></p>
                        </div>
                    </div>
                    <? } ?>
                    <div class="row text-center">
                        <div class="col-sm-6">
                            <p class="m-0">Last name:</p>
                        </div>
                        <div class="col-sm-6">
                            <p><? if(isset($user->lastname)) echo $user->lastname?></p>
                        </div>
                    </div>
                    <hr class="@notmobile col-md-9 @elsemobile col-xs-12 @endnotmobile">
                    <div class="row text-center m-t-20">
                        <div class="col-sm-6">
                            <p class="m-0">Email:</p>
                        </div>
                        <div class="col-sm-6">
                            <p><? if(isset($user->email)) echo $user->email?></p>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-sm-6">
                            <p class="m-0">Address:</p>
                        </div>
                        <div class="col-sm-6">
                            <p><? if(isset($user->postalcode)) echo $user->postalcode .", ". $user->city .", ". $user->country->country?></p>
                        </div>
                    </div>
                    <hr class="@notmobile col-md-9 @elsemobile col-xs-12 @endnotmobile">
                    <div class="row text-center m-t-20">
                        <div class="col-sm-6">
                            <p class="m-0">Mobile-number:</p>
                        </div>
                        <div class="col-sm-6">
                            <p><? if(isset($user->phonenumber)) echo $user->phonenumber?></p>
                        </div>
                    </div>
                    <hr class="@notmobile col-md-9 @elsemobile col-xs-12 @endnotmobile">
                    <div class="row text-center m-t-20">
                        <div class="col-sm-6">
                            <p class="m-0">Skype:</p>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="skype" class="input" value="<? if(isset($user->skype)) echo $user->skype?>">
                        </div>
                    </div>
                    <div class="row text-center m-t-20">
                        <div class="col-sm-6">
                            <p class="m-t-30">My motivation:</p>
                        </div>
                        <div class="col-sm-6">
                            <textarea class="input" name="motivation_user" cols="30" rows="5"><? if(isset($user->motivation)) echo $user->motivation ?></textarea>
                        </div>
                    </div>
                    <div class="row text-center m-t-20">
                        <div class="col-sm-6">
                            <p class="m-t-30">My introduction:</p>
                        </div>
                        <div class="col-sm-6">
                            <textarea class="input introductionUser" name="introduction_user" cols="30" rows="5"><? if(isset($user->introduction)) echo $user->introduction ?></textarea>
                        </div>
                    </div>
                    <div class="row m-t-20 p-b-20">
                        <div class="col-md-11">
                            <button class="btn btn-inno pull-right">Save my account</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('pagescript')
    <script src="/js/user/userAccountCredentials.js"></script>
@endsection