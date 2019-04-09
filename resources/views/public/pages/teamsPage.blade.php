@extends("layouts.app")
@section("content")
    <div class=" grey-background vh100">
        <div class="container">
            <? if(isset($user)) { ?>
                <div class="row">
                    <h3 class="bold f-30 m-b-10 m-t-30">Teams in need of your expertise</h3>
                </div>
                <div class="row">
                    <?= \App\Services\Pages\teamsPageService::getTeamsInNeedOfExpertise($teams, $user)?>
                </div>
            <? } ?>
            <div class="row">
                <h3 class="bold f-30 m-b-10 m-t-30">All teams</h3>
            </div>
            <div class="row">
                <?= \App\Services\Pages\teamsPageService::getAllTeams($teams)?>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/home/teamSearch.js"></script>
    <script defer async src="/js/lazyLoader.js"></script>
@endsection