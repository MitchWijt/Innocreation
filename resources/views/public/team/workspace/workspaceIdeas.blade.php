@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.workspace_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black"><?= $team->team_name?> idea's</h1>
            </div>
            <hr class="m-b-20">
            <div class="row d-flex js-center">
                <div class="col-sm-12 text-center m-b-20">
                     <button class="btn btn-inno btn-sm" data-toggle="modal" data-target="#addNewIdeaModal">Add new idea</button>
                </div>
            </div>
            <div class="row d-flex js-center">
                <div class="card card-lg text-center">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 d-flex">
                                <div class="col-sm-4">
                                    <span class="f-13">Title</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="f-13">Creator</span>
                                </div>
                                <div class="col-sm-4">
                                    <span class="f-13">Status</span>
                                </div>
                            </div>
                        </div>
                        <div class="hr-card p-b-20"></div>
                        <? foreach($workplaceIdeas as $workplaceIdea) { ?>
                            <div class="row workplaceIdea">
                                <div class="col-sm-12 d-flex">
                                    <div class="col-sm-4">
                                        <p class="c-pointer ideaToggle" data-idea-id="<?= $workplaceIdea->id?>"><?= $workplaceIdea->title?></p>
                                    </div>
                                    <div class="col-sm-4">
                                        <img class="circle circleSmall m-0" src="<?= $workplaceIdea->users->First()->getProfilePicture()?>" alt="<?= $workplaceIdea->users->First()->firstname?>">
                                    </div>
                                    <div class="col-sm-4">
                                        <? if($user->id == $team->ceo_user_id || $user->role == 1 || $user->role == 4) { ?>
                                                <select class="workplace_idea_status input <? if($workplaceIdea->status == "Passed") echo "border-green"; else if($workplaceIdea->status == "Rejected") echo "border-red"; else echo "border-default";?>" data-idea-id="<?= $workplaceIdea->id?>" name="workplace_idea_status">
                                                <option  <? if($workplaceIdea->status == "Passed") echo "selected"?> data-idea-id="<?= $workplaceIdea->id?>" value="Passed">Passed</option>
                                                <option  <? if($workplaceIdea->status == "On hold") echo "selected"?> data-idea-id="<?= $workplaceIdea->id?>" value="On hold">On hold</option>
                                                <option  <? if($workplaceIdea->status == "Rejected") echo "selected"?> data-idea-id="<?= $workplaceIdea->id?>" value="Rejected">Rejected</option>
                                            </select>
                                        <? } else { ?>
                                            <? if($workplaceIdea->status == "On hold") { ?>
                                                <p class="c-orange"><?= $workplaceIdea->status?></p>
                                            <? } else if($workplaceIdea->status == "Passed") { ?>
                                                <p class="c-green"><?= $workplaceIdea->status?></p>
                                            <? } else { ?>
                                                <p class="c-red"><?= $workplaceIdea->status?></p>
                                            <? } ?>
                                        <? } ?>
                                    </div>
                                </div>
                                <div class="modal fade ideaDetailsModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-idea-id="<?= $workplaceIdea->id?>">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex js-center">
                                                <h4 class="modal-title text-center c-black" id="modalLabel"><?= $workplaceIdea->title?></h4>
                                            </div>
                                            <div class="modal-body ">
                                                <p class="c-black"><?= $workplaceIdea->description?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addNewIdeaModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex js-center">
                    <h4 class="modal-title text-center" style="font-weight: 300" id="modalLabel">Add new idea</h4>
                </div>
                <div class="modal-body ">
                    <form action="/workspace/addNewIdea" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="team_id" value="<?= $team->id?>">
                        <input type="hidden" name="creator_user_id" value="<?= $user->id?>">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="m-b-0">Title</p>
                                <input class="input" type="text" name="workspace_idea_title" placeholder="Idea title">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="m-b-0">Description</p>
                                <textarea name="workspace_idea_description" placeholder="Write your idea description" class="input" cols="50" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 m-t-10">
                                <button class="btn btn-inno pull-right">Add idea</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/workspaceIdeas.js"></script>
@endsection