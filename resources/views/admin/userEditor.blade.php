@extends("layouts.app_admin")
@section("content")
    <div class="d-flex grey-background vh100">
        @include("includes.admin_sidebar")
        <div class="container">
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 d-flex js-between m-b-10">
                                <h4 class="m-t-5"><?= $user->getName()?></h4>
                                <div class="buttons m-t-5">
                                    <button class="btn btn-inno pull-right btn-sm">Delete</button>
                                    <button class="btn btn-inno pull-right btn-sm m-r-10 ">Login as <?= $user->firstname?></button>
                                    <a href="<?= $user->getUrl()?>" class="btn btn-inno pull-right btn-sm m-r-10">To live page</a>
                                </div>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <form action="/admin/saveUser" method="post">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <input type="hidden" name="user_id" value="<? if(isset($user)) echo $user->id ?>">
                                <div class="row">
                                    <div class="col-sm-12 d-flex">
                                        <div class="col-sm-5">
                                            <div class="col-sm-5 m-t-15 m-b-20">
                                                <img src="<?= $user->getProfilePicture()?>" class="circle circleMedium">
                                                <p class="text-center">Team: <? if($user->team_id != null) { ?><a target="_blank" class="regular-link" href="<?= $user->team->getUrl()?>"><?= $user->team->team_name?></a><? } else { ?> - <? } ?></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="row">
                                                <div class="col-sm-12 d-flex m-t-20">
                                                    <div class="col-sm-4">
                                                        <input type="text" placeholder="First name" name="firstname" class="input col-sm-12" value="<? if(isset($user->firstname)) echo $user->firstname?>">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" placeholder="Middle name" name="middlename" class="input col-sm-12" value="<? if(isset($user->middlename)) echo $user->middlename?>">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" placeholder="Last name" name="lastname" class="input col-sm-12" value="<? if(isset($user->lastname)) echo $user->lastname?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 d-flex m-t-20">
                                                    <div class="col-sm-6">
                                                        <input type="text" placeholder="Email" name="email" class="input col-sm-12" value="<? if(isset($user->email)) echo $user->email?>">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" placeholder="phonenumber" name="phonenumber" class="input col-sm-12" value="<? if(isset($user->phonenumber)) echo $user->phonenumber?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 d-flex m-t-20">
                                                    <div class="col-sm-3">
                                                        <input type="text" placeholder="Postal code" name="postal_code" class="input col-sm-12" value="<? if(isset($user->postalcode)) echo $user->postalcode?>">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" placeholder="State" name="state" class="input col-sm-12" value="<? if(isset($user->state)) echo $user->state?>">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <input type="text" placeholder="City" name="city" class="input col-sm-12" value="<? if(isset($user->city)) echo $user->city?>">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <select name="country" class="input col-sm-12">
                                                            <? foreach($countries as $country) { ?>
                                                                <option <? if($user->country == $country->country) echo "selected"?> value="<?= $country->country?>"><?= $country->country?></option>
                                                            <? } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 m-t-20">
                                                  <button class="btn btn-inno pull-right">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row p-20">
                                    <div class="col-sm-12">
                                        <p class="f-20 col-sm-12">Motivation</p>
                                        <div class="text-center">
                                        <textarea name="user_motivation" class="input col-sm-12" cols="30" rows="10"><? if(isset($user->motivation)) echo $user->motivation?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-20">
                                    <div class="col-sm-12">
                                        <p class="f-20 col-sm-12">Introduction</p>
                                        <div class="text-center">
                                            <textarea name="user_introduction" class="input col-sm-12" cols="30" rows="10"><? if(isset($user->introduction)) echo $user->introduction?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-20">
                                    <div class="col-sm-12">
                                       <button class="btn btn-inno pull-right">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-b-20">
                <div class="card card-lg col-sm-12 m-t-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 m-b-10">
                                <h4 class="m-t-10">Expertises</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <? foreach($expertiseLinktables as $expertiseLinktable) { ?>
                                <form action="/admin/saveSingleUserExpertise" method="post" class="col-sm-12">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <input type="hidden" name="expertise_linktable_id" value="<?= $expertiseLinktable->id?>">
                                    <div class="row p-20">
                                        <div class="col-sm-12">
                                            <div class=" col-sm-11 d-flex js-between">
                                                <p class="f-20 col-sm-12"><?= $expertiseLinktable->expertises->First()->title?></p>
                                                <button class="btn btn-inno m-b-20">Save</button>
                                            </div>
                                            <div class="text-center">
                                                <textarea name="expertise_description" class="input col-sm-12" cols="30" rows="10"><?= $expertiseLinktable->description?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection