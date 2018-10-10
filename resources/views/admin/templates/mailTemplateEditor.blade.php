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
                                <h4 class="m-t-5"><? if(isset($mailTemplate)) echo $mailTemplate->subject; else echo "Create new template"?></h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <form action="/admin/saveMailTemplate" method="post" class="col-sm-12 m-t-20">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <? if(isset($mailTemplate)) { ?>
                                    <input type="hidden" name="mail_template_id" value="<?= $mailTemplate->id?>">
                                <? } ?>
                                <p class="m-b-0 f-14 col-sm-3 p-0 m-l-5">Onderwerp</p>
                                <input type="text" name="title" class="input col-sm-3" value="<? if(isset($mailTemplate)) echo $mailTemplate->subject?>">
                                <div class="m-t-20 m-b-20">
                                    <textarea name="content" class="content col-sm-12 " cols="30" rows="20"><? if(isset($mailTemplate)) echo $mailTemplate->content?></textarea>
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