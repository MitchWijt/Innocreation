<div class="modal-header d-flex js-center fd-column">
    <h4 class="modal-title text-center c-black" id="modalLabel"><?= $bucketlistItem->title?></h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <textarea class="bucketListDescription input col-sm-12" data-bucketlistitem-id="<?= $bucketlistItem->id?>" rows="10"><?= htmlspecialchars_decode($bucketlistItem->description)?></textarea>
        </div>
    </div>
</div>