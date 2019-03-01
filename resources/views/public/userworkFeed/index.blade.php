@extends("layouts.app")
<link rel="stylesheet" href="/css/responsiveness/innocreativeFeed/index.css">
<link rel="stylesheet" href="/css/userworkFeed/newIndex2.css">
@section("content")
    @mobile
    <? if(isset($user)) { ?>
        <div class="sliderUpDown close p-relative">
            <div class="sliderContent hidden">
                <div class="row p-l-10 p-r-10 m-t-10">
                    <div class="col-6">
                        <a class="regular-link closeSlider">Close</a>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-inno btn-sm pull-right p-l-20 p-r-20 postInnocreativePost">Post</button>
                    </div>
                </div>
               <div class="hr-dark"></div>
                <div class="row">
                    <div class="col-sm-12">
                        <form action="/feed/postUserWork" method="post" class="userWorkForm" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                            <input type="hidden" name="user_id" value="<?= $user->id?>">
                            <div class="m-b-5 d-flex js-center">
                                <div class="col-md-8 d-flex js-center m-t-5">
                                    <textarea placeholder="Share your idea, project or story" id="description_id" class="col-sm-12 input" rows="4" name="newUserWorkDescription"></textarea>
                                </div>
                            </div>
                            <div class="m-b-5 d-flex js-center">
                                <div class="col-md-8 m-t-5">
                                    <div class="row">
                                        <div class="@handheld col-6 m-b-10 @elsedesktop col-sm-4 @endhandheld">
                                            <div class="fileUpload p-relative">
                                                <input type="file" class="userwork_image hidden" name="image">
                                                <i class="zmdi zmdi-camera-add iconCTA addPicture c-pointer"></i>
                                                <span class="fileName pull-right m-r-10"></span>
                                                <i class="zmdi zmdi-mood iconCTA c-pointer popoverEmojis " data-toggle="popover" data-content='<?= view("/public/userworkFeed/shared/_popoverEmojis", compact("emojis"))?>'></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="@mobile col-4 @elsedesktop col-sm-4 @endmobile p-relative previewBox hidden">
                                            <i class="zmdi zmdi-close c-orange f-25 p-absolute c-pointer" id="removePreview" style="top: 2%; right: -63%;"></i>
                                            <img style="width: 200px; height: 200px;" id="previewUpload" src="#" alt="PreviewUpload"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <? } ?>
    @endmobile
    <input type="hidden" class="totalAmount" value="<?= $totalAmount?>">
    <? if(isset($user) && $user->hasContent()) { ?>
        <input type="hidden" class="userId" value="<?= $user->id?>">
    <? } else { ?>
        <input type="hidden" class="userId" value="0">
    <? } ?>
    <? if(isset($sharedUserWorkId)) { ?>
        <input type="hidden" class="sharedLinkId" value="<?= $sharedUserWorkId?>">
    <? } ?>
    <div class="d-flex grey-background">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex js-center">
                    @include("includes.flash")
                </div>
            </div>
            <div class="sub-title-container p-t-20 m-b-20">
                <h1 class="sub-title-black m-b-0">Innocreatives</h1>
            </div>
            <hr class="m-b-20">
            <? if(isset($user)) { ?>
                <input type="hidden" class="userJS" value="1">
                <div class="userworkPostForm">
                    @notmobile
                        <form action="/feed/postUserWork" method="post" class="userWorkForm" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="<?= csrf_token()?>">
                            <input type="hidden" name="user_id" value="<?= $user->id?>">
                            <div class="m-b-5 d-flex js-center">
                                <div class="col-md-8 d-flex js-center m-t-5">
                                    <textarea placeholder="Share your idea, project or story" id="description_id" class="col-sm-12 input @notmobile contentActive @endnotmobile descDesktop c-pointer" rows="2" name="newUserWorkDescription"></textarea>
                                </div>
                            </div>
                            <div class="m-b-5 d-flex js-center extraOptions hidden">
                                <div class="col-md-8 m-t-5 @notmobile contentActive @endnotmobile">
                                    <div class="row contentClick">
                                        <div class="@handheld col-6 m-b-10 @elsedesktop col-6 @endhandheld contentActive">
                                            <div class="fileUpload p-relative contentActiveIcons d-flex">
                                                <input type="file" class="userwork_image hidden" accept=".jpg, .jpeg" name="image">
                                                <i class="zmdi zmdi-camera-add iconCTA addPicture c-pointer m-r-5"></i>
                                                <i class="zmdi zmdi-mood iconCTA c-pointer popoverEmojis " data-toggle="popover" data-content='<?= view("/public/userworkFeed/shared/_popoverEmojis", compact("emojis"))?>'></i>
                                            </div>
                                        </div>
                                        <div class="@handheld col-12 m-b-10 @elsedesktop col-6 @endhandheld">
                                           <button type="button" class="btn btn-inno btn-sm pull-right submitPost">Post!</button>
                                        </div>
                                    </div>
                                    @tablet
                                        <div class="row">
                                            <div class="col-sm-4 previewBox hidden">
                                                <img style="width: 100px; height: 100px;" id="previewUpload" src="#" alt="PreviewUpload" class="p-relative"/>
                                                <i class="zmdi zmdi-close c-orange f-20 p-absolute c-pointer hidden" id="removePreview" style="top: 3%; right: 28% !important;"></i>
                                            </div>
                                        </div>
                                    @elsedesktop
                                        <div class="row">
                                            <div class="col-sm-4 previewBox hidden">
                                                <img style="width: 200px; height: 200px;" id="previewUpload" class="p-relative" src="#" alt="PreviewUpload"/>
                                                <i class="zmdi zmdi-close c-orange f-25 p-absolute c-pointer hidden" id="removePreview" style="top: 3%; right: 15% !important;"></i>
                                            </div>
                                        </div>
                                    @endtablet
                                </div>
                            </div>
                        </form>
                    @elsemobile
                        <div class="d-flex js-center m-b-5">
                            <div class="col-md-8 m-t-5">
                                <p class="c-dark-grey iconCTA col-sm-12 p-b-40 triggerSlider">Share your ideas, project or story</p>
                            </div>
                        </div>
                    @endnotmobile
                </div>
            <? } else { ?>
                <input type="hidden" class="userJS" value="0">
                <div class="text-center m-b-20">
                    <p class="@mobile f-14 @elsedesktop f-20 @endmobile text-center"><a class="regular-link" href="/create-my-account">Create an account</a> or <a class="regular-link" href="/login">login</a> to post your work!</p>
                </div>
            <? } ?>
            <div class="userworkData m-t-20 grid-container" data-page="feedPage">

            </div>
        </div>
    </div>
    <script>
        $('body').on('click', function (e) {
            $('[data-toggle=popover]').each(function () {
                // hide any open popovers when the anywhere else in the body is clicked
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });
        $('.popoverAttachment').popover({ trigger: "click" , html: true, animation:false, placement: 'auto'});
        $('.popoverEmojis').popover({ trigger: "click" , html: true, animation:false, placement: 'auto'});
    </script>
@endsection
@section('pagescript')
    <script src="/js/userworkFeed/index.js"></script>
    <script src="/js/userworkFeed/feed.js"></script>
@endsection