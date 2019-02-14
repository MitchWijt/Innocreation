<div class="modal connectionsModal fade fade-scale" id="connectionsModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered" role="document">
        <div class="modal-content modal-content-border" style='position: absolute !important;'>
            <div class="modal-body modal-body-border-full p-t-0 p-b-0 p-l-0 p-r-0 o-scroll scrollableBody" style="max-height: 500px !important;">
                <? foreach($connections as $connection) { ?>
                    <?
                    if($connection->receiver_user_id == $userId){
                        $user = $connection->sender;
                    } else if($connection->sender_user_id == $userId){
                        $user = $connection->user;
                    }
                    ?>
                    <div class="d-flex js-between divLink c-pointer @desktop hover-animation @enddesktop border-bottom p-r-10 p-l-10" data-src="<?= $user->getUrl()?>" style="will-change: transform !important;">
                        <div class="d-flex js-center m-b-20 m-t-20">
                            <div class="avatar" style="background: url('<?= $user->getProfilePicture()?>'); z-index: 100 !important"></div>
                        </div>
                        <div class="col-4 vertically-center">
                        <div class="o-hidden" style="white-space: nowrap; text-overflow: ellipsis">
                            <span class="m-b-0 f-14"><?= strip_tags($user->getName())?></span>
                        </div>
                        <div class="o-hidden" style="white-space: nowrap; text-overflow: ellipsis">
                            <? if($user->team_id != null) { ?>
                                <span class="regular-link f-12"><i class="zmdi zmdi-accounts-alt f-12 m-t-5 m-r-5 c-black" ></i><a href="<?= $user->team->getUrl()?>" class="regular-link"><?= $user->team->team_name?></a></span>
                            <? } ?>
                        </div>
                        </div>
                        <? if(isset($loggedIn) && !$user->hasSwitched()) { ?>
                            <?= \App\Services\UserConnections\ConnectionService::getSwitch($user->id)?>
                        <? } else { ?>
                            <div class="text-center vertically-center">
                                <span class="c-orange">Connected</span>
                            </div>
                        <? } ?>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
</div>

<script>
    $('.popoverSwitch').popover({ trigger: "click" , html: true, animation:false, placement: 'top'});
</script>