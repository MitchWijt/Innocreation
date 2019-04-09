<div class="modal editExpertiseModal fade fade-scale" id="editExpertiseModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <i class="zmdi zmdi-close c-pointer c-orange f-30" data-dismiss="modal" @desktop style="top: 1%; right: 1%; z-index: 1; position: fixed !important" @elsemobile style="top: 5%; right: 5%; z-index: 1; position: fixed !important" @enddesktop></i>
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-border p-relative">
            <form action="/user/saveUserExpertise" method="post">
                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                <input type="hidden" name="user_id" value="<?= $user->id?>">
                <? if(isset($expertiseLinktable)) { ?>
                    <input type="hidden" name="expertise_id" value="<?= $expertiseLinktable->expertise_id?>">
                <? } ?>
                <div class="m-t-20 <?= \App\Services\UserAccount\UserAccount::getTheme();?>">
                    <? if(!isset($expertiseLinktable)) { ?>
                        <div class="col-sm-12 p-l-20 p-r-20" style="margin-bottom: 80px;">
                            <p class="m-b-5 f-20 bold" for="">Choose from existing expertises</p>
                            <div class="custom-select col-sm-12 country">
                                <select name="newExpertiseId" class="m-b-15">
                                    <option value="" selected disabled >Expertises</option>
                                    <? foreach($expertises as $expertise) { ?>
                                        <option value="<?= $expertise->id?>"><?= $expertise->title?></option>
                                    <? } ?>
                                </select>
                            </div>
                            <p class="m-t-40 text-center">Or</p>
                            <p class="m-b-5 f-20 bold">Add a new expertise</p>
                            <i class="c-orange textWarning f-12"></i>
                            <input type="text" class="input p-b-10 col-sm-12" name="newExpertises" id="tokenfield" value=""/>
                        </div>
                    <? } ?>
                    <div class="col-sm-12 p-l-20 p-r-20">
                        <label for="" class="m-b-5 f-20 bold">My experience</label>
                        <textarea name="userExpertiseDescription" placeholder="Why are you experienced in this expertise?" class="col-sm-12 input m-b-30" rows="4"><? if(isset($expertiseLinktable) && $expertiseLinktable->description) echo $expertiseLinktable->description?></textarea>
                        <p class="m-b-5 f-20 bold">Skill level: </p>
                        <div class="custom-select col-sm-12 country m-b-30">
                            <select name="skill_level_id" class="m-b-15">
                                <option value="" selected disabled >Your skill level</option>
                                <? foreach(\App\Services\UserAccount\UserExpertises::skillLevels() as $skill) { ?>
                                    <option <? if(isset($expertiseLinktable) && $expertiseLinktable->skill_level_id == $skill['id']) echo "selected"?> value="<?= $skill['id']?>"><?= ucfirst($skill['level'])?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 m-t-20">
                        <button class="pull-right btn btn-inno-cta btn-sm m-r-5">Save</button>
                    </div>
                </div>
            </form>
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

    $(document).ready(function () {
        $(".token-input").attr("style", "");

        $(".tokenfield").removeClass("form-control");
        $(".tokenfield").addClass("col-sm-12");

    });

</script>
<script defer async src="/js/home/general.js"></script>