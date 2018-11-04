@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh80">
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
                <h1 class="sub-title-black">Privacy settings</h1>
            </div>
            <hr class="col-xs-12">
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
                        <div class="row text-center m-t-20">
                            <div class="col-sm-6">
                                <p class="m-0">Skype:</p>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="skype" class="input" value="<? if(isset($user->skype)) echo $user->skype?>">
                            </div>
                        </div>
                        <hr class="col-xs-12 m-t-20">
                        <div class="row text-center m-t-20">
                            <div class="col-sm-6">
                                <p class="m-t-30">My motivation:</p>
                            </div>
                            <div class="col-sm-6">
                                <textarea class="input btn-block" placeholder="What is your motivation for your passion? What keeps you driven?" name="motivation_user" rows="5"><? if(isset($user->motivation)) echo $user->motivation ?></textarea>
                            </div>
                        </div>
                        <div class="row text-center m-t-20">
                            <div class="col-sm-6">
                                <p class="m-t-30">My introduction:</p>
                            </div>
                            <div class="col-sm-6">
                                <textarea class="input introductionUser btn-block" placeholder="Tell us more about yourself, how did you start, who are you?" name="introduction_user" rows="5"><? if(isset($user->introduction)) echo $user->introduction ?></textarea>
                            </div>
                        </div>
                        <div class="row m-t-20 p-b-20">
                            <div class="col-md-12">
                                <button class="btn btn-inno pull-right">Save my account</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
