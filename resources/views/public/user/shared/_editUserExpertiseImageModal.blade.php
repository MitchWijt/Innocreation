<div class="row p-relative">
    <i class="zmdi zmdi-close c-orange f-23 p-absolute closeModal p-20 p-t-0" data-dismiss="modal" style="top: -7px !important; right: 8px;"></i>
    <? foreach($imageObjects as $imagesObject) { ?>
        <div class="col-md-6">
            <div class="card m-t-20 m-b-20 ">
                <div class="card-block userExpImg p-relative c-pointer" style="max-height: 150px !important" data-expertise-id="<?= $expertise->id?>" data-img="<?= $imagesObject->urls->regular?>" data-pn="<?= $imagesObject->user->name?>" data-pl="<?= $imagesObject->user->links->html?>">
                    <div class="p-t-40 p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                        <a class="c-gray f-9 c-pointer photographer" target="_blank"  href="<?= $imagesObject->links->html?>">Photo</a><span class="c-gray f-9"> by </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="<?= $imagesObject->user->links->html?>"><?= $imagesObject->user->name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="https://unsplash.com">Unsplash</a>
                    </div>
                    <div class="p-t-40 p-absolute" style="z-index: 100; top: 45%; left: 50%; transform: translate(-50%, -50%);">
                        <div class="hr-sm"></div>
                    </div>
                    <div class="p-t-40 p-absolute" style="z-index: 99; top: 35%; left: 50%; transform: translate(-50%, -50%);">
                        <p class="c-white f-20"><?= $expertise->title?></p>
                    </div>
                    <div class="overlay">
                        <div class="contentExpertiseUsers" style="background: url('<?= $imagesObject->urls->regular?>');"></div>
                    </div>
                </div>
            </div>
        </div>
    <? } ?>
</div>
