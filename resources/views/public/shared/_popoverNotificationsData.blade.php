<? $array = [];?>
<? foreach($notifications as $notification) { ?>
    <? array_push($array, ['object' => $notification, 'category' => 'notification', 'time' => date("Y-m-d H:i:s",strtotime($notification['time']))]); ?>
<? } ?>
<? foreach($connections as $connection) { ?>
    <? array_push($array, ['object' => $connection, 'category' => 'connection', 'time' => date("Y-m-d H:i:s", strtotime($connection->created_at))]); ?>
<? }
    usort($array, function($a, $b) {
        return ($a['time'] > $b['time']) ? -1 : 1;
    });
?>
<? $counter = 0;?>
<? foreach($array as $item) { ?>
    <?
    $counter++;
    $today = new DateTime(date("Y-m-d H:i:s"));
    $date = new DateTime(date("Y-m-d H:i:s",strtotime($item['time'] . "+1 hour")));
    $interval = $date->diff($today);
    ?>
    <? if ($item['category'] == 'connection') { ?>
            <div class="row p-b-10 notificationHover" style="border-bottom: 1px solid #FF6100 !important">
                <div class="col-2 m-b-5 m-t-15">
                    <div class="avatar-header img m-t-0 p-t-0 m-l-15" style="background: url('<?= $item['object']->sender->getProfilePicture()?>'); border-color: #000 !important"></div>
                </div>
                <div class="col-10 text-center m-t-15">
                    <p class="m-0">New request from <?= $item['object']->sender->firstname?> </p>
                    <label class="switch switch_type2 m-t-0" role="switch">
                        <input type="checkbox" class="switch__toggle acceptConnectionNotification" data-id="<?= $item['object']->id?>">
                        <span class="switch__label"></span>
                    </label>
                </div>
                <form action="/user/acceptConnection" method="post" class="acceptConnection-<?= $item['object']->id?> hidden">
                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                    <input type="hidden" name="connection_id" value="<?= $item['object']->id?>">
                </form>
                <div class="col-12">
                    <div class="pull-right m-r-10">
                        <i class="c-dark-grey f-12 pull-right"><?= \App\Services\GenericService::dateDiffToString($interval)?></i>
                    </div>
                </div>
            </div>
    <? } else if($item['category'] == "notification") { ?>
        <div class="row p-b-10 notificationHover" style="border-bottom: 1px solid #FF6100 !important">
            <div class="col-12 text-center m-t-15">
                <p class="m-l-10"><?= $item['object']['message']?></p>
            </div>
            <div class="col-12">
                <div class="pull-right m-r-10">
                    <i class="c-dark-grey f-12 pull-right"><?= \App\Services\GenericService::dateDiffToString($interval)?></i>
                </div>
            </div>
        </div>
    <? } ?>
<? } ?>
<? if($counter < 1) { ?>
<div class="row d-flex js-center m-t-10">
    <p>No notifications to show</p>
</div>
<? } ?>

