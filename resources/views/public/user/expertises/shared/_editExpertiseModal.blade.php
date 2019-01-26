<div class="modal editExpertiseModal fade fade-scale" id="editExpertiseModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-border p-relative">
                <i class="zmdi zmdi-close c-orange f-22 p-absolute" data-dismiss="modal" style="top: 3%; right: 3%; z-index: 1"></i>
                <form action="/user/saveUserExpertise" method="post">
                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                    <input type="hidden" name="user_id" value="<?= $user->id?>">
                    <? if(isset($expertiseLinktable)) { ?>
                        <input type="hidden" name="expertise_id" value="<?= $expertiseLinktable->expertise_id?>">
                    <? } ?>
                    <div class="m-t-20">
                        <? if(!isset($expertiseLinktable)) { ?>
                            <div class="col-sm-12 p-l-20 p-r-20 m-b-20">
                                <p class="m-b-0" for="">Choose from existing expertises</p>
                                <select name="newExpertiseId" class="input m-b-15">
                                    <? foreach($expertises as $expertise) { ?>
                                        <option value="<?= $expertise->id?>"><?= $expertise->title?></option>
                                    <? } ?>
                                </select>
                                <p class="m-t-10">Or</p>
                                <p class="m-b-0">Add a new expertise</p>
                                <i class="c-orange textWarning f-12"></i>
                                <input type="text" class="input p-b-10 col-sm-12" name="newExpertises" id="tokenfield" value=""/>
                            </div>
                        <? } ?>
                        <div class="col-sm-12 p-l-20 p-r-20">
                            <label for="" class="m-b-5">My experience</label>
                            <textarea name="userExpertiseDescription" placeholder="Why are you experienced in this expertise?" class="col-sm-12 input m-b-10" rows="4"><? if(isset($expertiseLinktable) && $expertiseLinktable->description) echo $expertiseLinktable->description?></textarea>
                            <span>Skill level: </span>
                            <select class="input" name="skill_level_id">
                                <? foreach(\App\Services\UserAccount\UserExpertises::skillLevels() as $skill) { ?>
                                    <option <? if(isset($expertiseLinktable) && $expertiseLinktable->skill_level_id == $skill['id']) echo "selected"?> value="<?= $skill['id']?>"><?= ucfirst($skill['level'])?></option>
                                <? } ?>
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <button class="pull-right btn btn-inno btn-sm m-r-5">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#tokenfield')
        .on('tokenfield:createdtoken', function (e) {
            var tokens = $('#tokenfield').tokenfield('getTokens');
            if(tokens.length >= 1){
                $(".textWarning").text("You can add a max. of 1 expertise at the same time");
            }
        })
        .on('tokenfield:removedtoken', function (e) {
            $(".textWarning").text("");
        })
        .tokenfield({
            showAutocompleteOnFocus: true,
            createTokensOnBlur: true,
            limit: 1
        });
</script>