@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh100">
        <div class="container">
            <div class="d-flex js-between">
                <? foreach($topTeams as $topTeam) { ?>
                <div class="card-sm text-center m-t-20 m-b-20">
                    <div class="card-block chat-card d-flex js-around m-t-10">
                        <img class="circle circleImage m-r-0 m-t-20" src="<?=$topTeam->getProfilePicture()?>" alt="">
                        <div class="d-flex fd-column">
                            <p class="f-17 c-orange"><?= $topTeam->team_name?></p>
                            <p>Expertises needed: (later)</p>
                            <p>Members: <?=count($topTeam->getMembers())?></p>
                            <p>Support(later): <?=$topTeam->support?></p>
                            <p>Age: <?=$topTeam->calculateAge()?></p>
                        </div>
                    </div>
                </div>
                <? } ?>
            </div>
            <div class="hr col-sm-12"></div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/teamSearch.js"></script>
@endsection