<div class="row p-relative">
    @mobile
    <i class="zmdi zmdi-close f-18 c-orange p-absolute closePopover" style="top: -7px !important; right: 8px!important;"></i>
    @endmobile
    <div class="col-sm-12">
        <? if(isset($user)) { ?>
            <form class="m-b-10" action="/user/sendConnectRequest" method="post">
                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                <input type="hidden" name="receiver_user_id" value="<?= $receiver->id?>">
                <input type="hidden" name="sender_user_id" value="<?= $user->id?>">
                <textarea name="connectMessage" class="col-sm-12 input" rows="5" placeholder="Why do you want to connect with <?= $receiver->firstname?> ?"></textarea>
                <button class="btn btn-inno btn-sm pull-right">Connect</button>
            </form>
        <? } else { ?>
            <p>Login or create an account to connect with fellow innocreatives</p>
        <? } ?>
    </div>
</div>


