<div class="modal-body">
    <div class="row d-flex js-center p-relative">
        @mobile
            <i class="zmdi zmdi-close c-orange closeModal f-20 p-absolute" style="top: -10px; right: 10px;"></i>
        @endmobile
        <div class="co-sm-12">
            <? if($user->getSinglePortfolio()) { ?>
                <p class="f-22">Best work of <?= $user->firstname?>:</p>
            <? } else { ?>
                <p class="f-22"><?= $user->firstname?>:</p>
            <? } ?>
        </div>
    </div>
    <? if($user->getSinglePortfolio()) { ?>
        <div class="row">
            <div class="col-sm-12 d-flex js-center">
                <? if($user->getSinglePortfolio()->link != null) { ?>
                <a target="_blank" href="https://<?= $user->getSinglePortfolio()->link?>" class="d-flex js-center">
                <? } ?>
                    <img class=" h-100 radius" style="width: 50%;" src="<?=$user->getSinglePortfolio()->getUrl()?>" alt="<?= $user->getSinglePortfolio()->title?>">
                <? if($user->getSinglePortfolio()->link != null) { ?>
                </a>
                <? } ?>
            </div>
        </div>
    <? } else { ?>
    <div class="row">
        <div class="col-sm-12 d-flex js-center">
            <a target="_blank" href="<?= $user->getUrl()?>" class="d-flex js-center">
                <img class="h-100 radius img-responsive" style="width: 50%;" src="<?=$user->getProfilePicture()?>" alt="<?= $user->firstname?>">
            </a>
        </div>
    </div>
    <?  } ?>
    <div class="row d-flex js-center">
        <div class="col-sm-12 d-flex js-center">
            <i class="c-dark-grey f-19">Active as:</i>
        </div>
        <div class="col-sm-12 d-flex js-center">
            <ul class="dashed">
                <? foreach($user->getExpertises() as $expertise) { ?>
                    <li>
                        <i class="f-12"><?= $expertise->title?></i>
                    </li>
                <? } ?>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <p class="m-b-5 f-20" style="border-bottom: 1px solid #FF6100">Introduction:</p>
            <p><?= $user->introduction?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <p class="m-b-5 f-20" style="border-bottom: 1px solid #FF6100">Motivation:</p>
            <p><?= $user->motivation?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <? if(\Illuminate\Support\Facades\Session::has("user_id")) { ?>
                <form action="/selectChatUser" method="post">
                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                    <input type="hidden" name="receiver_user_id" value="<?= $user->id?>">
                    <input type="hidden" name="creator_user_id" value="<?= \Illuminate\Support\Facades\Session::get("user_id")?>">
                    <button class="btn btn-inno pull-right">Send <?= $user->firstname?> a message</button>
                </form>
            <? } else { ?>
                <a class="btn btn-inno pull-right" target="_blank" href="<?= $user->getUrl()?>">Go to <?= $user->firstname?></a>
            <? } ?>
        </div>
    </div>
</div>
