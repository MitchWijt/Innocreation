<? if(count($teamInvites) > 0) { ?>
    <? foreach($teamInvites as $teamInvite) {
            $today = new DateTime(date("Y-m-d H:i:s"));
            $date = new DateTime(date("Y-m-d H:i:s",strtotime($teamInvite->created_at)));
            $interval = $date->diff($today);
        ?>
        <div class="row p-b-10 notificationHover" style="border-bottom: 1px solid #FF6100 !important">
            <div class="col-2 m-b-5 m-t-15">
                <div class="avatar-header img m-t-0 p-t-0 m-l-15" style="background: url('<?= $teamInvite->teams->getProfilePicture()?>'); border-color: #000 !important"></div>
            </div>
            <div class="col-10 text-center m-t-15">
                <p class="m-0">New invite to join <?= $teamInvite->teams->team_name ?> </p>
                <div class="d-flex js-around m-t-10 m-b-10">
                    <form action="/my-account/acceptTeamInvite" method="post" class="acceptTeamInvite">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="user_id" value="<?= $teamInvite->user_id?>">
                        <input type="hidden" name="expertise_id" value="<?= $teamInvite->expertise_id?>">
                        <input type="hidden" name="team_id" value="<?= $teamInvite->team_id?>">
                        <input type="hidden" name="invite_id" value="<?= $teamInvite->id?>">
                        <button class="btn btn-inno btn-success btn-sm acceptInvite" type="submit">Accept</button>
                    </form>
                    <form action="/my-account/rejectTeamInvite" method="post" class="declineTeamInvite">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="user_id" value="<?= $teamInvite->user_id?>">
                        <input type="hidden" name="expertise_id" value="<?= $teamInvite->expertise_id?>">
                        <input type="hidden" name="team_id" value="<?= $teamInvite->team_id?>">
                        <input type="hidden" name="invite_id" value="<?= $teamInvite->id?>">
                        <button type="submit" class="btn btn-inno btn-danger btn-sm declineInvite">Decline</button>
                    </form>
                </div>
            </div>
            <div class="col-12">
                <div class="pull-right m-r-10">
                    <i class="c-dark-grey f-12 pull-right"><?= \App\Services\GenericService::dateDiffToString($interval)?></i>
                </div>
            </div>
        </div>
    <? } ?>
<? } ?>
<? if(isset($joinRequests)) { ?>
    <? if(count($joinRequests) > 0) { ?>
        <? foreach($joinRequests as $joinRequest) { ?>
            <?
                $today = new DateTime(date("Y-m-d H:i:s"));
                $date = new DateTime(date("Y-m-d H:i:s",strtotime($joinRequest->created_at)));
                $interval = $date->diff($today);
            ?>
            <div class="row p-b-10 notificationHover" style="border-bottom: 1px solid #FF6100 !important">
                <div class="col-2 m-b-5 m-t-15">
                    <div class="avatar-header img m-t-0 p-t-0 m-l-15" style="background: url('<?= $joinRequest->user->getProfilePicture()?>'); border-color: #000 !important"></div>
                </div>
                <div class="col-10 text-center m-t-15">
                    <p class="m-0"><?= $joinRequest->user->firstname ?> Wants to join your team!</p>
                    <div class="d-flex js-around m-t-10 m-b-10">
                        <form action="/my-team/acceptUserInteam" class="acceptUserInTeam" method="post">
                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                            <input type="hidden" name="request_id" value="<?= $joinRequest->id?>">
                            <input type="hidden" name="user_id" value="<?= $joinRequest->user->id?>">
                            <input type="hidden" name="expertise_id" value="<?= $joinRequest->expertise_id?>">
                            <input type="hidden" name="team_id" value="<?= $joinRequest->team_id?>">
                            <button class="btn btn-inno btn-success btn-sm acceptInvite" type="submit">Accept</button>
                        </form>
                        <form action="/my-team/rejectUserFromTeam" class="rejectUserFromTeam" method="post">
                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                            <input type="hidden" name="request_id" value="<?= $joinRequest->id?>">
                            <button type="submit" class="btn btn-inno btn-danger btn-sm declineInvite">Decline</button>
                        </form>
                    </div>
                </div>
                <div class="col-12">
                    <div class="pull-right m-r-10">
                        <i class="c-dark-grey f-12 pull-right"><?= \App\Services\GenericService::dateDiffToString($interval)?></i>
                    </div>
                </div>
            </div>
        <? } ?>
    <? } ?>
<? } ?>
<div class="row m-t-15">
    <div class="col-sm-12 text-center">
        <? if(isset($joinRequests) && count($joinRequests) < 1 && count($teamInvites) < 1) { ?>
            <p>No invites or team join requests</p>
        <? } else if(count($teamInvites) < 1) { ?>
            <p>No open invites at the moment</p>
        <? } ?>
    </div>
</div>

