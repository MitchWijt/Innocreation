<div class="<?= \App\Services\UserAccount\UserAccount::getTheme()?>">
    <div class="modal packageFunctionsModel fade fade-scale" id="packageFunctionsModel" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content modal-content-border">
                <div class="row">
                    <div class="col-sm-12 text-center m-t-20">
                        <h3 class="f-40 bold" style="margin-bottom: 40px;">Functions <?= str_replace("-", " ", strtolower($membershipPackage->title))?></h3>
                        <div class="d-flex js-center" style="margin-bottom: 70px;">
                            <div>
                                <? foreach($functions as $function) { ?>
                                    <p class="f-13 text-left"><?= $function?></p>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>