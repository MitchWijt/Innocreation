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
                <h1 class="sub-title-black">My favorite expertises</h1>
            </div>
            <div class="hr p-b-20"></div>
            <? if(count($favoriteExpertisesUser) < 4) { ?>
                <div class="row d-flex js-center p-b-20">
                    <div class="card card-lg text-center">
                        <div class="card-block">
                            <div class="sub-title-container p-t-20">
                                <h1 class="sub-title-black c-gray">Info</h1>
                            </div>
                            <div class="hr-card p-b-20"></div>
                            <ul class="instructions-list">
                                <li class="instructions-list-item">
                                    <p class="instructions-text f-19 m-0 p-b-10">Choose the expertises that you are interested in</p>
                                </li>
                                <li class="instructions-list-item">
                                    <p class="instructions-text f-19 m-0 p-b-10">See daily updated news articles about your expertises</p>
                                </li>
                                <li class="instructions-list-item">
                                    <p class="instructions-text f-19 m-0 p-b-10">Keep yourself updated with development around your expertises</p>
                                </li>
                                <li class="instructions-list-item">
                                    <p class="instructions-text f-19 m-0 p-b-10">Choose max 4 expertises</p>
                                </li>
                                <li class="instructions-list-item">
                                    <p class="instructions-text f-19 m-0 p-b-10">Click to add one</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-10 m-b-15">
                        <button class="btn btn-inno pull-right filterFavExpertises">New expertises</button>
                    </div>
                </div>
            <? } else { ?>
                <div class="row p-b-20">
                    <div class="col-sm-12 text-center">
                        <button class="btn btn-sm btn-inno editFavExpertisesBtn">Add/delete expertises</button>
                    </div>
                </div>
            <? } ?>
            <? $counter2 = 0;?>
            <? if(count($favoriteExpertisesUser) >= 4) { ?>
                <? foreach($favoriteExpertisesUser as $favExpertise){ ?>
                <? if($counter2 % 2 == 0 ) { ?>
                    <? if($counter2 == 6) { ?>
                        <div class="row d-flex js-center m-b-20">
                    <? } else { ?>
                        <div class="row d-flex js-center m-b-5">
                    <? } ?>
                <? } ?>
                    <div class="col-sm-4">
                        <div class="card card-final text-center" data-expertise-id="<?= $favExpertise->expertise_id?>" style="position: relative;">
                            <form action="/deleteFavoriteExpertisesUser" method="post" class="editFavExpertises">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <input type="hidden" name="expertise_id" value="<?= $favExpertise->expertise_id?>">
                                <input type="hidden" name="user_id" value="<?= $favExpertise->user_id?>">
                                <span class="f-22 deleteCross hidden" style="position: absolute; left: 10px; top: 5px; color: #FF6100"><i class="zmdi zmdi-close"></i></span>
                            </form>
                            <div class="card-block">
                                <div class="row d-flex js-center">
                                    <div class="col-sm-8">
                                        <p style="margin-top: 140px;" class="border-inno f-22"><?= $favExpertise->expertises->first()->title?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <? if($counter2 % 2 == 1) { ?>
                    </div>
                <? } ?>
                <? $counter2++; } ?>
            <? } else { ?>
                <?
                    $counter = 0;
                    $chosenFavExpertisesArray = [];
                    foreach($favoriteExpertisesUser as $favExpertise){
                        array_push($chosenFavExpertisesArray, $favExpertise->expertise_id);
                    }
                ?>
                <? foreach($expertises as $expertise) { ?>
                <? if($counter % 2 == 0 ) { ?>
                    <? if($counter == 6) { ?>
                        <div class="row d-flex js-center m-b-20">
                    <? } else { ?>
                        <div class="row d-flex js-center m-b-5">
                    <? } ?>
                <? } ?>
                        <? if(!in_array($expertise->id, $chosenFavExpertisesArray)) { ?>
                            <form action="" method="post" class="ajax-form ChoosefavExpertisesForm">
                                <input type="hidden" class="expertise_id" name="expertise_id" value="<?= $expertise->id?>">
                                <input type="hidden" class="user_id" name="user_id" value="<?= $user->id?>">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <div class="col-sm-4">
                                    <div class="card card-square text-center" data-expertise-id="<?= $expertise->id?>" style="position: relative;">
                                        <span style="position: absolute; left: 100px; top: -15px; font-size: 250px; z-index: 1;" class="checkMark hidden"><i class="zmdi zmdi-check"></i></span>
                                        <div class="card-block">
                                            <div class="row d-flex js-center">
                                                <div class="col-sm-8">
                                                    <p style="margin-top: 140px;" class="border-inno f-22"><?= $expertise->title?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <? } else { ?>
                            <form action="" method="post" class="ajax-form ChoosefavExpertisesForm">
                                <div class="col-sm-4">
                                    <div class="card card-chosen text-center" data-expertise-id="<?= $expertise->id?>" style="position: relative;">
                                        <span style="position: absolute; left: 100px; top: -15px; font-size: 250px; z-index: 1;" class="checkMark"><i class="zmdi zmdi-check"></i></span>
                                        <div class="card-block">
                                            <div class="row d-flex js-center">
                                                <div class="col-sm-8">
                                                    <p style="margin-top: 140px;" class="border-inno f-22"><?= $expertise->title?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <? } ?>
                <? if($counter % 2 == 1) { ?>
                    </div>
                <? } ?>
                <? $counter++; } ?>
            <? } ?>
        </div>
    </div>
</div>
@endsection
@section('pagescript')
    <script src="/js/user/favoriteExpertisesUser.js"></script>
@endsection
