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
                                <h4 class="m-t-5"><?= $expertise->title?></h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="row m-t-20 m-b-20 m-l-10 d-flex js-center">
                                <div class="col-sm-12">
                                    <form action="/admin/saveExpertise" method="post">
                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                        <input type="hidden" name="expertise_id" value="<?= $expertise->id?>">
                                        <i>Add search tags for the search bar type + enter to add a tag</i>
                                        <input type="text" name="tags" class="tokenfield" value="<?= $expertise->getTags()?>" />
                                        <i class="c-red errorTag f-12 hidden">Tag already added</i>
                                        <button class="btn btn-inno pull-right m-t-20 m-r-10">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex js-center">
                            <div class="col-sm-12">
                                <h4 class="m-t-5">Current image</h4>
                            </div>
                            <div class="hr col-sm-12"></div>
                            <div class="col-md-5">
                                <div class="card m-t-20 m-b-20 ">
                                    <div class="card-block expertiseCard p-relative " style="max-height: 150px !important">
                                        <div class="p-t-40 p-absolute" style="z-index: 200; bottom: 0; right: 5px">
                                            <a class="c-gray f-9 c-pointer photographer" target="_blank"  href="<?= $expertise->photographer_link?>"><?= $expertise->photographer_name?></a><span class="c-gray f-9"> on </span><a class="c-gray f-9 c-pointer photographer" target="_blank"  href="https://unsplash.com">Unsplash</a>
                                        </div>
                                        <div class="p-t-40 p-absolute" style="z-index: 102; top: 54%; left: 50%; transform: translate(-50%, -50%);">
                                            <p class="c-white f-20">Active users: <?= count($expertise->getActiveUsers())?></p>
                                        </div>
                                        <div class="p-t-40 p-absolute" style="z-index: 100; top: 35%; left: 50%; transform: translate(-50%, -50%);">
                                            <div class="hr-sm"></div>
                                        </div>
                                        <div class="p-t-40 p-absolute" style="z-index: 99; top: 25%; left: 50%; transform: translate(-50%, -50%);">
                                            <p class="c-white f-20"><?= $expertise->title?></p>
                                        </div>
                                        <div class="overlay">
                                            <div class="contentExpertiseUsers" style="background: url('<?= $expertise->image?>');"></div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-inno pull-right m-b-20 editImage" data-expertise-id="<?= $expertise->id?>">Edit image</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade editImageModal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body editImageModalData">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.tokenfield').tokenfield({
            autocomplete: {
                delay: 100
            },
            showAutocompleteOnFocus: false,
            createTokensOnBlur: true
        });
        $('.tokenfield').on('tokenfield:createtoken', function (event) {
            var existingTokens = $(this).tokenfield('getTokens');
            $.each(existingTokens, function(index, token) {
                if (token.value === event.attrs.value)
                    event.preventDefault();
            });
        });

        $(".editImage").on("click",function () {
            var expertise_id = $(this).data("expertise-id");
            $.ajax({
                method: "POST",
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');

                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                url: "/user/getEditUserExpertiseModal",
                data: {'expertise_id': expertise_id},
                success: function (data) {
                    $(".editImageModalData").html(data);
                    $(".editImageModal").modal().toggle();
                }
            });
        });

        $(document).on("click", ".userExpImg", function () {
            var expertise_id = $(this).data("expertise-id");
            var image = $(this).data("img");
            var photographerLink = $(this).data("pl");
            var photographerName = $(this).data("pn");
            var admin = 1;
            $.ajax({
                method: "POST",
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');

                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                url: "/admin/editExpertiseImage",
                data: {'expertise_id': expertise_id, 'photographerLink' : photographerLink, 'image' : image, 'photographerName' : photographerName, 'admin' : admin},
                success: function (data) {
                    window.location.reload();
                }
            });
        });
    </script>
@endsection