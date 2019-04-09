<? foreach($expertise_linktable as $expertise) { ?>
<div class="row p-l-30 p-r-30 m-b-30 m-t-10 expertise-<?= $expertise->id?>">
    <div class="col-xl-3">
        <div class="card">
            <div class="card-block expertiseCard p-relative" style="max-height: 150px !important">
                <div class="p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                    <a class="c-gray f-9 photographer" target="_blank" href="<?= $expertise->image_link?>">Photo</a><span class="c-gray f-9"> by </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="<?= $expertise->photographer_link?>"><?= $expertise->photographer_name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="https://unsplash.com">Unsplash</a>
                </div>
                <? if(isset($loggedIn) && $loggedIn == $user->id) { ?>
                <div class="p-absolute" style="z-index: 200; top: 5px; right: 5px">
                    <i data-expertise-id="<?= $expertise->expertise_id?>" class="zmdi zmdi-camera f-20 editBtn editImage"></i>
                </div>
                <? } ?>
                <div class="overlay">
                    <div class="contentExpertiseUsers" style="background: url('<?= $expertise->image?>');"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-9 m-t-10">
        <div class="d-flex js-between align-start">
            <div class="d-flex align-start">
                <div class="d-flex fd-column" style="min-width: 140px">
                    <h3 class="m-r-10 m-b-0"><?= $expertise->expertises->First()->title?></h3>
                    <i class="c-dark-grey f-12">Skill level: <span style="color: <?= \App\Services\UserAccount\UserExpertises::getSkillLevel($expertise->skill_level_id)['color']?>"><?= ucfirst(\App\Services\UserAccount\UserExpertises::getSkillLevel($expertise->skill_level_id)['level'])?></span></i>
                </div>
                <? if($user->team_id == null) { ?>
                    <? if($loggedIn) { ?>
                        <? if($team) { ?>
                            <? if($team->checkInvite($team->id, $user->id) == false) { ?>
                                <? if(\App\Services\TeamServices\TeamPackage::checkPackageAndPayment($team->id, $expertise)) { ?>
                                    <form action="/my-team/inviteUserForTeam" method="post" class="m-0">
                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                        <input type="hidden" name="invite" value="1">
                                        <input type="hidden" name="team_id" value="<?= $team->id?>">
                                        <input type="hidden" name="expertise_id" value="<?= $expertise->expertise_id?>">
                                        <input type="hidden" name="user_id" value="<?= $user->id?>">
                                        <button class="btn btn-inno btn-sm m-t-10">Invite user to my team</button>
                                    </form>
                                <? } else { ?>
                                    <button class="btn btn-inno btn-sm m-t-10 openTeamLimitModal">Invite user to my team</button>
                                <? } ?>
                            <? } else { ?>
                                <p class="c-orange m-b-0 vertically-center">User invited</p>
                            <? } ?>
                        <? } ?>
                    <? } ?>
                <? } ?>
            </div>
            <? if(isset($loggedIn) && $loggedIn == $user->id) { ?>
                <div style="z-index: 2;">
                    <i class="editBtn zmdi zmdi-edit m-t-15 editExpertise @handheld no-hover @endhandheld" data-expertise-id="<?= $expertise->id?>"></i>
                    <i class="editBtn zmdi zmdi-close m-t-15 removeExpertise @handheld no-hover @endhandheld" data-expertise-id="<?= $expertise->id?>"></i>
                </div>
            <? } ?>
        </div>
        <hr>
        <? if($expertise->description) { ?>
            <p class="wp-pre-wrap"><?= $expertise->description?></p>
        <? } else { ?>
            <i class="c-dark-grey f-12 text-center">No experience given yet</i>
        <? } ?>
    </div>
</div>
<? } ?>