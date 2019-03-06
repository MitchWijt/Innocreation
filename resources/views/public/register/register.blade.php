@extends("layouts.app")
@section("content")
    {{--<div class="banner-expertises"></div>--}}
    <div class="<?= \App\Services\UserAccount\UserAccount::getTheme();?>">
        <div class="grey-background vh100">
            <div class="container <?= \App\Services\UserAccount\UserAccount::getTheme();?>">
                <div class="row d-flex js-center">
                    <div class="col-sm-10 m-t-20">
                        <h1 class="bold text-center">Join Innocreation</h1>
                        <form action="">
                            <div class="row d-flex js-center m-b-20">
                                <div class="col-sm-5">
                                    <label for="" class="m-b-0 labelFirstname">First name</label>
                                    <input type="text" name="firstname" id="" class="input col-sm-12 p-b-5 firstname">
                                </div>
                                <div class="col-sm-5">
                                    <label for="" class="m-b-0 labelLastname">Last name</label>
                                    <input type="text" name="lastname" id="" class="input col-sm-12 p-b-5 lastname">
                                </div>
                            </div>
                            <div class="row d-flex js-center m-b-20">
                                <div class="col-sm-10">
                                    <label for="" class="m-b-0 labelEmail">Email address</label>
                                    <input type="email" name="email" id="" class="input col-sm-12 p-b-5 email">
                                    <span class="existingError c-red f-13"></span>
                                </div>
                            </div>
                            <div class="row d-flex js-center m-b-20">
                                <div class="col-sm-10">
                                    <label for="" class="m-b-0 labelPassword">Password <a class="regular-link" href="">Forgot?</a></label>
                                    <input type="password" name="password" id="" class="input col-sm-12 p-b-5 password">
                                </div>
                            </div>
                            <div class="row d-flex js-center m-b-20">
                                <div class="col-sm-10">
                                    <label for="" class="m-b-0 labelUsername">Username <span class="c-dark-grey f-12">(only letters, numbers, and underscores)</span></label>
                                    <input type="text" name="text" id="" class="input col-sm-12 p-b-5 username">
                                </div>
                            </div>
                            <div class="row d-flex js-center m-b-20">
                                <div class="col-sm-10">
                                    <label for="" class="m-b-0 labelExpertises">Expertises <span class="c-dark-grey f-12">(Type and press enter to add a new expertise)</span></label>
                                    <input type="text" class="input p-b-5 expertises" name="expertises" id="tokenfield" value=""/>
                                </div>
                            </div>
                            <div class="row d-flex js-center m-b-20">
                                <div class="col-sm-10">
                                    <label class="m-b-0 labelCountry">Country</label>
                                    <div class="custom-select col-sm-12 country">
                                        <select name="country" class="country">
                                            <option value="" selected disabled >Your country</option>
                                            <? foreach($countries as $country) { ?>
                                                <option value="<?= $country->id?>"><?= $country->country?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex js-center m-b-20">
                                <div class="col-sm-10">
                                    <button class="btn-inno-cta btn btn-block submitRegisterForm" type="button">Join</button>
                                </div>
                                <span class="f-12 c-gray m-t-20">By joining, you agree to the <a href="/page/terms-of-service" class="regular-link">Terms</a> and <a href="/page/privacy-policy" class="regular-link">Privacy Policy.</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .banner-expertises {
            height: 330px;
            width:100vw;
            background: url('/images/testYep.png');
            background-size: cover !important;
            background-repeat:no-repeat !important;
            background-position:center,center !important;
        }

        .circleExpertise{
            margin: 30px !important;
        }

        .half-circle-img{
            margin: 20px;
            background-size: cover !important;
            background-repeat:no-repeat !important;
            background-position:center,center !important;
            border-top-left-radius: 100px;
            border-top-right-radius: 100px;
            border: 1px solid gray;
            border-bottom: 0;
            position: absolute;

            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .half-circle-text{
            margin: 20px;
            background-color: #fff;
            border-bottom-left-radius: 100px;
            border-bottom-right-radius: 100px;
            border: 1px solid gray;
            border-top: 0;
            position: absolute;

            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
    </style>
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
            showAutocompleteOnFocus: true,
            createTokensOnBlur: true
        });


    </script>
@endsection
@section('pagescript')
    <script src="/js/register/index.js"></script>
@endsection