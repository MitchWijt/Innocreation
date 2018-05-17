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
            <div class="row m-t-20">
                <div class="col-sm-12 m-0 p-0">
                    <button class="btn btn-inno pull-right" data-toggle="modal" data-target="#newMembershipPackageModal">Create new category</button>
                </div>
            </div>
            <? foreach($customMembershipPackageTypes as $customMembershipPackageType) { ?>
                <div class="row m-b-20">
                    <div class="card card-lg col-sm-12 m-t-20">
                        <div class="card-block">
                            <div class="row membershipPackage">
                                <div class="col-sm-12 d-flex js-between">
                                    <h4 class="m-t-5"><?= $customMembershipPackageType->title?></h4>
                                    <button class="btn btn-inno m-t-5 m-b-10 membershipPackageSubmit">Save</button>
                                </div>
                                <div class="hr col-sm-12"></div>
                                <div class="col-sm-12">
                                    <form action="" class="membershipPackageForum" method="post">
                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                        <input type="hidden" name="package_id" value="<?= $customMembershipPackageType->id?>">
                                        <div class="col-sm-12 d-flex">
                                            <div class="col-sm-4 m-t-20">
                                                <p>Options select:</p>
                                               <? foreach($customMembershipPackageType->getCustomPackages() as $customPackage) { ?>
                                                   <input type="text" name="packageOption" class="input m-b-10" value="<?= $customPackage->option?>">
                                               <? } ?>
                                            </div>
                                            <div class="col-sm-4 m-t-20">
                                                <p>Prices:</p>
                                                <? foreach($customMembershipPackageType->getCustomPackages() as $customPackage) { ?>
                                                    <p class="m-0">&euro; <input type="text" name="packagePrice" class="input m-b-10" value="<?= $customPackage->price?>"></p>
                                                <? } ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
            <div class="modal fade newMembershipPackageModal" id="newMembershipPackageModal" tabindex="-1" role="dialog" aria-labelledby="newMembershipPackageModal" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-flex js-center">
                            <h4 class="modal-title text-center" id="modalLabel">Add new package</h4>
                        </div>
                        <div class="modal-body ">
                            <form action="/admin/saveMembershipPackage" method="post">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <div class="row">
                                    <div class="col-sm-12 d-flex m-t-20 m-b-20">
                                        <input type="text" name="title" class="input col-sm-3 m-r-10" placeholder="Title">
                                        <input type="text" name="price" class="input col-sm-3" placeholder="Price (10.9999)">
                                    </div>
                                    <div class="col-sm-12">
                                        <textarea name="description" class="col-sm-12 input" cols="30" rows="10" placeholder="List description"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class="btn btn-inno pull-right">Save</button>
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
        $(".membershipPackageSubmit").on("click",function () {
            $(this).parents(".membershipPackage").find(".membershipPackageForum").submit();
        });
        tinymce.init({
            selector : "textarea.test"
        });
    </script>
@endsection