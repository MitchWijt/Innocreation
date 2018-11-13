<div class="row p-relative">
    @mobile
    <i class="zmdi zmdi-close f-18 c-orange p-absolute closePopover" style="top: 5px !important; right: 15px!important; z-index: 10 !important;"></i>
    @endmobile
    <div class="d-flex js-center">
        <div class="col-sm-12 o-scroll emojidiv" unselectable="on" onselectstart="return false;" onmousedown="return false;" style="max-height: 80px !important; min-height: 80px !important">
            <? foreach($emojis as $emoji){ ?>
                <span class="p-l-10 m-b-20 c-pointer emojiComment" data-id="<?= $userWorkPost->id?>" data-code="<?= str_replace("U+", "&#x", $emoji->unicode)?>" title="<?= $emoji->description?>"><?= str_replace("U+", "&#x", $emoji->unicode)?></span>
            <? } ?>
        </div>
    </div>
</div>


