@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100">
        <div class="container">
            <div class="row">
                {{--<div class="col-sm-12">--}}
                    {{--<div class="d-flex js-between">--}}
                        <?$topTeamArray = [];?>
                        <? foreach($topTeams as $topTeam) { ?>
                            <div class="col-md-4 col-xs-12">
                                <? array_push($topTeamArray, $topTeam->id)?>
                                <a class="td-none" href="/team/<?=$topTeam->slug?>">
                                    <div class="card-sm text-center m-t-20 m-b-20">
                                        <div class="card-block d-flex js-around m-t-10">
                                            <img class="circle circleImage m-r-0 m-t-20" src="<?=$topTeam->getProfilePicture()?>" alt="">
                                            <div class="d-flex fd-column">
                                                <p class="f-17 m-b-0 c-orange"><?= $topTeam->team_name?></p>
                                                <p class="m-b-0">Expertises needed: <?= $topTeam->getAmountNeededExpertises()?></p>
                                                <p class="m-b-0">Members: <?=count($topTeam->getMembers())?></p>
                                                <p class="m-b-0">Support: <?=$topTeam->support?></p>
                                                <p class="m-b-0">Age: <?=$topTeam->calculateAge()?></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <? } ?>
                    {{--</div>--}}
                {{--</div>--}}
            </div>
            <form action="/team/searchTeams" method="POST">
                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                <div class="hr col-sm-12"></div>
                <div class="row">
                    <div class="col-sm-12 text-center v-center">
                        <div class="form-group">
                            <input type="text" class="input-fat col-sm-10" name="searchTeams" placeholder="Search teams...">
                            <button class="btn btn-lg btn-inno searchTeamBtn">Search</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-10">
                        <div class="d-flex js-between">
                                <div class="m-l-40">
                                    <? if($user) { ?>
                                    <? if($user->team_id == null) { ?>
                                        <p>Want your own team? <a class="regular-link" href="/my-account/teamInfo">click here</a></p>
                                    <? } else if($user->team_id != null) { ?>
                                        <p>Want your own team? <a class="regular-link" href="/my-team">click here</a></p>
                                    <? } ?>
                                    <? } else { ?>
                                        <p>Want your own team? <a class="regular-link" href="/login">click here</a></p>
                                    <? } ?>
                                </div>
                            <div class="row m-l-30">
                                <div class="m-l-40 ">
                                    <div class="form-group d-flex pull-right">
                                        <input type="checkbox" name="allTeamsSearch" value="1" class="m-r-10 m-t-5" id="check">
                                        <label for="check">Select all teams</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <? if(isset($searchedTeams)) { ?>
                <span class="searched hidden">1</span>
                <div class="row d-flex js-center">
                    <div class="col-sm-7">
                        <? foreach($searchedTeams as $searchedTeam) { ?>
                            <? if(!in_array($searchedTeam->id, $topTeamArray)) { ?>
                                <a class="td-none col-sm-8 col-xs-12" href="/team/<?=$searchedTeam->slug?>">
                                    <div class="card m-t-20 m-b-20">
                                        <div class="card-block d-flex js-around m-t-10 m-b-10">
                                            <img class="circle circleImage m-r-0 m-t-20" src="<?= $searchedTeam->getProfilePicture()?>" alt="">
                                            <div class="d-flex fd-column">
                                                <p class="f-17 m-b-0 c-orange"><?= $searchedTeam->team_name?></p>
                                                <p class="m-b-0">Expertises needed: <?=count($searchedTeam->getNeededExpertises())?></p>
                                                <p class="m-b-0">Members: <?=count($searchedTeam->getMembers())?></p>
                                                <p class="m-b-0">Support: <?=$searchedTeam->support?></p>
                                                <p class="m-b-0">Age: <?=$searchedTeam->calculateAge()?></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <? } ?>
                        <? } ?>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/home/teamSearch.js"></script>
@endsection