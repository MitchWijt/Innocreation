<div class="row">
    <form action="/user/deleteUserChat" class="btn-block p-b-0 m-b-0" method="post">
        <input type="hidden" name="_token" value="<?= csrf_token()?>">
        <input type="hidden" name="user_chat_id" value="<?= $userChatId?>">
        <button class="btn btn-inno btn-block f-15">Delete chat</button>
    </form>

</div>
<style>
    .popover-body{
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }
</style>