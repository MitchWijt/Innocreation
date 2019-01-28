<div class="modal privacySettingsModal fade fade-scale" id="privacySettingsModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-border">
            <i class="zmdi zmdi-close c-orange f-22 p-absolute" data-dismiss="modal" style="top: 3%; right: 3%; z-index: 1"></i>
            <form action="/my-account/saveUserAccount" method="post">
                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                <input type="hidden" name="user_id" value="<? if(isset($user)) echo $user->id ?>">
                <div class="form-group m-b-0 row">
                    <div class="m-t-20 col-sm-12 p-30">
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
                        <hr class="col-xs-12 m-t-20">
                        <div class="row text-center m-t-20">
                            <div class="col-sm-6">
                                <p class="m-0">Join notifications:</p>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="radio" name="notifications" value="on" <? if($user->notifications == 1) echo "checked"?> id="on"><label for="on">On</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="radio" name="notifications" value="off" <? if($user->notifications == 0) echo "checked"?> id="off"><label for="off">Off</label>
                                    </div>
                                </div>
                            </div>
                        </div>
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
</div>