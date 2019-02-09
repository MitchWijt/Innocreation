<?php
    if(\Illuminate\Support\Facades\Session::has("user_id")){
        $user = \App\User::select("*")->where("id", \Illuminate\Support\Facades\Session::get("user_id"))->first();
    } else {
        $user = null;
    }
?>
<? if($user !== null && $user->id != $receiver->id) { ?>
    <? if(!$receiver->hasSwitched()) {?>
    <div class="switcher m-t-10 m-r-20">
        <label class="switch switch_type2 m-0" role="switch">
            <input type="checkbox" data-sender-id="<?= $user->id?>" data-receiver-id="<?= $receiver->id?>" class="switch__toggle popoverSwitch">
            <span class="switch__label"></span>
        </label>
        <i class="c-orange hidden connectionSent">Connection request sent</i>
    </div>
    <? } else { ?>
        <? if($receiver->isAcceptedConnection($receiver->id)) { ?>
            <i class="c-orange m-r-20 m-t-15">Connected</i>
        <? } else { ?>
            <i class="c-orange m-r-20 m-t-15">Connection request sent</i>
        <? } ?>
    <? } ?>
<? } ?>