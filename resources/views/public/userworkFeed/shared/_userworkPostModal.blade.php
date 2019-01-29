<div class="modal userWorkPostModal" id="userWorkPostModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-border">
            <i class="zmdi zmdi-close c-orange f-22 p-absolute" data-dismiss="modal" style="top: 3%; right: 3%; z-index: 1"></i>
            <div class="col-sm-12 p-0 d-flex m-l-10 align-start m-t-5 m-b-5">
                    <a href="<?= $userWork->user->getUrl()?>" target="_blank">
                        <div class="avatar-header m-r-10 m-l-10 popoverUser" style="background: url('<?= $userWork->user->getProfilePicture()?>')"></div>
                    </a>
                    <p class="m-b-0 m-t-5"><a href="<?= $userWork->user->getUrl()?>" target="_blank" class="c-black"><?= $userWork->user->getName()?></a></p>
            </div>
            <img src="<?= $userWork->getImage()?>" style="width: 100%">
        </div>
    </div>
</div>