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
                                <h4 class="m-t-5"><? if(isset($faq)) echo $faq->question; else echo "Create new faq"?></h4>
                                <? if(isset($faq)) { ?>
                                    <div class="buttons d-flex">
                                        <form action="/admin/deleteFaq" method="post" class="deleteFaqForm">
                                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                            <input type="hidden" name="faq_id" value="<?= $faq->id?>">
                                            <button class="btn btn-inno m-t-5 m-b-10 m-r-10 deleteFaqBtn" type="button">Delete <i class="zmdi zmdi-delete"></i></button>
                                        </form>
                                        <? if($faq->published == 1) { ?>
                                            <form action="/admin/hideFaq" method="post">
                                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                <input type="hidden" name="faq_id" value="<?= $faq->id?>">
                                                <button class="btn btn-inno m-t-5 m-b-10">Hide <i class="zmdi zmdi-eye-off"></i></button>
                                            </form>
                                        <? } else { ?>
                                            <form action="/admin/publishFaq" method="post">
                                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                <input type="hidden" name="faq_id" value="<?= $faq->id?>">
                                                <button class="btn btn-inno m-t-5 m-b-10">Publish <i class="zmdi zmdi-eye"></i></button>
                                            </form>
                                        <? } ?>
                                    </div>
                                <? } ?>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="col-sm-12 m-b-20">
                                <form action="/admin/saveFaq" method="post" class="col-sm-12 m-t-20">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <? if(isset($faq)) { ?>
                                        <input type="hidden" name="faq_id" value="<?= $faq->id?>">
                                    <? } ?>
                                    <div class="d-flex">
                                        <div class="col-sm-6">
                                            <p class="f-14 m-b-5">Question</p>
                                            <textarea name="question" class="col-sm-12 input" cols="30" rows="6"><? if(isset($faq)) echo $faq->question?></textarea>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="f-14 m-b-5">Answer</p>
                                            <textarea name="answer" class="col-sm-12 input" cols="30" rows="6"><? if(isset($faq)) echo $faq->answer?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 d-flex m-t-20 p-0">
                                        <div class="col-sm-5">
                                            <select name="faqType" class="input col-sm-12">
                                                <? foreach($faqTypes as $faqType) { ?>
                                                    <option <? if(isset($faq) && $faq->faq_type_id == $faqType->id) echo "selected"?> value="<?= $faqType->id?>"><?= $faqType->title?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <p class="text-center">Or</p>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" name="newFaqType" class="input col-sm-12" placeholder="New category">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button class="btn btn-inno pull-right">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(".deleteFaqBtn").on("click",function () {
            if(confirm("Are you sure you want to delete this FAQ?")) {
                $(".deleteFaqForm").submit()
            }
        });
    </script>
@endsection