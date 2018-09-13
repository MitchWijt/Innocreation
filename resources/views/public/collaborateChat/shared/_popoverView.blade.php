<div class="row p-relative">
    <div class="col-sm-12">
        <img src="<?= $user->getProfilePicture()?>" alt="<?= $user->firstname?>" class="circle circleSmall m-r-5">
        <span><?= $user->getName()?></span>
    </div>
   @mobile
        <i class="zmdi zmdi-close f-18 c-orange p-absolute closePopover" style="top: 0px !important; right: 15px!important;"></i>
    @endmobile
    <div class="hr-auto o-hidden m-t-10"></div>
</div>
<div class="row">
    <div class="col-sm-12">
        <i class="c-dark-grey f-11">Active as:</i>
        <? foreach($expertises as $expertise) { ?>
            <p class="m-0"><?= $expertise->title?></p>
        <? } ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <a href="<?= $user->getUrl()?>" target="_blank" class="btn btn-inno btn-sm pull-right">To <?= $user->firstname?> <i class="zmdi zmdi-long-arrow-right"></i></a>
    </div>
</div>


