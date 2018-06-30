@extends("layouts.app")
@section("content")
<div class="grey-background" style="min-height: 80vh;">
    <div class="container">
        <div class="sub-title-container p-t-20">
            <h1 class="sub-title-black" id="titleLogin"><? if(isset($urlParameter)) echo "Register"; else echo "Login"?></h1>
        </div>
        <div class="hr col-md-8"></div>
        <? if(count($errors) > 0){ ?>
            <? foreach($errors->all() as $error){ ?>
                <p class="c-orange text-center"><?=$error?></p>
            <? } ?>
        <? } ?>
        <form action="/loginUser" method="POST" class="loginForm <? if(isset($urlParameter)) echo "hidden"?>">
            <input type="hidden" name="_token" value="<?= csrf_token()?>">
            <div class="form-group d-flex js-center m-b-0 p-b-20">
                <div class="d-flex fd-column col-sm-5 m-t-20">
                    <label class="m-0">Email</label>
                    <input type="email" name="email" class="email input">
                    <label class="m-0">Password</label>
                    <input type="password" name="password" class="password input">
                    <div class="row m-t-20">
                        <div class="col-sm-12">
                            <button class="btn btn-inno pull-right">Log in</button>
                            <p class="m-t-10">Don't have an account? <a class="regular-link toRegister" href="#">Sign up here!</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form action="/register" method="POST" class="registerForm m-t-20 <? if(!isset($urlParameter)) echo "hidden"?>">
            <input type="hidden" name="_token" value="<?= csrf_token()?>">
            <div class="form-group d-flex js-center m-b-10">
                <div class="row d-flex js-center col-sm-9">
                    <div class="col-sm-3 @desktop p-l-0 @elsemobile p-0 @enddesktop">
                        <label class="m-0">First name</label>
                        <input type="text" name="firstname" class="firstname input col-sm-12">
                    </div>
                    <div class="col-sm-3 @desktop p-l-0 @elsemobile p-0 @enddesktop">
                        <label class="m-0">Middle name</label>
                        <input type="text" name="middlename" class="middlename input col-sm-12">
                    </div>
                    <div class="col-sm-3 @desktop p-r-0 @elsemobile p-0 @enddesktop">
                        <label class="m-0">Last name</label>
                        <input type="text" name="lastname" class="lastname input col-sm-12">
                    </div>
                </div>
            </div>
            <div class="form-group m-b-10 d-flex js-center">
                <div class="row d-flex js-center col-sm-9">
                    <label class="m-0 col-sm-9 p-0">Password</label>
                    <input type="password" name="password" class="password input col-sm-9">
                </div>
            </div>
            <div class="form-group m-b-10 d-flex js-center">
                <div class="row d-flex js-center col-sm-9">
                    <label class="m-0 col-sm-9 p-0">Email</label>
                    <input type="email" name="email" class="email input col-sm-9">
                </div>
            </div>
            <div class="form-group m-b-10 d-flex js-center p-relative expertises">
                <div class="row d-flex js-center col-sm-9">
                    <label class="m-0 col-sm-9 p-0">Expertises</label>
                    <input type="text" class="input p-b-10 col-sm-9" name="expertises" id="tokenfield" value=""/>
                </div>
            </div>
            <div class="form-group d-flex js-center m-b-10 ">
                <div class="row d-flex js-center col-sm-9">
                    <div class="col-sm-3 @desktop p-l-0 @elsemobile p-0 @enddesktop">
                        <label class="m-0">City</label>
                        <input type="text" name="city" class="city input col-sm-12">
                    </div>
                    <div class="col-sm-3 @desktop p-l-0 @elsemobile p-0 @enddesktop">
                        <label class="m-0">Postcode</label>
                        <input type="text" name="postcode" class="postcode input col-sm-12">
                    </div>
                    <div class="col-sm-3 @desktop p-r-0 @elsemobile p-0 @enddesktop">
                        <label class="m-0">State</label>
                        <input type="text" name="state" class="state input col-sm-12">
                    </div>
                </div>
            </div>
            <div class="form-group m-b-0 d-flex js-center m-b-10">
                <div class="row d-flex js-center col-sm-9">
                    <label class="m-0 col-sm-9 p-0">Country</label>
                    <select name="country" class="input col-sm-9">
                    <? foreach($countries as $country) { ?>
                        <option data-country-code="<?= $country->country_code?>" value="<?= $country->country?>"><?= $country->country?></option>
                        <? } ?>
                    </select>
                </div>
            </div>
            <div class="form-group m-b-0 d-flex js-center">
                <div class="row d-flex js-center col-sm-9">
                    <label class="m-0 col-sm-9 p-0">Phonenumber</label>
                    <input type="text" name="phonenumber" class="phonenumber input col-sm-9">
                </div>
            </div>
            <div class="row m-t-20 d-flex js-center">
                <div class="col-sm-7">
                    <button class="btn btn-inno pull-right">Register</button>
                    <p class="m-t-10">Already have an account? <a class="regular-link toLogin" href="#">Sign in here!</a></p>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $('#tokenfield').tokenfield({
        autocomplete: {
            source: [
                <? foreach($expertises as $expertise) { ?>
                    <? $title = $expertise->title?>
                    <? if(strpos($expertise->title,"-") !== false) {
                        $title = str_replace("-"," ",$title);
                     } ?>
                    <?= "'$title'"?>,
                <? } ?>
            ],
            delay: 100
        },
        showAutocompleteOnFocus: true
    });
</script>
@endsection
@section('pagescript')
    <script src="/js/login.js"></script>
@endsection