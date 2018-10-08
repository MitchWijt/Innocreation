@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.userAccount_sidebar")
        @endnotmobile
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            @mobile
                @include("includes.userAccount_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My expertises</h1>
            </div>
            <div class="hr p-b-20 col-md-10"></div>
            <div class="row p-b-20">
                <div class="col-sm-12 text-center">
                    <button class="btn btn-sm btn-inno" data-toggle="modal" data-target="#myModal">Add expertises</button>
                </div>
            </div>
            <?
                $chosenExpertisesArray = [];
            ?>
            <? foreach($expertises_linktable as $userExpertises) { ?>
                <? array_push($chosenExpertisesArray, $userExpertises->expertises->First()->id)?>
                <div class="expertise" data-expertise-id="<?= $userExpertises->id?>">
                    <div class="row d-flex js-center">
                        <div class="col-md-7">
                            <div class="card text-center">
                                <div class="card-block">
                                    <i class="zmdi zmdi-close pull-right m-r-10 m-t-5 c-orange deleteCross" data-expertise-id="<?= $userExpertises->id?>"></i>
                                    <p class="f-z-rem m-b-5 p-0"><?=$userExpertises->expertises->first()->title?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row m-t-10 d-flex js-center">
                        <div class="col-md-7 hidden formHidden ">
                            <form data-id="<?= $userExpertises->expertises->first()->id?>" action="/saveUserExpertiseDescription" method="post" class="d-flex js-center p-t-20 editUserExpertiseField">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <input type="hidden" name="user_id" value="<?= $userExpertises->users->first()->id?>">
                                <input type="hidden" name="expertise_id" value="<?= $userExpertises->expertises->first()->id?>">
                                <textarea name="userExpertiseDescription" class="input col-md-12 inputExpertise" rows="8"><? if(isset($userExpertises->description)) echo $userExpertises->description?></textarea>
                            </form>
                        </div>
                    </div>

                    <div class="row m-t-10 d-flex js-center">
                        <div class="col-md-7">
                            <div data-id="<?= $userExpertises->expertises->first()->id?>" class="expertise-description">
                                <p class="desc"><?=$userExpertises->description?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 expertiseButtons">
                            <button data-expertise-id="<?= $userExpertises->expertises->first()->id?>" class="btn btn-inno pull-right saveDescriptionBtn m-b-5 hidden">Save experience</button>
                            <button data-expertise-id="<?= $userExpertises->expertises->first()->id?>" class="btn btn-inno pull-right editDescriptionBtn m-b-5">Edit experience</button>
                        </div>
                    </div>
                </div>
            <? } ?>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-flex js-center p-relative">
                            @mobile
                            <i class="zmdi zmdi-close p-absolute c-orange" data-dismiss="modal" style="top: 4px; right: 7px"></i>
                            @endmobile
                            <h2 class="modal-title text-center" id="modalLabel">Add your expertise</h2>
                        </div>
                        <div class="modal-body ">
                            <form action="/my-account/addUserExpertise" method="post">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <input type="hidden" name="user_id" value="<?= $user_id?>">
                                <p class=" m-b-5">Choose existing expertise: </p>
                                <div class="row">
                                    <div class="col-sm-12 text-center m-b-25">
                                        <select name="expertise" class="input col-sm-12">
                                            <option value="" selected disabled>Choose expertise</option>
                                            <? foreach($expertises as $expertise) { ?>
                                                <? if(!in_array($expertise->id, $chosenExpertisesArray)) { ?>
                                                    <option value="<?= $expertise->id?>"><?= $expertise->title?></option>
                                                <? } ?>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <p>Or</p>
                                    </div>
                                </div>
                                <div class="row expertises">
                                    <div class="col-sm-12 m-b-15">
                                        <label class="m-b-0 p-0 col-sm-12">Add a new expertise: </label>
                                        <i class="c-orange textWarning f-12"></i>
                                        <input type="text" class="input p-b-10 col-sm-12" name="newExpertises" id="tokenfield" value=""/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="f-19 m-b-5">Expertise experience: </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <textarea name="expertise_description" placeholder="Write down your experience with this expertise" class="input col-sm-12" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class="btn btn-inno pull-right m-t-10">Add expertise</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#tokenfield')
            .on('tokenfield:createdtoken', function (e) {
                var tokens = $('#tokenfield').tokenfield('getTokens');
                if(tokens.length >= 1){
                    $(".textWarning").text("You can add a max. of 1 expertise at the same time");
                }
            })
            .tokenfield({
            showAutocompleteOnFocus: true,
            createTokensOnBlur: true,
            limit: 1
        });
    </script>
@endsection
@section('pagescript')
    <script src="/js/user/userAccountExpertises.js"></script>
@endsection