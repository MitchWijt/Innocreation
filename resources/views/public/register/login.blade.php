@extends("layouts.app")
@section("content")
<div class="grey-background" style="min-height: 80vh;">
    <div class="container">
        <div class="sub-title-container p-t-20">
            <h1 class="sub-title-black" id="titleLogin">Login</h1>
        </div>
        <div class="hr"></div>
        <form action="loginUser" method="POST" class="loginForm">
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
                            <p class="m-t-10">Don't have an account? <a class="regular-link" href="#" id="toRegister">Sign up here!</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form action="register" method="POST" class="registerForm hidden">
            <input type="hidden" name="_token" value="<?= csrf_token()?>">
            <div class="form-group d-flex js-center m-b-0 ">
                <div class="d-flex fd-column col-sm-9 m-t-20">
                    <div class="row d-flex js-center">
                        <div class="col-sm-3">
                            <label class="m-0">First name</label>
                            <input type="text" name="firstname" class="firstname input">
                        </div>
                        <div class="col-sm-3">
                            <label class="m-0">Middle name</label>
                            <input type="text" name="middlename" class="middlename input">
                        </div>
                        <div class="col-sm-3">
                            <label class="m-0">Last name</label>
                            <input type="text" name="lastname" class="lastname input">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group m-b-0 d-flex js-center">
                <div class="col-sm-9 m-t-10" style="padding-right: 0;">
                    <div class="row d-flex js-center">
                        <div class="col-sm-9">
                            <label class="m-0 col-sm-12 p-0">Password</label>
                            <input type="password" name="password" class="password input col-sm-12">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group m-b-0 d-flex js-center">
                <div class="col-sm-9 m-t-10" style="padding-right: 0;">
                    <div class="row d-flex js-center">
                        <div class="col-sm-9">
                            <label class="m-0 col-sm-12 p-0">Email</label>
                            <input type="email" name="email" class="email input col-sm-12">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group m-b-0 d-flex js-center">
                <div class="col-sm-9 m-t-10" style="padding-right: 0;">
                    <div class="row d-flex js-center">
                        <div class="col-sm-9">
                            {{--Create like categorie hashtags for it--}}
                            <label class="m-0 col-sm-12 p-0">Expertises</label>
                            <input type="text" name="expertises" class="expertises input col-sm-12">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group d-flex js-center m-b-0 ">
                <div class="d-flex fd-column col-sm-9 m-t-20">
                    <div class="row d-flex js-center">
                        <div class="col-sm-3">
                            <label class="m-0">City</label>
                            <input type="text" name="city" class="city input">
                        </div>
                        <div class="col-sm-3">
                            <label class="m-0">Postcode</label>
                            <input type="text" name="postcode" class="postcode input">
                        </div>
                        <div class="col-sm-3">
                            <label class="m-0">State</label>
                            <input type="text" name="state" class="state input">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group m-b-0 d-flex js-center">
                <div class="col-sm-9 m-t-10" style="padding-right: 0;">
                    <div class="row d-flex js-center">
                        <div class="col-sm-9">
                            <label class="m-0 col-sm-12 p-0">Country</label>
                            <select name="country" class="input col-sm-12">
                            <? foreach($countries as $country) { ?>
                                <option data-country-code="<?= $country->country_code?>" value="<?= $country->country?>"><?= $country->country?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group m-b-0 d-flex js-center">
                <div class="col-sm-9 m-t-10" style="padding-right: 0;">
                    <div class="row d-flex js-center">
                        <div class="col-sm-9">
                            <label class="m-0 col-sm-12 p-0">Phonenumber</label>
                            <input type="text" name="phonenumber" class="phonenumber input col-sm-12">
                            <div class="row m-t-20 ">
                                <div class="col-sm-12">
                                    <button class="btn btn-inno pull-right">Register</button>
                                    <p class="m-t-10">Already have an account? <a class="regular-link" href="#" id="toLogin">Sign in here!</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $("#toRegister").on("click",function () {
        $("#titleLogin").text("Register");
        $(".loginForm").fadeOut();
        $(".registerForm").fadeIn();
    });

    $("#toLogin").on("click",function () {
        $("#titleLogin").text("Login");
        $(".registerForm").fadeOut();
        $(".loginForm").fadeIn();
    });
</script>
@endsection