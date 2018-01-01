@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background">
        @include("includes.userAccount_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My expertises</h1>
            </div>
            <div class="hr p-b-20"></div>
            <? foreach($expertises_linktable as $userExpertises) { ?>
                <div class="row d-flex js-center">
                    <div class="card text-center">
                        <div class="card-block">
                            <p class="f-z-rem m-b-5 p-0"><?=$userExpertises->expertises->first()->title?></p>
                        </div>
                    </div>
                </div>
                <div class="hidden formHidden">
                    <form data-id="<?= $userExpertises->expertises->first()->id?>" action="/saveUserExpertiseDescription" method="post" class="d-flex js-center p-t-20 editUserExpertiseField">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="user_id" value="<?= $userExpertises->users->first()->id?>">
                        <input type="hidden" name="expertise_id" value="<?= $userExpertises->expertises->first()->id?>">
                        <textarea name="userExpertiseDescription" class="input " cols="58" rows="8"><? if(isset($userExpertises->description)) echo $userExpertises->description?></textarea>
                    </form>
                </div>

                <div class="row m-t-10 d-flex js-center">
                    <div data-id="<?= $userExpertises->expertises->first()->id?>" class="expertise-description">
                        <p style="width: 60vh;" class="desc"><?=$userExpertises->description?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-9 expertiseButtons">
                        <button data-expertise-id="<?= $userExpertises->expertises->first()->id?>" class="btn btn-inno pull-right saveDescriptionBtn m-b-5 hidden">Save description</button>
                        <button data-expertise-id="<?= $userExpertises->expertises->first()->id?>" class="btn btn-inno pull-right editDescriptionBtn m-b-5">Edit description</button>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
@endsection