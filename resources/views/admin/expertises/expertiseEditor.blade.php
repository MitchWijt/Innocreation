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
    </script>
@endsection