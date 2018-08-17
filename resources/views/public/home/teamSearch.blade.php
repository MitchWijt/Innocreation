@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100">
        <div class="container">
            <div class="row">
                <?$topTeamArray = [];?>
                <? foreach($topTeams as $topTeam) { ?>
                    <div class="col-md-4 col-xs-12">
                        <? array_push($topTeamArray, $topTeam->id)?>
                        <a class="td-none" href="/team/<?=$topTeam->slug?>">
                            <div class="card-sm text-center m-t-20 m-b-20 @tablet p-10 @endtablet">
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
            </div>
            <form action="/team/searchTeams" method="POST">
                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                <div class="hr col-sm-12"></div>
                <div class="row text-center v-center">
                    <div class="col-md-10 p-r-10">
                        <input type="text" class="input-fat col-sm-12 p-r-5" name="searchTeams" placeholder="Search teams...">
                    </div>
                    <div class="col-md-2 p-l-5">
                        @mobile
                            <button class="btn btn-sm btn-inno searchTeamBtn pull-right m-t-10">Search</button>
                        @elsedesktop
                            <button class="btn btn-lg btn-inno searchTeamBtn btn-block">Search</button>
                        @endmobile
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
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
                    <div class="col-sm-4">
                        <div class="form-group d-flex">
                            <input type="checkbox" name="allTeamsSearch" value="1" class="m-r-10 m-t-5" id="check">
                            <label for="check">Select all teams</label>
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