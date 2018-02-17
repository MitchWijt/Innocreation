@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background">
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black"><?=$user->getName()?></h1>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <? if(count($errors) > 0){ ?>
                        <? foreach($errors->all() as $error){ ?>
                            <p class="c-orange"><?=$error?></p>
                        <? } ?>
                    <? } ?>
                </div>
            </div>
            <hr class="m-b-20">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <img class="circle circleImgLg m-r-0" src="<?=$user->getProfilePicture()?>" alt="<?=$user->getName()?>">
                </div>
            </div>
            <? if($loggedIn) { ?>
            <div class="row">
                <div class="col-sm-12 text-center m-t-20">
                    <form action="/selectChatUser" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <button class="btn btn-inno">Send chat message</button>
                    </form>
                </div>
            </div>
            <? } ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
                        <div class="card card-lg m-t-20 m-b-20">
                            <div class="card-block m-t-10">
                                <div class="row">
                                    <div class="col-sm-12 m-l-20">
                                        <h3>Who am i?</h3>
                                    </div>
                                </div>
                                <div class="d-flex fd-column">
                                    <div class="row d-flex js-center">
                                        <div class="col-sm-11">
                                            <p class="f-21 m-0">My motivation</p>
                                            <hr>
                                            <p><?=$user->motivation?></p>
                                        </div>
                                    </div>
                                    <div class="row d-flex js-center">
                                        <div class="col-sm-11">
                                            <p class="f-21 m-0">My introduction</p>
                                            <hr>
                                            <p><?=$user->introduction?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
                        <div class="card card-lg m-t-20 m-b-20">
                            <div class="card-block m-t-10">
                                <div class="row">
                                    <div class="col-sm-12 m-l-20">
                                        <h3>My expertises</h3>
                                    </div>
                                </div>
                                <? foreach($expertise_linktable as $expertise) { ?>
                                    <div class="d-flex fd-column">
                                        <div class="row d-flex js-center">
                                            <div class="col-sm-11">
                                                <p class="f-21 m-0"><?= $expertise->expertises->First()->title?></p>
                                                <hr>
                                                <p><?= $expertise->description?></p>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex js-center">
                        <div class="card card-lg m-t-20 m-b-20">
                            <div class="card-block m-t-10">
                                <div class="row">
                                    <div class="col-sm-12 m-l-20">
                                        <h3>My portfolio</h3>
                                    </div>
                                </div>
                                <? foreach($portfolios as $portfolio) { ?>
                                    <div class="d-flex fd-column">
                                        <div class="row d-flex js-center">
                                            <div class="col-sm-11">
                                                <div class="d-flex fd-row">
                                                    <img class="circleImage m-t-10 circle" src="<?= $portfolio->getUrl()?>" alt="<?= $portfolio->title?>">
                                                    <div class="col-sm-11 p-0">
                                                        <p class="f-21 m-0"><?= $portfolio->title?></p>
                                                        <hr>
                                                        <p><?= mb_strimwidth($portfolio->description, 0, 100, "...");?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <? if($user->team_id != null) { ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-flex js-center">
                            <div class="card card-lg m-t-20 m-b-20">
                                <div class="card-block m-t-10">
                                    <div class="row">
                                        <div class="col-sm-12 m-l-20">
                                            <h3>My team - <a href="/team/<?= $user->team->team_name?>" class="regular-link"><?= $user->team->team_name?></a></h3>
                                        </div>
                                    </div>
                                    <div class="d-flex fd-column">
                                        <div class="row d-flex js-center">
                                            <div class="col-sm-11">
                                                <p class="f-21 m-0">Team introduction</p>
                                                <hr>
                                                <p><?= $user->team->team_introduction?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
@endsection