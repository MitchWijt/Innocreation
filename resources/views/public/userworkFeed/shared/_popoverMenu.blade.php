<div class="row p-relative">
    @mobile
        <i class="zmdi zmdi-close f-18 c-orange p-absolute closePopover" style="top: 5px !important; right: 15px!important; z-index: 10 !important;"></i>
    @endmobile
    <div class="col-sm-12">
        <form class="m-b-10" action="/feed/deleteUserWorkPost" method="post">
            <input type="hidden" name="_token" value="<?= csrf_token()?>">
            <input type="hidden" name="userWorkId" value="<?= $userWork->id?>">
            <button class="btn btn-inno btn-sm">Delete post</button>
        </form>
        <button class="btn btn-inno btn-sm editPostBtn" data-id="<?= $userWork->id?>">Edit post</button>
    </div>
</div>


