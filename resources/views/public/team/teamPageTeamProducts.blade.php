@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.teamPage_sidebar")
        @endnotmobile
        <div class="container">
            @mobile
                @include("includes.teamPage_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My team products</h1>
            </div>
            <div class="row m-b-20">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <div class="hr col-md-10"></div>
            <div class="row d-flex js-center m-t-20">
                <div class="col-md-9">
                    <div class="card card-lg">
                        <div class="card-block @mobile p-10 @endmobile">
                            <form action="/my-team/saveTeamProduct" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <input type="hidden" name="team_id" value="<?= $team->id?>">
                                <div class="row d-flex js-center m-t-10">
                                    <div class="col-sm-11">
                                        <p class="m-b-5 m-t-5">Choose your product name:</p>
                                        <input type="text" name="product_name" placeholder="Your unique product name..." class="input col-sm-5">
                                    </div>
                                </div>
                                <div class="row d-flex js-center m-t-20">
                                    <div class="col-sm-11">
                                        <p class="m-b-5 m-t-5">Add a picture of your product (optional):</p>
                                        <p class="fileName c-dark-grey m-b-5"></p>
                                        <input type="file" name="product_image" class="hidden uploadImageInput">
                                        <button type="button" class="btn btn-inno btn-sm uploadTeamProductImage">Add image</button>
                                    </div>
                                </div>
                                <div class="row d-flex js-center m-t-20">
                                    <div class="col-sm-11">
                                        <p class="m-b-5 m-t-5">Explain what your product includes and what it is:</p>
                                        <textarea name="product_description" placeholder="Your product description" class="input col-sm-12" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="row d-flex js-center m-b-20">
                                    <div class="col-sm-11">
                                    <button class="btn btn-inno pull-right">Post my product!</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="col-md-10 m-t-20">
            <div class="m-b-20">
                <? foreach($teamProducts as $teamProduct) { ?>
                    <div class="row d-flex js-center m-t-20 teamProduct" data-id="<?= $teamProduct->id?>">
                        <div class="col-md-9">
                            <div class="card card-lg">
                                <div class="card-block @mobile p-10 @endmobile">
                                    <i class="deleteTeamProduct zmdi zmdi-close pull-right f-20 m-r-10 m-t-5 c-orange" data-id="<?= $teamProduct->id?>"></i>
                                    <i class="editTeamProduct zmdi zmdi-edit pull-right f-18 m-t-5 m-r-5 c-orange" data-id="<?= $teamProduct->id?>"></i>
                                    <div class="row">
                                        <div class="col-sm-4 m-t-15">
                                            <p class="col-sm-12"><?= $teamProduct->title?></p>
                                        </div>
                                        <div class="col-sm-8 m-t-10 d-flex">
                                            <div class="col-sm-6 text-center">
                                                <p class="m-0"><?= $teamProduct->getLikes()?></p>
                                                <p>Likes</p>
                                            </div>
                                            <div class="col-sm-6 text-center">
                                                <p class="m-0"><?= $teamProduct->getShares()?></p>
                                                <p>Shares</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
            <div class="modal fade teamProductModal" id="teamProductModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-body teamProductModalData">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/team/teamPageTeamProducts.js"></script>
@endsection