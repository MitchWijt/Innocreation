@extends("layouts.app")
@section("content")
    <div class="">
        <div class="grey-background vh85">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 d-flex js-center">
                        @include("includes.flash")
                    </div>
                </div>
                <div class="sub-title-container p-t-20 m-b-20">
                    <h1 class="sub-title-black m-b-0">All team projects</h1>
                </div>
                <hr class="m-b-20">
                <input type="hidden" class="userJS" value="1">
                <div class="text-center <?= \App\Services\UserAccount\UserAccount::getTheme()?>">
                    <button class="btn btn-inno-cta m-t-25">New project</button>
                </div>
                <div class="row">
                    <? foreach($projects->projects as $project) { ?>
                        <div class="col-xl-4 m-t-10">
                            <a class="td-none" href="/my-team/project/<?= $project->slug?>">
                                <div class="card userCard m-t-20 m-b-20">
                                    <div class="card-block p-relative c-pointer" data-url="/" style="min-height: 160px !important">
                                        <div class="text-center">
                                            <i class="zmdi zmdi-calendar c-black f-40 m-t-30"></i>
                                        </div>
                                        <div class="text-center m-t-5">
                                            <span class="c-orange f-13">10/120</span>
                                        </div>
                                        <div class="o-hidden p-absolute c-black" style="white-space: nowrap; text-overflow: ellipsis; max-width: 130px; top: 78%; left: 50%; transform: translate(-50%, -50%); z-index: 200;">
                                            <span class="c-black f-20"><?= $project->title?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
@endsection
