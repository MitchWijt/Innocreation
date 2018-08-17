<form action="/my-team/saveTeamProduct" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="<?= csrf_token()?>">
    <input type="hidden" name="team_product_id" value="<?= $teamProduct->id?>">
    <div class="row d-flex js-center m-t-10">
        <div class="col-sm-11">
            <p class="m-b-5 m-t-5">Choose your product name:</p>
            <input type="text" name="product_name" value="<?= $teamProduct->title?>" class="input col-sm-5">
        </div>
    </div>
    <div class="row d-flex js-center m-t-20">
        <div class="col-sm-11">
            <p class="m-b-5 m-t-5">Add a picture of your product (optional):</p>
            <? if($teamProduct->image != null) { ?>
                <img src="<?= $teamProduct->getImage()?>" alt="">
            <? } ?>
            <p class="fileNameModal c-dark-grey m-b-5"></p>
            <input type="file" name="product_image" class="hidden uploadImageInputModal">
            <button type="button" class="btn btn-inno btn-sm uploadTeamProductImageModal">Add image</button>
        </div>
    </div>
    <div class="row d-flex js-center m-t-20">
        <div class="col-sm-11">
            <p class="m-b-5 m-t-5">Explain what your product includes and what it is:</p>
            <textarea name="product_description" class="input col-sm-12" rows="5"><?= $teamProduct->description?></textarea>
        </div>
    </div>
    <div class="row d-flex js-center m-b-20">
        <div class="col-sm-11">
            <button class="btn btn-inno pull-right">Save</button>
        </div>
    </div>
</form>
