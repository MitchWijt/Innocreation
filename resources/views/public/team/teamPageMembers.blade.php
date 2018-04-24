@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.teamPage_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Team members</h1>
            </div>
            <hr>
            <div class="m-b-20">
                <? foreach ($team->getMembers() as $member) { ?>
                    <div class="row d-flex js-center m-t-20 fullMemberCard">
                        <div class="card-lg text-center member">
                            <div class="card-block d-flex">
                                <div class="col-sm-12 m-t-15 d-flex">
                                    <div class="col-sm-2">
                                        <img class="circleImage circle" src="<?= $member->getProfilePicture()?>" alt="<?=$member->firstname?>">
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="m-t-15"><?= $member->getName()?></p>
                                    </div>
                                    <div class="col-sm-2">
                                        <? if($member->id == $team->ceo_user_id) { ?>
                                            <p class="m-t-15">CEO</p>
                                        <? } else { ?>
                                            <p class="m-t-15"><?= $member->roles->First()->title;?></p>
                                        <? } ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="d-flex fd-column">
                                            <? if($member->id == $team->ceo_user_id) { ?>
                                                <? foreach($member->getExpertises() as $memberExpertise) { ?>
                                                    <p><?= $memberExpertise->title?></p>
                                                <? } ?>
                                            <? } else { ?>
                                                    <p style="margin-top: 17px;"><?= $member->getJoinedExpertise()->expertises->first()->title?></p>
                                            <? } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-sm-12 d-flex m-b-20 m-t-10">
                                    <? if($team->ceo_user_id == $user->id || $user->role == 1) { ?>
                                        <? if($member->id != $team->ceo_user_id) { ?>
                                            <div class="col-sm-4">
                                                <a href="<?= $member->getUrl()?>" target="_blank" class="btn btn-inno btn-sm col-sm-12">Go to account</a>
                                            </div>
                                            <div class="col-sm-4">
                                                <button class="btn btn-inno btn-sm col-sm-12 kickMember" data-user-id="<?=$member->id?>">Kick member</button>
                                            </div>
                                            <div class="col-sm-4">
                                                <? if($member->muted == null || $member->muted <= date("Y-m-d H:i:s")) { ?>
                                                    <button class="btn btn-inno btn-sm col-sm-12 muteMember" data-user-id="<?=$member->id?>"><i class="zmdi zmdi-volume-off"></i> Mute from team chat</button>
                                                <? } else { ?>
                                                    <form action="/my-team/unmuteMemberFromTeamChat" method="post">
                                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                        <input type="hidden" name="user_id" value="<?=$member->id?>">
                                                        <button class="btn btn-inno btn-sm col-sm-12"><i class="zmdi zmdi-volume-up"></i> Unmute</button>
                                                    </form>
                                                <? } ?>
                                            </div>
                                        <? } else { ?>
                                            <div class="col-sm-12">
                                                <a href="<?= $member->getUrl()?>" target="_blank" class="btn btn-inno btn-sm col-sm-6">Go to account</a>
                                            </div>
                                        <? } ?>
                                    <? } else { ?>
                                        <div class="col-sm-12">
                                            <a href="<?= $member->getUrl()?>" target="_blank" class="btn btn-inno btn-sm col-sm-6">Go to account</a>
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                           <? if($team->ceo_user_id == $user->id || $user->role == 1) { ?>
                                <? if($member->id != $team->ceo_user_id) { ?>
                                    <div class="row">
                                        <div class="col-sm-12 d-flex m-b-20 m-t-10">
                                            <div class="col-sm-4">
                                                <button class="btn btn-inno btn-sm col-sm-12 editMemberPermission" data-user-id="<?=$member->id?>">Edit member permissions</button>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            <? } ?>
                        </div>

                        <div class="modal fade editMemberPermissionsModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-user-id="<?=$member->id?>">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header d-flex js-center">
                                        <h4 class="modal-title text-center" id="modalLabel">Edit permissions <?= $member->getName()?></h4>
                                    </div>
                                    <div class="modal-body ">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h5>Team admin:</h5>
                                                <ul class="instructions-list">
                                                    <li class="instructions-list-item">
                                                        <p class="instructions-text c-black f-15 m-0 p-b-10">All permission of moderator</p>
                                                    </li>
                                                    <li class="instructions-list-item">
                                                        <p class="instructions-text c-black f-15 m-0 p-b-10">Permission to add board in workplace</p>
                                                    </li>
                                                    <li class="instructions-list-item">
                                                        <p class="instructions-text c-black f-15 m-0 p-b-10">Permission to post newsletters</p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h5>Team moderator:</h5>
                                                <ul class="instructions-list">
                                                    <li class="instructions-list-item">
                                                        <p class="instructions-text c-black f-15 m-0 p-b-10">Permission to change team credentials</p>
                                                    </li>
                                                    <li class="instructions-list-item">
                                                        <p class="instructions-text c-black f-15 m-0 p-b-10">Permission to change needed expertises</p>
                                                    </li>
                                                    <li class="instructions-list-item">
                                                        <p class="instructions-text c-black f-15 m-0 p-b-10">Permission to create form posts</p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <form action="/my-team/editMemberPermissions" method="post">
                                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                    <input type="hidden" name="user_id" value="<?=$member->id?>">
                                                    <select name="teamRole" class="input">
                                                        <? foreach($teamRoles as $teamRole) { ?>
                                                            <option value="<?= $teamRole->id?>"><?= str_replace("_"," ",$teamRole->title)?></option>
                                                        <? } ?>
                                                    </select>
                                                    <div class="row">
                                                        <div class="col-sm-12 m-t-20">
                                                            <button class="btn btn-inno pull-right">Save</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade kickMemberModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-user-id="<?=$member->id?>">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header d-flex js-center">
                                        <h4 class="modal-title text-center" id="modalLabel">Kick <?= $member->getName()?></h4>
                                    </div>
                                    <div class="modal-body ">
                                        <form action="/my-team/kickMemberFromTeam" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="user_id" value="<?= $member->id?>">
                                            <input type="hidden" name="team_id" value="<?= $team->id?>">
                                            <? if($member->id != $team->ceo_user_id) { ?>
                                                <input type="hidden" name="joined_expertise_id" value="<?=$member->getJoinedExpertise()->expertise_id?>">
                                            <? } ?>
                                            <div class="row">
                                                <div class="col-sm-12 text-center">
                                                    <p class="pull-left">Reason for kick</p>
                                                    <textarea name="kickMessage" class="input" cols="50" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-inno pull-right m-t-10">Kick <?= $member->getName()?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade muteMemberModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-user-id="<?=$member->id?>">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header d-flex js-center">
                                        <h4 class="modal-title text-center" id="modalLabel">Mute <?= $member->getName()?></h4>
                                    </div>
                                    <div class="modal-body ">
                                        <form action="/my-team/muteMemberFromTeamChat" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="user_id" value="<?= $member->id?>">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <p class="pull-left f-18">Duration mute:</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-5 d-flex fd-row">
                                                    <span class="m-r-10">Hours:</span>
                                                    <div class="row">
                                                        <div class="col-sm-12 d-flex ">
                                                            <input type="number" name="hours" max="24" min="1" class="input" value="1">
                                                        </div>
                                                    </div>
                                                    <span class="m-l-10 m-r-10">Minutes:</span>
                                                    <div class="row">
                                                        <div class="col-sm-12 d-flex ">
                                                            <input type="number" name="minutes" max="59" min="1" class="input" value="1">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-inno pull-right m-t-10">Mute <?= $member->getName()?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/team/teamPageMembers.js"></script>
@endsection