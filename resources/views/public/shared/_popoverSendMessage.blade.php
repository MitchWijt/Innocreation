<div class="row d-flex js-center">
    <form action="/selectChatUser" method="post">
        <input type="hidden" name="_token" value="<?= csrf_token()?>">
        <input type="hidden" name="receiver_user_id" value="<?= $user->id?>">
        <input type="hidden" name="creator_user_id" value="<?= $loggedIn->id?>">
        <button class="btn btn-inno btn-sm">Send chat message</button>
    </form>
</div>
