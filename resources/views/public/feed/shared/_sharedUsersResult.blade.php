<? if(isset($usersArray)) { ?>
    <div class=" o-scroll" style="min-height: 300px;">
        <? foreach($usersArray as $user) { ?>
            <div class="row m-t-20 searchUserResult">
                <div class="col-sm-1 text-center">
                    <input type="checkbox" class="input m-t-25 selectUser" data-id="<?= $user->id?>">
                </div>
                <div class="col-md-4 text-center p-l-0">
                    <img class="circle circleImage m-0 text-center" src="<?= $user->getProfilePicture()?>" alt="<?= $user->firstname?>">
                    <p class="m-b-0 userName"><?= $user->getName()?></p>
                </div>
            </div>
        <? } ?>
    </div>
<? } ?>
