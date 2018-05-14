@extends("layouts.app_admin")
@section("content")
    <div class="d-flex grey-background vh100">
        @include("includes.admin_sidebar")
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <div class="row">
                <div class="card card-lg col-sm-12 m-t-20">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 d-flex js-between">
                                <h4 class="m-t-5"><? if(isset($page)) echo $page->title; else echo "Create new page"?></h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <form action="/admin/savePage" method="post" class="col-sm-12 m-t-20">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <? if(isset($page)) { ?>
                                    <input type="hidden" name="page_id" value="<?= $page->id?>">
                                <? } ?>
                                <p class="m-b-0 f-14 col-sm-3 p-0 m-l-5">Title</p>
                                <input type="text" name="title" class="input col-sm-3" value="<? if(isset($page)) echo $page->title?>">
                                <select name="type" class="input col-sm-3">
                                    <? foreach($pageTypes as $pageType) { ?>
                                        <option <? if(isset($page) && $page->page_type_id == $pageType->id) echo "selected"?> value="<?= $pageType->id?>"><?= $pageType->title?></option>
                                    <? } ?>
                                </select>
                                <div class="m-t-20 m-b-20">
                                    <textarea name="content" class="content col-sm-12 " cols="30" rows="20"><? if(isset($page)) echo $page->content?></textarea>
                                </div>
                                <button class="btn btn-inno pull-right m-b-20">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        tinymce.init({
            selector : "textarea.content"
        });
    </script>
@endsection