@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @include("includes.teamPage_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">Team members</h1>
            </div>
            <div class="hr"></div>
            <? foreach ($team->getMembers() as $member) { ?>
                <div class="row d-flex js-center m-t-20 fullMemberCard">
                    <div class="card text-center member">
                        <div class="card-block d-flex">
                            <div class="col-sm-12 m-t-15 d-flex">
                                <div class="col-sm-4">
                                    <img class="circleImage circle" src="<?= $member->getProfilePicture()?>" alt="<?=$member->firstname?>">
                                </div>
                                <div class="col-sm-4">
                                    <p class="m-t-15"><?= $member->getName()?></p>
                                </div>
                                <div class="col-sm-4">
                                    <div class="d-flex fd-column">
                                        <? foreach($member->getExpertises() as $memberExpertise) { ?>
                                        <p><?= $memberExpertise->title?></p>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 d-flex m-b-20 m-t-10">
                                <? if($team->ceo_user_id == $user->id) { ?>
                                    <div class="col-sm-6">
                                        <button class="btn btn-inno btn-sm col-sm-12">Go to account</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button class="btn btn-inno btn-sm col-sm-12 kickMember" data-user-id="<?=$member->id?>">Kick member</button>
                                    </div>
                                <? } else { ?>
                                    <div class="col-sm-12">
                                        <button class="btn btn-inno btn-sm col-sm-6">Go to account</button>
                                    </div>
                                <? } ?>
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
                </div>
            <? } ?>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/teamPageMembers.js"></script>
@endsection