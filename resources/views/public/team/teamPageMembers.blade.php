@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.teamPage_sidebar")
        @endnotmobile
        <div class="container">
            @mobile
                @include("includes.teamPage_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Team members</h1>
            </div>
            <hr>
            <div class="m-b-20">
                <div class="row">
                    <div class="col-sm-4 @mobile p-20 @endmobile">
                        <div class="row m-t-20">
                            <div class="card-lg col-md-12">
                                <div class="card-block">
                                    <p class="m-l-10 m-b-5 m-t-5">Invite friends!</p>
                                    <hr class="col-md-11 m-0">
                                    <p class="f-14">Invite members instantly through this link. They will create an account and instantly join your team! Keep in mind the link is only usable for 1 hour per link.</p>
                                    <div class="row m-b-10">
                                        <div class="@handheld col-xs-4 m-b-10 m-l-10 @elsedesktop col-sm-4 @endhandheld">
                                            <? if($team->packageDetails()) { ?>
                                                <? if($team->hasPaid()) { ?>
                                                    <? if($team->packageDetails()->custom_team_package_id == null) { ?>
                                                        <? if($team->packageDetails()->membershipPackage->id == 3) { ?>
                                                            <button type="button" class="btn btn-inno btn-sm generateInviteLink" data-team-id="<?= $team->id?>">Create link</button>
                                                        <? } else if(count($team->getMembers()) >= $team->packageDetails()->membershipPackage->members) { ?>
                                                            <button data-toggle="modal" data-target="#teamLimitNotification" class="btn btn-inno btn-sm m-b-5">Create link</button>
                                                        <? } else { ?>
                                                            <button type="button" class="btn btn-inno btn-sm generateInviteLink" data-team-id="<?= $team->id?>">Create link</button>
                                                        <? } ?>
                                                    <? } else { ?>
                                                        <? if(count($team->getMembers()) >= $team->packageDetails()->customTeamPackage->members && $team->packageDetails()->customTeamPackage->members != "unlimited") { ?>
                                                            <button data-toggle="modal" data-target="#teamLimitNotification" class="btn btn-inno btn-sm m-b-5">Create link</button>
                                                        <? } else { ?>
                                                            <button type="button" class="btn btn-inno btn-sm generateInviteLink" data-team-id="<?= $team->id?>">Create link</button>
                                                        <? } ?>
                                                    <? } ?>
                                                <? } else { ?>
                                                    <button data-toggle="modal" data-target="#teamLimitNotification" class="btn btn-inno btn-sm m-b-5">Create link</button>
                                                <? } ?>
                                            <? } else { ?>
                                                <button type="button" class="btn btn-inno btn-sm generateInviteLink" data-team-id="<?= $team->id?>">Create link</button>
                                            <? } ?>
                                        </div>
                                        <div class="@handheld col-xs-8 m-l-10 @elsedesktop col-sm-8 @endhandheld">
                                            <input type="text" class="input inviteLink">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="fb-share-button" data-href="" data-layout="button"></div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="m-t-5">
                                                        <a class="twitter-share-button hidden" href="">Tweet</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                    <? foreach ($team->getMembers() as $member) { ?>
                        <div class="row d-flex js-center m-t-20 fullMemberCard">
                            <div class="col-md-12">
                                <div class="card-lg text-center member">
                                    <div class="card-block row">
                                        <div class="col-sm-2 m-t-15">
                                            <img class="circleImage circle m-0" src="<?= $member->getProfilePicture()?>" alt="<?=$member->firstname?>">
                                        </div>
                                        <div class="col-sm-4 m-t-20">
                                            <p class="m-t-15"><?= $member->getName()?></p>
                                        </div>
                                        <div class="col-sm-2 m-t-20">
                                            <? if($member->id == $team->ceo_user_id) { ?>
                                                <p class="m-t-15">Team leader</p>
                                            <? } else { ?>
                                                <p class="m-t-15"><?= $member->roles->First()->title;?></p>
                                            <? } ?>
                                        </div>
                                        <div class="col-sm-4 m-t-20">
                                            <div class="d-flex fd-column">
                                                <? if($member->id == $team->ceo_user_id) { ?>
                                                    <? foreach($member->getExpertises() as $memberExpertise) { ?>
                                                        <p class="m-0"><?= $memberExpertise->title?></p>
                                                    <? } ?>
                                                <? } else { ?>
                                                        <p style="margin-top: 17px;"><?= $member->getJoinedExpertise()->expertises->first()->title?></p>
                                                <? } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-t-20 d-flex m-b-20 m-t-10 p-15">
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
            <div class="modal teamLimitNotification fade" id="teamLimitNotification" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body ">
                            <p>Your current team package has reached its max member capacity. If you wanna keep inviting users and make sure users are able to join your team. Than take a look at the available team package upgrades.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/team/teamPageMembers.js"></script>
@endsection