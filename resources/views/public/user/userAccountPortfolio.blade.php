@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background">
        @notmobile
            @include("includes.userAccount_sidebar")
        @endnotmobile
        <div class="container">
            @mobile
                @include("includes.userAccount_sidebar")
            @endmobile
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My portfolio</h1>
            </div>
            <div class="hr col-md-10"></div>
            <? if($amountPortfolios != 0) { ?>
                <div class="hidden">
                    <form action="/my-account/saveUserPortfolio" enctype="multipart/form-data" class="emptyForm" id="emptyForm" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="user_id" value="<? if(isset($user)) echo $user->id ?>">
                        <div class="row d-flex js-center">
                            <div class="form-group m-b-0 col-md-6 m-t-10 p-r-0">
                                <label class="m-0 col-sm-12 p-0">Title</label>
                                <input type="text" name="portfolio_title[]" class="input col-sm-12 portfolio_title">
                            </div>
                        </div>
                        <div class="row m-b-0 d-flex js-center">
                            <div class="form-group col-md-6 m-t-10 p-r-0">
                                <label class="m-0 col-sm-12 p-0">Optional project link</label>
                                <input type="text" name="portfolio_link[]" placeholder="www.github.com" class="input col-sm-12 portfolio_link">
                            </div>
                        </div>
                        <div class="row d-flex js-center">
                            <div class="m-t-20 fileUpload">
                                <input type="file" class="portfolio_image_new hidden" name="portfolio_image[]">
                                <button type="button" class="btn btn-inno uploadPortfolioImage m-b-10">Upload picture</button>
                            </div>
                        </div>
                        <div class="row d-flex js-center">
                            <span class="fileNameNew"></span>
                        </div>
                        <div class="row m-b-0 d-flex js-center">
                            <div class="form-group col-md-6 m-t-10 p-r-0">
                                <label class="m-0 col-sm-12 p-0">Description</label>
                                <textarea name="description_portfolio[]" class="input portfolio_description col-sm-12" rows="12"></textarea>
                                <button type="submit" class="btn btn-inno pull-right m-t-10 saveButton">Save portfolio</button>
                            </div>
                        </div>
                    </form>
                </div>
                <?foreach($userPortfolios as $userPortfolio) { ?>
                    <form action="/my-account/editUserPortfolio" enctype="multipart/form-data" class="portfolioForm" method="post" data-portfolio_id="<?=$userPortfolio->id?>">
                        <input type="hidden" name="portfolio_id" value="<?= $userPortfolio->id?>">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <div id="portofolio-item">
                            <div class="row m-b-0 d-flex js-center">
                                <div class="form-group m-t-10 p-r-0 col-md-6">
                                    <label class="m-0 col-sm-10 p-0">Title</label>
                                    <span class="pull-right col-sm-2 c-orange f-20 deleteCrossPortfolio" data-portfolio-id="<?=$userPortfolio->id?>"><i class="zmdi zmdi-close pull-right"></i></span>
                                    <input type="text" name="portfolio_title" class="input col-sm-12" value="<? if(isset($userPortfolio->title)) echo $userPortfolio->title?>">
                                </div>
                            </div>
                            <div class="row  m-b-0 d-flex js-center">
                                <div class="form-group col-md-6 m-t-10 p-r-0">
                                    <label class="m-0 col-sm-12 p-0">Optional project link</label>
                                    <input type="text" name="portfolio_link" placeholder="www.github.com" class="input col-sm-12 portfolio_link" value="<? if(isset($userPortfolio->link)) echo $userPortfolio->link?>">
                                </div>
                            </div>
                            <div class="row m-b-0 d-flex js-center">
                                <div class="form-group col-md-6 m-t-10 p-r-0">
                                    <img class="col-sm-12 h-100 p-0 radius img-responsive" src="<?= $userPortfolio->getUrl()?>" alt="">
                                    <div class="fileUpload">
                                        <input type="file" class="portfolio_image hidden" name="portfolio_image">
                                        <button type="button" class="btn btn-inno pull-right m-t-10 editPortfolioImage">Edit picture</button>
                                        <span class="fileName pull-right m-t-15 m-r-10"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex js-center m-b-0 m-t-10">
                                <div class="form-group col-md-6 m-t-10 p-r-0">
                                    <label class="m-0 col-sm-12 p-0">Description</label>
                                    <textarea name="description_portfolio" class="input col-sm-12" rows="12"><? if(isset($userPortfolio->description)) echo $userPortfolio->description?></textarea>
                                    <button type="submit" class="btn btn-inno pull-right m-t-10">Save portfolio</button>
                                </div>
                            </div>
                        </div>
                    </form>
                <? } ?>
                <div class="emptyForms">

                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <i class="zmdi zmdi-plus addPortfolioEmpty c-pointer" style="font-size: 50px;"></i>
                    </div>
                </div>
            <? } else { ?>
                <form action="/my-account/saveUserPortfolio" enctype="multipart/form-data" class="portfolioForm" method="post">
                    <div id="portofolio-item">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="user_id" value="<? if(isset($user)) echo $user->id ?>">
                        <div class="row m-b-0 d-flex js-center">
                            <div class="form-group col-md-6 m-t-10 p-r-0">
                                <label class="m-0 col-sm-12 p-0">Title</label>
                                <input type="text" name="portfolio_title[]" class="input col-sm-12 portfolio_title">
                            </div>
                        </div>
                        <div class="row m-b-0 d-flex js-center">
                            <div class="form-group col-md-6 m-t-10 p-r-0">
                                <label class="m-0 col-sm-12 p-0">Optional project link</label>
                                <input type="text" name="portfolio_link[]" placeholder="www.github.com" class="input col-sm-12 portfolio_link">
                            </div>
                        </div>
                        <div class="row d-flex js-center m-t-20 ">
                            <div class="fileUpload">
                                <input type="file" class="portfolio_image_new hidden" name="portfolio_image[]">
                                <button type="button" class="btn btn-inno uploadPortfolioImage m-b-10">Upload picture</button>
                            </div>
                        </div>
                        <div class="row d-flex js-center">
                            <span class="fileNameNew"></span>
                        </div>
                        <div class="row m-b-0 d-flex js-center">
                            <div class="form-group col-md-6 m-t-10 p-r-0">
                                <label class="m-0 col-sm-12 p-0">Description</label>
                                <textarea name="description_portfolio[]" class="input portfolio_description col-md-12" rows="12"></textarea>
                                <button type="submit" class="btn btn-inno pull-right m-t-10 saveButton">Save portfolio</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row d-flex js-center">
                    <i class="zmdi zmdi-plus addPortfolioNew c-pointer" style="font-size: 50px;"></i>
                </div>
            <? } ?>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/user/userAccountPortfolio.js"></script>
@endsection