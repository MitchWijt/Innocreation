<? if($user->isMember() && $user->id == $user->team->ceo_user_id) { ?>
    <? if(isset($membershipPackage) && $membershipPackage->members < count($user->team->getMembers()) && $membershipPackage->members != "unlimited") { ?>
        <div class="modal-body ">
            <div class="row">
                <div class="col-sm-12">
                    <p>You are trying to downgrade to a package with less member capacity than you have at the moment.</p>
                    <p>To pursue this downgrade make sure to have the same amount of members or less than the package.</p>
                </div>
            </div>
        </div>
    <? } else { ?>
        <div class="modal-body ">
            <form action="/checkout/changePackage" method="post">
                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                <input type="hidden" name="team_id" value="<?= $user->team_id?>">
                <? if(isset($membershipPackage)) { ?>
                    <input type="hidden" name="title" value="<?= lcfirst($membershipPackage->title);?>">
                <? } else { ?>
                    <input type="hidden" name="title" value="custom">
                <? } ?>

                <div class="row">
                    <div class="col-sm-12">
                        <? if(isset($membershipPackage)) { ?>
                            <p>You are about to change your package to <?= $membershipPackage->title?></p>
                        <? } else { ?>
                            <p>You are about to change your package to a custom package</p>
                        <? } ?>
                        <? if($user->team->split_the_bill == 1) { ?>
                            <p>You have chosen to split the bill with your team. Because you are going to change the package all your team members need to verify the request again. After everyone has verified the request you will be notified and the package will be changed.</p>
                            <p>Don't want to use split the bill anymore? <br>Change this in your team settings!</p>
                        <? } else { ?>
                            <? if(count($user->team->getMembers()) > 2) { ?>
                                <p>Want to use the split the bill feature? You can change this in your team settings!</p>
                            <? } ?>
                        <? } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <? if(isset($membershipPackage)) { ?>
                            <button type="submit" class="btn btn-inno pull-right">Change package</button>
                        <? } else { ?>
                            <button type="button" class="btn btn-inno pull-right submitCustomForm">Change package</button>
                        <? } ?>
                    </div>
                </div>
            </form>
        </div>
    <? } ?>
<? } else { ?>
    <div class="modal-body ">
        <div class="row">
            <div class="col-sm-12">
                <p>It seems that you are already in a team but you aren't the team leader.</p>
                <p>Only team leaders are able to buy packages for their team. Create your own team to get your own package!</p>
            </div>
        </div>
    </div>
<? } ?>
