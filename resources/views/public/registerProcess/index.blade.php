@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100">
        <div class="container">
            <div class="sub-title-container p-t-20">
            </div>
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50"
                     aria-valuemin="0" aria-valuemax="100" style="<? if(isset($user)) echo "width: 40%"; else echo "with: 10%"?>">
                    <? if(isset($user)) echo "40% Complete"; else echo "10% Complete"?>
                </div>
            </div>
            <div class="row d-flex js-center">
                <div class="col-md-9 m-t-20">
                    <div class="row">
                        <div class="col-sm-4">
                            <img src="/images/Mascot.png" width="130" alt="">
                        </div>
                        <div class="col-sm-8">
                            <p>Hey, Welcome! <br> We are glad you want to take your dreams and ideas to the next level with Innocreation! <br> Follow the steps below to create your account and start connecting, networking and creating!</p>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="row credentials <? if(isset($user)) echo "hidden"?>">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
                        <div class="card card-lg m-t-20 m-b-20 col-sm-12">
                            <div class="card-block m-t-10">
                                <div class="row">
                                    <div class="col-sm-12 p-0">
                                        <p class="f-18 m-l-20 m-b-0">We are Innocreation. And who are you?</p>
                                        <i class="m-l-20 f-12 existingError c-orange"></i>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row d-flex js-center">
                                    <div class="col-md-9">
                                        <div class="row m-t-20">
                                            <div class="col-sm-4">
                                                <p class="m-0 labelFirstname">First name*</p>
                                                <input type="text" placeholder="Your First name" class="firstname col-sm-12 input" name="firstname">
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="m-0">Middle name</p>
                                                <input type="text" placeholder="Your Middle name" class="middlename col-sm-12 input" name="middlename">
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="m-0 labelLastname">Last name*</p>
                                                <input type="text" placeholder="Your Last name" class="lastname col-sm-12 input" name="lastname">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="row d-flex js-center">--}}
                                    {{--<div class="col-md-9">--}}
                                        {{--<div class="row m-t-10">--}}
                                            {{--<div class="col-sm-4">--}}
                                                {{--<input type="radio" name="gender" class="gender" value="male" id="male">--}}
                                                {{--<label for="male" class="m-r-10">Male</label>--}}

                                                {{--<input type="radio" name="gender" class="gender" value="female" id="female">--}}
                                                {{--<label for="female" class="m-r-10">Female</label>--}}

                                                {{--<input type="radio" name="gender" class="gender" value="private" id="private">--}}
                                                {{--<label for="private">Private</label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="row d-flex js-center">
                                    <div class="col-md-9">
                                        <div class="row m-t-10">
                                            <div class="col-sm-6">
                                                <p class="m-0 labelPassword">Password*</p>
                                                <input type="password" placeholder="Choose your password" class="password input col-sm-12" name="password">
                                            </div>
                                            <div class="col-sm-6 labelConfirm">
                                                <p class="m-0">Confirm password*</p>
                                                <input type="password" placeholder="Make sure password matches" class="password-confirm input col-sm-12" name="passwordConfirm">
                                                <i class="f-12 c-orange hidden errorMatch">Your password doesn't seem to match with the first one.</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex js-center">
                                    <div class="col-md-9 m-t-10 m-b-10">
                                        <p class="m-0 labelEmail">Email address*</p>
                                        <input type="email" name="email" placeholder="Your email address" class="email input col-sm-12" value="<? if(isset($email)) echo $email?>">
                                    </div>
                                </div>
                                <div class="row d-flex js-center">
                                    <div class="col-md-9 m-t-10 m-b-10">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <input type="checkbox" name="termsCheck" id="terms">
                                                <label for="terms" class="terms">I agree with the <a target="_blank" href="/page/terms-of-service" class="regular-link">Terms of service</a> and the <a target="_blank" href="/page/privacy-policy" class="regular-link">Privacy policy</a></label>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-inno pull-right goToStep2">Let's continue!</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row residence <? if(!isset($user)) echo "hidden"?>">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
                        <div class="card card-lg m-t-20 m-b-20 col-sm-12">
                            <div class="card-block m-t-10">
                                <div class="row">
                                    <div class="col-sm-12 p-0">
                                        <p class="f-18 m-l-20 m-b-0 residenceHeader"><? if(isset($user)) echo "Welcome $user->firstname, what is your residence info?"?></p>
                                        <i class="f-11 c-dark-grey m-l-20">This information is needed for other people and teams to identify you to network even better!</i>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row d-flex js-center">
                                    <div class="col-md-9">
                                        <div class="row m-t-20">
                                            <div class="col-sm-6">
                                                <p class="m-0">City*</p>
                                                <input type="text" placeholder="Your city" class="city col-sm-12 input" name="city">
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-0">Postal code*</p>
                                                <input type="text" placeholder="Your postal code" class="postalcode col-sm-12 input" name="postalcode">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex js-center">
                                    <div class="col-md-9 m-t-15">
                                        <select name="country" class="country input col-sm-12">
                                            <option value="default" selected disabled >Your country</option>
                                            <? foreach($countries as $country) { ?>
                                                <option value="<?= $country->id?>"><?= $country->country?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row d-flex js-center">
                                    <div class="col-md-9">
                                        <div class="row m-t-10">
                                            <div class="col-sm-6">
                                                <p class="m-0">Phonenumber</p>
                                                <input type="tel" placeholder="Your phonenumber" class="phonenumber input col-sm-12" name="phonenumber">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex js-center">
                                    <div class="col-md-9 m-t-10 m-b-10">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button class="btn btn-inno pull-right">Let's continue!</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/registerProcess/index.js"></script>
@endsection