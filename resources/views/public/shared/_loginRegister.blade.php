<form action="/loginUser" method="POST" class="loginForm <? if(isset($urlParameter)) echo "hidden"?>">
    <input type="hidden" name="_token" value="<?= csrf_token()?>">
    <? if(isset($url)) { ?>
        <input type="hidden" name="redirect_uri" value="<?= $url?>">
        <input type="hidden" name="token" value="<?= $token?>">
    <? } ?>
    <? if($pageType == "checkout") { ?>
        <input type="hidden" name="pageType" value="<?= $pageType?>">
        <input type="hidden" name="backlink" value="<?= $backlink?>">
    <? } ?>
    <div class="form-group d-flex js-center m-b-0 p-b-20">
        <div class="d-flex fd-column <? if($pageType == "clean") echo "col-sm-9"; else echo "col-sm-9"?> m-t-20">
            <label class="m-0">Email</label>
            <input type="email" name="email" class="email input m-b-15">
            <label class="m-0">Password <a href="/password-forgotten" class="regular-link">Forgot?</a></label>
            <input type="password" name="password" class="password input">
            <div class="row m-t-20">
                <div class="col-sm-12">
                    <button class="btn btn-inno pull-right btn-block">Log in</button>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-sm-12">
                    <? if($pageType == "clean") { ?>
                        <p class="m-t-10 m-b-0">Don't have an account? <a class="regular-link toRegister" href="#">Sign up here!</a></p>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
</form>
<form action="/register" method="POST" class="registerForm m-t-20 <? if(!isset($urlParameter)) echo "hidden"?>">
    <input type="hidden" name="_token" value="<?= csrf_token()?>">
    <? if($pageType == "checkout") { ?>
        <input type="hidden" name="pageType" value="<?= $pageType?>">
        <input type="hidden" name="backlink" value="<?= $backlink?>">
    <? } ?>
    <div class="form-group d-flex js-center m-b-10">
        <div class="row d-flex js-center <? if($pageType == "clean") echo "col-sm-9"; else echo "col-sm-12"?>">
            <div class="col-sm-3 @desktop p-l-0 @elsemobile p-0 @enddesktop">
                <label class="m-0">First name *</label>
                <input type="text" name="firstname" placeholder="First name" class="firstname input col-sm-12" value="<? if(isset($user->firstname)) echo $user->firstname?>">
            </div>
            <div class="col-sm-3 @desktop p-l-0 @elsemobile p-0 @enddesktop">
                <label class="m-0">Middle name</label>
                <input type="text" name="middlename" placeholder="Middle name" class="middlename input col-sm-12" value="<? if(isset($user->middlename)) echo $user->middlename?>">
            </div>
            <div class="col-sm-3 @desktop p-r-0 @elsemobile p-0 @enddesktop">
                <label class="m-0">Last name *</label>
                <input type="text" name="lastname" placeholder="Last name   " class="lastname input col-sm-12" value="<? if(isset($user->lastname)) echo $user->lastname?>">
            </div>
        </div>
    </div>
    <? if($pageType != "checkout") { ?>
        <div class="form-group m-b-0 d-flex js-center m-b-10">
            <div class="row d-flex js-center col-sm-9">
                <label class="m-0 col-sm-9 p-0">Gender *</label>
                <select name="gender" class="input col-sm-9">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="private">Private</option>
                </select>
            </div>
        </div>
    <? } ?>
    <? if(!isset($user)) { ?>
        <div class="form-group m-b-10 d-flex js-center">
            <div class="row d-flex js-center col-sm-9">
                <label class="m-0  <? if($pageType == "clean") echo "col-sm-9"; else echo "col-sm-12"?> p-0">Password *</label>
                <input type="password" name="password" placeholder="Create your password" class="password input <? if($pageType == "clean") echo "col-sm-9"; else echo "col-sm-12"?>">
            </div>
        </div>
    <? } ?>
    <div class="form-group m-b-10 d-flex js-center">
        <div class="row d-flex js-center col-sm-9">
            <label class="m-0 <? if($pageType == "clean") echo "col-sm-9"; else echo "col-sm-12"?> p-0">Email *</label>
            <input type="email" name="email" placeholder="E-mail address" class="email input <? if($pageType == "clean") echo "col-sm-9"; else echo "col-sm-12"?>" value="<? if(isset($user->email)) echo $user->email?>">
        </div>
    </div>
    <? if(!isset($user)) { ?>
        <div class="form-group m-b-0 d-flex js-center p-relative expertises">
            <div class="row d-flex js-center col-sm-9">
                <label class="m-0 <? if($pageType == "clean") echo "col-sm-9"; else echo "col-sm-12"?> p-0">Expertises *</label>
                <input type="text" class="input p-b-10 <? if($pageType == "clean") echo "col-sm-9"; else echo "col-sm-12"?>" name="expertises" id="tokenfield" value=""/>
            </div>
        </div>
        <div class="row d-flex js-center m-b-5">
            <div class="col-sm-7 m-t-0 m-l-30">
               <i class="f-11 m-0 c-dark-grey">Type and press enter to add a new expertise</i>
            </div>
        </div>
    <? } ?>
    <div class="form-group d-flex js-center m-b-10 ">
        <div class="row d-flex js-center <? if($pageType == "clean") echo "col-sm-9"; else echo "col-sm-12"?>">
            <div class="col-sm-3 @desktop p-l-0 @elsemobile p-0 @enddesktop">
                <label class="m-0">City *</label>
                <input type="text" name="city" placeholder="Your city" class="city input col-sm-12" value="<? if(isset($user->city)) echo $user->city?>">
            </div>
            <div class="col-sm-3 @desktop p-l-0 @elsemobile p-0 @enddesktop">
                <label class="m-0">Postcode *</label>
                <input type="text" name="postcode" placeholder="Your postal code" class="postcode input col-sm-12" value="<? if(isset($user->postcode)) echo $user->postcode?>">
            </div>
            <div class="col-sm-3 @desktop p-r-0 @elsemobile p-0 @enddesktop">
                <label class="m-0">State</label>
                <input type="text" name="state" placeholder="Your state" class="state input col-sm-12" value="<? if(isset($user->state)) echo $user->state?>">
            </div>
        </div>
    </div>
    <div class="form-group m-b-0 d-flex js-center m-b-10">
        <div class="row d-flex js-center col-sm-9">
            <label class="m-0 <? if($pageType == "clean") echo "col-sm-9"; else echo "col-sm-12"?> p-0">Country *</label>
            <select name="country" class="input <? if($pageType == "clean") echo "col-sm-9"; else echo "col-sm-12"?>">
                <option selected disabled>Which country do you live?</option>
                <? foreach($countries as $country) { ?>
                    <option <? if(isset($user->country) && $user->country == $country->country) echo "selected"?> data-country-code="<?= $country->country_code?>" value="<?= $country->id?>"><?= $country->country?></option>
                <? } ?>
            </select>
        </div>
    </div>
    <div class="form-group m-b-0 d-flex js-center m-b-20">
        <div class="row d-flex js-center col-sm-9">
            <label class="m-0 <? if($pageType == "clean") echo "col-sm-9"; else echo "col-sm-12"?> p-0">Phonenumber</label>
            <input type="text" name="phonenumber" placeholder="Your phonenumber" class="phonenumber input <? if($pageType == "clean") echo "col-sm-9"; else echo "col-sm-12"?>" value="<? if(isset($user->phonenumber)) echo $user->phonenumber?>">
        </div>
    </div>
    <div class="form-group m-b-0 d-flex js-center">
        <div class="col-md-7">
            <div class="row m-l-5">
                <div class="col-xs-1 m-r-10">
                    <input type="checkbox" name="agreeTerms" class="agreeTerms" id="agreeTermOfService">
                </div>
                <div class="col-xs-11">
                    <label class="m-0 p-0 agreeTermsLabel" for="agreeTermOfService">I agree with the <a target="_blank" href="/page/terms-of-service" class="regular-link">terms of service</a> and <a target="_blank" href="/page/privacy-policy" class="regular-link">privacy policy</a></label>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-t-20 d-flex js-center">
        <div class="col-sm-7">
            <button type="button" class="btn btn-inno pull-right submitRegister">Register</button>
            <? if($pageType == "clean") { ?>
                <p class="m-t-10">Already have an account? <a class="regular-link toLogin" href="#">Sign in here!</a></p>
            <? } ?>
        </div>
    </div>
</form>