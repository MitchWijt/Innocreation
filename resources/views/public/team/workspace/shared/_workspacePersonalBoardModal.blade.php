<div class="modal-header d-flex js-center fd-column">
    <h4 class="modal-title text-center c-black" id="modalLabel"><?= $shortTermPlannerTask->title?></h4>
</div>
<div class="modal-body">
    <? if($shortTermPlannerTask->checkAssistanceTicketRequest() == false) { ?>
        <small class="c-black m-t-5 assistanceToggleLink pull-left">Trouble with the task? <span class="c-orange regular-link toggleAssistanceForm">Ask a member for assistance!</span></small>
    <? } else { ?>
        <small class="c-black m-t-5 assistanceToggleLink pull-left">You have asked assistance for this task. Check the request <a href="/my-team/workspace/assistance-requests" class="regular-link">here</a></small>
    <? } ?>
    <small class="c-black m-t-5 closeAssistanceForm hidden pull-left"><i class="zmdi zmdi-close c-orange f-20"></i></small>
    <div class="assistanceForm hidden">
        <div class="row">
            <div class="col-sm-12">
                <p class="c-black f-18 m-b-5 pull-left">Ask a member for assistance:</p>
            </div>
        </div>
        <form action="/workspace/askForAssistance" method="post">
            <input type="hidden" name="_token" value="<?= csrf_token()?>">
            <input type="hidden" name="task_id" value="<?= $shortTermPlannerTask->id?>">
            <input type="hidden" name="user_id" value="<?= $user->id?>">
            <input type="hidden" name="team_id" value="<?= $team->id?>">
            <div class="row">
                <div class="col-sm-12 m-t-10">
                    <textarea name="assistance_message" class="input col-sm-12" cols="80" rows="5" placeholder="Your question"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 border-bottom">
                    <button class="text-center m-0 btn-sm btn btn-inno pull-right">Send request</button>
                    <select name="assistanceMembers" class="input m-b-15 m-t-5 pull-right m-r-20">
                        <option value="" selected disabled>Choose member</option>
                        <? foreach($team->getMembers() as $member) { ?>
                        <option value="<?= $member->id?>"><?= $member->getName()?></option>
                        <? } ?>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <? if($shortTermPlannerTask->description != null) { ?>
        <div class="row">
            <div class="col-sm-12 m-t-10" style="text-align: start">
              <?= htmlspecialchars_decode(str_replace("contenteditable", "",$shortTermPlannerTask->description))?>
            </div>
        </div>
    <? } else { ?>
        <div class="row">
            <div class="col-sm-12 m-t-20">
                <i class="c-dark-grey m-t-20">No task description given</i>
            </div>
        </div>
    <? } ?>
</div>