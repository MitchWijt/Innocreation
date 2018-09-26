<div class="modal-body">
    <div class="row d-flex js-center">
        <div class="co-sm-12">
            <p class="f-22">Best work of <?= $user->firstname?>:</p>
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
    <? } ?>
    <div class="row d-flex js-center">
        <div class="col-sm-12 d-flex js-center">
            <i class="c-dark-grey f-19">Active as:</i>
        </div>
        <? foreach($user->getExpertises() as $expertise) { ?>
            <div class="col-sm-12 d-flex js-center">
                <i class="f-12">- <?= $expertise->title?></i>
            </div>
        <? } ?>
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
</div>
