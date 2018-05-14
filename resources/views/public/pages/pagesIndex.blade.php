@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        <? if($page->page_type_id == 1) { ?>
            @include("includes.forum_sidebar")
        <? } ?>
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black"><?= $page->title?></h1>
            </div>
            <? if($page->page_type_id == 1) { ?>
                @include("public.forum.shared._searchbarForum")
            <? } ?>
            <hr class="m-b-0">
            <div class="card m-t-20 m-b-20 col-sm-12" style="width: 100% !important;">
                <div class="card-block m-t-10">
                    <div class="col-sm-12 c-gray" style="color: #C9CCCF !important">
                        <?= htmlspecialchars_decode($page->content)?>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
            </div>
        </div>
    </div>
@endsection