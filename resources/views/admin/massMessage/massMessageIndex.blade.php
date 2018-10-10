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
                            <div class="col-sm-12">
                                <h4 class="m-t-5">Mass message</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="col-sm-12 m-t-20">
                                <p class="m-b-5">Choose mail template</p>
                                <select name="mail_template" class="selectMailTemplate input col-sm-5">
                                    <? foreach($mailTemplates as $mailTemplate) { ?>
                                        <option value="<?= $mailTemplate->content?>"><?= $mailTemplate->subject?></option>
                                    <? } ?>
                                </select>
                            </div>
                            <form action="/admin/sendMassEmail" method="post">
                                <div class="form-group">
                                    <div class="col-sm-12 m-t-20">
                                        <textarea name="emailMessage" id="content" class="content" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12 m-t-20">
                                        <div class="row">
                                            <div class="col-sm-6 fileUpload">
                                                <input type="file" class="image_input hidden" name="image">
                                                <button class="btn btn-inno btn-sm addPicture" type="button">Add picture</button>
                                                <span class="fileName m-r-10"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <button class="btn btn-inno btn-sm pull-right">Send email</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.addPicture', function() {
            $(this).parents(".fileUpload").find(".image_input").click();
        });

        $(document).on("change", ".image_input",function () {
            var _this = $(this);
            var filename = $(this).val().split('\\').pop();
            _this.parents(".fileUpload").find(".fileName").text(filename);

        });
        tinymce.init({
            selector : "textarea.content"
        });
    </script>
@endsection