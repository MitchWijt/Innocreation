<form action="checkout/saveUserFromCheckout" method="POST" class="m-t-20 <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
    <input type="hidden" name="_token" value="<?= csrf_token()?>">
    <input type="hidden" name="user_id" value="<?= $user->id?>">
    <input type="hidden" name="backlink" value="<?= $backlink?>">
    <div class="form-group d-flex js-center m-b-10">
        <div class="row d-flex js-center col-sm-12">
            <div class="col-sm-6 @desktop p-l-0 @elsemobile p-0 @enddesktop">
                <label class="m-0">First name</label>
                <input type="text" name="firstname" class="firstname input col-sm-12" value="<? if(isset($user->firstname)) echo $user->firstname?>">
            </div>
            <div class="col-sm-6 @desktop p-r-0 @elsemobile p-0 @enddesktop">
                <label class="m-0">Last name</label>
                <input type="text" name="lastname" class="lastname input col-sm-12" value="<? if(isset($user->lastname)) echo $user->lastname?>">
            </div>
        </div>
    </div>
    <div class="form-group m-b-10 d-flex js-center">
        <div class="row d-flex js-center col-sm-12">
            <label class="m-0 col-sm-12 p-0">Email</label>
            <input type="email" name="email" class="email input col-sm-12" value="<? if(isset($user->email)) echo $user->email?>">
        </div>
    </div>
    <div class="form-group m-b-0 d-flex js-center m-b-10">
        <div class="row col-sm-12">
            <label class="m-0  p-0">Country</label>
            <div class="custom-select country">
                <select name="country" class="country">
                    <? foreach($countries as $country) { ?>
                        <option <? if(isset($user->country_id) && $user->country->country == $country->country) echo "selected"?> value="<?= $country->id?>"><?= $country->country?></option>
                    <? } ?>
                </select>
            </div>
        </div>
    </div>
    <? if(isset($user) && $user->team_id == null) { ?>
    <p class="f-25 bold m-t-25 m-b-15">Create your team</p>
    <div class="form-group m-b-10 d-flex js-center">
        <div class="row col-sm-12">
            <label class="m-0 p-0">Team name</label>
            <input type="text" name="team_name" class="team_name input col-sm-12" value="">
        </div>
    </div>
    <? } ?>
    <div class="row m-t-30">
        <div class="m-b-20 col-sm-12 text-right">
            <button class="btn btn-inno">Next step</button>
        </div>
    </div>
</form>