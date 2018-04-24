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
                            <input type="hidden" name="receiver_user_id" value="<?= $user->id?>">
                            <input type="hidden" name="creator_user_id" value="<?= $loggedIn->id?>">
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
                                                <div class="d-flex js-between">
                                                    <p class="f-21 m-0"><?= $expertise->expertises->First()->title?></p>
                                                    <? if($user->team_id == null) { ?>
                                                        <? if($loggedIn) { ?>
                                                            <? if($team) { ?>
                                                                <? if(in_array($expertise->expertise_id, $neededExpertisesArray)) { ?>
                                                                    <? if($team->checkInvite($expertise->expertise_id, $team->id, $user->id) == false) { ?>
                                                                        <form action="/my-team/inviteUserForTeam" method="post">
                                                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                                            <input type="hidden" name="invite" value="1">
                                                                            <input type="hidden" name="team_id" value="<?= $team->id?>">
                                                                            <input type="hidden" name="expertise_id" value="<?= $expertise->expertise_id?>">
                                                                            <input type="hidden" name="user_id" value="<?= $user->id?>">
                                                                            <button class="btn btn-inno btn-sm m-b-5">Invite user to my team</button>
                                                                        </form>
                                                                    <? } else { ?>
                                                                        <p class="c-orange">User invited</p>
                                                                    <? } ?>
                                                                <? } ?>
                                                            <? } ?>
                                                        <? } ?>
                                                    <? } ?>
                                                </div>
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
                                    <div class="portfolio">
                                        <div class="d-flex fd-column">
                                            <div class="row d-flex js-center">
                                                <div class="col-sm-11">
                                                    <div class="d-flex fd-row">
                                                        <img class="circleImage openPortfolioModal c-pointer m-t-10 circle" src="<?= $portfolio->getUrl()?>" alt="<?= $portfolio->title?>">
                                                        <div class="col-sm-11 p-0">
                                                            <p class="f-21 m-0"><?= $portfolio->title?></p>
                                                            <hr>
                                                            <p><?= mb_strimwidth($portfolio->description, 0, 160, "... <span class='c-orange openPortfolioModal underline c-pointer'>read more</span>");?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--===========MODAL=========--}}
                                        <div class="modal fade portfolioModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header d-flex js-center">
                                                        <h4 class="modal-title text-center c-black" id="modalLabel"><?=$portfolio->title?></h4>
                                                    </div>
                                                    <div class="modal-body p-t-0">
                                                        <div class="row modal-header">
                                                            <div class="col-sm-12 d-flex js-center">
                                                                <img class=" h-100 radius" style="width: 50%;" src="<?=$portfolio->getUrl()?>" alt="<?= $portfolio->title?>">
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex js-center">
                                                            <div class="col-sm-9 m-t-20">
                                                                <p class="c-black"><?= $portfolio->description?></p>
                                                            </div>
                                                        </div>
                                                        <? if($portfolio->link != null) { ?>
                                                            <div class="row d-flex js-center">
                                                                <div class="col-sm-9 m-t-20 text-center">
                                                                    <p class="c-black f-18 m-b-0">Check it out here:</p>
                                                                    <? if(strpos($portfolio->link, "https://") !== false) { ?>
                                                                        <a target="_blank" class="regular-link" href="<?=$portfolio->link?>">Demo</a>
                                                                    <? } else { ?>
                                                                        <a target="_blank" class="regular-link" href="https://<?=$portfolio->link?>">Demo</a>
                                                                    <? } ?>
                                                                </div>
                                                            </div>
                                                        <? } ?>
                                                        <? if($loggedIn) { ?>
                                                            <div class="row">
                                                                <div class="col-sm-12 text-center m-t-20">
                                                                    <form action="/selectChatUser" method="post">
                                                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                                        <input type="hidden" name="receiver_user_id" value="<?= $user->id?>">
                                                                        <input type="hidden" name="creator_user_id" value="<?= $loggedIn->id?>">
                                                                        <button class="btn btn-sm btn-inno">Send chat message</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        <? } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--==============--}}
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
@section('pagescript')
    <script src="/js/singleUserPage.js"></script>
@endsection