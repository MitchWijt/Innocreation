@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.userAccount_sidebar")
        @endnotmobile
        <div class="container">
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
                                <textarea name="userExpertiseDescription" class="input col-md-12" rows="8"><? if(isset($userExpertises->description)) echo $userExpertises->description?></textarea>
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
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex js-center">
                    <h2 class="modal-title text-center" id="modalLabel">Add your expertise</h2>
                </div>
                <div class="modal-body ">
                    <form action="/my-account/addUserExpertise" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="user_id" value="<?= $user_id?>">
                        <p class="f-19">Expertise: </p>
                        <div class="row">
                            <div class="col-sm-12 text-center m-b-15">
                                <select name="expertise" class="input col-sm-12">
                                    <? foreach($expertises as $expertise) { ?>
                                        <? if(!in_array($expertise->id, $chosenExpertisesArray)) { ?>
                                            <option value="<?= $expertise->id?>"><?= $expertise->title?></option>
                                        <? } ?>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="f-19">Expertise experience: </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <textarea name="expertise_description" placeholder="Write down your experience with this expertise" class="input" cols="76" rows="10"></textarea>
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
@endsection
@section('pagescript')
    <script src="/js/user/userAccountExpertises.js"></script>
@endsection