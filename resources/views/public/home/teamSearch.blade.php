@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100">
        <div class="container">
            <div class="d-flex js-between">
                <?$topTeamArray = [];?>
                <? foreach($topTeams as $topTeam) { ?>
                    <? array_push($topTeamArray, $topTeam->id)?>
                    <a class="td-none" href="/team/<?=$topTeam->team_name?>">
                        <div class="card-sm text-center m-t-20 m-b-20">
                            <div class="card-block d-flex js-around m-t-10">
                                <img class="circle circleImage m-r-0 m-t-20" src="<?=$topTeam->getProfilePicture()?>" alt="">
                                <div class="d-flex fd-column">
                                    <p class="f-17 m-b-0 c-orange"><?= $topTeam->team_name?></p>
                                    <p class="m-b-0">Expertises needed: <?= count($topTeam->getNeededExpertisesWithoutAcception())?></p>
                                    <p class="m-b-0">Members: <?=count($topTeam->getMembers())?></p>
                                    <p class="m-b-0">Support: <?=$topTeam->support?></p>
                                    <p class="m-b-0">Age: <?=$topTeam->calculateAge()?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                <? } ?>
            </div>
            <div class="hr col-sm-12"></div>
            <div class="row">
                <div class="col-sm-12 text-center v-center">
                    <form action="/team/searchTeams" method="POST">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <div class="form-group">
                            <input type="text" class="input-fat col-sm-10" name="searchTeams" placeholder="Search teams...">
                            <button class="btn btn-lg btn-inno searchTeamBtn">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 m-l-40">
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
            </div>
            <? if(isset($searchedTeams)) { ?>
                <span class="searched hidden">1</span>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-flex fd-column">
                            <? foreach($searchedTeams as $searchedTeam) { ?>
                                <? if(!in_array($searchedTeam->id, $topTeamArray)) { ?>
                                    <a class="td-none" href="/team/<?=$searchedTeam->team_name?>">
                                        <div class="col-sm-11 d-flex js-center">
                                            <div class="card  m-t-20 m-b-20">
                                                <div class="card-block d-flex js-around m-t-10">
                                                    <img class="circle circleImage m-r-0 m-t-20" src="<?=$searchedTeam->getProfilePicture()?>" alt="">
                                                    <div class="d-flex fd-column">
                                                        <p class="f-17 m-b-0 c-orange"><?= $searchedTeam->team_name?></p>
                                                        <p class="m-b-0">Expertises needed: <?=count($searchedTeam->getNeededExpertises())?></p>
                                                        <p class="m-b-0">Members: <?=count($searchedTeam->getMembers())?></p>
                                                        <p class="m-b-0">Support: <?=$searchedTeam->support?></p>
                                                        <p class="m-b-0">Age: <?=$searchedTeam->calculateAge()?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <? } ?>
                            <? } ?>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/teamSearch.js"></script>
@endsection