@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.workspace_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black"><?= $team->team_name?> bucketlist</h1>
            </div>
            <hr class="m-b-20">
            <div class="row d-flex js-center">
                <div class="col-sm-12 text-center m-b-20">
                    <? if($user->id == $team->ceo_user_id || $user->role == 1 || $user->role == 4) { ?>
                        <button class="btn btn-inno btn-sm addNewBucketlistBoard">Add bucketlist board</button>
                    <? } ?>
                    <button class="btn btn-inno btn-sm" data-toggle="modal" data-target="#addNewGoalModal">Add new goal</button>
                </div>
            </div>
            <div class="newBoard hidden">
                <div class="row d-flex js-center m-t-20 bucketlistBoard ">
                    <div class="card card-lg">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12 m-t-10 m-l-10 m-b-10">
                                    <input data-team-id="<?= $team->id?>" type="text" name="bucketlistType_title" class="input bucketlistType_title">
                                    <p class="m-l-10 m-t-10 f-18 hidden newBoardTitle"></p>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-sm-12 d-flex">
                                    <div class="col-sm-4">
                                        <span class="f-13">Title</span>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="f-13">Description</span>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="f-13">Completed</span>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-card p-b-20"></div>
                            <div class="row text-center">
                                <div class="col-sm-12 d-flex">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="allBucketlistBoards m-b-20">
                <? foreach($workspaceBucketlistTypes as $workspaceBucketlistType) { ?>
                    <div class="row d-flex js-center m-t-20 bucketlistBoard" data-bucketlist-type-id="<?= $workspaceBucketlistType->id?>">
                        <div class="card card-lg">
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input data-bucketlist-type-id="<?= $workspaceBucketlistType->id?>" type="text" name="bucketlistType_title" class="input rename_bucketlistType_title m-t-10 m-l-10 hidden">
                                        <p class="m-l-10 m-t-10 f-18 m-b-10 boardTitle"><?= $workspaceBucketlistType->name?><i class="m-l-10 zmdi zmdi-chevron-down openBoardMenu "></i></p>
                                    </div>
                                </div>
                                <div class="col-sm-2 text-center bucketlistBoardMenu hidden f-12">
                                    <p class="bcg-black border-default border-bottom-none m-b-0 deleteBucketlistBoard menu-item" data-bucketlist-type-id="<?= $workspaceBucketlistType->id?>">Delete board</p>
                                    <p class="bcg-black border-default renameBucketlistBoard menu-item" data-bucketlist-type-id="<?= $workspaceBucketlistType->id?>">Rename board</p>
                                </div>
                                <div class="row text-center">
                                    <div class="col-sm-12 d-flex">
                                        <div class="col-sm-4">
                                            <span class="f-13">Title</span>
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="f-13">Description</span>
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="f-13">Completed</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-card p-b-20"></div>
                                <div id="div" ondrop="drop(event)"  ondragover="allowDrop(event)" class="p-b-20">
                                    <? foreach($workspaceBucketlistType->getWorkspaceBucketlist($team->id) as $workspaceBucketlist) { ?>
                                        <div class="row text-center" id="drag<?=$workspaceBucketlist->id?>" draggable="true" ondragstart="drag(event)">
                                            <div class="col-sm-12 d-flex">
                                                <div class="col-sm-4">
                                                    <p><?= $workspaceBucketlist->title?></p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p><?= $workspaceBucketlist->description?></p>
                                                </div>
                                                <div class="col-sm-4 d-flex js-center">
                                                    <? if($workspaceBucketlist->completed == 0) { ?>
                                                        <p class="circle circleSmall m-0 completeBucketlistGoal" data-bucketlist-id="<?= $workspaceBucketlist->id?>"><i class="zmdi zmdi-check"></i></p>
                                                    <? } else { ?>
                                                        <p class="circle circleSmall m-0 completeBucketlistGoal c-black" style="background: #FF6100" data-bucketlist-id="<?= $workspaceBucketlist->id?>"><i class="zmdi zmdi-check"></i></p>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addNewGoalModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex js-center">
                    <h4 class="modal-title text-center" style="font-weight: 300" id="modalLabel">Add new bucketlist goal</h4>
                </div>
                <div class="modal-body ">
                    <form action="/workspace/addNewBucketlistGoal" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="team_id" value="<?= $team->id?>">
                        <div class="row">
                            <div class="col-sm-12 m-b-15">
                                <p class="m-b-0">Goal title: </p>
                                <input class="input" type="text" name="goal_title" placeholder="Goal title">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 m-b-10">
                                <p class="m-b-0">Goal description: </p>
                                <textarea name="goal_description" placeholder="Write down your goal description" class="input" cols="50" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="m-b-0">Bucketlist place: </p>
                                <select name="bucketlist_type" class="input">
                                    <?foreach($workspaceBucketlistTypes as $workspaceBucketlistType) { ?>
                                        <option value="<?= $workspaceBucketlistType->id?>"><?= $workspaceBucketlistType->name?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 m-t-10">
                                <button class="btn btn-inno pull-right">Add new goal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/workspaceBucketlist.js"></script>
@endsection