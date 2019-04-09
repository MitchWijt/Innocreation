<div class="modal privacySettingsModalTeam fade fade-scale" id="privacySettingsModalTeam" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-border <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
            <i class="zmdi zmdi-close c-orange f-22 p-absolute" data-dismiss="modal" style="top: 3%; right: 3%; z-index: 1"></i>
            <form action="/my-team/saveTeamPage" method="post">
                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                <input type="hidden" name="team_id" value="<? if(isset($team)) echo $team->id ?>">
                <div class="form-group m-b-0 row">
                    <div class="col-sm-12 p-30">
                        <div class="row m-t-20">
                            <div class="col-sm-12">
                                <p class="bold">My motivation:</p>
                            </div>
                            <div class="col-sm-12">
                                <textarea class="input btn-block" placeholder="What is your motivation for your passion? What keeps you driven?" name="motivation_team" rows="5"><? if(isset($team->team_motivation)) echo $team->team_motivation ?></textarea>
                            </div>
                        </div>
                        <div class="row m-t-20">
                            <div class="col-sm-12">
                                <p class="m-t-30 bold">My introduction:</p>
                            </div>
                            <div class="col-sm-12">
                                <textarea class="input btn-block" placeholder="Tell us more about yourself, how did you start, who are you?" name="introduction_team" rows="5"><? if(isset($team->team_introduction)) echo $team->team_introduction ?></textarea>
                            </div>
                        </div>
                        <div class="row m-t-20 p-b-20">
                            <div class="col-md-12">
                                <button class="btn btn-inno pull-right">Save team</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>