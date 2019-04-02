<div class="modal editNeededExpertiseModal fade fade-scale" id="editNeededExpertiseModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-border <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
            <i class="zmdi zmdi-close c-orange f-22 p-absolute" data-dismiss="modal" style="top: 3%; right: 3%; z-index: 1"></i>
            <form action="/my-team/saveNeededExpertise" method="post">
                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                <input type="hidden" name="team_id" value="<?= $team->id?>">
                <? if(isset($neededExpertise)) { ?>
                    <input type="hidden" name="neededExpertiseId" value="<? if(isset($neededExpertise)) echo $neededExpertise->id ?>">
                <? } ?>
                <div class="form-group m-b-0 row">
                    <div class="col-sm-12 p-30">
                        <div class="row ">
                            <? if(!isset($neededExpertise)) { ?>
                                <div class="col-sm-12">
                                    <p class="bold f-20">Expertise:</p>
                                </div>
                                <div class="col-sm-12">
                                    <div class="custom-select country">
                                        <select name="expertise_id" <? if(isset($neededExpertise)) echo "disabled"?> class="expertise col-sm-12">
                                            <option value="" selected disabled >Expertise</option>
                                            <? foreach($expertises as $expertise) { ?>
                                                <option value="<?= $expertise->id?>"><?= $expertise->title?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                            <? } else { ?>
                                <input type="hidden" name="expertise_id" value="<?= $neededExpertise->expertise_id?>">
                                <div class="col-sm-12">
                                    <p class="bold f-30"><?= $neededExpertise->expertises->First()->title?></p>
                                </div>
                            <? } ?>
                        </div>
                        <div class="row m-t-20">
                            <div class="col-sm-12">
                                <p class="bold f-20 m-t-10">Description:</p>
                            </div>
                            <div class="col-sm-12">
                                <textarea class="input btn-block" placeholder="Overall description of what you seek in a person active in this expertise" name="description_needed_expertise" rows="5"><? if(isset($neededExpertise)) echo $neededExpertise->description ?></textarea>
                            </div>
                        </div>
                        <div class="row m-t-20">
                            <div class="col-sm-12">
                                <p class="m-t-30 bold f-20">Requirements:</p>
                            </div>
                            <div class="col-sm-12">
                                <input type="text" class="input p-b-5 requirements" name="requirements" id="tokenfield" value="<? if(isset($neededExpertise)) echo $neededExpertise->requirements?>"/>
                            </div>
                        </div>
                        <div class="row m-t-20">
                            <div class="col-sm-12">
                                <p class="m-t-30 bold f-20">Amount needed:</p>
                            </div>
                            <div class="col-sm-12">
                                <input type="number" min="1" max="5" class="input p-b-5 amount" name="amount"  value="<? if(isset($neededExpertise)) echo $neededExpertise->amount; else echo 1?>"/>
                            </div>
                        </div>
                        <div class="row m-t-20 p-b-20">
                            <div class="col-md-12">
                                <button class="btn btn-inno pull-right">Save expertise</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script defer async src="/js/home/general.js"></script>
<script>
    $('#tokenfield').tokenfield({
        autocomplete: {
            source: [],
            delay: 100
        },
        showAutocompleteOnFocus: true,
        createTokensOnBlur: true
    });
</script>