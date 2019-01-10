 <div class="row">
    <div class="col-sm-4">
        <div class="avatar" style="background: url('<?= $receiver->getProfilePicture()?>')"></div>
    </div>
    <div class="col-sm-4 text-center">
        <a class="c-black" target="_blank" href="<?= $receiver->getUrl()?>">
            <p class="m-t-15 m-b-0"><?= $receiver->getName()?></p>
        </a>
        <? if($receiver->active_status != null) { ?>
            <? if($receiver->active_status == "online") { ?>
                <i class="f-12 c-dark-grey">Active now</i>
            <? } else { ?>
                <i class="f-12 c-dark-grey"><?= \App\Services\GenericService::dateDiffToString($interval)?></i>
            <? } ?>
        <? } ?>
    </div>
    <div class="col-sm-4 text-right">
        <i class="zmdi zmdi-chevron-down c-dark-grey f-22 p-r-20 m-t-15 popoverChat" data-toggle="popover" data-content='<?= view("/public/shared/messages/_popoverSingleUserchat", compact("userChatId"))?>'></i>
    </div>
</div>

<script>
    $('.popoverChat').popover({ trigger: "click" , html: true, animation:false, placement: 'bottom'});
</script>