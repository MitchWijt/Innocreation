@extends("layouts.app")
{{--<link rel="stylesheet" href="/css/musicPlayer.css">--}}
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
                <h1 class="sub-title-black"><?= $userPortfolio->title?></h1>
            </div>
            <div class="hr col-md-12"></div>
            <div class="row m-t-20">
                <div class="col-sm-12 text-center">
                    <i class="editBtnDark zmdi zmdi-camera-add f-25 p-l-20 p-r-20 input-file"></i>
                    <form action="/user/addImagesPortfolio" method="post" enctype="multipart/form-data" class="addImagesPortfolio">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <input type="hidden" name="user_id" value="<?= $user->id?>">
                        <input type="hidden" name="portfolio_id" value="<?= $userPortfolio->id?>">
                        <input type="file" accept="audio/mpeg3, image/jpeg, video/mp4" name="files[]" multiple id="fileBox" class="hidden">
                    </form>
                </div>
            </div>
            <div class="row">
                <? $counter = 0?>
                <? foreach($userPortfolioFiles as $file) { ?>
                    <div class="td-none portfolioFileItem p-r-10 p-l-10 col-sm-4">
                        <? if($file->mimetype != "video/mp4" ) { ?>
                            <div class="card m-t-20 m-b-20 portfolioItemCard p-relative">
                                <div class="p-relative c-pointer contentContainerPortfolio" data-url="/" style="max-height: 180px">
                                    <? if($file->mimetype == "application/octet-stream") { ?>
                                        <? if($file->filename != null) { ?>
                                            <div class="@mobile contentPortfolioNoScale noScale-<?= $file->id?> @elsedesktop contentPortfolio @enddesktop" data-id="<?= $file->id?>" data-url="<?= $file->getUrl()?>" style="background: url('<?= $file->getAudioCover()?>'); z-index: -1 !important">
                                        <? } else { ?>
                                            <div class="@mobile contentPortfolioNoScale noScale-<?= $file->id?> @elsedesktop contentPortfolio @enddesktop" data-id="<?= $file->id?>" style="z-index: -1 !important">
                                        <? } ?>
                                    <? } else { ?>
                                        <div class="@mobile contentPortfolioNoScale noScale-<?= $file->id?> @elsedesktop contentPortfolio @enddesktop" data-id="<?= $file->id?>" data-url="<?= $file->getUrl()?>" style="background: url('<?= $file->getUrl()?>'); z-index: -1 !important">
                                    <? } ?>
                                        <? if($file->title != null ) { ?>
                                            <div id="content" class="contentFixed" @desktop style="display: none;" @enddesktop>
                                                <div class="p-absolute cont-<?= $file->id?>" style="top: 42%; left: 50%; !important; transform: translate(-50%, -50%);">
                                                    <p class="c-white f-9 p-t-40 descPortFixed-<?=$file->id?>" style="width: 310px !important;"><?= $file->description?></p>
                                                </div>
                                                <div class="p-t-40 p-absolute cont-<?= $file->id?>" style="top: 5%; left: 48%; width: 80%; transform: translate(-50%, -50%);">
                                                    <p class="c-white f-12 titlePortFixed-<?= $file->id?>"><?= $file->title?></p>
                                                </div>
                                                <div class="p-absolute cont-<?= $file->id?>" style="top: 18%; left: 44%; width: 100%; transform: translate(-50%, -50%);">
                                                    <hr class="col-8">
                                                </div>
                                                <div class="p-absolute cont-<?= $file->id?>" style="top: 1%; right: 5%">
                                                    <form action="/user/removePortfolioImage" method="post" class="removeImageForm-<?= $file->id?> hidden">
                                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                        <input type="hidden" name="user_id" value="<?= $user->id?>">
                                                        <input type="hidden" name="file_id" value="<?= $file->id?>">
                                                    </form>
                                                    <i class="zmdi zmdi-close f-20 c-orange p-absolute removeImage" data-id="<?= $file->id?>"></i>
                                                </div>
                                            </div>
                                        <? } ?>
                                        <div id="content inputs" class="contentInputs">
                                            <div class="p-absolute" style="top: 42%; left: 45%; !important; transform: translate(-50%, -50%);">
                                                <textarea data-id="<?= $file->id?>" class="input-transparant col-sm-12 f-9 hidden descPortImg desc-<?= $file->id?>" placeholder="Description" style="width: 300px !important" name="file_desc"><? if(isset($file->title)) echo $file->description?></textarea>
                                            </div>
                                            <div class="cont-<?= $file->id?>">
                                                <input data-id="<?= $file->id?>" type="text" name="file_title" placeholder="Title" class="p-absolute input-transparant f-9 p-t-30 p-b-30 hidden title-<?= $file->id?> titlePortImg" value="<? if(isset($file->title)) echo $file->title?>" style="top: 5%; left: 55%; width: 100%; transform: translate(-50%, -50%);">
                                            </div>
                                            <div class="p-absolute cont-<?= $file->id?>" style="top: 18%; left: 44%; width: 100%; transform: translate(-50%, -50%);">
                                                <hr class="col-8 hr-<?= $file->id?> hidden hrPortImg">
                                            </div>
                                            <? if($file->mimetype == "application/octet-stream") { ?>
                                                <div class="p-absolute" style="top: 80%; right: -1%; transform: translate(-50%, -50%);">
                                                    <i class="zmdi zmdi-play editBtnDark f-15 p-b-0 p-t-0 p-r-10 p-l-10 playSong" data-counter="<?= $counter?>" data-id="<?= $file->id?>"></i>
                                                    <i class="zmdi zmdi-pause editBtnDark f-15 p-b-0 p-t-0 p-r-10 p-l-10 pauseSong hidden" data-counter="<?= $counter?>" data-id="<?= $file->id?>"></i>
                                                </div>
                                                <div class="p-absolute" style="top: 80%; left: 13%; transform: translate(-50%, -50%);">
                                                    <span class="currentTime f-12 cur-<?= $file->id?>"></span><span class="f-12">/</span><span class="duration f-12 dur-<?= $file->id?>" data-id="<?= $file->id?>"></span>
                                                </div>
                                                <div class="p-absolute p-l-5 p-r-5" style="top: 90%; left: 50%; width: 100%; transform: translate(-50%, -50%);">
                                                    <input type="range" class=" p-l-0 p-r-0 music-progress-bar musicBar-<?= $file->id?>" data-counter="<?= $counter?>" data-id="<?= $file->id?>" value="0" name="" id="">
                                                </div>
                                                <audio id="player-<?= $file->id?>" ontimeupdate="getCurrentTime(this, $(this).data('id'))" data-id="<?= $file->id?>" src="<?= $file->getAudio()?>"></audio>
                                            <? } ?>
                                        </div>
                                        <div id="content">
                                            <? if($file->mimetype == "application/octet-stream") { ?>
                                                <div class="p-t-40 p-absolute" style="top: 5%; left: 83%; transform: translate(-50%, -50%);">
                                                    <form action="/user/addImageToAudio" method="post" enctype="multipart/form-data" class="addImageToAudio-<?= $file->id?>">
                                                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                                        <input type="hidden" name="user_id" value="<?= $user->id?>">
                                                        <input type="hidden" name="portfolio_file_id" value="<?= $file->id?>">
                                                        <input type="file" accept="image/jpeg" name="file" data-file-id="<?= $file->id?>" id="imageAudio-<?= $file->id?>" class="hidden imageForAudio">
                                                    </form>
                                                    <i data-file-id="<?= $file->id?>" class="zmdi zmdi-camera-add editBtnDark f-20 addMusicImage"></i>
                                                </div>
                                            <? } ?>
                                            <? if($file->mimetype == "application/octet-stream") { ?>
                                                <div class="p-t-40 p-absolute" style="top: 5%; left: 94%; transform: translate(-50%, -50%);">
                                            <? } else { ?>
                                                <div class="p-t-40 p-absolute" style="top: 75%; left: 94%; transform: translate(-50%, -50%);">
                                            <? } ?>
                                                <i data-file-id="<?= $file->id?>" class="zmdi zmdi-edit editBtnDark f-20 editPortfolioImage"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <? } else { ?>
                                <div class="card m-t-20 m-b-20 p-0 portfolioItemCard p-relative">
                                    <div class="p-relative c-pointer contentContainerPortfolio" data-url="/" style="max-height: 180px">
                                        <div class="p-relative @mobile contentPortfolioNoScale noScale videoContentMobile @elsedesktop contentPortfolio videoContent @enddesktop" data-id="<?= $file->id?>"  style="z-index: 2 !important;">
                                            <div class="m-t-10 p-absolute" style="top: 40%; left: 52%; !important; transform: translate(-50%, -50%);">
                                                <i class="zmdi zmdi-play playButtonVideo shadow play-<?= $file->id?>"></i>
                                            </div>
                                            <video poster="<?= $file->getThumbnail()?>"  id="video-<?= $file->id?>" data-id="<?= $file->id?>" class="video video-<?= $file->id?>" style="min-width: 100% !important; max-width: 350px !important; max-height: 180px !important; min-height: 180px !important; z-index: -1;" src="<?= $file->getVideo()?>" muted></video>
                                        </div>
                                    </div>
                                </div>
                            <? } ?>
                    </div>
                    <? $counter++?>
                <? } ?>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
    <script src="/js/user/userAccountPortfolio.js"></script>
    <script src="/js/assets/musicPlayer.js"></script>
@endsection