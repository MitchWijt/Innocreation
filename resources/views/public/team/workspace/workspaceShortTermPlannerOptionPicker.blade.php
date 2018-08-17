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
            <? if(!$team->packageDetails() || !$team->hasPaid()) { ?>
                <? if($workspaceShortTermPlanners >= 1) { ?>
                    <div class="row d-flex js-center p-b-20">
                        <div class="col-md-8">
                            <div class="card card-lg text-center">
                                <div class="card-block m-t-20">
                                    <p class="m-b-0">We're sorry to say that your team has reached its max planner capacity in your package.</p>
                                    <p class="m-b-0">In order to keep creating more innovative products and create your ideas way quiker.</p>
                                    <p>You can take a look <a class="regular-link" href="/pricing">here</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            <? } else { ?>
                <? if($team->hasPaid()) { ?>
                    <? if($team->packageDetails()->custom_team_package_id == null) { ?>
                    <? if($team->packageDetails()->membershipPackage->id == 3) { ?>
                        {{--//--}}
                        <? } else if($workspaceShortTermPlanners >= $team->packageDetails()->membershipPackage->planners) { ?>
                            <div class="row d-flex js-center p-b-20">
                                <div class="col-md-8">
                                    <div class="card card-lg text-center">
                                        <div class="card-block m-t-20">
                                            <p class="m-b-0">We're sorry to say that your team has reached its max planner capacity in your package.</p>
                                            <p class="m-b-0">In order to keep creating more innovative products and create your ideas way quiker.</p>
                                            <p>You can take a look <a class="regular-link" href="/pricing">here</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <? } else { ?>
                            {{--//--}}
                        <? } ?>
                    <? } else { ?>
                        <? if($workspaceShortTermPlanners >= $team->packageDetails()->customTeamPackage->planners && $team->packageDetails()->customTeamPackage->planners != "unlimited") { ?>
                            <div class="row d-flex js-center p-b-20">
                                <div class="col-md-8">
                                    <div class="card card-lg text-center">
                                        <div class="card-block m-t-20">
                                            <p class="m-b-0">We're sorry to say that your team has reached its max planner capacity in your package.</p>
                                            <p class="m-b-0">In order to keep creating more innovative products and create your ideas way quiker.</p>
                                            <p>You can take a look <a class="regular-link" href="/pricing">here</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <? } else { ?>
                            {{--//--}}
                        <? } ?>
                    <? } ?>
                <? } else { ?>
                    <div class="row d-flex js-center p-b-20">
                        <div class="col-md-8">
                            <div class="card card-lg text-center">
                                <div class="card-block m-t-20">
                                    <p class="m-b-0">We're sorry to say that your team has reached its max planner capacity in your package.</p>
                                    <p class="m-b-0">In order to keep creating more innovative products and create your ideas way quiker.</p>
                                    <p>You can take a look <a class="regular-link" href="/pricing">here</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            <? } ?>
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
                                    <? if(!$team->packageDetails() || !$team->hasPaid()) { ?>
                                        <? if($workspaceShortTermPlanners >= 1) { ?>
                                            <button class="btn btn-inno" disabled>Create <?= $workspaceShortTermPlannerType->title?></button>
                                        <? } else { ?>
                                            <button class="btn btn-inno">Create <?= $workspaceShortTermPlannerType->title?></button>
                                        <? } ?>
                                    <? } else { ?>
                                        <? if($team->hasPaid()) { ?>
                                            <? if($team->packageDetails()->custom_team_package_id == null) { ?>
                                                <? if($team->packageDetails()->membershipPackage->id == 3) { ?>
                                                    <button class="btn btn-inno">Create <?= $workspaceShortTermPlannerType->title?></button>
                                                <? } else if($workspaceShortTermPlanners >= $team->packageDetails()->membershipPackage->planners) { ?>
                                                    <button class="btn btn-inno" disabled>Create <?= $workspaceShortTermPlannerType->title?></button>
                                                <? } else { ?>
                                                    <button class="btn btn-inno">Create <?= $workspaceShortTermPlannerType->title?></button>
                                                <? } ?>
                                            <? } else { ?>
                                                <? if($workspaceShortTermPlanners >= $team->packageDetails()->customTeamPackage->planners && $team->packageDetails()->customTeamPackage->planners != "unlimited") { ?>
                                                    <button class="btn btn-inno" disabled>Create <?= $workspaceShortTermPlannerType->title?></button>
                                                <? } else { ?>
                                                    <button class="btn btn-inno">Create <?= $workspaceShortTermPlannerType->title?></button>
                                                <? } ?>
                                            <? } ?>
                                        <? } else { ?>
                                            <button class="btn btn-inno" disabled>Create <?= $workspaceShortTermPlannerType->title?></button>
                                        <? } ?>
                                    <? } ?>
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