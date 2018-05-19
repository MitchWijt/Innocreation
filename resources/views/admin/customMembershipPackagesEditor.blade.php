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
                    <button class="btn btn-inno pull-right" data-toggle="modal" data-target="#newCustomMembershipPackageModal">Create new category</button>
                </div>
            </div>
            <? foreach($customMembershipPackageTypes as $customMembershipPackageType) { ?>
                <div class="row m-b-20">
                    <div class="card card-lg col-sm-12 m-t-20">
                        <div class="card-block">
                            <div class="row membershipPackage">
                                <div class="col-sm-12 d-flex js-between">
                                    <h4 class="m-t-5"><?= $customMembershipPackageType->title?></h4>
                                    <button class="btn btn-inno m-t-5 m-b-10 addOption" data-type="<?= $customMembershipPackageType->id?>">Add option</button>
                                </div>
                                <div class="col-sm-12 returnMessage" style="display: none" data-type="<?= $customMembershipPackageType->id?>">
                                    <small><i class="zmdi zmdi-check c-orange"></i><span class="successMessage" data-type="<?= $customMembershipPackageType->id?>"></span></small>
                                </div>
                                <div class="hr col-sm-12"></div>
                                <div class="col-sm-12">
                                    <form action="/admin/saveCustomMembershipPackage" class="membershipPackageForum" method="post">
                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                        <input type="hidden" name="package_id" value="<?= $customMembershipPackageType->id?>">
                                        <div class="col-sm-12 d-flex">
                                            <div class="col-sm-4 m-t-20">
                                                <p>Options select:</p>
                                               <? foreach($customMembershipPackageType->getCustomPackages() as $customPackage) { ?>
                                                   <input type="text" name="packageOption[]" class="input m-b-10 packageOption" data-package-id="<?= $customPackage->id?>" value="<?= $customPackage->option?>">
                                               <? } ?>
                                            </div>
                                            <div class="col-sm-4 m-t-20">
                                                <p>Prices:</p>
                                                <? foreach($customMembershipPackageType->getCustomPackages() as $customPackage) { ?>
                                                    <p class="m-0">&euro; <input type="text" name="packagePrice[]" class="input m-b-10 packagePrice" data-package-id="<?= $customPackage->id?>" value="<?= $customPackage->price?>"></p>
                                                <? } ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade addOptionModal" data-type="<?= $customMembershipPackageType->id?>" id="addOptionModal" tabindex="-1" role="dialog" aria-labelledby="addOptionModal" aria-hidden="true">
                    <div class="modal-dialog " role="document">
                        <div class="modal-content">
                            <div class="modal-body ">
                                <div class="row">
                                    <form action="/admin/addOptionCustomMembershipPackage" class="col-sm-12" method="post">
                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                        <input type="hidden" name="type_id" value="<?= $customMembershipPackageType->id?>">
                                        <div class="d-flex">
                                            <div class="col-sm-6">
                                                <input type="text" name="option" class="input col-sm-12" placeholder="Option">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" name="price" class="input col-sm-12" placeholder="Price">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button class="btn btn-inno pull-right btn-sm m-r-15 m-t-15">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
            <div class="modal fade newCustomMembershipPackageModal" id="newCustomMembershipPackageModal" tabindex="-1" role="dialog" aria-labelledby="newCustomMembershipPackageModal" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-flex js-center">
                            <h4 class="modal-title text-center" id="modalLabel">Add new category</h4>
                        </div>
                        <div class="modal-body ">
                            <form action="/admin/addCategoryCustomMembershipPackage" method="post">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <div class="row">
                                    <div class="col-sm-12 d-flex m-t-20 m-b-20">
                                        <input type="text" name="category" class="input col-sm-6 m-r-10" placeholder="Category name">
                                        <input type="number" name="amountOptions" class="input col-sm-6" placeholder="Amount of options to add">
                                    </div>
                                    <div class="col-sm-12">
                                    <i class="pull-right f-13 m-b-10">You can fill in the options later</i>
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


        $(".packageOption").on("change",function () {
            var option = $(this).val();
            var package_id = $(this).data("package-id");
            $.ajax({
                method: "POST",
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');

                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                url: "/admin/saveCustomMembershipPackage",
                data: {'package_id': package_id, 'option': option},
                success: function (data) {
                    $(".returnMessage").each(function () {
                        if($(this).data("type") == data){
                            $(this).fadeIn();
                            setTimeout(function(){
                                $(".returnMessage").fadeOut();
                            }, 1000);
                            $(this).find(".successMessage").text(" Option succesfully saved");
                        }
                    });
                }
            });
        });


        $(".packagePrice").on("change",function () {
            var price = $(this).val();
            var package_id = $(this).data("package-id");
            $.ajax({
                method: "POST",
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');

                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                url: "/admin/saveCustomMembershipPackage",
                data: {'package_id': package_id, 'price': price},
                success: function (data) {
                    $(".returnMessage").each(function () {
                        if($(this).data("type") == data){
                            $(this).fadeIn();
                            setTimeout(function(){
                                $(".returnMessage").fadeOut();
                            }, 1000);
                            $(this).find(".successMessage").text(" Price succesfully saved");
                        }
                    });
                }
            });
        });

        $(".addOption").on("click",function () {
            var type = $(this).data("type");
            $(".addOptionModal").each(function () {
               if($(this).data("type") == type){
                   $(this).modal().toggle();
               }
            });
        });

    </script>
@endsection