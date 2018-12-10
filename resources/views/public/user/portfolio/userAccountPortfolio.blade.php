@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background vh85">
        @notmobile
            @include("includes.userAccount_sidebar")
        @endnotmobile
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            @mobile
                @include("includes.userAccount_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My portfolio</h1>
            </div>
            <div class="hr col-md-12"></div>
            <form action="/user/addUserAccountPortfolio" method="post" enctype="multipart/form-data">
                <div class="row d-flex js-center m-t-20">
                    <div class="col-10">
                        <input type="text" name="portfolio_title" placeholder="What is the subject?" class="input-fat col-sm-12">
                    </div>
                </div>
                <div class="row d-flex js-center">
                    <div class="col-10 m-t-5">
                        <button class="btn btn-inno pull-right" type="submit">Save</button>
                        <i class="zmdi zmdi-camera-add pull-right editBtnDark m-r-10 p-r-15 p-l-15 input-file"></i>
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="user_id" value="<?= $user->id?>">
                        <input type="file" name="files[]" accept="image/*" multiple id="fileBox" class="hidden">
                    </div>
                </div>
            </form>
            <div class="row">
                <? foreach($userPortfolios as $userPortfolio) { ?>
                    <div class="col-sm-3">
                        <a class="td-none" href="/my-account/portfolio/<?= $userPortfolio->slug?>">
                            <div class="card m-t-20 m-b-20 p-relative c-pointer" style="min-height: 180px">
                                <div style="margin: 0 auto; padding-top: 20%">
                                    <p class="f-20 text-center"><?= $userPortfolio->title?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/user/userAccountPortfolio.js"></script>
@endsection