@extends("layouts.app")
@section("content")
    <div class="d-flex grey-background">
        @include("includes.userAccount_sidebar")
        <div class="container">
            <div class="sub-title-container p-t-20">
                <h1 class="sub-title-black">My portfolio</h1>
            </div>
            <div class="hr"></div>
            <? if($amountPortfolios != 0) { ?>
                <div class="hidden">
                    <form action="/my-account/saveUserPortfolio" enctype="multipart/form-data" class="emptyForm" id="emptyForm" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="user_id" value="<? if(isset($user)) echo $user->id ?>">
                        <div class="form-group m-b-0 d-flex js-center">
                            <div class="col-sm-9 m-t-10 p-r-0">
                                <div class="row d-flex js-center">
                                    <div class="col-sm-9">
                                        <label class="m-0 col-sm-12 p-0">Title</label>
                                        <input type="text" name="portfolio_title[]" class="input col-sm-12 portfolio_title">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center m-t-20 fileUpload">
                                <input type="file" class="portfolio_image_new hidden" name="portfolio_image[]">
                                <button type="button" class="btn btn-inno uploadPortfolioImage m-b-10">Upload picture</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <span class="fileNameNew"></span>
                            </div>
                        </div>
                        <div class="form-group m-b-0 d-flex js-center">
                            <div class="col-sm-9 m-t-10 p-r-0">
                                <div class="row d-flex js-center">
                                    <div class="col-sm-9 d-flex row">
                                        <label class="m-0 col-sm-12 p-0">Description</label>
                                        <textarea name="description_portfolio[]" class="input portfolio_description" cols="90" rows="12"></textarea>
                                    </div>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-inno pull-right m-t-10 saveButton">Save portfolio</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <?foreach($userPortfolios as $userPortfolio) { ?>
                    <form action="/my-account/editUserPortfolio" enctype="multipart/form-data" class="portfolioForm" method="post" data-portfolio_id="<?=$userPortfolio->id?>">
                        <input type="hidden" name="portfolio_id" value="<?= $userPortfolio->id?>">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <div id="portofolio-item">
                            <div class="form-group m-b-0 d-flex js-center">
                                <div class="col-sm-9 m-t-10 p-r-0">
                                    <div class="row d-flex js-center">
                                        <div class="col-sm-9">
                                            <label class="m-0 col-sm-10 p-0">Title</label>
                                            <span class="pull-right col-sm-2 c-orange f-20 deleteCrossPortfolio" data-portfolio-id="<?=$userPortfolio->id?>"><i class="zmdi zmdi-close pull-right"></i></span>
                                            <input type="text" name="portfolio_title" class="input col-sm-12" value="<? if(isset($userPortfolio->title)) echo $userPortfolio->title?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-b-0 d-flex js-center">
                                <div class="col-sm-9 m-t-10 p-r-0">
                                    <div class="row d-flex js-center">
                                        <div class="col-sm-9 d-flex row">
                                            <img class="col-sm-12 h-100 p-0 radius" src="<?= $userPortfolio->getUrl()?>" alt="">
                                        </div>
                                        <div class="col-sm-9 fileUpload">
                                            <input type="file" class="portfolio_image hidden" name="portfolio_image">
                                            <button type="button" class="btn btn-inno pull-right m-t-10 editPortfolioImage col-sm-3">Edit picture</button>
                                            <span class="fileName pull-right m-t-15 m-r-10"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-b-0 d-flex js-center">
                                <div class="col-sm-9 m-t-10 p-r-0">
                                    <div class="row d-flex js-center">
                                        <div class="col-sm-9 d-flex row">
                                            <label class="m-0 col-sm-12 p-0">Description</label>
                                            <textarea name="description_portfolio" class="input" cols="90" rows="12"><? if(isset($userPortfolio->description)) echo $userPortfolio->description?></textarea>
                                        </div>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-inno pull-right m-t-10">Save portfolio</button>
                                        </div>
                                    </div>
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
                    <div class="form-group m-b-0 d-flex js-center">
                        <div class="col-sm-9 m-t-10 p-r-0">
                            <div class="row d-flex js-center">
                                <div class="col-sm-9">
                                    <label class="m-0 col-sm-12 p-0">Title</label>
                                    <input type="text" name="portfolio_title[]" class="input col-sm-12 portfolio_title">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-center m-t-20 fileUpload">
                            <input type="file" class="portfolio_image_new hidden" name="portfolio_image[]">
                            <button type="button" class="btn btn-inno uploadPortfolioImage m-b-10">Upload picture</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <span class="fileNameNew"></span>
                        </div>
                    </div>
                    <div class="form-group m-b-0 d-flex js-center">
                        <div class="col-sm-9 m-t-10 p-r-0">
                            <div class="row d-flex js-center">
                                <div class="col-sm-9 d-flex row">
                                    <label class="m-0 col-sm-12 p-0">Description</label>
                                    <textarea name="description_portfolio[]" class="input portfolio_description" cols="90" rows="12"></textarea>
                                </div>
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-inno pull-right m-t-10 saveButton">Save portfolio</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <i class="zmdi zmdi-plus addPortfolioNew c-pointer" style="font-size: 50px;"></i>
                </div>
            </div>
            <? } ?>
        </div>
    </div>
@endsection