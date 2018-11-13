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
            <input type="hidden" class="totalChosen">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black @mobile f-25 @endmobile">My favorite expertises</h1>
            </div>
            <hr class="p-b-20">
            <? if(count($favoriteExpertisesUser) < 4) { ?>
                <div class="row d-flex js-center p-b-20 @mobile p-20 @endmobile">
                    <div class="card card-lg text-center ">
                        <div class="card-block ">
                            <div class="sub-title-container p-t-20">
                                <h1 class="sub-title-black c-gray">Info</h1>
                            </div>
                            <hr class="p-b-20">
                            <ul class="instructions-list">
                                <li class="instructions-list-item">
                                    <p class="instructions-text m-0 p-b-10 @mobile f-15 @elsedesktop f-19 @endmobile">Choose the expertises that you are interested in</p>
                                </li>
                                <li class="instructions-list-item">
                                    <p class="instructions-text @mobile f-15 @elsedesktop f-19 @endmobile m-0 p-b-10">See daily updated news articles about your expertises</p>
                                </li>
                                <li class="instructions-list-item">
                                    <p class="instructions-text @mobile f-15 @elsedesktop f-19 @endmobile m-0 p-b-10">Keep yourself updated with development around your expertises</p>
                                </li>
                                <li class="instructions-list-item">
                                    <p class="instructions-text @mobile f-15 @elsedesktop f-19 @endmobile m-0 p-b-10">Choose max 4 expertises</p>
                                </li>
                                <li class="instructions-list-item">
                                    <p class="instructions-text @mobile f-15 @elsedesktop f-19 @endmobile m-0 p-b-10">Click to add one</p>
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
                            <div class="card m-t-20 m-b-20">
                                <div class="card expertiseCard p-relative c-pointer" data-url="/" style="max-height: 210px !important">
                                    <form action="/deleteFavoriteExpertisesUser" method="post" class="editFavExpertises">
                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                        <input type="hidden" name="expertise_id" value="<?= $favExpertise->expertise_id?>">
                                        <input type="hidden" name="user_id" value="<?= $favExpertise->user_id?>">
                                        <span class="f-22 deleteCross hidden p-absolute c-orange" style="right: 10px; top: 5px; z-index: 100"><i class="zmdi zmdi-close"></i></span>

                                    </form>
                                    <div class="p-t-40 p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                                        <a class="c-gray f-9 photographer" target="_blank" href="<?= $favExpertise->image_link?>">Photo</a><span class="c-gray f-9"> by </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="<?= $favExpertise->expertises->first()->photographer_link?>"><?= $favExpertise->expertises->first()->photographer_name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="https://unsplash.com">Unsplash</a>
                                    </div>
                                    <a href="/<?= $favExpertise->expertises->first()->slug?>/users" style="z-index: 400;">
                                        <div class="p-t-40 p-absolute" style="z-index: 100; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                            <i class="zmdi zmdi-star c-orange f-40"></i>
                                        </div>
                                        <div class="p-t-40 p-absolute" style="z-index: 100; top: 35%; left: 50%; transform: translate(-50%, -50%);">
                                            <div class="hr-sm"></div>
                                        </div>
                                        <div class="p-t-40 p-absolute" style="z-index: 99; top: 25%; left: 50%; transform: translate(-50%, -50%);">
                                            <p class="c-white @handheld f-15 @elsedesktop f-20 @endhandheld"><?= $favExpertise->expertises->first()->title?></p>
                                        </div>
                                    </a>
                                    <div class="overlay">
                                        <a href="/<?= $favExpertise->expertises->first()->slug?>/users" style="z-index: 400;">
                                            <div class="contentExpertise" style="background: url('<?= $favExpertise->expertises->first()->image?>');"></div>
                                        </a>
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
                                <div class="col-sm-4 ChoosefavExpertisesForm">
                                    <input type="hidden" class="expertise_id" name="expertise_id" value="<?= $expertise->id?>">
                                    <input type="hidden" class="user_id" name="user_id" value="<?= $user->id?>">
                                    <div class="card card-fav m-t-20 m-b-20 p-relative">
                                        <div class="card p-relative c-pointer" data-url="/" style="max-height: 210px !important">
                                            <div class="p-t-40 p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                                                <a class="c-gray f-9 photographer" target="_blank" href="<?= $expertise->image_link?>">Photo</a><span class="c-gray f-9"> by </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="<?= $expertise->photographer_link?>"><?= $expertise->photographer_name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="https://unsplash.com">Unsplash</a>
                                            </div>
                                            <div class="card-fav" data-expertise-id="<?= $expertise->id?>" >
                                                <div class="p-t-40 p-absolute card-fav-" data-expertise-id="<?= $expertise->id?>"  style="z-index: 100; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                    <i class="zmdi zmdi-star checkMark hidden c-orange f-40"></i>
                                                </div>
                                                <div class="p-t-40 p-absolute" style="z-index: 100; top: 35%; left: 50%; transform: translate(-50%, -50%);">
                                                    <div class="hr-sm"></div>
                                                </div>
                                                <div class="p-t-40 p-absolute" style="z-index: 99; top: 25%; left: 50%; transform: translate(-50%, -50%);">
                                                    <p class="c-white @handheld f-15 @elsedesktop f-20 @endhandheld"><?= $expertise->title?></p>
                                                </div>
                                            </div>
                                            <div class="overlay">
                                                <div class="card-fav">
                                                    <div class="contentExpertise" style="background: url('<?= $expertise->image?>');"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <? } else { ?>
                            <div class="col-sm-4 ChoosefavExpertisesForm">
                                <div class="card card-fav m-t-20 m-b-20 p-relative">
                                    <div class="card p-relative c-pointer" data-url="/" style="max-height: 210px !important">
                                        <div class="p-t-40 p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                                            <a class="c-gray f-9 photographer" target="_blank" href="<?= $expertise->image_link?>">Photo</a><span class="c-gray f-9"> by </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="<?= $expertise->photographer_link?>"><?= $expertise->photographer_name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="https://unsplash.com">Unsplash</a>
                                        </div>
                                        <div class="card-fav" data-expertise-id="<?= $expertise->id?>" >
                                            <div class="p-t-40 p-absolute card-fav-" data-expertise-id="<?= $expertise->id?>"  style="z-index: 100; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                <i class="zmdi zmdi-star c-orange f-40"></i>
                                            </div>
                                            <div class="p-t-40 p-absolute" style="z-index: 100; top: 35%; left: 50%; transform: translate(-50%, -50%);">
                                                <div class="hr-sm"></div>
                                            </div>
                                            <div class="p-t-40 p-absolute" style="z-index: 99; top: 25%; left: 50%; transform: translate(-50%, -50%);">
                                                <p class="c-white @handheld f-15 @elsedesktop f-20 @endhandheld"><?= $expertise->title?></p>
                                            </div>
                                        </div>
                                        <div class="overlay">
                                            <div class="card-fav">
                                                <div class="contentExpertise" style="background: url('<?= $expertise->image?>');"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
