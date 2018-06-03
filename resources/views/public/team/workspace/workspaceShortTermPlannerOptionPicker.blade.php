@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.workspace_sidebar")
        @endnotmobile
        <div class="container">
            @mobile
                @include("includes.workspace_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Choose your option</h1>
            </div>
            <hr class="m-b-20">
            <div class="row d-flex js-center p-b-20">
                <? foreach($workspaceShortTermPlannerTypes as $workspaceShortTermPlannerType ) { ?>
                <? $instructions = explode(",",$workspaceShortTermPlannerType->information);
                    $counter = 0;
                ?>
                <? foreach($instructions as $instruction) { ?>
                    <? $counter++?>
                <? } ?>
                    <div class="col-md-4 col-xs-12 m-b-10">
                        <div class="card card-square-sm text-center">
                            <div class="card-block">
                                <p class="f-20 m-t-30"><?= $workspaceShortTermPlannerType->title?></p>
                                <hr>
                                <ul class="instructions-list">
                                    <? for($i = 0; $i < $counter; $i++) { ?>
                                        <li class="instructions-list-item">
                                            <p class="instructions-text f-13 m-0 p-b-10"><?= $instructions[$i]?></p>
                                        </li>
                                    <? } ?>
                                </ul>
                            </div>
                            <div class="text-center m-b-30 col-xs-12">
                                <form action="/workspace/addNewShortTermPlannerBoard" method="post">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <input type="hidden" name="team_id" value="<?= $team->id?>">
                                    <input type="hidden" name="short_term_planner_type" value="<?= $workspaceShortTermPlannerType->id?>">
                                    <button class="btn btn-inno">Create <?= $workspaceShortTermPlannerType->title?></button>
                                </form>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
            <div class="row d-flex js-center p-b-20">
                <div class="col-md-8">
                    <div class="card card-lg text-center">
                        <div class="card-block m-t-20">
                            <ul class="instructions-list">
                                <li class="instructions-list-item">
                                    <p class="instructions-text f-19 m-0 p-b-10">Choose your plan and name it</p>
                                </li>
                                <li class="instructions-list-item">
                                    <p class="instructions-text f-19 m-0 p-b-10">You can create more plans later on</p>
                                </li>
                                <li class="instructions-list-item">
                                    <p class="instructions-text f-19 m-0 p-b-10">Make your team even more efficient</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection