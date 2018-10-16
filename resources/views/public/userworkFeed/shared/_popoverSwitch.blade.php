<div class="row">
    <div class="col-sm-12">
        <? if(isset($user)) { ?>
            <? if($user->hasContent()) { ?>
                <form class="m-b-10" action="/feed/sendConnectRequest" method="post">
                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                    <input type="hidden" name="user_work_id" value="<?= $userWork->id?>">
                    <input type="hidden" name="receiver_user_id" value="<?= $userWork->user->id?>">
                    <input type="hidden" name="sender_user_id" value="<?= $user->id?>">
                    <textarea name="connectMessage" class="col-sm-12 input" rows="5" placeholder="Why do you want to connect with <?= $userWork->user->firstname?> ?"></textarea>
                    <button class="btn btn-inno btn-sm pull-right">Connect</button>
                </form>
            <? } else { ?>
                <p>It seems that you have not uploaded your portfolio or shared any of your work/stories. To connect please share your work</p>
            <? } ?>
        <? } else { ?>
            <p>Login or create an account to connect with fellow innocreatives</p>
        <? } ?>
    </div>
</div>


