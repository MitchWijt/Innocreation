@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.workspace_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black"><?= $shortTermPlannerBoard->title?><i class="zmdi zmdi-chevron-down f-20 m-l-10 toggleBoardRename"></i></h1>
            </div>
            <div class="row">
                <div class="col-sm-12 d-flex js-center ">
                    <div class="col-sm-2">
                        <p class="border-default text-center f-13 renameShortTermPlannerBoard btn-inno hidden">Rename board</p>
                    </div>
                </div>
            </div>
            <?
                $dayTimes = [];
                for($i = 1; $i < 13; $i++) {
                    array_push($dayTimes, $i . ":00AM");
                 }
                for($i = 1; $i < 13; $i++) {
                    array_push($dayTimes, $i . ":00PM");
                 }
            ?>
            <hr class="m-b-20">
            <? if($shortTermPlannerBoard->short_term_planner_type == 1) { ?>
                <div class="d-flex fd-row x-scroll p-b-20">
                    <? foreach($dayTimes as $dayTime) { ?>
                        <div class=" col-sm-3">
                            <p class="f-19 text-center"><?=$dayTime?></p>
                            <div class="text-center">
                                <i class="zmdi zmdi-plus f-25 "></i>
                            </div>
                            <? foreach($shortTermPlannerTasks as $shortPlannerTask) { ?>
                                <? if($shortPlannerTask->category == $dayTime) { ?>
                                    <div class="card card-task col-sm-12">
                                        <div class="card-block">
                                            <p class="m-t-10 f-19"><?= $shortPlannerTask->title?></p>
                                            <img class="circle circleSmall" src="<?= $shortPlannerTask->assignedUser->getProfilePicture()?>" alt="<?=$shortPlannerTask->assignedUser->getName()?>">
                                        </div>
                                    </div>
                                <? } ?>
                            <? } ?>
                        </div>
                    <? } ?>
                </div>
            <? } ?>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/workspace/workspaceShortTermPlannerBoard.js"></script>
@endsection